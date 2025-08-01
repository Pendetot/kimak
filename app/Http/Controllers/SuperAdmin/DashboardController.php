<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\Pelamar;
use App\Models\Cuti;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelamar = Pelamar::count();
        $totalCuti = Cuti::count();

        return view('superadmin.dashboard', compact('totalPelamar', 'totalCuti'));
    }
}