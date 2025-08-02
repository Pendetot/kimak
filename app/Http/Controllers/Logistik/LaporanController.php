<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanBarang;
use App\Models\PengajuanBarangHRD;
use App\Models\Pembelian;
use App\Models\Vendor;
use App\Models\Karyawan;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display pembelian reports
     */
    public function pembelian(Request $request)
    {
        $data = [
            'total_pembelian' => Pembelian::sum('total_harga'),
            'total_transaksi' => Pembelian::count(),
            'avg_pembelian' => Pembelian::avg('total_harga'),
            'pembelian_pending' => Pembelian::where('status', 'pending')->count(),
            'pembelian_selesai' => Pembelian::where('status', 'selesai')->count(),
        ];

        $pembelianByVendor = Pembelian::join('vendors', 'pembelians.vendor_id', '=', 'vendors.id')
            ->selectRaw('vendors.nama_vendor, SUM(pembelians.total_harga) as total, COUNT(*) as count')
            ->groupBy('vendors.id', 'vendors.nama_vendor')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $monthlyPembelian = Pembelian::selectRaw('MONTH(tanggal_pembelian) as month, SUM(total_harga) as total, COUNT(*) as count')
            ->whereYear('tanggal_pembelian', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pembelianByStatus = Pembelian::selectRaw('status, SUM(total_harga) as total, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $pembelians = Pembelian::with('vendor')
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->vendor_id, function ($query, $vendorId) {
                return $query->where('vendor_id', $vendorId);
            })
            ->when($request->bulan, function ($query, $bulan) {
                return $query->whereMonth('tanggal_pembelian', $bulan);
            })
            ->latest('tanggal_pembelian')
            ->paginate(15);

        return view('logistik.laporan.pembelian', compact('data', 'pembelianByVendor', 'monthlyPembelian', 'pembelianByStatus', 'pembelians'));
    }

    /**
     * Display stock reports
     */
    public function stock(Request $request)
    {
        // This is a placeholder as we need actual stock/inventory models
        // You may need to create Stock or Inventory models for actual implementation
        
        $data = [
            'total_items' => 0, // Placeholder - replace with actual stock count
            'low_stock_items' => 0, // Items below minimum threshold
            'out_of_stock' => 0, // Items with zero stock
            'total_value' => 0, // Total inventory value
        ];

        // Placeholder for stock by category
        $stockByCategory = collect([
            ['category' => 'Office Supplies', 'count' => 45, 'value' => 1250000],
            ['category' => 'Electronics', 'count' => 23, 'value' => 15750000],
            ['category' => 'Furniture', 'count' => 12, 'value' => 8500000],
        ]);

        // Placeholder for recent stock movements
        $recentMovements = collect([
            ['item' => 'Laptop Dell', 'type' => 'in', 'quantity' => 5, 'date' => now()],
            ['item' => 'Office Chair', 'type' => 'out', 'quantity' => 2, 'date' => now()->subDays(1)],
        ]);

        return view('logistik.laporan.stock', compact('data', 'stockByCategory', 'recentMovements'));
    }

    /**
     * Display distribusi reports
     */
    public function distribusi(Request $request)
    {
        // Distribution of approved requests to departments/employees
        $data = [
            'total_distribusi' => PengajuanBarang::where('status', 'approved')->count(),
            'pending_distribusi' => PengajuanBarang::where('status', 'pending')->count(),
            'completed_distribusi' => PengajuanBarang::where('status', 'completed')->count(),
        ];

        $distribusiByDepartment = PengajuanBarang::join('karyawans', 'pengajuan_barangs.karyawan_id', '=', 'karyawans.id')
            ->selectRaw('karyawans.departemen, COUNT(*) as count')
            ->where('pengajuan_barangs.status', 'approved')
            ->groupBy('karyawans.departemen')
            ->get();

        $monthlyDistribusi = PengajuanBarang::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 'approved')
            ->whereYear('created_at', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $recentDistributions = PengajuanBarang::with('karyawan')
            ->where('status', 'approved')
            ->latest()
            ->take(10)
            ->get();

        return view('logistik.laporan.distribusi', compact('data', 'distribusiByDepartment', 'monthlyDistribusi', 'recentDistributions'));
    }

    /**
     * Display vendor reports
     */
    public function vendor(Request $request)
    {
        $data = [
            'total_vendor' => Vendor::count(),
            'vendor_aktif' => Vendor::where('status', 'aktif')->count(),
            'vendor_non_aktif' => Vendor::where('status', 'non_aktif')->count(),
            'vendor_suspended' => Vendor::where('status', 'suspended')->count(),
            'avg_rating' => Vendor::avg('rating'),
        ];

        $vendorByCategory = Vendor::selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->get();

        $vendorByRating = Vendor::selectRaw('
                CASE 
                    WHEN rating >= 4.5 THEN "Excellent (4.5-5.0)"
                    WHEN rating >= 3.5 THEN "Good (3.5-4.4)"
                    WHEN rating >= 2.5 THEN "Average (2.5-3.4)"
                    WHEN rating >= 1.5 THEN "Poor (1.5-2.4)"
                    ELSE "Very Poor (0-1.4)"
                END as rating_range,
                COUNT(*) as count')
            ->groupBy('rating_range')
            ->get();

        $topVendors = Vendor::withCount('pembelians')
            ->withSum('pembelians', 'total_harga')
            ->orderBy('pembelians_count', 'desc')
            ->take(10)
            ->get();

        $vendors = Vendor::withCount('pembelians')
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($request->rating, function ($query, $rating) {
                return $query->where('rating', '>=', $rating);
            })
            ->latest()
            ->paginate(15);

        return view('logistik.laporan.vendor', compact('data', 'vendorByCategory', 'vendorByRating', 'topVendors', 'vendors'));
    }

    /**
     * Display pengajuan barang reports
     */
    public function pengajuanBarang(Request $request)
    {
        // Regular employee requests
        $regularRequests = [
            'total' => PengajuanBarang::count(),
            'pending' => PengajuanBarang::where('status', 'pending')->count(),
            'approved' => PengajuanBarang::where('status', 'approved')->count(),
            'rejected' => PengajuanBarang::where('status', 'rejected')->count(),
        ];

        // HRD procurement requests
        $hrdRequests = [
            'total' => PengajuanBarangHRD::count(),
            'pending' => PengajuanBarangHRD::where('status', 'pending')->count(),
            'approved' => PengajuanBarangHRD::where('status', 'approved')->count(),
            'completed' => PengajuanBarangHRD::where('status', 'completed')->count(),
        ];

        $data = [
            'regular_requests' => $regularRequests,
            'hrd_requests' => $hrdRequests,
            'total_requests' => $regularRequests['total'] + $hrdRequests['total'],
        ];

        $monthlyRequests = PengajuanBarang::selectRaw('MONTH(created_at) as month, COUNT(*) as regular_count')
            ->whereYear('created_at', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyHRDRequests = PengajuanBarangHRD::selectRaw('MONTH(created_at) as month, COUNT(*) as hrd_count')
            ->whereYear('created_at', $request->year ?? Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Merge monthly data
        $combinedMonthly = $monthlyRequests->map(function ($item) use ($monthlyHRDRequests) {
            $hrdData = $monthlyHRDRequests->firstWhere('month', $item->month);
            return [
                'month' => $item->month,
                'regular' => $item->regular_count,
                'hrd' => $hrdData ? $hrdData->hrd_count : 0,
                'total' => $item->regular_count + ($hrdData ? $hrdData->hrd_count : 0)
            ];
        });

        $recentRequests = PengajuanBarang::with('karyawan')
            ->latest()
            ->take(10)
            ->get();

        return view('logistik.laporan.pengajuan-barang', compact('data', 'combinedMonthly', 'recentRequests'));
    }

    /**
     * Display performance reports
     */
    public function performance(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;

        // Request processing performance
        $avgProcessingTime = PengajuanBarang::whereNotNull('approved_at')
            ->whereYear('created_at', $year)
            ->selectRaw('AVG(DATEDIFF(approved_at, created_at)) as avg_days')
            ->value('avg_days');

        // Vendor performance
        $vendorPerformance = Vendor::withAvg('pembelians', 'total_harga')
            ->withCount('pembelians')
            ->where('status', 'aktif')
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get();

        // Monthly efficiency
        $monthlyEfficiency = collect();
        for ($month = 1; $month <= 12; $month++) {
            $totalRequests = PengajuanBarang::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
            
            $approvedRequests = PengajuanBarang::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('status', 'approved')
                ->count();
            
            $efficiency = $totalRequests > 0 ? ($approvedRequests / $totalRequests) * 100 : 0;
            
            $monthlyEfficiency->push([
                'month' => $month,
                'total' => $totalRequests,
                'approved' => $approvedRequests,
                'efficiency' => round($efficiency, 2)
            ]);
        }

        $data = [
            'avg_processing_days' => round($avgProcessingTime, 1),
            'total_vendors' => Vendor::count(),
            'active_vendors' => Vendor::where('status', 'aktif')->count(),
            'avg_vendor_rating' => round(Vendor::avg('rating'), 2),
            'overall_efficiency' => round($monthlyEfficiency->avg('efficiency'), 2),
        ];

        return view('logistik.laporan.performance', compact('data', 'vendorPerformance', 'monthlyEfficiency', 'year'));
    }
}