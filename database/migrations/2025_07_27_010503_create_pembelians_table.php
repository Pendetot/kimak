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
            throw new \Exception('Users table must exist before creating pembelians table.');
        }
        
        if (!Schema::hasTable('vendors')) {
            throw new \Exception('Vendors table must exist before creating pembelians table.');
        }

        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            
            // Vendor Information
            $table->unsignedBigInteger('vendor_id');
            
            // Purchase Details
            $table->date('tanggal_pembelian');
            $table->decimal('total_harga', 15, 2);
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'kredit'])->default('transfer');
            $table->text('catatan')->nullable();
            
            // Status Management
            $table->enum('status', ['pending', 'diproses', 'selesai', 'dibatalkan'])->default('pending');
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan_penyelesaian')->nullable();
            
            // Audit Trail
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->unsignedBigInteger('completed_by')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['status', 'tanggal_pembelian']);
            $table->index(['vendor_id', 'status']);
            $table->index(['created_by', 'status']);
            $table->index('tanggal_pembelian');
        });

        // Add foreign key constraints after table creation
        Schema::table('pembelians', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first if table exists
        if (Schema::hasTable('pembelians')) {
            Schema::table('pembelians', function (Blueprint $table) {
                try {
                    $table->dropForeign(['vendor_id']);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist, continue
                }
                
                try {
                    $table->dropForeign(['created_by']);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist, continue
                }
                
                try {
                    $table->dropForeign(['processed_by']);
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

        Schema::dropIfExists('pembelians');
    }
};