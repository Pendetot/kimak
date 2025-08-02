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
        Schema::create('pengajuan_barang_hrds', function (Blueprint $table) {
            $table->id();
            
            // Employee Information
            $table->foreignId('pelamar_id')->nullable()->constrained('pelamars')->onDelete('set null');
            $table->string('pelamar_name');
            $table->string('posisi_diterima');
            $table->date('tanggal_masuk');
            $table->string('departemen');
            
            // Request Details
            $table->json('items'); // Array of requested items with specifications
            $table->decimal('total_estimasi', 15, 2)->default(0);
            $table->text('keperluan');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'mendesak'])->default('sedang');
            $table->date('tanggal_dibutuhkan');
            $table->text('catatan_hrd')->nullable();
            
            // Status and Workflow
            $table->enum('status', [
                'pending',
                'logistik_approved',
                'approved',
                'logistik_rejected',
                'superadmin_rejected',
                'completed'
            ])->default('pending');
            
            // Audit Trail
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            // Logistik Approval
            $table->foreignId('logistik_approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('logistik_approved_at')->nullable();
            $table->text('logistik_notes')->nullable();
            
            // SuperAdmin Approval
            $table->foreignId('superadmin_approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('superadmin_approved_at')->nullable();
            $table->text('superadmin_notes')->nullable();
            
            // Completion
            $table->foreignId('completed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('completed_at')->nullable();
            $table->text('completion_notes')->nullable();
            
            $table->softDeletes();
            $table->timestamps();

            // Indexes for performance
            $table->index(['status', 'created_at']);
            $table->index(['prioritas', 'status']);
            $table->index(['departemen', 'status']);
            $table->index(['tanggal_dibutuhkan', 'status']);
            $table->index(['created_by', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_barang_hrds');
    }
};