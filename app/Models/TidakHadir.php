<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TidakHadir extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelamar_id',
        'reason',
        'type',
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
