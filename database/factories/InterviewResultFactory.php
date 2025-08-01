<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InterviewResult;
use App\Models\Pelamar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InterviewResult>
 */
class InterviewResultFactory extends Factory
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
            'hrd_notes' => $this->faker->paragraph(),
            'ops_notes' => $this->faker->paragraph(),
            'decision' => $this->faker->randomElement(['recommended', 'not_recommended', 'pending']),
            'q_about_yourself' => $this->faker->sentence(),
            'q_reason_for_resigning' => $this->faker->sentence(),
            'q_hobbies_organizations' => $this->faker->sentence(),
            'q_why_interested' => $this->faker->sentence(),
            'q_motivation' => $this->faker->sentence(),
            'q_experience' => $this->faker->sentence(),
            'q_skills_for_job' => $this->faker->sentence(),
            'q_what_you_like_about_job' => $this->faker->sentence(),
            'q_desired_salary' => $this->faker->numberBetween(3000000, 10000000),
            'q_knowledge_of_position' => $this->faker->sentence(),
            'doc_cv' => $this->faker->boolean(),
            'doc_ktp' => $this->faker->boolean(),
            'doc_kk' => $this->faker->boolean(),
            'doc_ijazah' => $this->faker->boolean(),
            'doc_paklaring' => $this->faker->boolean(),
            'doc_skck' => $this->faker->boolean(),
            'doc_sim' => $this->faker->boolean(),
            'doc_surat_dokter' => $this->faker->boolean(),
            'doc_sertifikat_beladiri' => $this->faker->boolean(),
            'doc_ijazah_gp' => $this->faker->boolean(),
            'doc_ijazah_gm' => $this->faker->boolean(),
            'doc_kta' => $this->faker->boolean(),
            'uniform_size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'shoe_size' => $this->faker->numberBetween(35, 45),
            'height' => $this->faker->numberBetween(150, 190),
            'weight' => $this->faker->numberBetween(50, 90),
            'score_formal_education' => $this->faker->numberBetween(1, 5),
            'score_technical_knowledge' => $this->faker->numberBetween(1, 5),
            'score_communication' => $this->faker->numberBetween(1, 5),
            'score_teamwork' => $this->faker->numberBetween(1, 5),
            'score_motivation' => $this->faker->numberBetween(1, 5),
            'score_stress_resistance' => $this->faker->numberBetween(1, 5),
            'score_independence' => $this->faker->numberBetween(1, 5),
            'score_leadership' => $this->faker->numberBetween(1, 5),
            'score_ethics' => $this->faker->numberBetween(1, 5),
            'score_appearance' => $this->faker->numberBetween(1, 5),
            'final_notes' => $this->faker->paragraph(),
            'interview_date' => $this->faker->date(),
            'ops_signature' => $this->faker->name(),
            'hrd_signature' => $this->faker->name(),
        ];
    }
}