<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KaryawanOperasional;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KaryawanOperasional>
 */
class KaryawanOperasionalFactory extends Factory
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
            'area_operasi' => $this->faker->city(),
            'shift_kerja' => $this->faker->randomElement(['Pagi', 'Siang', 'Malam']),
            'tanggal_mulai_efektif' => $this->faker->date(),
            'catatan_operasional' => $this->faker->sentence(),
        ];
    }
}