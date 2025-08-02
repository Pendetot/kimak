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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            
            // Authentication fields
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            // Employee identification
            $table->string('nik')->unique()->comment('Nomor Induk Karyawan');
            $table->string('nip')->unique()->comment('Nomor Induk Pegawai');
            
            // Personal information
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->enum('status_pernikahan', ['single', 'married', 'divorced', 'widowed'])->default('single');
            $table->text('alamat_domisili')->nullable();
            $table->text('alamat_ktp')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email_pribadi')->nullable();
            
            // Identity documents
            $table->string('no_ktp')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('no_bpjs_kesehatan')->nullable();
            $table->string('no_bpjs_ketenagakerjaan')->nullable();
            
            // Employment information
            $table->string('jabatan');
            $table->string('departemen');
            $table->string('divisi')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('lokasi_kerja')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_kontrak_mulai')->nullable();
            $table->date('tanggal_kontrak_selesai')->nullable();
            $table->enum('jenis_kontrak', ['tetap', 'kontrak', 'magang', 'freelance'])->default('kontrak');
            $table->enum('status_karyawan', ['aktif', 'non_aktif', 'cuti', 'resign', 'terminated'])->default('aktif');
            
            // Employment details
            $table->string('level_jabatan')->nullable();
            $table->string('grade')->nullable();
            $table->decimal('gaji_pokok', 15, 2)->nullable();
            $table->json('tunjangan')->nullable(); // Store as JSON for flexibility
            $table->string('shift_kerja')->nullable();
            $table->integer('jam_kerja_per_hari')->default(8);
            $table->integer('hari_kerja_per_minggu')->default(5);
            
            // Contact person (emergency)
            $table->string('kontak_darurat_nama')->nullable();
            $table->string('kontak_darurat_hubungan')->nullable();
            $table->string('kontak_darurat_telepon')->nullable();
            
            // Additional information
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('institusi_pendidikan')->nullable();
            $table->string('jurusan')->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->text('pengalaman_kerja')->nullable();
            $table->text('keahlian')->nullable(); // Skills
            $table->text('sertifikasi')->nullable();
            
            // File uploads
            $table->string('foto_profil')->nullable();
            $table->string('file_cv')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('file_kontrak')->nullable();
            
            // System fields
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status_karyawan', 'is_active']);
            $table->index(['departemen', 'divisi']);
            $table->index(['tanggal_masuk']);
            $table->index(['email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
