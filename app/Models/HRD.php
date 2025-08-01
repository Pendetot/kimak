<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class HRD extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'hrds';

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
