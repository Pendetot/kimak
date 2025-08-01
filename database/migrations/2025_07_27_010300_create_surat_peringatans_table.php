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
        Schema::create('surat_peringatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans');
            $table->string('jenis_sp');
            $table->date('tanggal_sp');
            $table->text('keterangan')->nullable();
            $table->text('alasan')->nullable();
            $table->text('tindakan')->nullable();
            $table->decimal('penalty_amount', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_peringatans');
    }
};
