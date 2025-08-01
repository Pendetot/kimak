<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call(SuperAdminUserSeeder::class);
        $this->call(HRDUserSeeder::class);
        $this->call(KeuanganUserSeeder::class);
        $this->call(KaryawanUserSeeder::class);
        $this->call(LogistikUserSeeder::class);
        $this->call(PelamarUserSeeder::class);
        $this->call(HrdDataSeeder::class);
    }
}
