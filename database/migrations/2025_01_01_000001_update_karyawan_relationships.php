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
        // Helper function to safely update foreign key relationships
        $updateForeignKey = function($tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'karyawan_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    try {
                        // Try to drop existing foreign key and index
                        $table->dropForeign(['karyawan_id']);
                    } catch (\Exception $e) {
                        // Foreign key doesn't exist, continue
                    }
                    
                    try {
                        $table->dropIndex(['karyawan_id']);
                    } catch (\Exception $e) {
                        // Index doesn't exist, continue
                    }
                    
                    // Add new foreign key and index
                    $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
                    $table->index(['karyawan_id']);
                });
            }
        };

        // Update absensis table
        $updateForeignKey('absensis');

        // Update cutis table
        $updateForeignKey('cutis');

        // Update k_p_i_s table
        $updateForeignKey('k_p_i_s');

        // Update pembinaans table
        $updateForeignKey('pembinaans');

        // Update hutang_karyawans table
        $updateForeignKey('hutang_karyawans');

        // Update surat_peringatans table
        $updateForeignKey('surat_peringatans');

        // Update penalti_s_p_s table
        $updateForeignKey('penalti_s_p_s');

        // Update mutasis table
        $updateForeignKey('mutasis');

        // Update resigns table
        $updateForeignKey('resigns');

        // Update rekening_karyawans table
        $updateForeignKey('rekening_karyawans');

        // Update lap_dokumens table
        $updateForeignKey('lap_dokumens');

        // Update pengajuan_barangs table to reference karyawan instead of user
        if (Schema::hasTable('pengajuan_barangs')) {
            Schema::table('pengajuan_barangs', function (Blueprint $table) {
                // Only proceed if requester_id exists
                if (Schema::hasColumn('pengajuan_barangs', 'requester_id')) {
                    try {
                        $table->dropForeign(['requester_id']);
                    } catch (\Exception $e) {
                        // Foreign key doesn't exist, continue
                    }
                    $table->dropColumn('requester_id');
                }
                
                // Only add karyawan_id if it doesn't exist
                if (!Schema::hasColumn('pengajuan_barangs', 'karyawan_id')) {
                    $table->unsignedBigInteger('karyawan_id')->after('id');
                    $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
                    $table->index(['karyawan_id']);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Helper function to safely reverse foreign key relationships
        $revertForeignKey = function($tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'karyawan_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    try {
                        $table->dropForeign(['karyawan_id']);
                    } catch (\Exception $e) {
                        // Foreign key doesn't exist, continue
                    }
                    
                    try {
                        $table->dropIndex(['karyawan_id']);
                    } catch (\Exception $e) {
                        // Index doesn't exist, continue
                    }
                    
                    // Re-add foreign key pointing to users table
                    $table->foreign('karyawan_id')->references('id')->on('users')->onDelete('cascade');
                    $table->index(['karyawan_id']);
                });
            }
        };

        // Reverse all changes
        $tables = [
            'absensis', 'cutis', 'k_p_i_s', 'pembinaans', 'hutang_karyawans',
            'surat_peringatans', 'penalti_s_p_s', 'mutasis', 'resigns',
            'rekening_karyawans', 'lap_dokumens'
        ];

        foreach ($tables as $table) {
            $revertForeignKey($table);
        }

        // Revert pengajuan_barangs table
        if (Schema::hasTable('pengajuan_barangs')) {
            Schema::table('pengajuan_barangs', function (Blueprint $table) {
                if (Schema::hasColumn('pengajuan_barangs', 'karyawan_id')) {
                    try {
                        $table->dropForeign(['karyawan_id']);
                    } catch (\Exception $e) {
                        // Foreign key doesn't exist, continue
                    }
                    
                    try {
                        $table->dropIndex(['karyawan_id']);
                    } catch (\Exception $e) {
                        // Index doesn't exist, continue
                    }
                    
                    $table->dropColumn('karyawan_id');
                }
                
                if (!Schema::hasColumn('pengajuan_barangs', 'requester_id')) {
                    $table->unsignedBigInteger('requester_id')->after('id');
                    $table->foreign('requester_id')->references('id')->on('users')->onDelete('cascade');
                    $table->index(['requester_id']);
                }
            });
        }
    }
};