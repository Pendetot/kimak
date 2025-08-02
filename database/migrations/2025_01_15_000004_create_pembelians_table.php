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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            
            // Vendor Information
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            
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
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('completed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('completed_at')->nullable();
            
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['status', 'tanggal_pembelian']);
            $table->index(['vendor_id', 'status']);
            $table->index(['created_by', 'status']);
            $table->index('tanggal_pembelian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};