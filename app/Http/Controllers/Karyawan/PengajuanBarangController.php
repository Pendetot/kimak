<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarang;
use App\Enums\StatusPengajuanEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PengajuanBarang::where('karyawan_id', Auth::guard('karyawan')->id());

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Filter berdasarkan bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        $pengajuans = $query->latest()->paginate(10);

        // Statistics
        $statistics = [
            'total' => PengajuanBarang::where('karyawan_id', Auth::guard('karyawan')->id())->count(),
            'pending' => PengajuanBarang::where('karyawan_id', Auth::guard('karyawan')->id())
                                      ->where('status', StatusPengajuanEnum::Pending)->count(),
            'approved' => PengajuanBarang::where('karyawan_id', Auth::guard('karyawan')->id())
                                       ->where('status', StatusPengajuanEnum::Approved)->count(),
            'rejected' => PengajuanBarang::where('karyawan_id', Auth::guard('karyawan')->id())
                                       ->where('status', StatusPengajuanEnum::Rejected)->count(),
            'delivered' => PengajuanBarang::where('karyawan_id', Auth::guard('karyawan')->id())
                                        ->where('status', StatusPengajuanEnum::Delivered)->count()
        ];

        return view('karyawan.pengajuan_barang.index', compact('pengajuans', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.pengajuan_barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:500',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'harga_estimasi' => 'nullable|numeric|min:0',
            'keperluan' => 'required|string|max:500',
            'prioritas' => 'required|in:rendah,sedang,tinggi,mendesak',
            'tanggal_dibutuhkan' => 'required|date|after:today',
            'catatan' => 'nullable|string|max:500'
        ]);

        $data = $request->all();
        $data['karyawan_id'] = Auth::guard('karyawan')->id();
        $data['status'] = StatusPengajuanEnum::Pending;

        PengajuanBarang::create($data);

        return redirect()->route('karyawan.pengajuan-barang.index')
                        ->with('success', 'Pengajuan barang berhasil disubmit. Menunggu persetujuan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengajuanBarang $pengajuanBarang)
    {
        // Ensure karyawan can only view their own pengajuan
        if ($pengajuanBarang->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('karyawan.pengajuan_barang.show', compact('pengajuanBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanBarang $pengajuanBarang)
    {
        // Ensure karyawan can only edit their own pengajuan
        if ($pengajuanBarang->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow edit if status is pending
        if ($pengajuanBarang->status !== StatusPengajuanEnum::Pending) {
            return redirect()->route('karyawan.pengajuan-barang.show', $pengajuanBarang)
                           ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        return view('karyawan.pengajuan_barang.edit', compact('pengajuanBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanBarang $pengajuanBarang)
    {
        // Ensure karyawan can only edit their own pengajuan
        if ($pengajuanBarang->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow edit if status is pending
        if ($pengajuanBarang->status !== StatusPengajuanEnum::Pending) {
            return redirect()->route('karyawan.pengajuan-barang.show', $pengajuanBarang)
                           ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:500',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'harga_estimasi' => 'nullable|numeric|min:0',
            'keperluan' => 'required|string|max:500',
            'prioritas' => 'required|in:rendah,sedang,tinggi,mendesak',
            'tanggal_dibutuhkan' => 'required|date|after:today',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pengajuanBarang->update($request->all());

        return redirect()->route('karyawan.pengajuan-barang.index')
                        ->with('success', 'Pengajuan barang berhasil diperbarui.');
    }

    /**
     * Cancel pending pengajuan
     */
    public function cancel(PengajuanBarang $pengajuanBarang)
    {
        // Ensure karyawan can only cancel their own pengajuan
        if ($pengajuanBarang->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow cancel if status is pending
        if ($pengajuanBarang->status !== StatusPengajuanEnum::Pending) {
            return redirect()->route('karyawan.pengajuan-barang.show', $pengajuanBarang)
                           ->with('error', 'Pengajuan yang sudah diproses tidak dapat dibatalkan.');
        }

        $pengajuanBarang->update(['status' => StatusPengajuanEnum::Cancelled]);

        return redirect()->route('karyawan.pengajuan-barang.index')
                        ->with('success', 'Pengajuan barang berhasil dibatalkan.');
    }

    /**
     * Get approval progress for pengajuan
     */
    public function getApprovalProgress(PengajuanBarang $pengajuanBarang)
    {
        if ($pengajuanBarang->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        $progress = $pengajuanBarang->getApprovalProgress();

        return response()->json([
            'success' => true,
            'data' => $progress
        ]);
    }

    /**
     * Confirm receipt of delivered items
     */
    public function confirmReceipt(Request $request, PengajuanBarang $pengajuanBarang)
    {
        // Ensure karyawan can only confirm their own pengajuan
        if ($pengajuanBarang->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow confirmation if item has been delivered
        if ($pengajuanBarang->status !== StatusPengajuanEnum::Delivered) {
            return response()->json([
                'success' => false,
                'message' => 'Item belum dalam status delivered.'
            ], 400);
        }

        $request->validate([
            'konfirmasi_penerimaan' => 'required|boolean',
            'catatan_penerimaan' => 'nullable|string|max:500'
        ]);

        $pengajuanBarang->update([
            'received_by' => Auth::guard('karyawan')->id(),
            'received_at' => now(),
            'catatan_penerimaan' => $request->catatan_penerimaan,
            'konfirmasi_penerimaan' => $request->konfirmasi_penerimaan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Konfirmasi penerimaan barang berhasil.'
        ]);
    }
}