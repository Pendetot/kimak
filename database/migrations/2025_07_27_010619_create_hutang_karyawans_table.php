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
        Schema::create('hutang_karyawans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans');
            $table->decimal('amount', 15, 2);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->string('status'); // e.g., 'lunas', 'belum lunas'
            $table->string('asal_hutang')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('surat_peringatan_id')->nullable()->constrained('surat_peringatans')->onDelete('set null');
            $table->text('deletion_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang_karyawans');
    }
};
