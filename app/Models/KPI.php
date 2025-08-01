<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPI extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'periode',
        'nilai_kpi',
        'evaluasi',
        'target_pencapaian',
        'realisasi',
        'catatan_evaluator',
        'evaluator_id',
        'status_evaluasi',
    ];

    protected $casts = [
        'periode' => 'date',
        'nilai_kpi' => 'decimal:2',
        'target_pencapaian' => 'decimal:2',
        'realisasi' => 'decimal:2',
    ];

    /**
     * Get the karyawan that owns the KPI.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    /**
     * Get the evaluator (could be HRD or manager).
     */
    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    /**
     * Scope for current year KPI.
     */
    public function scopeCurrentYear($query)
    {
        return $query->whereYear('periode', now()->year);
    }

    /**
     * Scope for specific period.
     */
    public function scopeByPeriod($query, $year, $month = null)
    {
        $query->whereYear('periode', $year);
        
        if ($month) {
            $query->whereMonth('periode', $month);
        }
        
        return $query;
    }

    /**
     * Get KPI performance category.
     */
    public function getPerformanceCategory(): string
    {
        $nilai = $this->nilai_kpi;
        
        if ($nilai >= 90) return 'Sangat Baik';
        if ($nilai >= 80) return 'Baik';
        if ($nilai >= 70) return 'Cukup';
        if ($nilai >= 60) return 'Kurang';
        return 'Sangat Kurang';
    }

    /**
     * Get performance color for UI.
     */
    public function getPerformanceColor(): string
    {
        $nilai = $this->nilai_kpi;
        
        if ($nilai >= 90) return 'success';
        if ($nilai >= 80) return 'primary';
        if ($nilai >= 70) return 'warning';
        if ($nilai >= 60) return 'orange';
        return 'danger';
    }
}
