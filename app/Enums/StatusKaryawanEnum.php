<?php

namespace App\Enums;

enum StatusKaryawanEnum: string
{
    case Aktif = 'aktif';
    case NonAktif = 'non_aktif';
    case Cuti = 'cuti';
    case Resign = 'resign';
    case Terminated = 'terminated';

    public function label(): string
    {
        return match($this) {
            self::Aktif => 'Aktif',
            self::NonAktif => 'Non Aktif',
            self::Cuti => 'Cuti',
            self::Resign => 'Resign',
            self::Terminated => 'Terminated',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Aktif => 'success',
            self::NonAktif => 'warning',
            self::Cuti => 'info',
            self::Resign => 'secondary',
            self::Terminated => 'danger',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
