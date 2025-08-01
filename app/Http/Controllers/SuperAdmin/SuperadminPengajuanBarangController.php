<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Services\PengajuanBarangService;
use App\Models\PengajuanBarang;
use App\Models\PembelianBarang;
use App\Models\User;
use App\Notifications\PurchaseRequestDecisionNotification;

class SuperadminPengajuanBarangController extends Controller
{
    protected $pengajuanBarangService;

    public function __construct(PengajuanBarangService $pengajuanBarangService)
    {
        $this->pengajuanBarangService = $pengajuanBarangService;
    }

    public function index()
    {
        $pendingRequests = PengajuanBarang::where('status', 'pending_superadmin_approval')->get();
        return view('superadmin.pengajuan_barang.index', compact('pendingRequests'));
    }

    public function approve(Request $request, PengajuanBarang $pengajuan)
    {
        $request->validate([
            'superadmin_notes' => 'nullable|string',
        ]);

        $this->pengajuanBarangService->approveBySuperadmin($pengajuan, $request->input('superadmin_notes'));

        return redirect()->back()->with('success', 'Pengajuan barang berhasil disetujui.');
    }

    public function reject(Request $request, PengajuanBarang $pengajuan)
    {
        $request->validate([
            'superadmin_notes' => 'required|string',
        ]);

        $this->pengajuanBarangService->rejectBySuperadmin($pengajuan, $request->input('superadmin_notes'));

        return redirect()->back()->with('success', 'Pengajuan barang ditolak dan notifikasi dikirim ke Logistik.');
    }

    public function approvePurchaseRequest(Request $request, PembelianBarang $pembelian)
    {
        $request->validate([
            'superadmin_notes' => 'nullable|string',
        ]);

        $pembelian->update([
            'status' => 'approved',
            'superadmin_id' => auth()->id(),
            'notes' => $request->input('superadmin_notes'),
        ]);

        // Notify Logistic
        $logisticUser = User::find($pembelian->logistic_id);
        if ($logisticUser) {
            $logisticUser->notify(new PurchaseRequestDecisionNotification($pembelian, 'approved'));
        }

        return redirect()->back()->with('success', 'Permintaan pembelian berhasil disetujui.');
    }

    public function rejectPurchaseRequest(Request $request, PembelianBarang $pembelian)
    {
        $request->validate([
            'superadmin_notes' => 'required|string',
        ]);

        $pembelian->update([
            'status' => 'rejected',
            'superadmin_id' => auth()->id(),
            'notes' => $request->input('superadmin_notes'),
        ]);

        // Notify Logistic
        $logisticUser = User::find($pembelian->logistic_id);
        if ($logisticUser) {
            $logisticUser->notify(new PurchaseRequestDecisionNotification($pembelian, 'rejected'));
        }

        return redirect()->back()->with('success', 'Permintaan pembelian ditolak.');
    }

    public function indexPembelianBarang()
    {
        $pembelianBarangs = PembelianBarang::all();
        return view('superadmin.pembelian_barang.index', compact('pembelianBarangs'));
    }
}