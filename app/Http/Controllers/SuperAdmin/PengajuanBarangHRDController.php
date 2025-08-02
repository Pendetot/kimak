<?php

namespace App\Http\Controllers\SuperAdmin;

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
     * Display a listing of HRD procurement requests for SuperAdmin final approval
     */
    public function index(Request $request)
    {
        $query = PengajuanBarangHRD::with(['creator', 'logistikApprover']);

        // Filter for SuperAdmin - only show logistik_approved requests
        $query->where('status', 'logistik_approved');

        // Filter berdasarkan prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Filter berdasarkan departemen
        if ($request->filled('departemen')) {
            $query->where('departemen', $request->departemen);
        }

        // Filter berdasarkan budget range
        if ($request->filled('budget_min')) {
            $query->where('total_estimasi', '>=', $request->budget_min);
        }
        if ($request->filled('budget_max')) {
            $query->where('total_estimasi', '<=', $request->budget_max);
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

        $pengajuans = $query->orderByRaw("FIELD(prioritas, 'mendesak', 'tinggi', 'sedang', 'rendah')")
                           ->latest()
                           ->paginate(15);

        // Statistics for SuperAdmin
        $statistics = [
            'pending_approval' => PengajuanBarangHRD::where('status', 'logistik_approved')->count(),
            'total_budget_pending' => PengajuanBarangHRD::where('status', 'logistik_approved')->sum('total_estimasi'),
            'approved_today' => PengajuanBarangHRD::where('status', 'approved')
                                                 ->whereDate('superadmin_approved_at', today())
                                                 ->count(),
            'rejected_today' => PengajuanBarangHRD::where('status', 'superadmin_rejected')
                                                 ->whereDate('updated_at', today())
                                                 ->count(),
            'urgent_requests' => PengajuanBarangHRD::where('status', 'logistik_approved')
                                                  ->where('prioritas', 'mendesak')
                                                  ->count(),
            'high_value_requests' => PengajuanBarangHRD::where('status', 'logistik_approved')
                                                      ->where('total_estimasi', '>', 5000000)
                                                      ->count()
        ];

        // Get unique departments for filter
        $departments = PengajuanBarangHRD::where('status', 'logistik_approved')
                                        ->distinct('departemen')
                                        ->pluck('departemen')
                                        ->filter();

        return view('superadmin.pengajuan_barang_hrd.index', compact('pengajuans', 'statistics', 'departments'));
    }

    /**
     * Display the specified HRD procurement request for approval
     */
    public function show(PengajuanBarangHRD $pengajuanBarang)
    {
        // Only show requests that are awaiting SuperAdmin approval
        if ($pengajuanBarang->status !== 'logistik_approved') {
            return redirect()->route('superadmin.pengajuan-barang-hrd.index')
                           ->with('error', 'Pengajuan ini tidak dapat diakses.');
        }

        $pengajuanBarang->load(['creator', 'logistikApprover', 'pelamar']);
        
        return view('superadmin.pengajuan_barang_hrd.show', compact('pengajuanBarang'));
    }

    /**
     * Approve HRD procurement request by SuperAdmin (Final Approval)
     */
    public function approve(Request $request, PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeApprovedBySuperadmin()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini tidak dapat disetujui.');
        }

        $request->validate([
            'superadmin_notes' => 'nullable|string|max:1000',
            'budget_approved' => 'nullable|numeric|min:0'
        ]);

        DB::transaction(function () use ($request, $pengajuanBarang) {
            // Update pengajuan status
            $pengajuanBarang->update([
                'status' => 'approved',
                'superadmin_approved_by' => auth()->id(),
                'superadmin_approved_at' => now(),
                'superadmin_notes' => $request->superadmin_notes,
                // Update budget if provided
                'total_estimasi' => $request->budget_approved ?? $pengajuanBarang->total_estimasi
            ]);

            // Notify Logistik users to prepare items
            $logistikUsers = User::role(RoleEnum::Logistik)->get();
            foreach ($logistikUsers as $user) {
                Notification::createProcurementNotification(
                    $user->id,
                    'procurement_final_approved',
                    $pengajuanBarang,
                    "Pengajuan barang untuk {$pengajuanBarang->pelamar_name} telah disetujui final, siapkan barang"
                );
            }

            // Notify HRD creator
            Notification::createProcurementNotification(
                $pengajuanBarang->created_by,
                'procurement_final_approved',
                $pengajuanBarang,
                "Pengajuan barang untuk {$pengajuanBarang->pelamar_name} telah disetujui final"
            );
        });

        return redirect()->back()
                        ->with('success', 'Pengajuan berhasil disetujui. Logistik akan menyiapkan barang.');
    }

    /**
     * Reject HRD procurement request by SuperAdmin (Final Rejection)
     */
    public function reject(Request $request, PengajuanBarangHRD $pengajuanBarang)
    {
        if (!$pengajuanBarang->canBeRejectedBySuperadmin()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini tidak dapat ditolak.');
        }

        $request->validate([
            'superadmin_notes' => 'required|string|max:1000',
            'rejection_reason' => 'required|in:budget_exceeded,policy_violation,unnecessary,duplicate,other'
        ]);

        DB::transaction(function () use ($request, $pengajuanBarang) {
            // Update pengajuan status
            $pengajuanBarang->update([
                'status' => 'superadmin_rejected',
                'superadmin_approved_by' => auth()->id(),
                'superadmin_approved_at' => now(),
                'superadmin_notes' => $request->superadmin_notes
            ]);

            // Notify HRD creator
            Notification::createProcurementNotification(
                $pengajuanBarang->created_by,
                'procurement_final_rejected',
                $pengajuanBarang,
                "Pengajuan barang untuk {$pengajuanBarang->pelamar_name} ditolak: {$request->superadmin_notes}"
            );

            // Notify Logistik approver
            if ($pengajuanBarang->logistik_approved_by) {
                Notification::createProcurementNotification(
                    $pengajuanBarang->logistik_approved_by,
                    'procurement_final_rejected',
                    $pengajuanBarang,
                    "Pengajuan barang untuk {$pengajuanBarang->pelamar_name} ditolak SuperAdmin"
                );
            }
        });

        return redirect()->back()
                        ->with('success', 'Pengajuan berhasil ditolak dan dikembalikan ke HRD.');
    }

    /**
     * Show approval form for specific action
     */
    public function showApprovalForm(PengajuanBarangHRD $pengajuanBarang, $action)
    {
        if (!in_array($action, ['approve', 'reject'])) {
            abort(404);
        }

        if ($action === 'approve' && !$pengajuanBarang->canBeApprovedBySuperadmin()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini tidak dapat disetujui.');
        }

        if ($action === 'reject' && !$pengajuanBarang->canBeRejectedBySuperadmin()) {
            return redirect()->back()
                           ->with('error', 'Pengajuan ini tidak dapat ditolak.');
        }

        $pengajuanBarang->load(['creator', 'logistikApprover', 'pelamar']);

        return view('superadmin.pengajuan_barang_hrd.approval_form', compact('pengajuanBarang', 'action'));
    }

    /**
     * Bulk approve multiple requests
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'pengajuan_ids' => 'required|array',
            'pengajuan_ids.*' => 'exists:pengajuan_barang_hrds,id',
            'bulk_notes' => 'nullable|string|max:1000',
            'bulk_budget_limit' => 'nullable|numeric|min:0'
        ]);

        $approvedCount = 0;
        $rejectedCount = 0;
        $errors = [];

        DB::transaction(function () use ($request, &$approvedCount, &$rejectedCount, &$errors) {
            foreach ($request->pengajuan_ids as $id) {
                $pengajuan = PengajuanBarangHRD::find($id);
                
                if ($pengajuan && $pengajuan->canBeApprovedBySuperadmin()) {
                    // Check budget limit if provided
                    if ($request->bulk_budget_limit && $pengajuan->total_estimasi > $request->bulk_budget_limit) {
                        $pengajuan->update([
                            'status' => 'superadmin_rejected',
                            'superadmin_approved_by' => auth()->id(),
                            'superadmin_approved_at' => now(),
                            'superadmin_notes' => $request->bulk_notes . ' (Rejected: Budget exceeds limit)'
                        ]);

                        // Notify about rejection
                        Notification::createProcurementNotification(
                            $pengajuan->created_by,
                            'procurement_final_rejected',
                            $pengajuan
                        );

                        $rejectedCount++;
                    } else {
                        $pengajuan->update([
                            'status' => 'approved',
                            'superadmin_approved_by' => auth()->id(),
                            'superadmin_approved_at' => now(),
                            'superadmin_notes' => $request->bulk_notes
                        ]);

                        // Notify Logistik users
                        $logistikUsers = User::role(RoleEnum::Logistik)->get();
                        foreach ($logistikUsers as $user) {
                            Notification::createProcurementNotification(
                                $user->id,
                                'procurement_final_approved',
                                $pengajuan
                            );
                        }

                        $approvedCount++;
                    }
                } else {
                    $errors[] = "Pengajuan ID {$id} tidak dapat diproses";
                }
            }
        });

        $message = "{$approvedCount} pengajuan disetujui, {$rejectedCount} ditolak";
        if (!empty($errors)) {
            $message .= ". " . implode(", ", $errors);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get approval statistics for SuperAdmin dashboard
     */
    public function getStatistics()
    {
        $statistics = [
            'pending_final_approval' => PengajuanBarangHRD::where('status', 'logistik_approved')->count(),
            'total_budget_pending' => PengajuanBarangHRD::where('status', 'logistik_approved')->sum('total_estimasi'),
            'approved_this_month' => PengajuanBarangHRD::where('status', 'approved')
                                                      ->whereMonth('superadmin_approved_at', now()->month)
                                                      ->count(),
            'rejected_this_month' => PengajuanBarangHRD::where('status', 'superadmin_rejected')
                                                      ->whereMonth('updated_at', now()->month)
                                                      ->count(),
            'avg_approval_time' => PengajuanBarangHRD::whereNotNull('superadmin_approved_at')
                                                    ->whereNotNull('logistik_approved_at')
                                                    ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, logistik_approved_at, superadmin_approved_at)) as avg_hours')
                                                    ->value('avg_hours'),
            'by_priority' => PengajuanBarangHRD::where('status', 'logistik_approved')
                                              ->selectRaw('prioritas, count(*) as count, sum(total_estimasi) as total_budget')
                                              ->groupBy('prioritas')
                                              ->get(),
            'by_department' => PengajuanBarangHRD::where('status', 'logistik_approved')
                                                ->selectRaw('departemen, count(*) as count, sum(total_estimasi) as total_budget')
                                                ->groupBy('departemen')
                                                ->get(),
            'high_value_requests' => PengajuanBarangHRD::where('status', 'logistik_approved')
                                                      ->where('total_estimasi', '>', 5000000)
                                                      ->count()
        ];

        return response()->json($statistics);
    }

    /**
     * Export approval reports
     */
    public function exportReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:excel,pdf'
        ]);

        // This would be implemented with a proper export library
        // For now, return a placeholder response
        return response()->json([
            'message' => 'Export functionality will be implemented',
            'parameters' => $request->all()
        ]);
    }
}