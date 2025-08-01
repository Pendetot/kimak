<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'hrd_id',
        'item_name',
        'quantity',
        'notes',
        'status',
        'logistic_notes',
        'superadmin_notes',
        'logistic_approved_at',
        'superadmin_approved_at',
        'rejected_by',
        'rejected_at',
    ];

    protected $casts = [
        'logistic_approved_at' => 'datetime',
        'superadmin_approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}