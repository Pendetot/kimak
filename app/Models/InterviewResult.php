<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class InterviewResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelamar_id',
        'hrd_notes',
        'ops_notes',
        'decision',
        'q_about_yourself',
        'q_reason_for_resigning',
        'q_hobbies_organizations',
        'q_why_interested',
        'q_motivation',
        'q_experience',
        'q_skills_for_job',
        'q_what_you_like_about_job',
        'q_desired_salary',
        'q_knowledge_of_position',
        'doc_cv',
        'doc_ktp',
        'doc_kk',
        'doc_ijazah',
        'doc_paklaring',
        'doc_skck',
        'doc_sim',
        'doc_surat_dokter',
        'doc_sertifikat_beladiri',
        'doc_ijazah_gp',
        'doc_ijazah_gm',
        'doc_kta',
        'uniform_size',
        'shoe_size',
        'height',
        'weight',
        'score_formal_education',
        'score_technical_knowledge',
        'score_communication',
        'score_teamwork',
        'score_motivation',
        'score_stress_resistance',
        'score_independence',
        'score_leadership',
        'score_ethics',
        'score_appearance',
        'final_notes',
        'interview_date',
        'ops_signature',
        'hrd_signature',
    ];

    protected $casts = [
        'doc_cv' => 'boolean',
        'doc_ktp' => 'boolean',
        'doc_kk' => 'boolean',
        'doc_ijazah' => 'boolean',
        'doc_paklaring' => 'boolean',
        'doc_skck' => 'boolean',
        'doc_sim' => 'boolean',
        'doc_surat_dokter' => 'boolean',
        'doc_sertifikat_beladiri' => 'boolean',
        'doc_ijazah_gp' => 'boolean',
        'doc_ijazah_gm' => 'boolean',
        'doc_kta' => 'boolean',
        'interview_date' => 'date',
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }
}
