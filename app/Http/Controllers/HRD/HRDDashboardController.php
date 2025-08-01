<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\RoleEnum;

use App\Models\Cuti;
use App\Models\Resign;
use App\Models\SuratPeringatan;
use App\Models\Mutasi;
use App\Models\Pelamar;

class HRDDashboardController extends Controller
{
    public function index()
    {
        $roleCounts = [
            'admin' => User::where('role', RoleEnum::SuperAdmin->value)->count(),
            'hrd' => User::where('role', RoleEnum::HRD->value)->count(),
            'finance' => User::where('role', RoleEnum::Keuangan->value)->count(),
            'logistik' => User::where('role', RoleEnum::Logistik->value)->count(),
        ];

        
        $totalCuti = Cuti::count();
        $totalResign = Resign::count();
        $totalSuratPeringatan = SuratPeringatan::count();
        $totalMutasi = Mutasi::count();
        $totalPelamar = Pelamar::count();

        return view('hrd.dashboard', compact('roleCounts', 'totalCuti', 'totalResign', 'totalSuratPeringatan', 'totalMutasi', 'totalPelamar'));
    }
}