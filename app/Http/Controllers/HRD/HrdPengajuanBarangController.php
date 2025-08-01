<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Services\PengajuanBarangService;
use Illuminate\Support\Facades\Auth;

class HrdPengajuanBarangController extends Controller
{
    protected $pengajuanBarangService;

    public function __construct(PengajuanBarangService $pengajuanBarangService)
    {
        $this->pengajuanBarangService = $pengajuanBarangService;
    }

    public function create()
    {
        return view('hrd.pengajuan_barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $data = [
            'hrd_id' => Auth::id(),
            'item_name' => $request->input('item_name'),
            'quantity' => $request->input('quantity'),
            'notes' => $request->input('notes'),
        ];

        $pengajuanBarang = $this->pengajuanBarangService->createPengajuan($data);

        // Notify logistic users
        $logisticUsers = \App\Models\User::where('role', \App\Enums\RoleEnum::Logistik->value)->get();
        \Illuminate\Support\Facades\Notification::send($logisticUsers, new \App\Notifications\PengajuanBarangNotification($pengajuanBarang));

        return redirect()->back()->with('success', 'Pengajuan barang berhasil diajukan ke Logistik.');
    }

    public function forwardDocumentsToLogistic(Request $request, Pelamar $pelamar)
    {
        // Logic to handle document forwarding
        // This might involve creating a new record in a table that tracks document submissions
        // and then notifying the logistic department.

        // For now, we'll just simulate the notification
        $logisticUsers = User::where('role', 'logistic')->get();
        Notification::send($logisticUsers, new DocumentsForwardedNotification($pelamar));

        return redirect()->back()->with('success', 'Dokumen berhasil diteruskan ke Logistik.');
    }
}