<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\KPI;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KPIController extends Controller
{
    /**
     * Display a listing of KPI for the authenticated karyawan.
     */
    public function index(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $query = $karyawan->kpi()->with(['evaluator']);
        
        // Filter by year if provided
        if ($request->has('year')) {
            $query->whereYear('periode', $request->year);
        } else {
            // Default to current year
            $query->whereYear('periode', now()->year);
        }
        
        $kpis = $query->orderBy('periode', 'desc')->get();
        
        // Calculate statistics
        $stats = [
            'total_evaluations' => $kpis->count(),
            'average_score' => $kpis->avg('nilai_kpi'),
            'highest_score' => $kpis->max('nilai_kpi'),
            'lowest_score' => $kpis->min('nilai_kpi'),
            'latest_score' => $kpis->first()?->nilai_kpi,
        ];
        
        return view('karyawan.kpi.index', compact('kpis', 'stats'));
    }

    /**
     * Display the specified KPI.
     */
    public function show(KPI $kpi)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        // Ensure karyawan can only view their own KPI
        if ($kpi->karyawan_id !== $karyawan->id) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('karyawan.kpi.show', compact('kpi'));
    }

    /**
     * Get KPI statistics for API.
     */
    public function statistics(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $year = $request->get('year', now()->year);
        $month = $request->get('month');
        
        $query = $karyawan->kpi()->whereYear('periode', $year);
        
        if ($month) {
            $query->whereMonth('periode', $month);
        }
        
        $kpis = $query->get();
        
        $stats = [
            'total_evaluations' => $kpis->count(),
            'average_score' => round($kpis->avg('nilai_kpi'), 2),
            'highest_score' => $kpis->max('nilai_kpi'),
            'lowest_score' => $kpis->min('nilai_kpi'),
            'performance_trend' => $this->getPerformanceTrend($kpis),
            'monthly_scores' => $this->getMonthlyScores($year, $karyawan),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get KPI history for chart.
     */
    public function history(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $year = $request->get('year', now()->year);
        $limit = $request->get('limit', 12); // Last 12 periods
        
        $kpis = $karyawan->kpi()
                        ->whereYear('periode', $year)
                        ->orderBy('periode', 'desc')
                        ->limit($limit)
                        ->get()
                        ->reverse()
                        ->values();
        
        $chartData = $kpis->map(function($kpi) {
            return [
                'periode' => $kpi->periode->format('M Y'),
                'nilai_kpi' => $kpi->nilai_kpi,
                'target_pencapaian' => $kpi->target_pencapaian,
                'realisasi' => $kpi->realisasi,
                'performance_category' => $kpi->getPerformanceCategory(),
                'color' => $kpi->getPerformanceColor(),
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $chartData
        ]);
    }

    /**
     * Get current month KPI summary.
     */
    public function currentSummary()
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $currentKPI = $karyawan->kpi()
                             ->whereYear('periode', now()->year)
                             ->whereMonth('periode', now()->month)
                             ->first();
        
        $lastKPI = $karyawan->kpi()
                          ->where('periode', '<', now()->startOfMonth())
                          ->orderBy('periode', 'desc')
                          ->first();
        
        $summary = [
            'current_kpi' => $currentKPI ? [
                'nilai_kpi' => $currentKPI->nilai_kpi,
                'target_pencapaian' => $currentKPI->target_pencapaian,
                'realisasi' => $currentKPI->realisasi,
                'performance_category' => $currentKPI->getPerformanceCategory(),
                'color' => $currentKPI->getPerformanceColor(),
                'periode' => $currentKPI->periode->format('F Y'),
            ] : null,
            'last_kpi' => $lastKPI ? [
                'nilai_kpi' => $lastKPI->nilai_kpi,
                'performance_category' => $lastKPI->getPerformanceCategory(),
                'periode' => $lastKPI->periode->format('F Y'),
            ] : null,
            'performance_change' => null,
        ];
        
        if ($currentKPI && $lastKPI) {
            $change = $currentKPI->nilai_kpi - $lastKPI->nilai_kpi;
            $summary['performance_change'] = [
                'value' => round($change, 2),
                'percentage' => round(($change / $lastKPI->nilai_kpi) * 100, 2),
                'trend' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable'),
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }

    /**
     * Get performance ranking among peers.
     */
    public function ranking(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        // Get all KPIs for the same department in the same period
        $departmentKPIs = KPI::whereHas('karyawan', function($query) use ($karyawan) {
                                $query->where('departemen', $karyawan->departemen);
                            })
                            ->whereYear('periode', $year)
                            ->whereMonth('periode', $month)
                            ->with('karyawan')
                            ->orderBy('nilai_kpi', 'desc')
                            ->get();
        
        $myRanking = $departmentKPIs->search(function($kpi) use ($karyawan) {
            return $kpi->karyawan_id === $karyawan->id;
        });
        
        $myKPI = $departmentKPIs->firstWhere('karyawan_id', $karyawan->id);
        
        $ranking = [
            'my_position' => $myRanking !== false ? $myRanking + 1 : null,
            'total_participants' => $departmentKPIs->count(),
            'my_score' => $myKPI?->nilai_kpi,
            'department_average' => round($departmentKPIs->avg('nilai_kpi'), 2),
            'highest_score' => $departmentKPIs->max('nilai_kpi'),
            'percentile' => $myRanking !== false && $departmentKPIs->count() > 1 
                           ? round((($departmentKPIs->count() - $myRanking) / $departmentKPIs->count()) * 100, 1)
                           : null,
        ];
        
        return response()->json([
            'success' => true,
            'data' => $ranking
        ]);
    }

    /**
     * Get performance improvement suggestions.
     */
    public function suggestions()
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $recentKPIs = $karyawan->kpi()
                             ->orderBy('periode', 'desc')
                             ->limit(3)
                             ->get();
        
        $suggestions = [];
        
        if ($recentKPIs->count() >= 2) {
            $latest = $recentKPIs->first();
            $previous = $recentKPIs->skip(1)->first();
            
            if ($latest->nilai_kpi < $previous->nilai_kpi) {
                $suggestions[] = [
                    'type' => 'performance_decline',
                    'title' => 'Performa Menurun',
                    'message' => 'Nilai KPI Anda turun dari ' . $previous->nilai_kpi . ' menjadi ' . $latest->nilai_kpi . '. Pertimbangkan untuk menganalisis faktor-faktor yang mempengaruhi performa.',
                    'priority' => 'high'
                ];
            }
            
            if ($latest->realisasi < $latest->target_pencapaian) {
                $gap = $latest->target_pencapaian - $latest->realisasi;
                $suggestions[] = [
                    'type' => 'target_gap',
                    'title' => 'Gap Target',
                    'message' => 'Terdapat gap sebesar ' . round($gap, 2) . ' antara target dan realisasi. Fokus pada peningkatan pencapaian target.',
                    'priority' => 'medium'
                ];
            }
        }
        
        if ($recentKPIs->avg('nilai_kpi') < 70) {
            $suggestions[] = [
                'type' => 'overall_improvement',
                'title' => 'Peningkatan Performa',
                'message' => 'Rata-rata nilai KPI masih di bawah standar baik (70). Pertimbangkan untuk mengikuti pelatihan atau coaching.',
                'priority' => 'high'
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $suggestions
        ]);
    }

    /**
     * Get performance trend analysis.
     */
    private function getPerformanceTrend($kpis)
    {
        if ($kpis->count() < 2) {
            return 'insufficient_data';
        }
        
        $sorted = $kpis->sortBy('periode');
        $latest = $sorted->last();
        $previous = $sorted->slice(-2, 1)->first();
        
        $change = $latest->nilai_kpi - $previous->nilai_kpi;
        
        if ($change > 5) return 'improving';
        if ($change < -5) return 'declining';
        return 'stable';
    }

    /**
     * Get monthly scores for the year.
     */
    private function getMonthlyScores($year, $karyawan)
    {
        $monthlyScores = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $kpi = $karyawan->kpi()
                          ->whereYear('periode', $year)
                          ->whereMonth('periode', $month)
                          ->first();
            
            $monthlyScores[] = [
                'month' => $month,
                'month_name' => date('M', mktime(0, 0, 0, $month, 1)),
                'score' => $kpi?->nilai_kpi,
            ];
        }
        
        return $monthlyScores;
    }
}