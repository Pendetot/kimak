<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PembelianBarang;
use App\Models\PengajuanBarang;
use Illuminate\Http\Request;

class PembelianBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelianBarangs = PembelianBarang::with('pengajuanBarang.requester')->get();
        return view('superadmin.pembelian_barang.index', compact('pembelianBarangs'));
    }

    

    

    /**
     * Display the specified resource.
     */
    public function show(PembelianBarang $pembelianBarang)
    {
        return view('superadmin.pembelian_barang.show', compact('pembelianBarang'));
    }

    
}
