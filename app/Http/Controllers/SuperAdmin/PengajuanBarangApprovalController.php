<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarang;
use App\Models\PembelianBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanBarangApprovalController extends Controller
{
    public function index()
    {
        $pengajuanBarangs = PengajuanBarang::with('requester')->get();
        return view('superadmin.pengajuan_barang_approval.index', compact('pengajuanBarangs'));
    }

    public function show(PengajuanBarang $pengajuanBarang)
    {
        return view('superadmin.pengajuan_barang_approval.show', compact('pengajuanBarang'));
    }

    public function approve(Request $request, PengajuanBarang $pengajuanBarang)
    {
        if ($pengajuanBarang->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah tidak pending.');
        }

        $pengajuanBarang->update([
            'status' => 'approved',
            'superadmin_approved_at' => now(),
            'superadmin_notes' => $request->superadmin_notes,
        ]);

        PembelianBarang::create([
            'pengajuan_barang_id' => $pengajuanBarang->id,
            'item_name' => $pengajuanBarang->item_name,
            'quantity' => $pengajuanBarang->quantity,
            'notes' => $pengajuanBarang->notes,
            'logistic_id' => $pengajuanBarang->requester_id,
            'status' => 'pending', // Status for the purchase order itself
        ]);

        return redirect()->route('superadmin.pengajuan-barang-approval.index')->with('success', 'Pengajuan barang berhasil disetujui dan pembelian barang dibuat.');
    }

    public function reject(Request $request, PengajuanBarang $pengajuanBarang)
    {
        if ($pengajuanBarang->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah tidak pending.');
        }

        $pengajuanBarang->update([
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'superadmin_notes' => $request->superadmin_notes,
        ]);

        return redirect()->route('superadmin.pengajuan-barang-approval.index')->with('success', 'Pengajuan barang berhasil ditolak.');
    }
}
