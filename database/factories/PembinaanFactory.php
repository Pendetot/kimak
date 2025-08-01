<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pembinaan;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembinaan>
 */
class PembinaanFactory extends Factory
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
            'tanggal_pembinaan' => $this->faker->date(),
            'jenis_pembinaan' => $this->faker->randomElement(['Disiplin', 'Kinerja', 'Etika']),
            'materi' => $this->faker->paragraph(),
            'tindak_lanjut' => $this->faker->sentence(),
        ];
    }
}