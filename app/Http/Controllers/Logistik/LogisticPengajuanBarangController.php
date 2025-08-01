<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanBarang;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PurchaseRequestDecisionNotification;

class LogisticPengajuanBarangController extends Controller
{
    public function index()
    {
        $pengajuanBarangs = PengajuanBarang::all();
        return view('logistik.pengajuan_barang.index', compact('pengajuanBarangs'));
    }

    public function show(PengajuanBarang $pengajuanBarang)
    {
        return view('logistik.pengajuan_barang.show', compact('pengajuanBarang'));
    }

    public function authorizeByLogistic(Request $request, PengajuanBarang $pengajuanBarang)
    {
        $pengajuanBarang->logistic_status = 'authorized';
        $pengajuanBarang->logistic_notes = $request->input('notes');
        $pengajuanBarang->save();

        // Notify Director
        $directorUsers = User::where('role', RoleEnum::SuperAdmin->value)->get(); // Assuming SuperAdmin is Director
        Notification::send($directorUsers, new PurchaseRequestDecisionNotification($pengajuanBarang, 'pending_director_approval'));

        return redirect()->back()->with('success', 'Pengajuan barang telah diotorisasi oleh Logistik dan diteruskan ke Direktur.');
    }

    public function markAsReady(PengajuanBarang $pengajuanBarang)
    {
        $pengajuanBarang->status = 'ready';
        $pengajuanBarang->save();

        // Notify HRD
        $hrdUser = User::find($pengajuanBarang->hrd_id);
        if ($hrdUser) {
            Notification::send($hrdUser, new \App\Notifications\ItemReadyNotification($pengajuanBarang));
        }

        return redirect()->back()->with('success', 'Barang telah ditandai siap dan HRD telah diberitahu.');
    }

    public function markAsNotReady(Request $request, PengajuanBarang $pengajuanBarang)
    {
        $pengajuanBarang->status = 'not_ready';
        $pengajuanBarang->logistic_notes = $request->input('notes');
        $pengajuanBarang->save();

        // Notify HRD
        $hrdUser = User::find($pengajuanBarang->hrd_id);
        if ($hrdUser) {
            Notification::send($hrdUser, new \App\Notifications\ItemReadyNotification($pengajuanBarang)); // Re-use ItemReadyNotification for simplicity, or create a new one
        }

        return redirect()->back()->with('success', 'Barang telah ditandai tidak siap dan HRD telah diberitahu.');
    }
}
