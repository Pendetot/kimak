<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelamarDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelamar_id',
        'document_type',
        'file_path',
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
