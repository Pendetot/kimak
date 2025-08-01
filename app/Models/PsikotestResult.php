<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PsikotestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelamar_id',
        'scan_path',
        'conclusion',
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
