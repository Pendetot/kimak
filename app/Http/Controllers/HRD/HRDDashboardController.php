<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan;
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
        // Total counts for dashboard cards
        $totalKaryawan = Karyawan::count();
        $totalCuti = Cuti::count();
        $totalResign = Resign::count();
        $totalSuratPeringatan = SuratPeringatan::count();
        $totalMutasi = Mutasi::count();
        $totalPelamar = Pelamar::count();

        // Role counts for system users (excluding karyawan since they're in separate table now)
        $roleCounts = [
            'Super Admin' => User::where('role', RoleEnum::SuperAdmin->value)->count(),
            'HRD' => User::where('role', RoleEnum::HRD->value)->count(),
            'Keuangan' => User::where('role', RoleEnum::Keuangan->value)->count(),
            'Logistik' => User::where('role', RoleEnum::Logistik->value)->count(),
        ];

        return view('hrd.dashboard', compact(
            'totalKaryawan', 
            'totalCuti', 
            'totalResign', 
            'totalSuratPeringatan', 
            'totalMutasi', 
            'totalPelamar', 
            'roleCounts'
        ));
    }
}