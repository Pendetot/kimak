<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Karyawan;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Karyawan>
 */
class KaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create(); // Create a new user for each Karyawan

        return [
            'user_id' => $user->id,
            'nama' => $this->faker->name(),
            'nik' => $this->faker->unique()->numerify('##############'),
            'nip' => $this->faker->unique()->numerify('################'),
            'tanggal_masuk' => $this->faker->date(),
            'jabatan' => $this->faker->jobTitle(),
            'departemen' => $this->faker->word(),
            'status' => $this->faker->randomElement(['aktif', 'non-aktif', 'cuti']),
            'no_telepon' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
        ];
    }
}