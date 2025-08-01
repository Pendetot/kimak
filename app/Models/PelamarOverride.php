<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarOverride extends Model
{
    protected $fillable = [
        'pelamar_id',
        'nik',
        'nama',
        'penempatan',
        'jabatan',
        'referensi',
        'authorized_by',
    ];
}
