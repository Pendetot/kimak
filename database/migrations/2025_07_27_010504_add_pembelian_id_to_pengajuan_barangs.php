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
        Schema::table('pengajuan_barangs', function (Blueprint $table) {
            // Add relationship to pembelian
            $table->foreignId('pembelian_id')->nullable()->after('status')->constrained('pembelians')->onDelete('set null');
            
            // Add fields for tracking purchase status
            $table->foreignId('purchased_by')->nullable()->after('pembelian_id')->constrained('users')->onDelete('set null');
            $table->timestamp('purchased_at')->nullable()->after('purchased_by');
            $table->timestamp('delivered_at')->nullable()->after('purchased_at');
            
            // Add index for performance
            $table->index(['pembelian_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_barangs', function (Blueprint $table) {
            $table->dropForeign(['pembelian_id']);
            $table->dropForeign(['purchased_by']);
            $table->dropIndex(['pembelian_id', 'status']);
            $table->dropColumn(['pembelian_id', 'purchased_by', 'purchased_at', 'delivered_at']);
        });
    }
};