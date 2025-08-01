<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusKaryawanEnum;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nik',
        'alamat',
        'telepon',
        'jabatan',
        'penempatan',
        'status',
    ];

    protected $casts = [
        'status' => StatusKaryawanEnum::class,
    ];
}
