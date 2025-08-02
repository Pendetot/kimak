<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanBarangHRD extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengajuan_barang_hrds';

    protected $fillable = [
        'pelamar_id',
        'pelamar_name',
        'posisi_diterima',
        'tanggal_masuk',
        'departemen',
        'items',
        'total_estimasi',
        'keperluan',
        'prioritas',
        'tanggal_dibutuhkan',
        'catatan_hrd',
        'status',
        'created_by',
        'logistik_approved_by',
        'logistik_approved_at',
        'logistik_notes',
        'superadmin_approved_by',
        'superadmin_approved_at',
        'superadmin_notes',
        'completed_by',
        'completed_at',
        'completion_notes'
    ];

    protected $casts = [
        'items' => 'array',
        'tanggal_masuk' => 'date',
        'tanggal_dibutuhkan' => 'date',
        'logistik_approved_at' => 'datetime',
        'superadmin_approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_estimasi' => 'decimal:2'
    ];

    /**
     * Relationship with Pelamar (if exists)
     */
    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }

    /**
     * Relationship with User who created the request
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship with User who approved at logistik level
     */
    public function logistikApprover()
    {
        return $this->belongsTo(User::class, 'logistik_approved_by');
    }

    /**
     * Relationship with User who approved at superadmin level
     */
    public function superadminApprover()
    {
        return $this->belongsTo(User::class, 'superadmin_approved_by');
    }

    /**
     * Relationship with User who completed the request
     */
    public function completer()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /**
     * Scope for pending requests (waiting for logistik)
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for logistik approved (waiting for superadmin)
     */
    public function scopeLogistikApproved($query)
    {
        return $query->where('status', 'logistik_approved');
    }

    /**
     * Scope for finally approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for rejected
     */
    public function scopeRejected($query)
    {
        return $query->whereIn('status', ['logistik_rejected', 'superadmin_rejected']);
    }

    /**
     * Scope for completed
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'bg-warning';
            case 'logistik_approved':
                return 'bg-info';
            case 'approved':
                return 'bg-success';
            case 'logistik_rejected':
            case 'superadmin_rejected':
                return 'bg-danger';
            case 'completed':
                return 'bg-primary';
            default:
                return 'bg-secondary';
        }
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'Menunggu Logistik';
            case 'logistik_approved':
                return 'Menunggu SuperAdmin';
            case 'approved':
                return 'Disetujui';
            case 'logistik_rejected':
                return 'Ditolak Logistik';
            case 'superadmin_rejected':
                return 'Ditolak SuperAdmin';
            case 'completed':
                return 'Selesai';
            default:
                return ucfirst($this->status);
        }
    }

    /**
     * Get formatted total estimasi
     */
    public function getFormattedTotalEstimasiAttribute()
    {
        return 'Rp ' . number_format($this->total_estimasi, 0, ',', '.');
    }

    /**
     * Get total items count
     */
    public function getItemsCountAttribute()
    {
        return is_array($this->items) ? count($this->items) : 0;
    }

    /**
     * Get priority badge color
     */
    public function getPriorityBadgeColorAttribute()
    {
        switch ($this->prioritas) {
            case 'mendesak':
                return 'bg-danger';
            case 'tinggi':
                return 'bg-warning';
            case 'sedang':
                return 'bg-info';
            case 'rendah':
                return 'bg-secondary';
            default:
                return 'bg-secondary';
        }
    }

    /**
     * Check if request can be approved by logistik
     */
    public function canBeApprovedByLogistik()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if request can be rejected by logistik
     */
    public function canBeRejectedByLogistik()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if request can be approved by superadmin
     */
    public function canBeApprovedBySuperadmin()
    {
        return $this->status === 'logistik_approved';
    }

    /**
     * Check if request can be rejected by superadmin
     */
    public function canBeRejectedBySuperadmin()
    {
        return $this->status === 'logistik_approved';
    }

    /**
     * Check if request can be completed
     */
    public function canBeCompleted()
    {
        return $this->status === 'approved';
    }

    /**
     * Get workflow progress percentage
     */
    public function getWorkflowProgressAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 25;
            case 'logistik_approved':
                return 50;
            case 'approved':
                return 75;
            case 'completed':
                return 100;
            case 'logistik_rejected':
            case 'superadmin_rejected':
                return 0;
            default:
                return 0;
        }
    }

    /**
     * Get approval timeline
     */
    public function getApprovalTimelineAttribute()
    {
        $timeline = [
            [
                'step' => 'HRD Request',
                'status' => 'completed',
                'date' => $this->created_at,
                'user' => $this->creator->name ?? 'System'
            ]
        ];

        // Logistik step
        if ($this->logistik_approved_at) {
            $timeline[] = [
                'step' => 'Logistik Approval',
                'status' => 'completed',
                'date' => $this->logistik_approved_at,
                'user' => $this->logistikApprover->name ?? 'System'
            ];
        } elseif ($this->status === 'logistik_rejected') {
            $timeline[] = [
                'step' => 'Logistik Rejected',
                'status' => 'rejected',
                'date' => $this->updated_at,
                'user' => $this->logistikApprover->name ?? 'System'
            ];
        } else {
            $timeline[] = [
                'step' => 'Logistik Approval',
                'status' => 'pending',
                'date' => null,
                'user' => null
            ];
        }

        // SuperAdmin step
        if ($this->superadmin_approved_at) {
            $timeline[] = [
                'step' => 'SuperAdmin Approval',
                'status' => 'completed',
                'date' => $this->superadmin_approved_at,
                'user' => $this->superadminApprover->name ?? 'System'
            ];
        } elseif ($this->status === 'superadmin_rejected') {
            $timeline[] = [
                'step' => 'SuperAdmin Rejected',
                'status' => 'rejected',
                'date' => $this->updated_at,
                'user' => $this->superadminApprover->name ?? 'System'
            ];
        } else {
            $timeline[] = [
                'step' => 'SuperAdmin Approval',
                'status' => $this->status === 'logistik_approved' ? 'pending' : 'waiting',
                'date' => null,
                'user' => null
            ];
        }

        // Completion step
        if ($this->completed_at) {
            $timeline[] = [
                'step' => 'Completed',
                'status' => 'completed',
                'date' => $this->completed_at,
                'user' => $this->completer->name ?? 'System'
            ];
        } else {
            $timeline[] = [
                'step' => 'Completion',
                'status' => $this->status === 'approved' ? 'pending' : 'waiting',
                'date' => null,
                'user' => null
            ];
        }

        return $timeline;
    }
}