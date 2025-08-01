<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Resign;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resign>
 */
class ResignFactory extends Factory
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
            'tanggal_resign' => $this->faker->date(),
            'alasan' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'disetujui', 'ditolak']),
        ];
    }
}