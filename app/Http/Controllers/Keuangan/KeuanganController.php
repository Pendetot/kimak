<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HutangKaryawan;
use App\Models\PenaltiSP;
use App\Models\SuratPeringatan;
use App\Models\Karyawan;

class KeuanganController extends Controller
{
    public function index()
    {
        // Total hutang karyawan
        $totalHutangKaryawan = HutangKaryawan::sum('jumlah');
        
        // Total hutang belum lunas
        $totalHutangBelumLunas = HutangKaryawan::where('status', 'belum_lunas')->sum('jumlah');
        
        // Total penalti SP
        $totalPenaltiSP = PenaltiSP::sum('jumlah_penalti');
        
        // Jumlah karyawan yang berhutang
        $jumlahKaryawanBerhutang = HutangKaryawan::distinct('karyawan_id')->count();
        
        // Jumlah karyawan yang terkena SP
        $jumlahKaryawanTerkenaSP = SuratPeringatan::distinct('karyawan_id')->count();
        
        return view('keuangan.dashboard', compact(
            'totalHutangKaryawan',
            'totalHutangBelumLunas', 
            'totalPenaltiSP',
            'jumlahKaryawanBerhutang',
            'jumlahKaryawanTerkenaSP'
        ));
    }
}