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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique()->index();
            $table->string('nama_barang');
            $table->string('kategori', 100)->index();
            $table->text('deskripsi')->nullable();
            $table->string('unit', 20); // pcs, kg, liter, etc.
            $table->decimal('harga_satuan', 12, 2);
            $table->integer('minimum_stock')->default(0);
            $table->integer('maximum_stock')->default(0);
            $table->string('lokasi_penyimpanan')->nullable();
            $table->string('supplier')->nullable();
            $table->string('barcode')->nullable()->unique();
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['status', 'kategori']);
            $table->index(['nama_barang']);
            $table->index(['created_at']);
        });

        // Add foreign key constraints after table creation
        Schema::table('barangs', function (Blueprint $table) {
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
        if (Schema::hasTable('barangs')) {
            Schema::table('barangs', function (Blueprint $table) {
                try {
                    $table->dropForeign(['created_by']);
                    $table->dropForeign(['updated_by']);
                } catch (\Exception $e) {
                    // Foreign keys don't exist, continue
                }
            });
        }
        Schema::dropIfExists('barangs');
    }
};