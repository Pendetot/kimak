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
        Schema::create('penalti_s_p_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans');
            $table->bigInteger('jumlah_penalti');
            $table->date('tanggal_penalti');
            $table->text('alasan')->nullable();
            $table->string('status');
            $table->foreignId('surat_peringatan_id')->nullable()->constrained('surat_peringatans')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalti_s_p_s');
    }
};
