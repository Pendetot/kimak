<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'status_absensi',
        'keterangan',
        'jam_masuk',
        'jam_keluar',
        'foto_absensi',
        'lokasi_absensi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
    ];

    /**
     * Get the karyawan that owns the absensi.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    /**
     * Scope for today's absensi.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    /**
     * Scope for this month's absensi.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
    }

    /**
     * Check if absensi is late.
     */
    public function isLate(): bool
    {
        if (!$this->jam_masuk) return false;
        
        $workStartTime = '08:00:00';
        return $this->jam_masuk->format('H:i:s') > $workStartTime;
    }

    /**
     * Get working hours duration.
     */
    public function getWorkingHours(): ?float
    {
        if (!$this->jam_masuk || !$this->jam_keluar) return null;
        
        return $this->jam_keluar->diffInHours($this->jam_masuk);
    }
}
