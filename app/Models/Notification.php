<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
        'action_url',
        'icon',
        'color'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Get time ago
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Create procurement notification
     */
    public static function createProcurementNotification($userId, $type, $pengajuanBarang, $message = null)
    {
        $notifications = [
            'procurement_request' => [
                'title' => 'Pengajuan Barang Baru',
                'message' => $message ?: "Pengajuan barang untuk pelamar {$pengajuanBarang->pelamar_name} memerlukan persetujuan",
                'icon' => 'ph-shopping-cart',
                'color' => 'text-primary',
                'action_url' => route('logistik.pengajuan-barang.show', $pengajuanBarang->id)
            ],
            'procurement_approved_logistik' => [
                'title' => 'Pengajuan Disetujui Logistik',
                'message' => $message ?: "Pengajuan barang telah disetujui logistik, menunggu approval SuperAdmin",
                'icon' => 'ph-check-circle',
                'color' => 'text-success',
                'action_url' => route('superadmin.pengajuan-barang-approval.show', $pengajuanBarang->id)
            ],
            'procurement_rejected_logistik' => [
                'title' => 'Pengajuan Ditolak Logistik',
                'message' => $message ?: "Pengajuan barang ditolak oleh logistik",
                'icon' => 'ph-x-circle',
                'color' => 'text-danger',
                'action_url' => route('hrd.pengajuan-barang.show', $pengajuanBarang->id)
            ],
            'procurement_final_approved' => [
                'title' => 'Pengajuan Disetujui Final',
                'message' => $message ?: "Pengajuan barang telah disetujui SuperAdmin",
                'icon' => 'ph-check-square',
                'color' => 'text-success',
                'action_url' => route('logistik.pengajuan-barang.show', $pengajuanBarang->id)
            ],
            'procurement_final_rejected' => [
                'title' => 'Pengajuan Ditolak Final',
                'message' => $message ?: "Pengajuan barang ditolak oleh SuperAdmin",
                'icon' => 'ph-x-square',
                'color' => 'text-danger',
                'action_url' => route('hrd.pengajuan-barang.show', $pengajuanBarang->id)
            ],
            'procurement_completed' => [
                'title' => 'Barang Telah Disiapkan',
                'message' => $message ?: "Barang untuk pelamar telah disiapkan logistik",
                'icon' => 'ph-package',
                'color' => 'text-info',
                'action_url' => route('hrd.pengajuan-barang.show', $pengajuanBarang->id)
            ]
        ];

        $config = $notifications[$type] ?? $notifications['procurement_request'];

        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $config['title'],
            'message' => $config['message'],
            'data' => [
                'pengajuan_barang_id' => $pengajuanBarang->id,
                'pelamar_name' => $pengajuanBarang->pelamar_name ?? 'Unknown',
                'total_items' => $pengajuanBarang->items_count ?? 0
            ],
            'action_url' => $config['action_url'],
            'icon' => $config['icon'],
            'color' => $config['color']
        ]);
    }
}