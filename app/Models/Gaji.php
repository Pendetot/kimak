<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Gaji extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gajis';

    protected $fillable = [
        'karyawan_id',
        'periode_bulan',
        'gaji_pokok',
        'tunjangan',
        'hari_kerja',
        'hari_hadir',
        'hari_sakit',
        'hari_izin',
        'hari_alpha',
        'potongan_absen',
        'lembur_jam',
        'upah_lembur',
        'bonus',
        'potongan_lain',
        'total_gaji',
        'status',
        'tanggal_bayar',
        'metode_pembayaran',
        'nomor_referensi',
        'catatan',
        'catatan_pembayaran',
        'created_by',
        'updated_by',
        'processed_by',
    ];

    protected $casts = [
        'periode_bulan' => 'date',
        'tanggal_bayar' => 'date',
        'gaji_pokok' => 'decimal:2',
        'tunjangan' => 'decimal:2',
        'potongan_absen' => 'decimal:2',
        'lembur_jam' => 'decimal:2',
        'upah_lembur' => 'decimal:2',
        'bonus' => 'decimal:2',
        'potongan_lain' => 'decimal:2',
        'total_gaji' => 'decimal:2',
        'hari_kerja' => 'integer',
        'hari_hadir' => 'integer',
        'hari_sakit' => 'integer',
        'hari_izin' => 'integer',
        'hari_alpha' => 'integer',
    ];

    /**
     * Get the karyawan that owns the salary record
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    /**
     * Get the user who created this record
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who processed the payment
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope: Filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Filter by month and year
     */
    public function scopePeriode($query, $month, $year)
    {
        return $query->whereMonth('periode_bulan', $month)
                    ->whereYear('periode_bulan', $year);
    }

    /**
     * Scope: Pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Paid salaries
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'dibayar');
    }

    /**
     * Accessor: Format periode bulan
     */
    public function getPeriodeBulanFormattedAttribute()
    {
        return $this->periode_bulan ? $this->periode_bulan->format('F Y') : '';
    }

    /**
     * Accessor: Format total gaji
     */
    public function getTotalGajiFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_gaji, 0, ',', '.');
    }

    /**
     * Accessor: Calculate total deductions
     */
    public function getTotalPotonganAttribute()
    {
        return $this->potongan_absen + $this->potongan_lain;
    }

    /**
     * Accessor: Calculate total allowances
     */
    public function getTotalTunjanganAttribute()
    {
        return $this->tunjangan + $this->upah_lembur + $this->bonus;
    }

    /**
     * Accessor: Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'badge bg-warning';
            case 'dibayar':
                return 'badge bg-success';
            case 'cancelled':
                return 'badge bg-danger';
            default:
                return 'badge bg-secondary';
        }
    }

    /**
     * Accessor: Get status text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'Pending';
            case 'dibayar':
                return 'Dibayar';
            case 'cancelled':
                return 'Dibatalkan';
            default:
                return 'Unknown';
        }
    }

    /**
     * Calculate net working days percentage
     */
    public function getWorkingDaysPercentageAttribute()
    {
        if ($this->hari_kerja == 0) return 0;
        return round(($this->hari_hadir / $this->hari_kerja) * 100, 1);
    }

    /**
     * Check if salary can be edited
     */
    public function canBeEdited()
    {
        return $this->status !== 'dibayar';
    }

    /**
     * Check if salary can be deleted
     */
    public function canBeDeleted()
    {
        return $this->status !== 'dibayar';
    }
}