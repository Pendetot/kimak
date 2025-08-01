<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interview_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelamar_id')->constrained('pelamars')->onDelete('cascade');
            $table->text('hrd_notes')->nullable();
            $table->text('ops_notes')->nullable();
            $table->string('decision');
            $table->text('q_about_yourself')->nullable();
            $table->text('q_reason_for_resigning')->nullable();
            $table->text('q_hobbies_organizations')->nullable();
            $table->text('q_why_interested')->nullable();
            $table->text('q_motivation')->nullable();
            $table->text('q_experience')->nullable();
            $table->text('q_skills_for_job')->nullable();
            $table->text('q_what_you_like_about_job')->nullable();
            $table->bigInteger('q_desired_salary')->nullable();
            $table->text('q_knowledge_of_position')->nullable();
            $table->boolean('doc_cv')->nullable();
            $table->boolean('doc_ktp')->nullable();
            $table->boolean('doc_kk')->nullable();
            $table->boolean('doc_ijazah')->nullable();
            $table->boolean('doc_paklaring')->nullable();
            $table->boolean('doc_skck')->nullable();
            $table->boolean('doc_sim')->nullable();
            $table->boolean('doc_surat_dokter')->nullable();
            $table->boolean('doc_sertifikat_beladiri')->nullable();
            $table->boolean('doc_ijazah_gp')->nullable();
            $table->boolean('doc_ijazah_gm')->nullable();
            $table->boolean('doc_kta')->nullable();
            $table->string('uniform_size')->nullable();
            $table->integer('shoe_size')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('score_formal_education')->nullable();
            $table->integer('score_technical_knowledge')->nullable();
            $table->integer('score_communication')->nullable();
            $table->integer('score_teamwork')->nullable();
            $table->integer('score_motivation')->nullable();
            $table->integer('score_stress_resistance')->nullable();
            $table->integer('score_independence')->nullable();
            $table->integer('score_leadership')->nullable();
            $table->integer('score_ethics')->nullable();
            $table->integer('score_appearance')->nullable();
            $table->text('final_notes')->nullable();
            $table->date('interview_date')->nullable();
            $table->string('ops_signature')->nullable();
            $table->string('hrd_signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_results');
    }
};
