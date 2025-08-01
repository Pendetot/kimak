<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusPengajuanEnum;

class PengajuanBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'nama_barang',
        'spesifikasi',
        'jumlah',
        'satuan',
        'harga_estimasi',
        'keperluan',
        'prioritas',
        'tanggal_dibutuhkan',
        'status',
        'catatan',
        
        // Approval workflow
        'approved_by_logistic',
        'logistic_approved_at',
        'logistic_notes',
        
        'approved_by_director',
        'director_approved_at',
        'director_notes',
        
        'approved_by_finance',
        'finance_approved_at',
        'finance_notes',
        
        // Rejection
        'rejected_by',
        'rejected_at',
        'rejection_reason',
        
        // Purchase & delivery
        'purchased_at',
        'supplier',
        'harga_aktual',
        'no_po',
        'delivered_at',
        'received_by',
    ];

    protected $casts = [
        'tanggal_dibutuhkan' => 'date',
        'jumlah' => 'integer',
        'harga_estimasi' => 'decimal:2',
        'harga_aktual' => 'decimal:2',
        'status' => StatusPengajuanEnum::class,
        
        'logistic_approved_at' => 'datetime',
        'director_approved_at' => 'datetime',
        'finance_approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'purchased_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the karyawan who made the request.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    /**
     * Get the logistic approver.
     */
    public function logisticApprover()
    {
        return $this->belongsTo(User::class, 'approved_by_logistic');
    }

    /**
     * Get the director approver.
     */
    public function directorApprover()
    {
        return $this->belongsTo(User::class, 'approved_by_director');
    }

    /**
     * Get the finance approver.
     */
    public function financeApprover()
    {
        return $this->belongsTo(User::class, 'approved_by_finance');
    }

    /**
     * Get the user who rejected the request.
     */
    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Get the user who received the delivery.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    // Scopes

    /**
     * Scope for pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', StatusPengajuanEnum::Pending);
    }

    /**
     * Scope for approved requests.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', StatusPengajuanEnum::Approved);
    }

    /**
     * Scope for rejected requests.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', StatusPengajuanEnum::Rejected);
    }

    /**
     * Scope for urgent requests.
     */
    public function scopeUrgent($query)
    {
        return $query->where('prioritas', 'urgent');
    }

    /**
     * Scope for this month requests.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    // Helper Methods

    /**
     * Check if request is pending logistic approval.
     */
    public function isPendingLogistic(): bool
    {
        return $this->status === StatusPengajuanEnum::Pending && !$this->approved_by_logistic;
    }

    /**
     * Check if request is pending director approval.
     */
    public function isPendingDirector(): bool
    {
        return $this->approved_by_logistic && !$this->approved_by_director && !$this->rejected_by;
    }

    /**
     * Check if request is pending finance approval.
     */
    public function isPendingFinance(): bool
    {
        return $this->approved_by_director && !$this->approved_by_finance && !$this->rejected_by;
    }

    /**
     * Check if request is fully approved.
     */
    public function isFullyApproved(): bool
    {
        return $this->approved_by_logistic && 
               $this->approved_by_director && 
               $this->approved_by_finance && 
               !$this->rejected_by;
    }

    /**
     * Check if request is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->tanggal_dibutuhkan && 
               $this->tanggal_dibutuhkan < now() && 
               !$this->delivered_at;
    }

    /**
     * Get approval progress percentage.
     */
    public function getApprovalProgress(): int
    {
        $steps = 0;
        $completed = 0;

        // Logistic approval
        $steps++;
        if ($this->approved_by_logistic) $completed++;

        // Director approval
        $steps++;
        if ($this->approved_by_director) $completed++;

        // Finance approval (if required for high value items)
        if ($this->harga_estimasi > 5000000) { // > 5 juta
            $steps++;
            if ($this->approved_by_finance) $completed++;
        }

        return $steps > 0 ? round(($completed / $steps) * 100) : 0;
    }

    /**
     * Get status color for UI.
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            StatusPengajuanEnum::Pending => 'warning',
            StatusPengajuanEnum::Approved => 'success',
            StatusPengajuanEnum::Rejected => 'danger',
            StatusPengajuanEnum::Purchased => 'info',
            StatusPengajuanEnum::Delivered => 'primary',
            default => 'secondary',
        };
    }

    /**
     * Get priority color for UI.
     */
    public function getPriorityColor(): string
    {
        return match($this->prioritas) {
            'urgent' => 'danger',
            'high' => 'warning',
            'normal' => 'info',
            'low' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Approve by logistic.
     */
    public function approveByLogistic($userId, $notes = null): void
    {
        $this->update([
            'approved_by_logistic' => $userId,
            'logistic_approved_at' => now(),
            'logistic_notes' => $notes,
        ]);
    }

    /**
     * Approve by director.
     */
    public function approveByDirector($userId, $notes = null): void
    {
        $this->update([
            'approved_by_director' => $userId,
            'director_approved_at' => now(),
            'director_notes' => $notes,
        ]);

        // If no finance approval needed, mark as approved
        if ($this->harga_estimasi <= 5000000) {
            $this->update(['status' => StatusPengajuanEnum::Approved]);
        }
    }

    /**
     * Approve by finance.
     */
    public function approveByFinance($userId, $notes = null): void
    {
        $this->update([
            'approved_by_finance' => $userId,
            'finance_approved_at' => now(),
            'finance_notes' => $notes,
            'status' => StatusPengajuanEnum::Approved,
        ]);
    }

    /**
     * Reject the request.
     */
    public function reject($userId, $reason): void
    {
        $this->update([
            'rejected_by' => $userId,
            'rejected_at' => now(),
            'rejection_reason' => $reason,
            'status' => StatusPengajuanEnum::Rejected,
        ]);
    }

    /**
     * Mark as purchased.
     */
    public function markAsPurchased($supplier, $actualPrice, $poNumber = null): void
    {
        $this->update([
            'purchased_at' => now(),
            'supplier' => $supplier,
            'harga_aktual' => $actualPrice,
            'no_po' => $poNumber,
            'status' => StatusPengajuanEnum::Purchased,
        ]);
    }

    /**
     * Mark as delivered.
     */
    public function markAsDelivered($receivedBy): void
    {
        $this->update([
            'delivered_at' => now(),
            'received_by' => $receivedBy,
            'status' => StatusPengajuanEnum::Delivered,
        ]);
    }
}