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
        'penalty_amount',
        'durasi_bulan',
    ];

    protected $casts = [
        'tanggal_sp' => 'date',
        'jenis_sp' => \App\Enums\JenisSPEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function hutangKaryawans()
    {
        return $this->hasMany(HutangKaryawan::class, 'karyawan_id', 'karyawan_id');
    }

    public function penalti()
    {
        return $this->hasOne(PenaltiSP::class);
    }
}