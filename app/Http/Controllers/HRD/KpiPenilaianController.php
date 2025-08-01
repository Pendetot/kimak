<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KpiPenilaianController extends Controller
{
    public function index()
    {
        return view('hrd.kpi_penilaian.index');
    }
}
