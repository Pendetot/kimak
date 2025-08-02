<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembelians';

    protected $fillable = [
        'vendor_id',
        'tanggal_pembelian',
        'total_harga',
        'metode_pembayaran',
        'catatan',
        'status',
        'tanggal_selesai',
        'catatan_penyelesaian',
        'created_by',
        'processed_by',
        'completed_by',
        'processed_at',
        'completed_at'
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'tanggal_selesai' => 'date',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_harga' => 'decimal:2'
    ];

    /**
     * Relationship with Vendor
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Relationship with PengajuanBarang
     */
    public function pengajuanBarang()
    {
        return $this->hasMany(PengajuanBarang::class, 'pembelian_id');
    }

    /**
     * Relationship with User who created the purchase
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship with User who processed the purchase
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Relationship with User who completed the purchase
     */
    public function completer()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /**
     * Scope for pending purchases
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for processed purchases
     */
    public function scopeProcessed($query)
    {
        return $query->where('status', 'diproses');
    }

    /**
     * Scope for completed purchases
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'bg-warning';
            case 'diproses':
                return 'bg-info';
            case 'selesai':
                return 'bg-success';
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
                return 'Pending';
            case 'diproses':
                return 'Diproses';
            case 'selesai':
                return 'Selesai';
            default:
                return ucfirst($this->status);
        }
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    /**
     * Check if purchase can be edited
     */
    public function canBeEdited()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if purchase can be processed
     */
    public function canBeProcessed()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if purchase can be completed
     */
    public function canBeCompleted()
    {
        return $this->status === 'diproses';
    }
}