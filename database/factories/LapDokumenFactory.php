<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LapDokumen;
use App\Models\Karyawan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LapDokumen>
 */
class LapDokumenFactory extends Factory
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
            'nama_dokumen' => $this->faker->word() . ' Dokumen',
            'jenis_dokumen' => $this->faker->word() . ' Dokumen',
            'tanggal_upload' => $this->faker->date(),
            'file_path' => 'documents/' . $this->faker->word() . '.pdf',
            'catatan' => $this->faker->sentence(),
        ];
    }
}