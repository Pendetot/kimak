<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LogistikUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Logistik User',
            'email' => 'logistik@example.com',
            'password' => Hash::make('password'),
            'role' => RoleEnum::Logistik,
        ]);
    }
}