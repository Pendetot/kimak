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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('stock_id');
            $table->string('type'); // initial_stock, increase, decrease, adjustment, transfer, return
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->integer('adjustment'); // positive or negative
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['barang_id', 'created_at']);
            $table->index(['stock_id', 'created_at']);
            $table->index(['type']);
            $table->index(['created_at']);
        });

        // Add foreign key constraints after table creation
        Schema::table('stock_movements', function (Blueprint $table) {
            if (Schema::hasTable('barangs')) {
                $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            }
            if (Schema::hasTable('stocks')) {
                $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');
            }
            if (Schema::hasTable('users')) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first if table exists
        if (Schema::hasTable('stock_movements')) {
            Schema::table('stock_movements', function (Blueprint $table) {
                try {
                    $table->dropForeign(['barang_id']);
                    $table->dropForeign(['stock_id']);
                    $table->dropForeign(['created_by']);
                } catch (\Exception $e) {
                    // Foreign keys don't exist, continue
                }
            });
        }
        Schema::dropIfExists('stock_movements');
    }
};