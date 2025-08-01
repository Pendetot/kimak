<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TandaTerimaBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelamar_id',
        'logistic_id',
        'received_by',
        'notes',
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }

    public function logistic()
    {
        return $this->belongsTo(User::class, 'logistic_id');
    }
}
