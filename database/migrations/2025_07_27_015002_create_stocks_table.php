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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->integer('quantity')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->integer('maximum_stock')->default(0);
            $table->string('location')->nullable();
            $table->string('batch_number')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['barang_id', 'quantity']);
            $table->index(['location']);
            $table->index(['expiry_date']);
        });

        // Add foreign key constraints after table creation
        Schema::table('stocks', function (Blueprint $table) {
            if (Schema::hasTable('barangs')) {
                $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            }
            if (Schema::hasTable('users')) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first if table exists
        if (Schema::hasTable('stocks')) {
            Schema::table('stocks', function (Blueprint $table) {
                try {
                    $table->dropForeign(['barang_id']);
                    $table->dropForeign(['created_by']);
                    $table->dropForeign(['updated_by']);
                } catch (\Exception $e) {
                    // Foreign keys don't exist, continue
                }
            });
        }
        Schema::dropIfExists('stocks');
    }
};