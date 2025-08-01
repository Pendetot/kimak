<?php

namespace App\Enums;

enum JenisKelaminEnum: string
{
    case Laki = 'L';
    case Perempuan = 'P';

    public function label(): string
    {
        return match($this) {
            self::Laki => 'Laki-laki',
            self::Perempuan => 'Perempuan',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}