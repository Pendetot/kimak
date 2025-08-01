<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembelianBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_barang_id',
        'item_name',
        'quantity',
        'notes',
        'logistic_id',
        'status',
    ];

    public function pengajuanBarang()
    {
        return $this->belongsTo(PengajuanBarang::class);
    }
}
