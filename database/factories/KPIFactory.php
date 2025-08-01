<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KPI;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KPI>
 */
class KPIFactory extends Factory
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
            'periode' => $this->faker->monthName() . ' ' . $this->faker->year(),
            'nilai_kpi' => $this->faker->numberBetween(0, 100),
            'evaluasi' => $this->faker->paragraph(),
        ];
    }
}