<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Karyawan>
 */
class KaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaLengkap = $this->faker->name();
        $namaPanggilan = explode(' ', $namaLengkap)[0]; // First name as nickname
        
        return [
            // Authentication fields
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Default password
            'remember_token' => \Str::random(10),
            
            // Employee identification
            'nik' => $this->faker->unique()->numerify('##############'),
            'nip' => $this->faker->unique()->numerify('################'),
            
            // Personal information
            'nama_lengkap' => $namaLengkap,
            'nama_panggilan' => $namaPanggilan,
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-25 years'),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'status_pernikahan' => $this->faker->randomElement(['single', 'married', 'divorced', 'widowed']),
            'alamat_domisili' => $this->faker->address(),
            'alamat_ktp' => $this->faker->address(),
            'no_telepon' => $this->faker->phoneNumber(),
            'no_hp' => $this->faker->phoneNumber(),
            'email_pribadi' => $this->faker->safeEmail(),
            
            // Identity documents
            'no_ktp' => $this->faker->numerify('################'),
            'no_npwp' => $this->faker->numerify('##.###.###.#-###.###'),
            'no_bpjs_kesehatan' => $this->faker->numerify('############'),
            'no_bpjs_ketenagakerjaan' => $this->faker->numerify('############'),
            
            // Employment information
            'jabatan' => $this->faker->jobTitle(),
            'departemen' => $this->faker->randomElement(['IT', 'HR', 'Finance', 'Marketing', 'Operations', 'Sales']),
            'divisi' => $this->faker->randomElement(['Development', 'Support', 'Analysis', 'Management']),
            'unit_kerja' => $this->faker->randomElement(['Unit A', 'Unit B', 'Unit C']),
            'lokasi_kerja' => $this->faker->city(),
            'tanggal_masuk' => $this->faker->date('Y-m-d', '-2 years'),
            'tanggal_kontrak_mulai' => $this->faker->date('Y-m-d', '-1 year'),
            'tanggal_kontrak_selesai' => $this->faker->date('Y-m-d', '+1 year'),
            'jenis_kontrak' => $this->faker->randomElement(['tetap', 'kontrak', 'magang', 'freelance']),
            'status_karyawan' => $this->faker->randomElement(['aktif', 'non_aktif', 'cuti', 'resign', 'terminated']),
            
            // Employment details
            'level_jabatan' => $this->faker->randomElement(['Junior', 'Senior', 'Lead', 'Manager']),
            'grade' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'gaji_pokok' => $this->faker->numberBetween(3000000, 15000000),
            'tunjangan' => json_encode([
                'transport' => $this->faker->numberBetween(200000, 500000),
                'makan' => $this->faker->numberBetween(150000, 300000),
                'kesehatan' => $this->faker->numberBetween(100000, 250000),
            ]),
            'shift_kerja' => $this->faker->randomElement(['Pagi', 'Siang', 'Malam']),
            'jam_kerja_per_hari' => $this->faker->randomElement([8, 9]),
            'hari_kerja_per_minggu' => $this->faker->randomElement([5, 6]),
            
            // Contact person (emergency)
            'kontak_darurat_nama' => $this->faker->name(),
            'kontak_darurat_hubungan' => $this->faker->randomElement(['Orang Tua', 'Saudara', 'Suami/Istri']),
            'kontak_darurat_telepon' => $this->faker->phoneNumber(),
            
            // Additional information
            'pendidikan_terakhir' => $this->faker->randomElement(['SMA', 'D3', 'S1', 'S2', 'S3']),
            'institusi_pendidikan' => $this->faker->company() . ' University',
            'jurusan' => $this->faker->randomElement(['Teknik Informatika', 'Manajemen', 'Akuntansi', 'Teknik Industri']),
            'tahun_lulus' => $this->faker->year(),
            'pengalaman_kerja' => $this->faker->paragraph(),
            'keahlian' => implode(', ', $this->faker->words(5)),
            'sertifikasi' => implode(', ', $this->faker->words(3)),
            
            // File uploads (nullable in real use)
            'foto_profil' => null,
            'file_cv' => null,
            'file_ktp' => null,
            'file_ijazah' => null,
            'file_kontrak' => null,
            
            // System fields
            'created_by' => 'system',
            'updated_by' => 'system',
            'last_login_at' => null,
            'last_login_ip' => null,
            'is_active' => true,
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}