<?php

namespace App\Enums;

enum StatusKaryawanEnum: string
{
    case Aktif = 'aktif';
    case NonAktif = 'non-aktif';
    case Cuti = 'cuti';
    case Resign = 'resign';
}
