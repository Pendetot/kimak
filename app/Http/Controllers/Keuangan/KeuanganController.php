<?php

namespace App\Http\Controllers\Keuangan;

use App\Models\PenaltiSP;
use App\Models\HutangKaryawan;
use App\Models\SuratPeringatan;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class KeuanganController extends Controller
{
    public function indexPenalti()
    {
        $suratPeringatans = SuratPeringatan::whereNotNull('penalty_amount')->with(['user', 'hutangKaryawans'])->get();
        return view('keuangan.penalti_sp.index', compact('suratPeringatans'));
    }

    public function indexHutang()
    {
        $hutangKaryawans = HutangKaryawan::with('user', 'suratPeringatan')->latest()->get();
        return view('keuangan.hutang.index', compact('hutangKaryawans'));
    }

    public function showHutang(HutangKaryawan $hutangKaryawan)
    {
        $hutangKaryawan->load('user', 'suratPeringatan');
        return view('keuangan.hutang.show', compact('hutangKaryawan'));
    }

    public function dashboard()
    {
        $totalHutangKaryawan = HutangKaryawan::sum('jumlah');
        $totalHutangBelumLunas = HutangKaryawan::where('status', 'belum_lunas')->sum('jumlah');
        $totalPenaltiSP = PenaltiSP::sum('jumlah_penalti');
        $jumlahKaryawanBerhutang = HutangKaryawan::distinct('karyawan_id')->count('karyawan_id');
        $jumlahKaryawanTerkenaSP = SuratPeringatan::distinct('karyawan_id')->count('karyawan_id');

        return view('keuangan.dashboard', compact('totalHutangKaryawan', 'totalHutangBelumLunas', 'totalPenaltiSP', 'jumlahKaryawanBerhutang', 'jumlahKaryawanTerkenaSP'));
    }

    public function showPaymentConfirmationForm(Pelamar $pelamar)
    {
        return view('keuangan.confirm_payment', compact('pelamar'));
    }

    public function confirmPayment(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $pembayaran = Pembayaran::create([
            'pelamar_id' => $pelamar->id,
            'keuangan_id' => Auth::id(),
            'payment_proof_path' => $paymentProofPath,
            'notes' => $request->input('notes'),
            'status' => 'confirmed',
        ]);

        // Notify HRD
        $hrdUsers = User::where('role', 'hrd')->get();
        foreach ($hrdUsers as $hrdUser) {
            $hrdUser->notify(new PaymentConfirmationNotification($pembayaran));
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}