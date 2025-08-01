<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PsikotestResult;
use App\Models\Pelamar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PsikotestResult>
 */
class PsikotestResultFactory extends Factory
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
            'scan_path' => $this->faker->boolean(50) ? 'psikotest_scans/' . $this->faker->uuid() . '.pdf' : null,
            'conclusion' => $this->faker->sentence(),
        ];
    }
}