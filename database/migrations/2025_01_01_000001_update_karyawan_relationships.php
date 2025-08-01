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
        // Update absensis table
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update cutis table
        Schema::table('cutis', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update k_p_i_s table
        Schema::table('k_p_i_s', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update pembinaans table
        Schema::table('pembinaans', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update hutang_karyawans table
        Schema::table('hutang_karyawans', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update surat_peringatans table
        Schema::table('surat_peringatans', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update penalti_s_p_s table
        Schema::table('penalti_s_p_s', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update mutasis table
        Schema::table('mutasis', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update resigns table
        Schema::table('resigns', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update rekening_karyawans table
        Schema::table('rekening_karyawans', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update lap_dokumens table
        Schema::table('lap_dokumens', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropIndex(['karyawan_id']);
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });

        // Update pengajuan_barangs table to reference karyawan instead of user
        Schema::table('pengajuan_barangs', function (Blueprint $table) {
            $table->dropForeign(['requester_id']);
            $table->dropColumn('requester_id');
            $table->unsignedBigInteger('karyawan_id')->after('id');
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
            $table->index(['karyawan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse all changes
        $tables = [
            'absensis', 'cutis', 'k_p_i_s', 'pembinaans', 'hutang_karyawans',
            'surat_peringatans', 'penalti_s_p_s', 'mutasis', 'resigns',
            'rekening_karyawans', 'lap_dokumens'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                $blueprint->dropForeign(['karyawan_id']);
                $blueprint->dropIndex(['karyawan_id']);
                $blueprint->foreign('karyawan_id')->references('id')->on('users')->onDelete('cascade');
                $blueprint->index(['karyawan_id']);
            });
        }

        // Revert pengajuan_barangs table
        Schema::table('pengajuan_barangs', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropColumn('karyawan_id');
            $table->unsignedBigInteger('requester_id')->after('id');
            $table->foreign('requester_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['requester_id']);
        });
    }
};