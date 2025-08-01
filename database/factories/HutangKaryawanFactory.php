<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HutangKaryawan;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HutangKaryawan>
 */
class HutangKaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $karyawan = Karyawan::inRandomOrder()->first();

        return [
            'karyawan_id' => $karyawan ? $karyawan->id : null,
            'amount' => $this->faker->numberBetween(100000, 5000000),
            'tanggal_pinjam' => $this->faker->date(),
            'status' => $this->faker->randomElement(['lunas', 'belum_lunas']),
            'asal_hutang' => $asalHutang = $this->faker->randomElement(['sp', 'pinjaman']),
            'keterangan' => $this->faker->sentence(),
            'surat_peringatan_id' => ($asalHutang === 'sp') ? \App\Models\SuratPeringatan::inRandomOrder()->first()->id : null,
        ];
    }
}