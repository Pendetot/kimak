<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal_pengajuan',
        'tanggal_efektif',
        'alasan',
        'status',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_efektif' => 'date',
        'status' => \App\Enums\StatusResignEnum::class,
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
