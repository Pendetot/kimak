<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PenaltiSP;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenaltiSP>
 */
class PenaltiSPFactory extends Factory
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
            'jumlah_penalti' => $this->faker->numberBetween(50000, 500000),
            'tanggal_penalti' => $this->faker->date(),
            'alasan' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['lunas', 'belum_lunas']),
        ];
    }
}