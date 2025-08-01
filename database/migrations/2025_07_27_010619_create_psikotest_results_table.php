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
        Schema::create('psikotest_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelamar_id')->constrained('pelamars')->onDelete('cascade');
            $table->string('scan_path')->nullable();
            $table->text('conclusion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psikotest_results');
    }
};
