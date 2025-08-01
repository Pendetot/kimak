<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mutasi;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mutasi>
 */
class MutasiFactory extends Factory
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
            'tanggal_mutasi' => $this->faker->date(),
            'departemen_lama' => $this->faker->word(),
            'departemen_baru' => $this->faker->word(),
            'jabatan_lama' => $this->faker->jobTitle(),
            'jabatan_baru' => $this->faker->jobTitle(),
            'keterangan' => $this->faker->sentence(),
        ];
    }
}