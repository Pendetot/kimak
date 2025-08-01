<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dokumen',
        'jenis_dokumen',
        'tanggal_upload',
        'file_path',
    ];
}
