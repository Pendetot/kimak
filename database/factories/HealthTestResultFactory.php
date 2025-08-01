<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HealthTestResult;
use App\Models\Pelamar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HealthTestResult>
 */
class HealthTestResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pelamar = Pelamar::inRandomOrder()->first();

        return [
            'pelamar_id' => $pelamar ? $pelamar->id : null,
            'tanggal_tes' => $this->faker->date(),
            'hasil' => $this->faker->randomElement(['fit', 'unfit', 'pending']),
            'keterangan' => $this->faker->sentence(),
        ];
    }
}