<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelamar_id',
        'result',
        'notes',
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
