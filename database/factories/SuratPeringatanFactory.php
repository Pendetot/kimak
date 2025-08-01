<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SuratPeringatan;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratPeringatan>
 */
class SuratPeringatanFactory extends Factory
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
            'jenis_sp' => $this->faker->randomElement(['SP1', 'SP2', 'SP3']),
            'tanggal_sp' => $this->faker->date(),
            'alasan' => $this->faker->sentence(),
            'tindakan' => $this->faker->sentence(),
            'penalty_amount' => $this->faker->numberBetween(100000, 300000),
        ];
    }
}