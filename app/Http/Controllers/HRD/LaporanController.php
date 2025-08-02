<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Pelamar;
use App\Models\Cuti;
use App\Models\Mutasi;
use App\Models\Resign;
use App\Models\Absensi;
use App\Models\KPI;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display main HR reports dashboard
     */
    public function index(Request $request)
    {
        $data = [
            'total_karyawan' => Karyawan::count(),
            'karyawan_aktif' => Karyawan::where('status_karyawan', 'aktif')->count(),
            'total_pelamar' => Pelamar::count(),
            'pelamar_pending' => Pelamar::where('interview_attendance_status', 'pending')->count(),
            'cuti_pending' => Cuti::where('status', 'pending')->count(),
            'mutasi_pending' => Mutasi::where('status', 'pending')->count(),
        ];

        $recentActivities = [
            'pelamars' => Pelamar::latest()->take(5)->get(),
            'cutis' => Cuti::with('karyawan')->latest()->take(5)->get(),
            'mutasis' => Mutasi::with('karyawan')->latest()->take(5)->get(),
            'resigns' => Resign::with('karyawan')->latest()->take(5)->get(),
        ];

        return view('hrd.laporan.index', compact('data', 'recentActivities'));
    }

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
        ];

        $departmentStats = Karyawan::selectRaw('departemen, COUNT(*) as total')
            ->where('status_karyawan', 'aktif')
            ->groupBy('departemen')
            ->get();

        $karyawans = Karyawan::with(['absensis', 'kpis'])
            ->when($request->departemen, function ($query, $departemen) {
                return $query->where('departemen', $departemen);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status_karyawan', $status);
            })
            ->paginate(15);

        return view('hrd.laporan.karyawan', compact('data', 'departmentStats', 'karyawans'));
    }

    /**
     * Display cuti reports
     */
    public function cuti(Request $request)
    {
        $data = [
            'total_cuti' => Cuti::count(),
            'cuti_pending' => Cuti::where('status', 'pending')->count(),
            'cuti_approved' => Cuti::where('status', 'disetujui')->count(),
            'cuti_rejected' => Cuti::where('status', 'ditolak')->count(),
        ];

        $monthlyData = Cuti::selectRaw('MONTH(tanggal_mulai) as month, COUNT(*) as total')
            ->whereYear('tanggal_mulai', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $cutiByType = Cuti::selectRaw('jenis_cuti, COUNT(*) as total')
            ->groupBy('jenis_cuti')
            ->get();

        $cutis = Cuti::with('karyawan')
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->jenis, function ($query, $jenis) {
                return $query->where('jenis_cuti', $jenis);
            })
            ->latest()
            ->paginate(15);

        return view('hrd.laporan.cuti', compact('data', 'monthlyData', 'cutiByType', 'cutis'));
    }

    /**
     * Display mutasi reports
     */
    public function mutasi(Request $request)
    {
        $data = [
            'total_mutasi' => Mutasi::count(),
            'mutasi_pending' => Mutasi::where('status', 'pending')->count(),
            'mutasi_approved' => Mutasi::where('status', 'approved')->count(),
            'mutasi_completed' => Mutasi::where('status', 'completed')->count(),
        ];

        $mutasiByDepartment = Mutasi::selectRaw('departemen_asal, departemen_tujuan, COUNT(*) as total')
            ->groupBy('departemen_asal', 'departemen_tujuan')
            ->get();

        $mutasis = Mutasi::with('karyawan')
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->departemen, function ($query, $departemen) {
                return $query->where('departemen_asal', $departemen)
                           ->orWhere('departemen_tujuan', $departemen);
            })
            ->latest()
            ->paginate(15);

        return view('hrd.laporan.mutasi', compact('data', 'mutasiByDepartment', 'mutasis'));
    }

    /**
     * Display resign reports
     */
    public function resign(Request $request)
    {
        $data = [
            'total_resign' => Resign::count(),
            'resign_pending' => Resign::where('status', 'pending')->count(),
            'resign_approved' => Resign::where('status', 'approved')->count(),
            'resign_completed' => Resign::where('status', 'completed')->count(),
        ];

        $resignByReason = Resign::selectRaw('alasan_resign, COUNT(*) as total')
            ->groupBy('alasan_resign')
            ->get();

        $monthlyResign = Resign::selectRaw('MONTH(tanggal_resign) as month, COUNT(*) as total')
            ->whereYear('tanggal_resign', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $resigns = Resign::with('karyawan')
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->alasan, function ($query, $alasan) {
                return $query->where('alasan_resign', $alasan);
            })
            ->latest()
            ->paginate(15);

        return view('hrd.laporan.resign', compact('data', 'resignByReason', 'monthlyResign', 'resigns'));
    }

    /**
     * Display pelamar reports
     */
    public function pelamar(Request $request)
    {
        $data = [
            'total_pelamar' => Pelamar::count(),
            'pelamar_pending' => Pelamar::where('interview_attendance_status', 'pending')->count(),
            'pelamar_hadir' => Pelamar::where('interview_attendance_status', 'hadir')->count(),
            'pelamar_tidak_hadir' => Pelamar::where('interview_attendance_status', 'tidak_hadir')->count(),
            'pelamar_diterima' => Pelamar::where('status_lamaran', 'diterima')->count(),
            'pelamar_ditolak' => Pelamar::where('status_lamaran', 'ditolak')->count(),
        ];

        $pelamarByPosition = Pelamar::selectRaw('jenis_jabatan_pekerjaan, COUNT(*) as total')
            ->groupBy('jenis_jabatan_pekerjaan')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $monthlyPelamar = Pelamar::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pelamars = Pelamar::when($request->status, function ($query, $status) {
                return $query->where('interview_attendance_status', $status);
            })
            ->when($request->posisi, function ($query, $posisi) {
                return $query->where('jenis_jabatan_pekerjaan', 'like', "%$posisi%");
            })
            ->latest()
            ->paginate(15);

        return view('hrd.laporan.pelamar', compact('data', 'pelamarByPosition', 'monthlyPelamar', 'pelamars'));
    }

    /**
     * Display KPI reports
     */
    public function kpi(Request $request)
    {
        $data = [
            'total_kpi' => KPI::count(),
            'avg_kpi' => KPI::avg('nilai_kpi'),
            'highest_kpi' => KPI::max('nilai_kpi'),
            'lowest_kpi' => KPI::min('nilai_kpi'),
        ];

        $kpiByDepartment = KPI::join('karyawans', 'k_p_i_s.karyawan_id', '=', 'karyawans.id')
            ->selectRaw('karyawans.departemen, AVG(k_p_i_s.nilai_kpi) as avg_kpi')
            ->groupBy('karyawans.departemen')
            ->get();

        $monthlyKPI = KPI::selectRaw('MONTH(created_at) as month, AVG(nilai_kpi) as avg_kpi')
            ->whereYear('created_at', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topPerformers = KPI::with('karyawan')
            ->where('nilai_kpi', '>=', 80)
            ->orderBy('nilai_kpi', 'desc')
            ->take(10)
            ->get();

        return view('hrd.laporan.kpi', compact('data', 'kpiByDepartment', 'monthlyKPI', 'topPerformers'));
    }

    /**
     * Display absensi reports
     */
    public function absensi(Request $request)
    {
        $data = [
            'total_absensi' => Absensi::count(),
            'hadir' => Absensi::where('status', 'hadir')->count(),
            'izin' => Absensi::where('status', 'izin')->count(),
            'sakit' => Absensi::where('status', 'sakit')->count(),
            'alpha' => Absensi::where('status', 'alpha')->count(),
        ];

        $absensiByStatus = Absensi::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $monthlyAbsensi = Absensi::selectRaw('MONTH(tanggal) as month, status, COUNT(*) as total')
            ->whereYear('tanggal', $request->year ?? Carbon::now()->year)
            ->groupBy('month', 'status')
            ->orderBy('month')
            ->get();

        $absensiByDepartment = Absensi::join('karyawans', 'absensis.karyawan_id', '=', 'karyawans.id')
            ->selectRaw('karyawans.departemen, absensis.status, COUNT(*) as total')
            ->groupBy('karyawans.departemen', 'absensis.status')
            ->get();

        return view('hrd.laporan.absensi', compact('data', 'absensiByStatus', 'monthlyAbsensi', 'absensiByDepartment'));
    }
}