<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HutangKaryawan;

class HutangController extends Controller
{
    public function index()
    {
        $hutangKaryawans = HutangKaryawan::with('karyawan')->get();

        return view('keuangan.hutang.index', compact('hutangKaryawans'));
    }
}
