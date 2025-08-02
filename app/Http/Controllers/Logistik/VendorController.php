<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of vendors
     */
    public function index(Request $request)
    {
        $query = Vendor::with(['creator']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan kota
        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        // Filter berdasarkan rating
        if ($request->filled('rating_min')) {
            $query->where('rating', '>=', $request->rating_min);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_vendor', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        $vendors = $query->latest()->paginate(15);

        // Statistics
        $statistics = [
            'total_vendors' => Vendor::count(),
            'active_vendors' => Vendor::active()->count(),
            'inactive_vendors' => Vendor::inactive()->count(),
            'suspended_vendors' => Vendor::where('status', 'suspended')->count(),
            'avg_rating' => Vendor::active()->avg('rating'),
            'total_transactions' => $vendors->sum(function($vendor) {
                return $vendor->total_transactions;
            }),
            'total_value' => $vendors->sum(function($vendor) {
                return $vendor->total_value;
            })
        ];

        // Get unique categories and cities for filters
        $categories = Vendor::distinct('kategori')->pluck('kategori')->filter();
        $cities = Vendor::distinct('kota')->pluck('kota')->filter();

        return view('logistik.vendor.index', compact('vendors', 'statistics', 'categories', 'cities'));
    }

    /**
     * Show the form for creating a new vendor
     */
    public function create()
    {
        return view('logistik.vendor.create');
    }

    /**
     * Store a newly created vendor
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:vendors,email',
            'website' => 'nullable|url',
            'contact_person' => 'required|string|max:255',
            'jabatan_contact_person' => 'nullable|string|max:255',
            'telepon_contact_person' => 'nullable|string|max:20',
            'email_contact_person' => 'nullable|email',
            'bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:255',
            'nama_rekening' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:20',
            'rating' => 'nullable|numeric|min:0|max:5',
            'catatan' => 'nullable|string'
        ]);

        Vendor::create([
            'nama_vendor' => $request->nama_vendor,
            'kategori' => $request->kategori,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
            'jabatan_contact_person' => $request->jabatan_contact_person,
            'telepon_contact_person' => $request->telepon_contact_person,
            'email_contact_person' => $request->email_contact_person,
            'bank' => $request->bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_rekening' => $request->nama_rekening,
            'npwp' => $request->npwp,
            'rating' => $request->rating ?? 0,
            'status' => 'aktif',
            'catatan' => $request->catatan,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('logistik.vendor.index')
                        ->with('success', 'Vendor berhasil ditambahkan.');
    }

    /**
     * Display the specified vendor
     */
    public function show(Vendor $vendor)
    {
        $vendor->load(['creator', 'pembelians.creator']);
        
        // Get recent transactions
        $recentTransactions = $vendor->pembelians()
                                   ->with(['creator'])
                                   ->latest()
                                   ->take(10)
                                   ->get();

        // Calculate performance metrics
        $performanceMetrics = [
            'total_transactions' => $vendor->total_transactions,
            'total_value' => $vendor->total_value,
            'avg_transaction_value' => $vendor->total_transactions > 0 
                                     ? $vendor->total_value / $vendor->total_transactions 
                                     : 0,
            'completion_rate' => $vendor->pembelians()->where('status', 'selesai')->count() * 100 / 
                               max($vendor->pembelians()->count(), 1),
            'avg_processing_time' => $vendor->pembelians()
                                          ->whereNotNull('completed_at')
                                          ->whereNotNull('created_at')
                                          ->selectRaw('AVG(DATEDIFF(completed_at, created_at)) as avg_days')
                                          ->value('avg_days') ?? 0
        ];

        return view('logistik.vendor.show', compact('vendor', 'recentTransactions', 'performanceMetrics'));
    }

    /**
     * Show the form for editing the specified vendor
     */
    public function edit(Vendor $vendor)
    {
        return view('logistik.vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified vendor
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'website' => 'nullable|url',
            'contact_person' => 'required|string|max:255',
            'jabatan_contact_person' => 'nullable|string|max:255',
            'telepon_contact_person' => 'nullable|string|max:20',
            'email_contact_person' => 'nullable|email',
            'bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:255',
            'nama_rekening' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:20',
            'rating' => 'nullable|numeric|min:0|max:5',
            'status' => 'required|in:aktif,non_aktif,suspended',
            'catatan' => 'nullable|string'
        ]);

        $vendor->update($request->all());

        return redirect()->route('logistik.vendor.index')
                        ->with('success', 'Vendor berhasil diperbarui.');
    }

    /**
     * Remove the specified vendor (soft delete)
     */
    public function destroy(Vendor $vendor)
    {
        // Check if vendor has active purchases
        $activePurchases = $vendor->pembelians()->whereIn('status', ['pending', 'diproses'])->count();
        
        if ($activePurchases > 0) {
            return redirect()->back()
                           ->with('error', 'Vendor tidak dapat dihapus karena masih memiliki pembelian aktif.');
        }

        $vendor->delete();

        return redirect()->route('logistik.vendor.index')
                        ->with('success', 'Vendor berhasil dihapus.');
    }

    /**
     * Restore soft deleted vendor
     */
    public function restore($id)
    {
        $vendor = Vendor::withTrashed()->findOrFail($id);
        $vendor->restore();

        return redirect()->route('logistik.vendor.index')
                        ->with('success', 'Vendor berhasil dipulihkan.');
    }

    /**
     * Permanently delete vendor
     */
    public function forceDelete($id)
    {
        $vendor = Vendor::withTrashed()->findOrFail($id);
        
        // Check if vendor has any purchases
        if ($vendor->pembelians()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Vendor tidak dapat dihapus permanen karena memiliki riwayat pembelian.');
        }

        $vendor->forceDelete();

        return redirect()->route('logistik.vendor.index')
                        ->with('success', 'Vendor berhasil dihapus permanen.');
    }

    /**
     * Update vendor status
     */
    public function updateStatus(Request $request, Vendor $vendor)
    {
        $request->validate([
            'status' => 'required|in:aktif,non_aktif,suspended',
            'reason' => 'nullable|string|max:500'
        ]);

        $vendor->update([
            'status' => $request->status,
            'catatan' => $request->reason ? 
                       ($vendor->catatan ? $vendor->catatan . "\n\n" : '') . 
                       "Status changed to {$request->status}: {$request->reason}" 
                       : $vendor->catatan
        ]);

        return redirect()->back()
                        ->with('success', 'Status vendor berhasil diperbarui.');
    }

    /**
     * Update vendor rating
     */
    public function updateRating(Request $request, Vendor $vendor)
    {
        $request->validate([
            'rating' => 'required|numeric|min:0|max:5',
            'review' => 'nullable|string|max:1000'
        ]);

        $vendor->update([
            'rating' => $request->rating,
            'catatan' => $request->review ? 
                       ($vendor->catatan ? $vendor->catatan . "\n\n" : '') . 
                       "Rating updated to {$request->rating}/5: {$request->review}" 
                       : $vendor->catatan
        ]);

        return redirect()->back()
                        ->with('success', 'Rating vendor berhasil diperbarui.');
    }

    /**
     * Get vendor statistics for dashboard
     */
    public function getStatistics()
    {
        $statistics = [
            'total_vendors' => Vendor::count(),
            'active_vendors' => Vendor::active()->count(),
            'new_vendors_this_month' => Vendor::whereMonth('created_at', now()->month)->count(),
            'top_rated_vendors' => Vendor::active()
                                        ->where('rating', '>=', 4)
                                        ->count(),
            'avg_rating' => round(Vendor::active()->avg('rating'), 1),
            'by_category' => Vendor::active()
                                  ->selectRaw('kategori, count(*) as count')
                                  ->whereNotNull('kategori')
                                  ->groupBy('kategori')
                                  ->get(),
            'by_city' => Vendor::active()
                              ->selectRaw('kota, count(*) as count')
                              ->groupBy('kota')
                              ->orderBy('count', 'desc')
                              ->take(10)
                              ->get(),
            'performance_vendors' => Vendor::active()
                                          ->withCount(['pembelians as total_transactions'])
                                          ->with(['pembelians' => function($query) {
                                              $query->selectRaw('vendor_id, sum(total_harga) as total_value')
                                                    ->groupBy('vendor_id');
                                          }])
                                          ->orderBy('total_transactions', 'desc')
                                          ->take(5)
                                          ->get()
        ];

        return response()->json($statistics);
    }

    /**
     * Export vendor data
     */
    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:excel,pdf,csv',
            'status' => 'nullable|in:aktif,non_aktif,suspended',
            'kategori' => 'nullable|string'
        ]);

        // This would be implemented with a proper export library
        // For now, return a placeholder response
        return response()->json([
            'message' => 'Export functionality will be implemented',
            'parameters' => $request->all()
        ]);
    }

    /**
     * Import vendor data
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        // This would be implemented with a proper import library
        // For now, return a placeholder response
        return response()->json([
            'message' => 'Import functionality will be implemented',
            'file_info' => [
                'name' => $request->file('file')->getClientOriginalName(),
                'size' => $request->file('file')->getSize()
            ]
        ]);
    }
}