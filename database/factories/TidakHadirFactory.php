<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TidakHadir;
use App\Models\Pelamar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TidakHadir>
 */
class TidakHadirFactory extends Factory
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
            'reason' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['administration', 'interview']),
        ];
    }
}