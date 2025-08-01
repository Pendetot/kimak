<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\PenaltiSP;
use App\Models\SuratPeringatan;
use Illuminate\Http\Request;

class PenaltiSPController extends Controller
{
    public function index()
    {
        $penaltiSPs = PenaltiSP::with('karyawan', 'suratPeringatan')->latest()->paginate(10);
        return view('keuangan.penalti_sp.index', compact('penaltiSPs'));
    }

    public function show(PenaltiSP $penaltiSP)
    {
        $penaltiSP->load('karyawan', 'suratPeringatan');
        return view('keuangan.penalti_sp.show', compact('penaltiSP'));
    }
}