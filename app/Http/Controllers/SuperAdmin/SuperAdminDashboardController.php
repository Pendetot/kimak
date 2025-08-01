<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\RoleEnum;

use App\Models\Karyawan;
use App\Models\Pelamar;
use App\Models\HutangKaryawan;
use App\Models\SuratPeringatan;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // System overview counts
        $totalUsers = User::count();
        $totalKaryawan = Karyawan::count();
        $totalPelamar = Pelamar::count();
        
        // Fix: use correct field name for hutang amount
        $totalHutangKaryawan = HutangKaryawan::sum('jumlah');
        $totalSuratPeringatan = SuratPeringatan::count();

        // Role counts for system users (excluding karyawan since they're in separate table now)
        $roleCounts = [
            'Super Admin' => User::where('role', RoleEnum::SuperAdmin->value)->count(),
            'HRD' => User::where('role', RoleEnum::HRD->value)->count(),
            'Keuangan' => User::where('role', RoleEnum::Keuangan->value)->count(),
            'Logistik' => User::where('role', RoleEnum::Logistik->value)->count(),
            'Pelamar' => User::where('role', RoleEnum::Pelamar->value)->count(),
        ];

        return view('superadmin.dashboard', compact(
            'totalUsers', 
            'totalKaryawan', 
            'totalPelamar', 
            'totalHutangKaryawan', 
            'totalSuratPeringatan', 
            'roleCounts'
        ));
    }
}