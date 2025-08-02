<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HutangKaryawan;
use App\Models\Karyawan;
use App\Models\RekeningKaryawan;
use App\Models\PenaltiSP;
use App\Models\SuratPeringatan;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display hutang reports
     */
    public function hutang(Request $request)
    {
        $data = [
            'total_hutang' => HutangKaryawan::sum('amount'),
            'hutang_lunas' => HutangKaryawan::where('status', 'lunas')->sum('amount'),
            'hutang_belum_lunas' => HutangKaryawan::where('status', 'belum_lunas')->sum('amount'),
            'total_transaksi' => HutangKaryawan::count(),
            'avg_hutang' => HutangKaryawan::avg('amount'),
        ];

        $hutangByType = HutangKaryawan::selectRaw('asal_hutang, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('asal_hutang')
            ->get();

        $monthlyHutang = HutangKaryawan::selectRaw('MONTH(created_at) as month, SUM(amount) as total, COUNT(*) as count')
            ->whereYear('created_at', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $hutangByDepartment = HutangKaryawan::join('karyawans', 'hutang_karyawans.karyawan_id', '=', 'karyawans.id')
            ->selectRaw('karyawans.departemen, SUM(hutang_karyawans.amount) as total, COUNT(*) as count')
            ->groupBy('karyawans.departemen')
            ->get();

        $hutangs = HutangKaryawan::with('karyawan')
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->asal, function ($query, $asal) {
                return $query->where('asal_hutang', $asal);
            })
            ->when($request->bulan, function ($query, $bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->latest()
            ->paginate(15);

        return view('keuangan.laporan.hutang', compact('data', 'hutangByType', 'monthlyHutang', 'hutangByDepartment', 'hutangs'));
    }

    /**
     * Display gaji reports
     */
    public function gaji(Request $request)
    {
        $data = [
            'total_karyawan' => Karyawan::where('status_karyawan', 'aktif')->count(),
            'total_gaji_pokok' => Karyawan::where('status_karyawan', 'aktif')->sum('gaji_pokok'),
            'avg_gaji' => Karyawan::where('status_karyawan', 'aktif')->avg('gaji_pokok'),
            'highest_gaji' => Karyawan::where('status_karyawan', 'aktif')->max('gaji_pokok'),
            'lowest_gaji' => Karyawan::where('status_karyawan', 'aktif')->min('gaji_pokok'),
        ];

        $gajiByDepartment = Karyawan::selectRaw('departemen, SUM(gaji_pokok) as total_gaji, AVG(gaji_pokok) as avg_gaji, COUNT(*) as count')
            ->where('status_karyawan', 'aktif')
            ->groupBy('departemen')
            ->get();

        $gajiByJabatan = Karyawan::selectRaw('jabatan, SUM(gaji_pokok) as total_gaji, AVG(gaji_pokok) as avg_gaji, COUNT(*) as count')
            ->where('status_karyawan', 'aktif')
            ->groupBy('jabatan')
            ->orderBy('avg_gaji', 'desc')
            ->get();

        $karyawans = Karyawan::where('status_karyawan', 'aktif')
            ->when($request->departemen, function ($query, $departemen) {
                return $query->where('departemen', $departemen);
            })
            ->when($request->jabatan, function ($query, $jabatan) {
                return $query->where('jabatan', $jabatan);
            })
            ->orderBy('gaji_pokok', 'desc')
            ->paginate(15);

        return view('keuangan.laporan.gaji', compact('data', 'gajiByDepartment', 'gajiByJabatan', 'karyawans'));
    }

    /**
     * Display cash flow reports
     */
    public function cashFlow(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        
        // Calculate monthly cash flow (simplified - you may need to adapt based on your actual cash flow data)
        $monthlyIncome = collect();
        $monthlyExpenses = collect();
        
        // Example income sources (you may need to add actual income models)
        for ($month = 1; $month <= 12; $month++) {
            $income = 0; // Add your income calculation here
            $expenses = HutangKaryawan::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('status', 'lunas')
                ->sum('amount');
            
            $monthlyIncome->push(['month' => $month, 'amount' => $income]);
            $monthlyExpenses->push(['month' => $month, 'amount' => $expenses]);
        }

        $data = [
            'total_income' => $monthlyIncome->sum('amount'),
            'total_expenses' => $monthlyExpenses->sum('amount'),
            'net_cashflow' => $monthlyIncome->sum('amount') - $monthlyExpenses->sum('amount'),
            'avg_monthly_expenses' => $monthlyExpenses->avg('amount'),
        ];

        return view('keuangan.laporan.cash-flow', compact('data', 'monthlyIncome', 'monthlyExpenses', 'year'));
    }

    /**
     * Display penalti reports
     */
    public function penalti(Request $request)
    {
        $data = [
            'total_penalti' => PenaltiSP::sum('jumlah_penalti'),
            'total_transaksi' => PenaltiSP::count(),
            'avg_penalti' => PenaltiSP::avg('jumlah_penalti'),
            'penalti_pending' => PenaltiSP::where('status_pembayaran', 'pending')->count(),
            'penalti_paid' => PenaltiSP::where('status_pembayaran', 'paid')->count(),
        ];

        $penaltiByType = PenaltiSP::join('surat_peringatans', 'penalti_s_p_s.surat_peringatan_id', '=', 'surat_peringatans.id')
            ->selectRaw('surat_peringatans.jenis_sp, SUM(penalti_s_p_s.jumlah_penalti) as total, COUNT(*) as count')
            ->groupBy('surat_peringatans.jenis_sp')
            ->get();

        $monthlyPenalti = PenaltiSP::selectRaw('MONTH(created_at) as month, SUM(jumlah_penalti) as total, COUNT(*) as count')
            ->whereYear('created_at', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $penaltis = PenaltiSP::with(['suratPeringatan', 'karyawan'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status_pembayaran', $status);
            })
            ->when($request->bulan, function ($query, $bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->latest()
            ->paginate(15);

        return view('keuangan.laporan.penalti', compact('data', 'penaltiByType', 'monthlyPenalti', 'penaltis'));
    }

    /**
     * Display rekening reports
     */
    public function rekening(Request $request)
    {
        $data = [
            'total_rekening' => RekeningKaryawan::count(),
            'rekening_aktif' => RekeningKaryawan::where('status', 'aktif')->count(),
            'rekening_non_aktif' => RekeningKaryawan::where('status', 'non_aktif')->count(),
        ];

        $rekeningByBank = RekeningKaryawan::selectRaw('nama_bank, COUNT(*) as count')
            ->groupBy('nama_bank')
            ->orderBy('count', 'desc')
            ->get();

        $rekeningByDepartment = RekeningKaryawan::join('karyawans', 'rekening_karyawans.karyawan_id', '=', 'karyawans.id')
            ->selectRaw('karyawans.departemen, COUNT(*) as count')
            ->groupBy('karyawans.departemen')
            ->get();

        $rekenings = RekeningKaryawan::with('karyawan')
            ->when($request->bank, function ($query, $bank) {
                return $query->where('nama_bank', $bank);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('keuangan.laporan.rekening', compact('data', 'rekeningByBank', 'rekeningByDepartment', 'rekenings'));
    }

    /**
     * Display pembayaran reports
     */
    public function pembayaran(Request $request)
    {
        // This is a consolidated view of all payment-related activities
        $data = [
            'total_pembayaran_hutang' => HutangKaryawan::where('status', 'lunas')->sum('amount'),
            'total_pembayaran_penalti' => PenaltiSP::where('status_pembayaran', 'paid')->sum('jumlah_penalti'),
            'pending_payments' => HutangKaryawan::where('status', 'belum_lunas')->count() + 
                                PenaltiSP::where('status_pembayaran', 'pending')->count(),
        ];

        $monthlyPayments = collect();
        for ($month = 1; $month <= 12; $month++) {
            $hutangPayments = HutangKaryawan::where('status', 'lunas')
                ->whereMonth('updated_at', $month)
                ->whereYear('updated_at', $request->year ?? Carbon::now()->year)
                ->sum('amount');
            
            $penaltiPayments = PenaltiSP::where('status_pembayaran', 'paid')
                ->whereMonth('updated_at', $month)
                ->whereYear('updated_at', $request->year ?? Carbon::now()->year)
                ->sum('jumlah_penalti');
            
            $monthlyPayments->push([
                'month' => $month,
                'hutang' => $hutangPayments,
                'penalti' => $penaltiPayments,
                'total' => $hutangPayments + $penaltiPayments
            ]);
        }

        return view('keuangan.laporan.pembayaran', compact('data', 'monthlyPayments'));
    }
}