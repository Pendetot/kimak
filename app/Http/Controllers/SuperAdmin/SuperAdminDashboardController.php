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
        $totalUsers = User::count();
        $totalKaryawan = Karyawan::count();
        $totalPelamar = Pelamar::count();
        $totalHutangKaryawan = HutangKaryawan::sum('amount');
        $totalSuratPeringatan = SuratPeringatan::count();

        $roleCounts = [
            'Super Admin' => User::where('role', RoleEnum::SuperAdmin->value)->count(),
            'HRD' => User::where('role', RoleEnum::HRD->value)->count(),
            'Keuangan' => User::where('role', RoleEnum::Keuangan->value)->count(),
            'Karyawan' => User::where('role', RoleEnum::Karyawan->value)->count(),
            'Logistik' => User::where('role', RoleEnum::Logistik->value)->count(),
        ];

        return view('superadmin.dashboard', compact('totalUsers', 'totalKaryawan', 'totalPelamar', 'totalHutangKaryawan', 'totalSuratPeringatan', 'roleCounts'));
    }
}