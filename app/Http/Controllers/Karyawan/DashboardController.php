<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the karyawan dashboard.
     */
    public function index()
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        // Today's absensi
        $todayAbsensi = $karyawan->absensi()->whereDate('tanggal', today())->first();
        
        // This month statistics
        $thisMonthAbsensi = $karyawan->absensi()
                                   ->whereMonth('tanggal', now()->month)
                                   ->whereYear('tanggal', now()->year)
                                   ->get();
        
        $absensiStats = [
            'total_days' => $thisMonthAbsensi->count(),
            'hadir' => $thisMonthAbsensi->where('status_absensi', 'hadir')->count(),
            'izin' => $thisMonthAbsensi->where('status_absensi', 'izin')->count(),
            'sakit' => $thisMonthAbsensi->where('status_absensi', 'sakit')->count(),
            'alpha' => $thisMonthAbsensi->where('status_absensi', 'alpha')->count(),
            'late_count' => $thisMonthAbsensi->filter(fn($a) => $a->isLate())->count(),
        ];
        
        // Latest KPI
        $latestKPI = $karyawan->kpi()->latest('periode')->first();
        
        // Pending cuti
        $pendingCuti = $karyawan->cuti()
                              ->where('status', 'pending')
                              ->count();
        
        // Active hutang
        $activeHutang = $karyawan->hutangKaryawan()
                               ->where('status', '!=', 'lunas')
                               ->sum('sisa_hutang');
        
        // Recent pengajuan barang
        $recentPengajuan = $karyawan->pengajuanBarang()
                                  ->orderBy('created_at', 'desc')
                                  ->limit(5)
                                  ->get();
        
        // Contract info
        $contractInfo = null;
        if ($karyawan->tanggal_kontrak_selesai) {
            $daysUntilExpiry = now()->diffInDays($karyawan->tanggal_kontrak_selesai, false);
            $contractInfo = [
                'end_date' => $karyawan->tanggal_kontrak_selesai,
                'days_until_expiry' => $daysUntilExpiry,
                'is_expiring_soon' => $daysUntilExpiry <= 30 && $daysUntilExpiry >= 0,
                'is_expired' => $daysUntilExpiry < 0,
            ];
        }
        
        // Recent pembinaan
        $recentPembinaan = $karyawan->pembinaan()
                                  ->orderBy('tanggal_pembinaan', 'desc')
                                  ->limit(3)
                                  ->get();
        
        // Active surat peringatan
        $activeSP = $karyawan->suratPeringatan()
                            ->where('status_sp', 'active')
                            ->where(function($q) {
                                $q->whereNull('tanggal_berakhir')
                                  ->orWhere('tanggal_berakhir', '>=', now());
                            })
                            ->count();
        
        return view('karyawan.dashboard', compact(
            'karyawan',
            'todayAbsensi',
            'absensiStats',
            'latestKPI',
            'pendingCuti',
            'activeHutang',
            'recentPengajuan',
            'contractInfo',
            'recentPembinaan',
            'activeSP'
        ));
    }

    /**
     * Get dashboard data for API.
     */
    public function apiDashboard()
    {
        $karyawan = Auth::guard('karyawan-api')->user();
        
        // Today's absensi
        $todayAbsensi = $karyawan->absensi()->whereDate('tanggal', today())->first();
        
        // This month statistics
        $thisMonthAbsensi = $karyawan->absensi()
                                   ->whereMonth('tanggal', now()->month)
                                   ->whereYear('tanggal', now()->year)
                                   ->get();
        
        $absensiStats = [
            'total_days' => $thisMonthAbsensi->count(),
            'hadir' => $thisMonthAbsensi->where('status_absensi', 'hadir')->count(),
            'izin' => $thisMonthAbsensi->where('status_absensi', 'izin')->count(),
            'sakit' => $thisMonthAbsensi->where('status_absensi', 'sakit')->count(),
            'alpha' => $thisMonthAbsensi->where('status_absensi', 'alpha')->count(),
            'late_count' => $thisMonthAbsensi->filter(fn($a) => $a->isLate())->count(),
            'attendance_percentage' => $thisMonthAbsensi->count() > 0 
                ? round(($thisMonthAbsensi->where('status_absensi', 'hadir')->count() / $thisMonthAbsensi->count()) * 100, 1)
                : 0,
        ];
        
        // Latest KPI
        $latestKPI = $karyawan->kpi()->latest('periode')->first();
        $kpiData = $latestKPI ? [
            'nilai_kpi' => $latestKPI->nilai_kpi,
            'target_pencapaian' => $latestKPI->target_pencapaian,
            'realisasi' => $latestKPI->realisasi,
            'performance_category' => $latestKPI->getPerformanceCategory(),
            'color' => $latestKPI->getPerformanceColor(),
            'periode' => $latestKPI->periode->format('F Y'),
        ] : null;
        
        // Financial summary
        $financialSummary = [
            'active_debt' => $karyawan->hutangKaryawan()
                                    ->where('status', '!=', 'lunas')
                                    ->sum('sisa_hutang'),
            'overdue_debt' => $karyawan->hutangKaryawan()
                                     ->where('tanggal_jatuh_tempo', '<', now())
                                     ->where('status', '!=', 'lunas')
                                     ->sum('sisa_hutang'),
            'monthly_deduction' => $karyawan->hutangKaryawan()
                                          ->where('status', '!=', 'lunas')
                                          ->sum('cicilan_per_bulan'),
        ];
        
        // Leave summary
        $leaveSummary = [
            'pending_requests' => $karyawan->cuti()->where('status', 'pending')->count(),
            'approved_this_year' => $karyawan->cuti()
                                           ->whereYear('created_at', now()->year)
                                           ->where('status', 'approved')
                                           ->sum('jumlah_hari'),
            'remaining_quota' => max(0, 12 - $karyawan->getCutiThisYear()), // Assuming 12 days annual leave
        ];
        
        // Recent activities
        $recentActivities = [];
        
        // Add recent pengajuan barang
        $recentPengajuan = $karyawan->pengajuanBarang()
                                  ->orderBy('created_at', 'desc')
                                  ->limit(3)
                                  ->get();
        
        foreach ($recentPengajuan as $pengajuan) {
            $recentActivities[] = [
                'type' => 'pengajuan_barang',
                'title' => 'Pengajuan: ' . $pengajuan->nama_barang,
                'status' => $pengajuan->status->label(),
                'date' => $pengajuan->created_at->format('d M Y'),
                'color' => $pengajuan->getStatusColor(),
            ];
        }
        
        // Add recent absensi
        $recentAbsensi = $karyawan->absensi()
                                ->orderBy('tanggal', 'desc')
                                ->limit(2)
                                ->get();
        
        foreach ($recentAbsensi as $absensi) {
            $recentActivities[] = [
                'type' => 'absensi',
                'title' => 'Absensi: ' . ucfirst($absensi->status_absensi),
                'status' => $absensi->status_absensi,
                'date' => $absensi->tanggal->format('d M Y'),
                'color' => $absensi->status_absensi === 'hadir' ? 'success' : 
                          ($absensi->status_absensi === 'izin' ? 'info' : 
                          ($absensi->status_absensi === 'sakit' ? 'warning' : 'danger')),
            ];
        }
        
        // Sort activities by date
        usort($recentActivities, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        // Quick actions
        $quickActions = [
            [
                'title' => 'Check In',
                'icon' => 'clock-in',
                'action' => 'checkin',
                'enabled' => !$todayAbsensi || !$todayAbsensi->jam_masuk,
                'color' => 'success',
            ],
            [
                'title' => 'Check Out',
                'icon' => 'clock-out',
                'action' => 'checkout',
                'enabled' => $todayAbsensi && $todayAbsensi->jam_masuk && !$todayAbsensi->jam_keluar,
                'color' => 'warning',
            ],
            [
                'title' => 'Ajukan Cuti',
                'icon' => 'calendar',
                'action' => 'request_leave',
                'enabled' => true,
                'color' => 'info',
            ],
            [
                'title' => 'Pengajuan Barang',
                'icon' => 'package',
                'action' => 'request_item',
                'enabled' => true,
                'color' => 'primary',
            ],
        ];
        
        // Notifications/Alerts
        $notifications = [];
        
        // Contract expiry warning
        if ($karyawan->isContractExpiringSoon()) {
            $notifications[] = [
                'type' => 'warning',
                'title' => 'Kontrak Akan Berakhir',
                'message' => 'Kontrak kerja Anda akan berakhir pada ' . 
                           $karyawan->tanggal_kontrak_selesai->format('d M Y') . 
                           '. Silakan hubungi HRD untuk perpanjangan.',
                'priority' => 'high',
            ];
        }
        
        // Active SP warning
        $activeSP = $karyawan->suratPeringatan()->active()->count();
        if ($activeSP > 0) {
            $notifications[] = [
                'type' => 'danger',
                'title' => 'Surat Peringatan Aktif',
                'message' => 'Anda memiliki ' . $activeSP . ' surat peringatan yang masih aktif.',
                'priority' => 'high',
            ];
        }
        
        // Overdue debt warning
        if ($financialSummary['overdue_debt'] > 0) {
            $notifications[] = [
                'type' => 'warning',
                'title' => 'Hutang Jatuh Tempo',
                'message' => 'Anda memiliki hutang yang sudah jatuh tempo sebesar Rp ' . 
                           number_format($financialSummary['overdue_debt'], 0, ',', '.'),
                'priority' => 'medium',
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'karyawan_info' => [
                    'nama_lengkap' => $karyawan->nama_lengkap,
                    'nik' => $karyawan->nik,
                    'jabatan' => $karyawan->jabatan,
                    'departemen' => $karyawan->departemen,
                    'foto_profil' => $karyawan->getPhotoUrl(),
                    'work_duration' => $karyawan->work_duration,
                ],
                'today_absensi' => $todayAbsensi ? [
                    'status' => $todayAbsensi->status_absensi,
                    'jam_masuk' => $todayAbsensi->jam_masuk?->format('H:i'),
                    'jam_keluar' => $todayAbsensi->jam_keluar?->format('H:i'),
                    'is_late' => $todayAbsensi->isLate(),
                    'working_hours' => $todayAbsensi->getWorkingHours(),
                ] : null,
                'absensi_stats' => $absensiStats,
                'kpi_data' => $kpiData,
                'financial_summary' => $financialSummary,
                'leave_summary' => $leaveSummary,
                'recent_activities' => array_slice($recentActivities, 0, 5),
                'quick_actions' => $quickActions,
                'notifications' => $notifications,
            ]
        ]);
    }

    /**
     * Get widget data for dashboard.
     */
    public function widgetData(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        $widget = $request->get('widget');
        
        switch ($widget) {
            case 'absensi_chart':
                return $this->getAbsensiChart($karyawan, $request);
            case 'kpi_trend':
                return $this->getKPITrend($karyawan, $request);
            case 'monthly_summary':
                return $this->getMonthlySummary($karyawan, $request);
            default:
                return response()->json(['success' => false, 'message' => 'Widget not found'], 404);
        }
    }

    /**
     * Get absensi chart data.
     */
    private function getAbsensiChart($karyawan, $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        $absensi = $karyawan->absensi()
                          ->whereYear('tanggal', $year)
                          ->whereMonth('tanggal', $month)
                          ->get();
        
        $chartData = [
            'hadir' => $absensi->where('status_absensi', 'hadir')->count(),
            'izin' => $absensi->where('status_absensi', 'izin')->count(),
            'sakit' => $absensi->where('status_absensi', 'sakit')->count(),
            'alpha' => $absensi->where('status_absensi', 'alpha')->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $chartData
        ]);
    }

    /**
     * Get KPI trend data.
     */
    private function getKPITrend($karyawan, $request)
    {
        $year = $request->get('year', now()->year);
        
        $kpis = $karyawan->kpi()
                        ->whereYear('periode', $year)
                        ->orderBy('periode')
                        ->get();
        
        $trendData = $kpis->map(function($kpi) {
            return [
                'month' => $kpi->periode->format('M'),
                'score' => $kpi->nilai_kpi,
                'target' => $kpi->target_pencapaian,
                'realisasi' => $kpi->realisasi,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $trendData
        ]);
    }

    /**
     * Get monthly summary data.
     */
    private function getMonthlySummary($karyawan, $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        $summary = [
            'absensi' => $karyawan->absensi()
                               ->whereYear('tanggal', $year)
                               ->whereMonth('tanggal', $month)
                               ->count(),
            'cuti_diambil' => $karyawan->cuti()
                                    ->whereYear('tanggal_mulai', $year)
                                    ->whereMonth('tanggal_mulai', $month)
                                    ->where('status', 'approved')
                                    ->sum('jumlah_hari'),
            'pengajuan_barang' => $karyawan->pengajuanBarang()
                                         ->whereYear('created_at', $year)
                                         ->whereMonth('created_at', $month)
                                         ->count(),
            'pembinaan' => $karyawan->pembinaan()
                                  ->whereYear('tanggal_pembinaan', $year)
                                  ->whereMonth('tanggal_pembinaan', $month)
                                  ->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }
}