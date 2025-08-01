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
            $table->foreignId('requester_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_barangs', function (Blueprint $table) {
            $table->dropForeign(['requester_id']);
            $table->dropColumn('requester_id');
        });
    }
};
