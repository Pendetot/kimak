<?php

namespace App\Services;

use App\Models\PengajuanBarang;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PengajuanBarangNotification;

class PengajuanBarangService
{
    public function createPengajuan(array $data)
    {
        $pengajuan = PengajuanBarang::create($data);

        // Notify Logistic
        $logisticUsers = User::where('role', 'logistic')->get();
        Notification::send($logisticUsers, new PengajuanBarangNotification($pengajuan, 'new_request_logistic'));

        return $pengajuan;
    }

    public function approveByLogistic(PengajuanBarang $pengajuan, string $notes = null)
    {
        $pengajuan->update([
            'status' => 'pending_superadmin_approval',
            'logistic_notes' => $notes,
            'logistic_approved_at' => now(),
        ]);

        // Notify Superadmin
        $superadminUsers = User::where('role', 'superadmin')->get();
        Notification::send($superadminUsers, new PengajuanBarangNotification($pengajuan, 'new_request_superadmin'));

        return $pengajuan;
    }

    public function rejectByLogistic(PengajuanBarang $pengajuan, string $notes = null)
    {
        $pengajuan->update([
            'status' => 'rejected',
            'logistic_notes' => $notes,
            'rejected_by' => 'logistic',
            'rejected_at' => now(),
        ]);

        // Notify HRD
        Notification::send($pengajuan->hrd, new PengajuanBarangNotification($pengajuan, 'rejected_by_logistic'));

        return $pengajuan;
    }

    public function approveBySuperadmin(PengajuanBarang $pengajuan, string $notes = null)
    {
        $pengajuan->update([
            'status' => 'approved',
            'superadmin_notes' => $notes,
            'superadmin_approved_at' => now(),
        ]);

        // Notify Logistic
        $logisticUsers = User::where('role', 'logistic')->get();
        Notification::send($logisticUsers, new PengajuanBarangNotification($pengajuan, 'approved_by_superadmin'));

        return $pengajuan;
    }

    public function rejectBySuperadmin(PengajuanBarang $pengajuan, string $notes = null)
    {
        $pengajuan->update([
            'status' => 'rejected',
            'superadmin_notes' => $notes,
            'rejected_by' => 'superadmin',
            'rejected_at' => now(),
        ]);

        // Notify Logistic
        $logisticUsers = User::where('role', 'logistic')->get();
        Notification::send($logisticUsers, new PengajuanBarangNotification($pengajuan, 'rejected_by_superadmin'));

        // Notify HRD
        Notification::send($pengajuan->hrd, new PengajuanBarangNotification($pengajuan, 'rejected_by_superadmin'));

        return $pengajuan;
    }

    public function setItemStatus(PengajuanBarang $pengajuan, string $status, string $notes = null)
    {
        $pengajuan->update([
            'status' => $status,
            'logistic_notes' => $notes, // Re-use logistic_notes for item status updates
        ]);

        // Notify HRD
        Notification::send($pengajuan->hrd, new PengajuanBarangNotification($pengajuan, 'item_status_update'));

        return $pengajuan;
    }
}
