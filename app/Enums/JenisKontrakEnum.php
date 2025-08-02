<?php

namespace App\Enums;

enum JenisKontrakEnum: string
{
    case Tetap = 'tetap';
    case Kontrak = 'kontrak';
    case Magang = 'magang';
    case Freelance = 'freelance';

    public function label(): string
    {
        return match($this) {
            self::Tetap => 'Karyawan Tetap',
            self::Kontrak => 'Karyawan Kontrak',
            self::Magang => 'Magang',
            self::Freelance => 'Freelance',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Tetap => 'success',
            self::Kontrak => 'primary',
            self::Magang => 'info',
            self::Freelance => 'warning',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}