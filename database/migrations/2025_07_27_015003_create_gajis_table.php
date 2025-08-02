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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->date('periode_bulan'); // Periode bulan gaji
            $table->decimal('gaji_pokok', 12, 2);
            $table->decimal('tunjangan', 12, 2)->default(0);
            $table->integer('hari_kerja');
            $table->integer('hari_hadir');
            $table->integer('hari_sakit')->default(0);
            $table->integer('hari_izin')->default(0);
            $table->integer('hari_alpha')->default(0);
            $table->decimal('potongan_absen', 12, 2)->default(0);
            $table->decimal('lembur_jam', 8, 2)->default(0);
            $table->decimal('upah_lembur', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('potongan_lain', 12, 2)->default(0);
            $table->decimal('total_gaji', 12, 2);
            $table->enum('status', ['pending', 'dibayar', 'cancelled'])->default('pending');
            $table->date('tanggal_bayar')->nullable();
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'check'])->nullable();
            $table->string('nomor_referensi')->nullable();
            $table->text('catatan')->nullable();
            $table->text('catatan_pembayaran')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['karyawan_id', 'periode_bulan']);
            $table->index(['status']);
            $table->index(['tanggal_bayar']);
            $table->unique(['karyawan_id', 'periode_bulan'], 'unique_karyawan_periode');
        });

        // Add foreign key constraints after table creation
        Schema::table('gajis', function (Blueprint $table) {
            if (Schema::hasTable('karyawans')) {
                $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            }
            if (Schema::hasTable('users')) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('processed_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first if table exists
        if (Schema::hasTable('gajis')) {
            Schema::table('gajis', function (Blueprint $table) {
                try {
                    $table->dropForeign(['karyawan_id']);
                    $table->dropForeign(['created_by']);
                    $table->dropForeign(['updated_by']);
                    $table->dropForeign(['processed_by']);
                } catch (\Exception $e) {
                    // Foreign keys don't exist, continue
                }
            });
        }
        Schema::dropIfExists('gajis');
    }
};