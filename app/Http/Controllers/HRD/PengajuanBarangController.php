<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangHRD;
use App\Models\Pelamar;
use App\Models\User;
use App\Models\Notification;
use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanBarangController extends Controller
{
    /**
     * Display a listing of procurement requests
     */
    public function index(Request $request)
    {
        $query = PengajuanBarangHRD::with(['creator', 'logistikApprover', 'superadminApprover']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Filter berdasarkan departemen
        if ($request->filled('departemen')) {
            $query->where('departemen', $request->departemen);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pelamar_name', 'like', "%{$search}%")
                  ->orWhere('posisi_diterima', 'like', "%{$search}%")
                  ->orWhere('departemen', 'like', "%{$search}%");
            });
        }

        $pengajuans = $query->latest()->paginate(15);

        // Statistics
        $statistics = [
            'total' => PengajuanBarangHRD::count(),
            'pending' => PengajuanBarangHRD::pending()->count(),
            'logistik_approved' => PengajuanBarangHRD::logistikApproved()->count(),
            'approved' => PengajuanBarangHRD::approved()->count(),
            'rejected' => PengajuanBarangHRD::rejected()->count(),
            'completed' => PengajuanBarangHRD::completed()->count(),
            'total_value' => PengajuanBarangHRD::sum('total_estimasi')
        ];

        // Get unique departments for filter
        $departments = PengajuanBarangHRD::distinct('departemen')->pluck('departemen')->filter();

        return view('hrd.pengajuan_barang.index', compact('pengajuans', 'statistics', 'departments'));
    }

    /**
     * Show the form for creating a new procurement request
     */
    public function create()
    {
        // Get recently accepted pelamars
        $pelamars = Pelamar::where('status', 'diterima')
                          ->latest()
                          ->take(20)
                          ->get();

        return view('hrd.pengajuan_barang.create', compact('pelamars'));
    }

    /**
     * Store a newly created procurement request
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelamar_id' => 'nullable|exists:pelamars,id',
            'pelamar_name' => 'required|string|max:255',
            'posisi_diterima' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date|after_or_equal:today',
            'departemen' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.nama_barang' => 'required|string|max:255',
            'items.*.spesifikasi' => 'nullable|string|max:500',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.estimasi_harga' => 'nullable|numeric|min:0',
            'items.*.keperluan' => 'nullable|string|max:255',
            'keperluan' => 'required|string|max:1000',
            'prioritas' => 'required|in:rendah,sedang,tinggi,mendesak',
            'tanggal_dibutuhkan' => 'required|date|after:today',
            'catatan_hrd' => 'nullable|string|max:1000'
        ]);

        // Calculate total estimasi
        $totalEstimasi = 0;
        foreach ($request->items as $item) {
            $totalEstimasi += ($item['jumlah'] * ($item['estimasi_harga'] ?? 0));
        }

        DB::transaction(function () use ($request, $totalEstimasi) {
            // Create procurement request
            $pengajuan = PengajuanBarangHRD::create([
                'pelamar_id' => $request->pelamar_id,
                'pelamar_name' => $request->pelamar_name,
                'posisi_diterima' => $request->posisi_diterima,
                'tanggal_masuk' => $request->tanggal_masuk,
                'departemen' => $request->departemen,
                'items' => $request->items,
                'total_estimasi' => $totalEstimasi,
                'keperluan' => $request->keperluan,
                'prioritas' => $request->prioritas,
                'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan,
                'catatan_hrd' => $request->catatan_hrd,
                'status' => 'pending',
                'created_by' => auth()->id()
            ]);

            // Notify all logistik users
            $logistikUsers = User::role(RoleEnum::Logistik)->get();
            foreach ($logistikUsers as $user) {
                Notification::createProcurementNotification(
                    $user->id,
                    'procurement_request',
                    $pengajuan,
                    "Pengajuan barang untuk pelamar {$pengajuan->pelamar_name} memerlukan persetujuan logistik"
                );
            }
        });

        return redirect()->route('hrd.pengajuan-barang.index')
                        ->with('success', 'Pengajuan barang berhasil dibuat dan dikirim ke logistik.');
    }

    /**
     * Display the specified procurement request
     */
    public function show(PengajuanBarangHRD $pengajuanBarang)
    {
        $pengajuanBarang->load(['creator', 'logistikApprover', 'superadminApprover', 'completer']);
        
        return view('hrd.pengajuan_barang.show', compact('pengajuanBarang'));
    }

    /**
     * Show the form for editing the specified procurement request
     */
    public function edit(PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeApprovedByLogistik()) {
            return redirect()->route('hrd.pengajuan-barang.show', $pengajuanBarang)
                           ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $pelamars = Pelamar::where('status', 'diterima')
                          ->latest()
                          ->take(20)
                          ->get();

        return view('hrd.pengajuan_barang.edit', compact('pengajuanBarang', 'pelamars'));
    }

    /**
     * Update the specified procurement request
     */
    public function update(Request $request, PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeApprovedByLogistik()) {
            return redirect()->route('hrd.pengajuan-barang.show', $pengajuanBarang)
                           ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $request->validate([
            'pelamar_id' => 'nullable|exists:pelamars,id',
            'pelamar_name' => 'required|string|max:255',
            'posisi_diterima' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date|after_or_equal:today',
            'departemen' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.nama_barang' => 'required|string|max:255',
            'items.*.spesifikasi' => 'nullable|string|max:500',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.estimasi_harga' => 'nullable|numeric|min:0',
            'items.*.keperluan' => 'nullable|string|max:255',
            'keperluan' => 'required|string|max:1000',
            'prioritas' => 'required|in:rendah,sedang,tinggi,mendesak',
            'tanggal_dibutuhkan' => 'required|date|after:today',
            'catatan_hrd' => 'nullable|string|max:1000'
        ]);

        // Calculate total estimasi
        $totalEstimasi = 0;
        foreach ($request->items as $item) {
            $totalEstimasi += ($item['jumlah'] * ($item['estimasi_harga'] ?? 0));
        }

        $pengajuanBarang->update([
            'pelamar_id' => $request->pelamar_id,
            'pelamar_name' => $request->pelamar_name,
            'posisi_diterima' => $request->posisi_diterima,
            'tanggal_masuk' => $request->tanggal_masuk,
            'departemen' => $request->departemen,
            'items' => $request->items,
            'total_estimasi' => $totalEstimasi,
            'keperluan' => $request->keperluan,
            'prioritas' => $request->prioritas,
            'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan,
            'catatan_hrd' => $request->catatan_hrd
        ]);

        return redirect()->route('hrd.pengajuan-barang.index')
                        ->with('success', 'Pengajuan barang berhasil diperbarui.');
    }

    /**
     * Remove the specified procurement request
     */
    public function destroy(PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeApprovedByLogistik()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan yang sudah diproses tidak dapat dihapus.');
        }

        $pengajuanBarang->delete();

        return redirect()->route('hrd.pengajuan-barang.index')
                        ->with('success', 'Pengajuan barang berhasil dihapus.');
    }

    /**
     * Get procurement statistics for dashboard
     */
    public function getStatistics()
    {
        $statistics = [
            'today' => [
                'requests' => PengajuanBarangHRD::whereDate('created_at', today())->count(),
                'value' => PengajuanBarangHRD::whereDate('created_at', today())->sum('total_estimasi')
            ],
            'this_month' => [
                'requests' => PengajuanBarangHRD::whereMonth('created_at', now()->month)->count(),
                'value' => PengajuanBarangHRD::whereMonth('created_at', now()->month)->sum('total_estimasi')
            ],
            'by_status' => PengajuanBarangHRD::selectRaw('status, count(*) as count')
                                           ->groupBy('status')
                                           ->get(),
            'by_priority' => PengajuanBarangHRD::selectRaw('prioritas, count(*) as count')
                                             ->groupBy('prioritas')
                                             ->get(),
            'by_department' => PengajuanBarangHRD::selectRaw('departemen, count(*) as count')
                                                ->groupBy('departemen')
                                                ->get()
        ];

        return response()->json($statistics);
    }

    /**
     * Duplicate procurement request for similar new employee
     */
    public function duplicate(PengajuanBarangHRD $pengajuanBarang)
    {
        $pelamars = Pelamar::where('status', 'diterima')
                          ->latest()
                          ->take(20)
                          ->get();

        return view('hrd.pengajuan_barang.duplicate', compact('pengajuanBarang', 'pelamars'));
    }

    /**
     * Store duplicated procurement request
     */
    public function storeDuplicate(Request $request, PengajuanBarangHRD $pengajuanBarang)
    {
        $request->validate([
            'pelamar_id' => 'nullable|exists:pelamars,id',
            'pelamar_name' => 'required|string|max:255',
            'posisi_diterima' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date|after_or_equal:today',
            'departemen' => 'required|string|max:255',
            'catatan_hrd' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request, $pengajuanBarang) {
            // Create duplicated procurement request
            $newPengajuan = PengajuanBarangHRD::create([
                'pelamar_id' => $request->pelamar_id,
                'pelamar_name' => $request->pelamar_name,
                'posisi_diterima' => $request->posisi_diterima,
                'tanggal_masuk' => $request->tanggal_masuk,
                'departemen' => $request->departemen,
                'items' => $pengajuanBarang->items, // Copy items from original
                'total_estimasi' => $pengajuanBarang->total_estimasi,
                'keperluan' => $pengajuanBarang->keperluan,
                'prioritas' => $pengajuanBarang->prioritas,
                'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan ?? $pengajuanBarang->tanggal_dibutuhkan,
                'catatan_hrd' => $request->catatan_hrd,
                'status' => 'pending',
                'created_by' => auth()->id()
            ]);

            // Notify all logistik users
            $logistikUsers = User::role(RoleEnum::Logistik)->get();
            foreach ($logistikUsers as $user) {
                Notification::createProcurementNotification(
                    $user->id,
                    'procurement_request',
                    $newPengajuan,
                    "Pengajuan barang duplikat untuk pelamar {$newPengajuan->pelamar_name} memerlukan persetujuan logistik"
                );
            }
        });

        return redirect()->route('hrd.pengajuan-barang.index')
                        ->with('success', 'Pengajuan barang berhasil diduplikasi dan dikirim ke logistik.');
    }
}