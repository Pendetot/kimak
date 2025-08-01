<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanBarang;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PurchaseRequestDecisionNotification;

class DirectorPengajuanBarangController extends Controller
{
    public function index()
    {
        $pengajuanBarangs = PengajuanBarang::where('logistic_status', 'authorized')->get();
        return view('superadmin.pengajuan_barang.index', compact('pengajuanBarangs'));
    }

    public function approve(Request $request, PengajuanBarang $pengajuanBarang)
    {
        $pengajuanBarang->director_status = 'approved';
        $pengajuanBarang->director_notes = $request->input('notes');
        $pengajuanBarang->status = 'approved_by_director';
        $pengajuanBarang->save();

        // Notify Logistic
        $logisticUsers = User::where('role', RoleEnum::Logistik->value)->get();
        Notification::send($logisticUsers, new PurchaseRequestDecisionNotification($pengajuanBarang, 'approved'));

        return redirect()->back()->with('success', 'Pengajuan barang telah disetujui.');
    }

    public function reject(Request $request, PengajuanBarang $pengajuanBarang)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        $pengajuanBarang->director_status = 'rejected';
        $pengajuanBarang->director_notes = $request->input('notes');
        $pengajuanBarang->status = 'rejected_by_director';
        $pengajuanBarang->save();

        // Notify Logistic
        $logisticUsers = User::where('role', RoleEnum::Logistik->value)->get();
        Notification::send($logisticUsers, new PurchaseRequestDecisionNotification($pengajuanBarang, 'rejected'));

        return redirect()->back()->with('success', 'Pengajuan barang telah ditolak.');
    }

    public function postpone(Request $request, PengajuanBarang $pengajuanBarang)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        $pengajuanBarang->director_status = 'postponed';
        $pengajuanBarang->director_notes = $request->input('notes');
        $pengajuanBarang->status = 'postponed_by_director';
        $pengajuanBarang->save();

        // Notify Logistic
        $logisticUsers = User::where('role', RoleEnum::Logistik->value)->get();
        Notification::send($logisticUsers, new PurchaseRequestDecisionNotification($pengajuanBarang, 'postponed'));

        return redirect()->back()->with('success', 'Pengajuan barang telah ditunda.');
    }
}
