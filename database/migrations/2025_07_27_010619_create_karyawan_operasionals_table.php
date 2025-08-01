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
        Schema::create('karyawan_operasionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans');
            $table->string('area_operasi');
            $table->string('shift_kerja');
            $table->date('tanggal_mulai_efektif');
            $table->text('catatan_operasional')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan_operasionals');
    }
};
