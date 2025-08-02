<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarang;
use App\Models\Pembelian;
use App\Models\Vendor;
use App\Enums\StatusPengajuanEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Display a listing of purchases
     */
    public function index(Request $request)
    {
        $query = Pembelian::with(['pengajuanBarang.karyawan', 'vendor']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan vendor
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_pembelian', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $pembelians = $query->latest()->paginate(15);

        // Statistics
        $statistics = [
            'total_pembelian' => Pembelian::count(),
            'pending' => Pembelian::where('status', 'pending')->count(),
            'diproses' => Pembelian::where('status', 'diproses')->count(),
            'selesai' => Pembelian::where('status', 'selesai')->count(),
            'total_nilai' => Pembelian::where('status', 'selesai')->sum('total_harga')
        ];

        $vendors = Vendor::all();

        return view('logistik.pembelian.index', compact('pembelians', 'statistics', 'vendors'));
    }

    /**
     * Show the form for creating a new purchase
     */
    public function create()
    {
        // Get approved pengajuan barang that haven't been purchased
        $pengajuanBarangs = PengajuanBarang::where('status', StatusPengajuanEnum::Approved)
                                         ->whereNull('purchased_by')
                                         ->with('karyawan')
                                         ->get();

        $vendors = Vendor::where('status', 'aktif')->get();

        return view('logistik.pembelian.create', compact('pengajuanBarangs', 'vendors'));
    }

    /**
     * Store a newly created purchase
     */
    public function store(Request $request)
    {
        $request->validate([
            'pengajuan_barang_ids' => 'required|array',
            'pengajuan_barang_ids.*' => 'exists:pengajuan_barangs,id',
            'vendor_id' => 'required|exists:vendors,id',
            'tanggal_pembelian' => 'required|date',
            'total_harga' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer,kredit',
            'catatan' => 'nullable|string|max:500'
        ]);

        DB::transaction(function () use ($request) {
            // Create pembelian record
            $pembelian = Pembelian::create([
                'vendor_id' => $request->vendor_id,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'total_harga' => $request->total_harga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'catatan' => $request->catatan,
                'status' => 'pending',
                'created_by' => auth()->id()
            ]);

            // Update pengajuan barang status
            PengajuanBarang::whereIn('id', $request->pengajuan_barang_ids)
                          ->update([
                              'status' => StatusPengajuanEnum::Purchased,
                              'purchased_by' => auth()->id(),
                              'purchased_at' => now(),
                              'pembelian_id' => $pembelian->id
                          ]);
        });

        return redirect()->route('logistik.pembelian.index')
                        ->with('success', 'Pembelian berhasil dibuat.');
    }

    /**
     * Display the specified purchase
     */
    public function show(Pembelian $pembelian)
    {
        $pembelian->load(['pengajuanBarang.karyawan', 'vendor', 'creator']);
        
        return view('logistik.pembelian.show', compact('pembelian'));
    }

    /**
     * Show the form for editing the specified purchase
     */
    public function edit(Pembelian $pembelian)
    {
        if ($pembelian->status !== 'pending') {
            return redirect()->route('logistik.pembelian.show', $pembelian)
                           ->with('error', 'Pembelian yang sudah diproses tidak dapat diubah.');
        }

        $vendors = Vendor::where('status', 'aktif')->get();
        $pembelian->load(['pengajuanBarang.karyawan', 'vendor']);

        return view('logistik.pembelian.edit', compact('pembelian', 'vendors'));
    }

    /**
     * Update the specified purchase
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        if ($pembelian->status !== 'pending') {
            return redirect()->route('logistik.pembelian.show', $pembelian)
                           ->with('error', 'Pembelian yang sudah diproses tidak dapat diubah.');
        }

        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'tanggal_pembelian' => 'required|date',
            'total_harga' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer,kredit',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pembelian->update($request->all());

        return redirect()->route('logistik.pembelian.index')
                        ->with('success', 'Pembelian berhasil diperbarui.');
    }

    /**
     * Update purchase status to processed
     */
    public function process(Pembelian $pembelian)
    {
        if ($pembelian->status !== 'pending') {
            return redirect()->back()
                           ->with('error', 'Pembelian sudah diproses sebelumnya.');
        }

        $pembelian->update([
            'status' => 'diproses',
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);

        return redirect()->back()
                        ->with('success', 'Status pembelian berhasil diubah menjadi diproses.');
    }

    /**
     * Complete the purchase
     */
    public function complete(Request $request, Pembelian $pembelian)
    {
        if ($pembelian->status !== 'diproses') {
            return redirect()->back()
                           ->with('error', 'Pembelian harus dalam status diproses untuk diselesaikan.');
        }

        $request->validate([
            'tanggal_selesai' => 'required|date|after_or_equal:' . $pembelian->tanggal_pembelian,
            'catatan_penyelesaian' => 'nullable|string|max:500'
        ]);

        DB::transaction(function () use ($request, $pembelian) {
            $pembelian->update([
                'status' => 'selesai',
                'tanggal_selesai' => $request->tanggal_selesai,
                'catatan_penyelesaian' => $request->catatan_penyelesaian,
                'completed_at' => now(),
                'completed_by' => auth()->id()
            ]);

            // Update related pengajuan barang to delivered status
            PengajuanBarang::where('pembelian_id', $pembelian->id)
                          ->update([
                              'status' => StatusPengajuanEnum::Delivered,
                              'delivered_at' => now()
                          ]);
        });

        return redirect()->back()
                        ->with('success', 'Pembelian berhasil diselesaikan dan barang telah dikirim.');
    }

    /**
     * Get purchase statistics for dashboard
     */
    public function getStatistics()
    {
        $statistics = [
            'today' => [
                'pembelian' => Pembelian::whereDate('created_at', today())->count(),
                'nilai' => Pembelian::whereDate('created_at', today())->sum('total_harga')
            ],
            'this_month' => [
                'pembelian' => Pembelian::whereMonth('created_at', now()->month)->count(),
                'nilai' => Pembelian::whereMonth('created_at', now()->month)->sum('total_harga')
            ],
            'by_status' => Pembelian::selectRaw('status, count(*) as count')
                                  ->groupBy('status')
                                  ->get(),
            'top_vendors' => Vendor::withCount('pembelians')
                                  ->orderBy('pembelians_count', 'desc')
                                  ->take(5)
                                  ->get()
        ];

        return response()->json($statistics);
    }
}