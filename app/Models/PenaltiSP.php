<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltiSP extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_peringatan_id',
        'karyawan_id',
        'jumlah_penalti',
        'tanggal_pencatatan',
    ];

    protected $casts = [
        'tanggal_pencatatan' => 'date',
    ];

    public function suratPeringatan()
    {
        return $this->belongsTo(SuratPeringatan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }
}