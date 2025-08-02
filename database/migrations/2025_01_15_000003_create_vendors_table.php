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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            
            // Basic Vendor Information
            $table->string('nama_vendor');
            $table->string('kategori')->nullable(); // Electronics, Office Supplies, etc.
            
            // Address Information
            $table->text('alamat');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('kode_pos', 10)->nullable();
            
            // Contact Information
            $table->string('telepon', 20);
            $table->string('email')->unique();
            $table->string('website')->nullable();
            
            // Contact Person
            $table->string('contact_person');
            $table->string('jabatan_contact_person')->nullable();
            $table->string('telepon_contact_person', 20)->nullable();
            $table->string('email_contact_person')->nullable();
            
            // Banking Information
            $table->string('bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_rekening')->nullable();
            
            // Business Information
            $table->string('npwp', 20)->nullable();
            $table->decimal('rating', 2, 1)->default(0)->comment('1-5 star rating');
            
            // Status and Notes
            $table->enum('status', ['aktif', 'non_aktif', 'suspended'])->default('aktif');
            $table->text('catatan')->nullable();
            
            // Audit Trail
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['status', 'kategori']);
            $table->index(['kota', 'status']);
            $table->index(['rating', 'status']);
            $table->index('nama_vendor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};