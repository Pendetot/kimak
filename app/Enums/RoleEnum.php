<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SuperAdmin = 'superadmin';
    case HRD = 'hrd';
    case Keuangan = 'keuangan';
    case Karyawan = 'karyawan';
    case Logistik = 'logistik';
    case Pelamar = 'pelamar';
}