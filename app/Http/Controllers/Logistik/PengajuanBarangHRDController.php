<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangHRD;
use App\Models\User;
use App\Models\Notification;
use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanBarangHRDController extends Controller
{
    /**
     * Display a listing of HRD procurement requests for logistik approval
     */
    public function index(Request $request)
    {
        $query = PengajuanBarangHRD::with(['creator', 'logistikApprover']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default show pending and logistik_approved requests
            $query->whereIn('status', ['pending', 'logistik_approved']);
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

        $pengajuans = $query->orderByRaw("FIELD(status, 'pending', 'logistik_approved')")
                           ->latest()
                           ->paginate(15);

        // Statistics for logistik
        $statistics = [
            'pending_approval' => PengajuanBarangHRD::pending()->count(),
            'approved_by_logistik' => PengajuanBarangHRD::logistikApproved()->count(),
            'approved_final' => PengajuanBarangHRD::approved()->count(),
            'completed_today' => PengajuanBarangHRD::completed()->whereDate('completed_at', today())->count(),
            'total_value_pending' => PengajuanBarangHRD::pending()->sum('total_estimasi'),
            'my_approvals' => PengajuanBarangHRD::where('logistik_approved_by', auth()->id())->count()
        ];

        // Get unique departments for filter
        $departments = PengajuanBarangHRD::distinct('departemen')->pluck('departemen')->filter();

        return view('logistik.pengajuan_barang_hrd.index', compact('pengajuans', 'statistics', 'departments'));
    }

    /**
     * Display the specified HRD procurement request
     */
    public function show(PengajuanBarangHRD $pengajuanBarang)
    {
        $pengajuanBarang->load(['creator', 'logistikApprover', 'superadminApprover', 'completer']);
        
        return view('logistik.pengajuan_barang_hrd.show', compact('pengajuanBarang'));
    }

    /**
     * Approve HRD procurement request by logistik
     */
    public function approve(Request $request, PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeApprovedByLogistik()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini tidak dapat disetujui.');
        }

        $request->validate([
            'logistik_notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request, $pengajuanBarang) {
            // Update pengajuan status
            $pengajuanBarang->update([
                'status' => 'logistik_approved',
                'logistik_approved_by' => auth()->id(),
                'logistik_approved_at' => now(),
                'logistik_notes' => $request->logistik_notes
            ]);

            // Notify SuperAdmin users
            $superadminUsers = User::role(RoleEnum::SuperAdmin)->get();
            foreach ($superadminUsers as $user) {
                Notification::createProcurementNotification(
                    $user->id,
                    'procurement_approved_logistik',
                    $pengajuanBarang,
                    "Pengajuan barang untuk {$pengajuanBarang->pelamar_name} telah disetujui logistik, menunggu approval final"
                );
            }

            // Notify HRD creator
            Notification::createProcurementNotification(
                $pengajuanBarang->created_by,
                'procurement_approved_logistik',
                $pengajuanBarang,
                "Pengajuan barang untuk {$pengajuanBarang->pelamar_name} telah disetujui logistik"
            );
        });

        return redirect()->back()
                        ->with('success', 'Pengajuan berhasil disetujui dan diteruskan ke SuperAdmin.');
    }

    /**
     * Reject HRD procurement request by logistik
     */
    public function reject(Request $request, PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeRejectedByLogistik()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini tidak dapat ditolak.');
        }

        $request->validate([
            'logistik_notes' => 'required|string|max:1000'
        ]);

        DB::transaction(function () use ($request, $pengajuanBarang) {
            // Update pengajuan status
            $pengajuanBarang->update([
                'status' => 'logistik_rejected',
                'logistik_approved_by' => auth()->id(),
                'logistik_approved_at' => now(),
                'logistik_notes' => $request->logistik_notes
            ]);

            // Notify HRD creator
            Notification::createProcurementNotification(
                $pengajuanBarang->created_by,
                'procurement_rejected_logistik',
                $pengajuanBarang,
                "Pengajuan barang untuk {$pengajuanBarang->pelamar_name} ditolak logistik"
            );
        });

        return redirect()->back()
                        ->with('success', 'Pengajuan berhasil ditolak dan dikembalikan ke HRD.');
    }

    /**
     * Complete the approved procurement request (prepare items)
     */
    public function complete(Request $request, PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeCompleted()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini belum dapat diselesaikan.');
        }

        $request->validate([
            'completion_notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($request, $pengajuanBarang) {
            // Update pengajuan status
            $pengajuanBarang->update([
                'status' => 'completed',
                'completed_by' => auth()->id(),
                'completed_at' => now(),
                'completion_notes' => $request->completion_notes
            ]);

            // Notify HRD creator
            Notification::createProcurementNotification(
                $pengajuanBarang->created_by,
                'procurement_completed',
                $pengajuanBarang,
                "Barang untuk pelamar {$pengajuanBarang->pelamar_name} telah disiapkan"
            );
        });

        return redirect()->back()
                        ->with('success', 'Pengajuan berhasil diselesaikan. Barang telah disiapkan untuk pelamar.');
    }

    /**
     * Show approval form
     */
    public function showApprovalForm(PengajuanBarangHRD $pengajuanBarang, $action)
    {
        if (!in_array($action, ['approve', 'reject'])) {
            abort(404);
        }

        if ($action === 'approve' && !$pengajuanBarang->canBeApprovedByLogistik()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini tidak dapat disetujui.');
        }

        if ($action === 'reject' && !$pengajuanBarang->canBeRejectedByLogistik()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini tidak dapat ditolak.');
        }

        return view('logistik.pengajuan_barang_hrd.approval_form', compact('pengajuanBarang', 'action'));
    }

    /**
     * Show completion form
     */
    public function showCompletionForm(PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeCompleted()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini belum dapat diselesaikan.');
        }

        return view('logistik.pengajuan_barang_hrd.completion_form', compact('pengajuanBarang'));
    }

    /**
     * Get procurement statistics for logistik dashboard
     */
    public function getStatistics()
    {
        $statistics = [
            'pending_approval' => PengajuanBarangHRD::pending()->count(),
            'awaiting_superadmin' => PengajuanBarangHRD::logistikApproved()->count(),
            'ready_to_prepare' => PengajuanBarangHRD::approved()->count(),
            'completed_today' => PengajuanBarangHRD::completed()->whereDate('completed_at', today())->count(),
            'total_value_pipeline' => PengajuanBarangHRD::whereIn('status', ['pending', 'logistik_approved', 'approved'])->sum('total_estimasi'),
            'my_approvals_today' => PengajuanBarangHRD::where('logistik_approved_by', auth()->id())
                                                   ->whereDate('logistik_approved_at', today())
                                                   ->count(),
            'by_priority' => PengajuanBarangHRD::whereIn('status', ['pending', 'logistik_approved'])
                                              ->selectRaw('prioritas, count(*) as count')
                                              ->groupBy('prioritas')
                                              ->get(),
            'urgent_requests' => PengajuanBarangHRD::where('prioritas', 'mendesak')
                                                  ->whereIn('status', ['pending', 'logistik_approved'])
                                                  ->count()
        ];

        return response()->json($statistics);
    }

    /**
     * Bulk approve multiple requests
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'pengajuan_ids' => 'required|array',
            'pengajuan_ids.*' => 'exists:pengajuan_barang_hrds,id',
            'bulk_notes' => 'nullable|string|max:1000'
        ]);

        $approvedCount = 0;
        $errors = [];

        DB::transaction(function () use ($request, &$approvedCount, &$errors) {
            foreach ($request->pengajuan_ids as $id) {
                $pengajuan = PengajuanBarangHRD::find($id);
                
                if ($pengajuan && $pengajuan->canBeApprovedByLogistik()) {
                    $pengajuan->update([
                        'status' => 'logistik_approved',
                        'logistik_approved_by' => auth()->id(),
                        'logistik_approved_at' => now(),
                        'logistik_notes' => $request->bulk_notes
                    ]);

                    // Notify SuperAdmin users
                    $superadminUsers = User::role(RoleEnum::SuperAdmin)->get();
                    foreach ($superadminUsers as $user) {
                        Notification::createProcurementNotification(
                            $user->id,
                            'procurement_approved_logistik',
                            $pengajuan
                        );
                    }

                    $approvedCount++;
                } else {
                    $errors[] = "Pengajuan ID {$id} tidak dapat disetujui";
                }
            }
        });

        $message = "{$approvedCount} pengajuan berhasil disetujui";
        if (!empty($errors)) {
            $message .= ". " . implode(", ", $errors);
        }

        return redirect()->back()->with('success', $message);
    }
}