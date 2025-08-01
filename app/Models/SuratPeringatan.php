<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPeringatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'jenis_sp',
        'tanggal_sp',
        'keterangan',
        'pelanggaran',
        'sanksi',
        'penalty_amount',
        'durasi_bulan',
        'pembuat_sp_id',
        'status_sp',
        'tanggal_berakhir',
    ];

    protected $casts = [
        'tanggal_sp' => 'date',
        'tanggal_berakhir' => 'date',
        'jenis_sp' => \App\Enums\JenisSPEnum::class,
        'penalty_amount' => 'decimal:2',
    ];

    /**
     * Get the karyawan that owns the surat peringatan.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    /**
     * Get the user who created the SP.
     */
    public function pembuatSP()
    {
        return $this->belongsTo(User::class, 'pembuat_sp_id');
    }

    /**
     * Get the hutang karyawan related to this SP.
     */
    public function hutangKaryawans()
    {
        return $this->hasMany(HutangKaryawan::class, 'surat_peringatan_id');
    }

    /**
     * Get the penalti associated with this SP.
     */
    public function penalti()
    {
        return $this->hasOne(PenaltiSP::class);
    }

    /**
     * Scope for active SP.
     */
    public function scopeActive($query)
    {
        return $query->where('status_sp', 'active')
                    ->where(function($q) {
                        $q->whereNull('tanggal_berakhir')
                          ->orWhere('tanggal_berakhir', '>=', now());
                    });
    }

    /**
     * Scope for expired SP.
     */
    public function scopeExpired($query)
    {
        return $query->where('tanggal_berakhir', '<', now());
    }

    /**
     * Check if SP is still active.
     */
    public function isActive(): bool
    {
        return $this->status_sp === 'active' && 
               (!$this->tanggal_berakhir || $this->tanggal_berakhir >= now());
    }

    /**
     * Get SP severity level.
     */
    public function getSeverityLevel(): int
    {
        return match($this->jenis_sp->value) {
            'sp1' => 1,
            'sp2' => 2,
            'sp3' => 3,
            'skorsing' => 4,
            'phk' => 5,
            default => 0,
        };
    }

    /**
     * Get SP color based on type.
     */
    public function getTypeColor(): string
    {
        return match($this->jenis_sp->value) {
            'sp1' => 'warning',
            'sp2' => 'orange',
            'sp3' => 'danger',
            'skorsing' => 'dark',
            'phk' => 'black',
            default => 'secondary',
        };
    }
}