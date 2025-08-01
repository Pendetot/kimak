<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pembayaran;
use App\Models\User;
use App\Notifications\PaymentConfirmationNotification;
use App\Models\PelamarDocument;

class AdministrasiPelamarController extends Controller
{
    public function index()
    {
        $pelamars = Pelamar::all();
        return view('hrd.administrasi_pelamar.index', compact('pelamars'));
    }

    public function show(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.show', compact('pelamar'));
    }

    public function approve(Pelamar $pelamar)
    {
        $pelamar->status = 'diterima';
        $pelamar->save();
        return redirect()->back()->with('success', 'Pelamar berhasil diterima.');
    }

    public function reject(Pelamar $pelamar)
    {
        $pelamar->status = 'ditolak';
        $pelamar->save();
        return redirect()->back()->with('success', 'Pelamar berhasil ditolak.');
    }

    public function destroy(Pelamar $pelamar)
    {
        $pelamar->delete();
        return redirect()->back()->with('success', 'Pelamar berhasil dihapus.');
    }

    public function showUploadPaymentProofForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.upload_payment_proof', compact('pelamar'));
    }

    public function uploadPaymentProof(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $pembayaran = Pembayaran::create([
            'pelamar_id' => $pelamar->id,
            'hrd_id' => auth()->id(), // Assuming HRD user is logged in
            'payment_proof_path' => $paymentProofPath,
            'notes' => $request->input('notes'),
            'status' => 'pending_keuangan_approval',
        ]);

        // Notify Keuangan
        $keuanganUsers = User::where('role', 'keuangan')->get();
        foreach ($keuanganUsers as $keuanganUser) {
            $keuanganUser->notify(new PaymentConfirmationNotification($pembayaran));
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah dan menunggu konfirmasi Keuangan.');
    }
}