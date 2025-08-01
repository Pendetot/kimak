<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PelamarDocument;
use App\Models\Pelamar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PelamarDocument>
 */
class PelamarDocumentFactory extends Factory
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
            'nama_dokumen' => $this->faker->randomElement(['KTP', 'Ijazah', 'CV', 'Transkrip Nilai', 'Sertifikat']),
            'file_path' => 'documents/' . $this->faker->uuid() . '.pdf',
        ];
    }
}