<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KeuanganUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Keuangan User',
            'email' => 'keuangan@example.com',
            'password' => Hash::make('password'),
            'role' => RoleEnum::Keuangan,
        ]);
    }
}