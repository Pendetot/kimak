<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pelamar;
use App\Enums\RoleEnum;

class LinkPelamarToUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelamarUsers = User::where('role', RoleEnum::Pelamar)->get();

        foreach ($pelamarUsers as $user) {
            // Check if a Pelamar entry already exists for this user
            $pelamar = Pelamar::where('user_id', $user->id)->first();

            if (!$pelamar) {
                // If not, create a new Pelamar entry and link it to the user
                Pelamar::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    // Add other necessary default fields for Pelamar here
                    // For example:
                    'no_hp' => '081234567890',
                    'alamat' => 'Jl. Contoh No. 123',
                    'tanggal_lahir' => '2000-01-01',
                    'jenis_kelamin' => 'Laki-laki',
                    'pendidikan_terakhir' => 'SMA',
                    'status_pernikahan' => 'belum_kawin',
                    'pengalaman_kerja' => 'Belum ada pengalaman',
                    'status_lamaran' => 'pending',
                ]);
            } else {
                // If it exists, ensure the user_id is correctly set (should already be)
                // You might want to update other fields if necessary
                $pelamar->update([
                    'nama' => $user->name,
                    'email' => $user->email,
                ]);
            }
        }
    }
}