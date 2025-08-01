<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'departemen_lama',
        'departemen_baru',
        'jabatan_lama',
        'jabatan_baru',
        'alasan',
        'tanggal_mutasi',
        'data_personal_berubah',
        'jaminan_seragam_mutasi',
        'seragam_mutasi',
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
        'data_personal_berubah' => 'boolean',
        'jaminan_seragam_mutasi' => 'boolean',
        'seragam_mutasi' => 'string', // Atau enum jika Anda membuat enum untuk ini
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
