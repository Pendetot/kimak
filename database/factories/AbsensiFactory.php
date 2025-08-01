<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Absensi;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absensi>
 */
class AbsensiFactory extends Factory
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
            'tanggal' => $this->faker->date(),
            'jam_masuk' => $this->faker->time('H:i:s'),
            'jam_keluar' => $this->faker->time('H:i:s'),
            'status' => $this->faker->randomElement(['hadir', 'izin', 'sakit', 'alpha']),
            'keterangan' => $this->faker->sentence(),
        ];
    }
}