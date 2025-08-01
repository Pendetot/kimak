<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HutangKaryawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'jumlah',
        'alasan',
        'asal_hutang',
        'status',
        'surat_peringatan_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_pelunasan',
        'cicilan_per_bulan',
        'sisa_hutang',
        'keterangan',
    ];

    protected $casts = [
        'status' => \App\Enums\StatusHutangEnum::class,
        'asal_hutang' => \App\Enums\AsalHutangEnum::class,
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_pelunasan' => 'date',
        'jumlah' => 'decimal:2',
        'cicilan_per_bulan' => 'decimal:2',
        'sisa_hutang' => 'decimal:2',
    ];

    /**
     * Get the karyawan that owns the hutang.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    /**
     * Get the surat peringatan associated with this hutang.
     */
    public function suratPeringatan()
    {
        return $this->belongsTo(SuratPeringatan::class);
    }

    /**
     * Scope for active debts.
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'lunas');
    }

    /**
     * Scope for overdue debts.
     */
    public function scopeOverdue($query)
    {
        return $query->where('tanggal_jatuh_tempo', '<', now())
                    ->where('status', '!=', 'lunas');
    }

    /**
     * Check if debt is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->tanggal_jatuh_tempo && 
               $this->tanggal_jatuh_tempo < now() && 
               $this->status->value !== 'lunas';
    }

    /**
     * Calculate remaining amount.
     */
    public function calculateRemainingAmount(): float
    {
        return $this->sisa_hutang ?? $this->jumlah;
    }

    /**
     * Get days until due date.
     */
    public function getDaysUntilDue(): ?int
    {
        if (!$this->tanggal_jatuh_tempo || $this->status->value === 'lunas') {
            return null;
        }
        
        return now()->diffInDays($this->tanggal_jatuh_tempo, false);
    }

    /**
     * Mark as paid.
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'lunas',
            'tanggal_pelunasan' => now(),
            'sisa_hutang' => 0,
        ]);
    }
}
