<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltiSP extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_peringatan_id',
        'karyawan_id',
        'jumlah_penalti',
        'tanggal_pencatatan',
        'jenis_penalti',
        'status_pembayaran',
        'keterangan',
        'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal_pencatatan' => 'date',
        'jumlah_penalti' => 'decimal:2',
    ];

    /**
     * Get the surat peringatan that owns this penalti.
     */
    public function suratPeringatan()
    {
        return $this->belongsTo(SuratPeringatan::class);
    }

    /**
     * Get the karyawan that owns this penalti.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    /**
     * Get the user who recorded this penalti.
     */
    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    /**
     * Scope for unpaid penalties.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status_pembayaran', '!=', 'lunas');
    }

    /**
     * Scope for this month penalties.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_pencatatan', now()->month)
                    ->whereYear('tanggal_pencatatan', now()->year);
    }

    /**
     * Check if penalty is paid.
     */
    public function isPaid(): bool
    {
        return $this->status_pembayaran === 'lunas';
    }

    /**
     * Mark penalty as paid.
     */
    public function markAsPaid(): void
    {
        $this->update(['status_pembayaran' => 'lunas']);
    }
}