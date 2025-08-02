<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembinaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal_pembinaan',
        'jenis_pembinaan',
        'catatan',
        'hasil',
        'pembina_id',
        'tindak_lanjut',
        'status_pembinaan',
    ];

    protected $casts = [
        'tanggal_pembinaan' => 'date',
    ];

    /**
     * Get the karyawan that owns the pembinaan.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    /**
     * Get the pembina (supervisor/trainer).
     */
    public function pembina()
    {
        return $this->belongsTo(User::class, 'pembina_id');
    }

    /**
     * Scope for current year pembinaan.
     */
    public function scopeCurrentYear($query)
    {
        return $query->whereYear('tanggal_pembinaan', now()->year);
    }

    /**
     * Scope by pembinaan type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('jenis_pembinaan', $type);
    }

    /**
     * Get pembinaan status color.
     */
    public function getStatusColor(): string
    {
        return match($this->status_pembinaan) {
            'completed' => 'success',
            'in_progress' => 'warning',
            'pending' => 'info',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
