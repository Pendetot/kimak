<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Absensi;
use App\Models\KPI;
use App\Models\HutangKaryawan;
use App\Models\PengajuanBarang;
use App\Models\Pembelian;
use App\Models\Vendor;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display karyawan reports
     */
    public function karyawan(Request $request)
    {
        $data = [
            'total_karyawan' => Karyawan::count(),
            'karyawan_aktif' => Karyawan::where('status_karyawan', 'aktif')->count(),
            'karyawan_non_aktif' => Karyawan::where('status_karyawan', 'non_aktif')->count(),
            'karyawan_cuti' => Karyawan::where('status_karyawan', 'cuti')->count(),
            'karyawan_resign' => Karyawan::where('status_karyawan', 'resign')->count(),
        ];

        $karyawans = Karyawan::with(['absensis', 'kpis'])
            ->when($request->departemen, function ($query, $departemen) {
                return $query->where('departemen', $departemen);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status_karyawan', $status);
            })
            ->paginate(15);

        return view('superadmin.laporan.karyawan', compact('data', 'karyawans'));
    }

    /**
     * Display keuangan reports
     */
    public function keuangan(Request $request)
    {
        $data = [
            'total_hutang' => HutangKaryawan::sum('amount'),
            'hutang_lunas' => HutangKaryawan::where('status', 'lunas')->sum('amount'),
            'hutang_belum_lunas' => HutangKaryawan::where('status', 'belum_lunas')->sum('amount'),
            'total_transaksi' => HutangKaryawan::count(),
        ];

        $monthlyData = HutangKaryawan::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $hutangs = HutangKaryawan::with('karyawan')
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->bulan, function ($query, $bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->latest()
            ->paginate(15);

        return view('superadmin.laporan.keuangan', compact('data', 'monthlyData', 'hutangs'));
    }

    /**
     * Display logistik reports
     */
    public function logistik(Request $request)
    {
        $data = [
            'total_pengajuan' => PengajuanBarang::count(),
            'pengajuan_pending' => PengajuanBarang::where('status', 'pending')->count(),
            'pengajuan_approved' => PengajuanBarang::where('status', 'approved')->count(),
            'pengajuan_rejected' => PengajuanBarang::where('status', 'rejected')->count(),
            'total_pembelian' => Pembelian::sum('total_harga'),
            'total_vendor' => Vendor::count(),
            'vendor_aktif' => Vendor::where('status', 'aktif')->count(),
        ];

        $monthlyPembelian = Pembelian::selectRaw('MONTH(tanggal_pembelian) as month, SUM(total_harga) as total')
            ->whereYear('tanggal_pembelian', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topVendors = Vendor::withCount('pembelians')
            ->orderBy('pembelians_count', 'desc')
            ->take(10)
            ->get();

        $recentPengajuan = PengajuanBarang::with('karyawan')
            ->latest()
            ->take(10)
            ->get();

        return view('superadmin.laporan.logistik', compact('data', 'monthlyPembelian', 'topVendors', 'recentPengajuan'));
    }

    /**
     * Display analytics dashboard
     */
    public function analytics(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        
        $karyawanGrowth = Karyawan::selectRaw('MONTH(tanggal_masuk) as month, COUNT(*) as total')
            ->whereYear('tanggal_masuk', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $absensiStats = Absensi::selectRaw('status, COUNT(*) as total')
            ->whereYear('tanggal', $year)
            ->groupBy('status')
            ->get();

        $kpiAverage = KPI::selectRaw('MONTH(created_at) as month, AVG(nilai_kpi) as average')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $departmentStats = Karyawan::selectRaw('departemen, COUNT(*) as total')
            ->where('status_karyawan', 'aktif')
            ->groupBy('departemen')
            ->get();

        return view('superadmin.laporan.analytics', compact('karyawanGrowth', 'absensiStats', 'kpiAverage', 'departmentStats', 'year'));
    }

    /**
     * Get dashboard data for AJAX requests
     */
    public function dashboardData(Request $request)
    {
        $period = $request->period ?? 'month';
        
        $data = [
            'karyawan' => [
                'total' => Karyawan::count(),
                'aktif' => Karyawan::where('status_karyawan', 'aktif')->count(),
                'growth' => $this->getGrowthData('karyawan', $period),
            ],
            'keuangan' => [
                'total_hutang' => HutangKaryawan::sum('amount'),
                'hutang_lunas' => HutangKaryawan::where('status', 'lunas')->sum('amount'),
                'trend' => $this->getGrowthData('keuangan', $period),
            ],
            'logistik' => [
                'total_pengajuan' => PengajuanBarang::count(),
                'pengajuan_pending' => PengajuanBarang::where('status', 'pending')->count(),
                'total_pembelian' => Pembelian::sum('total_harga'),
                'trend' => $this->getGrowthData('logistik', $period),
            ],
        ];

        return response()->json($data);
    }

    /**
     * Helper method to get growth data
     */
    private function getGrowthData($type, $period)
    {
        $dateFormat = $period === 'year' ? 'YEAR' : 'MONTH';
        $dateField = $period === 'year' ? 'YEAR(created_at)' : 'MONTH(created_at)';
        
        switch ($type) {
            case 'karyawan':
                return Karyawan::selectRaw("$dateField as period, COUNT(*) as total")
                    ->groupBy('period')
                    ->orderBy('period')
                    ->take(12)
                    ->get();
            
            case 'keuangan':
                return HutangKaryawan::selectRaw("$dateField as period, SUM(amount) as total")
                    ->groupBy('period')
                    ->orderBy('period')
                    ->take(12)
                    ->get();
            
            case 'logistik':
                return PengajuanBarang::selectRaw("$dateField as period, COUNT(*) as total")
                    ->groupBy('period')
                    ->orderBy('period')
                    ->take(12)
                    ->get();
            
            default:
                return collect();
        }
    }
}