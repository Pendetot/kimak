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
        // Check dependencies
        if (!Schema::hasTable('users')) {
            throw new \Exception('Users table must exist before creating pengajuan_barang_hrds table.');
        }
        
        if (!Schema::hasTable('pelamars')) {
            throw new \Exception('Pelamars table must exist before creating pengajuan_barang_hrds table.');
        }

        Schema::create('pengajuan_barang_hrds', function (Blueprint $table) {
            $table->id();
            
            // Employee Information
            $table->unsignedBigInteger('pelamar_id')->nullable();
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
            $table->unsignedBigInteger('created_by');
            
            // Logistik Approval
            $table->unsignedBigInteger('logistik_approved_by')->nullable();
            $table->timestamp('logistik_approved_at')->nullable();
            $table->text('logistik_notes')->nullable();
            
            // SuperAdmin Approval
            $table->unsignedBigInteger('superadmin_approved_by')->nullable();
            $table->timestamp('superadmin_approved_at')->nullable();
            $table->text('superadmin_notes')->nullable();
            
            // Completion
            $table->unsignedBigInteger('completed_by')->nullable();
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

        // Add foreign key constraints after table creation
        Schema::table('pengajuan_barang_hrds', function (Blueprint $table) {
            $table->foreign('pelamar_id')->references('id')->on('pelamars')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('logistik_approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('superadmin_approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first if table exists
        if (Schema::hasTable('pengajuan_barang_hrds')) {
            Schema::table('pengajuan_barang_hrds', function (Blueprint $table) {
                try {
                    $table->dropForeign(['pelamar_id']);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist, continue
                }
                
                try {
                    $table->dropForeign(['created_by']);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist, continue
                }
                
                try {
                    $table->dropForeign(['logistik_approved_by']);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist, continue
                }
                
                try {
                    $table->dropForeign(['superadmin_approved_by']);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist, continue
                }
                
                try {
                    $table->dropForeign(['completed_by']);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist, continue
                }
            });
        }

        Schema::dropIfExists('pengajuan_barang_hrds');
    }
};