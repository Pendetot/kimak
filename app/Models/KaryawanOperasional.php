<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class KaryawanOperasional extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'karyawan_operasionals';

    protected $guarded = [];

    protected $fillable = [
        'nama',
        'email',
        'password',
        'karyawan_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
