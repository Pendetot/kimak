<?php

namespace App\Enums;

enum StatusPernikahanEnum: string
{
    case Single = 'single';
    case Married = 'married';
    case Divorced = 'divorced';
    case Widowed = 'widowed';

    public function label(): string
    {
        return match($this) {
            self::Single => 'Belum Menikah',
            self::Married => 'Menikah',
            self::Divorced => 'Cerai',
            self::Widowed => 'Janda/Duda',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}