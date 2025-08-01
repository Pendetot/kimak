<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HRDUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'HRD User',
            'email' => 'hrd@example.com',
            'password' => Hash::make('password'),
            'role' => RoleEnum::HRD,
        ]);
    }
}