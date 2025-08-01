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
            $table->string('director_status')->nullable()->after('logistic_notes');
            $table->text('director_notes')->nullable()->after('director_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_barangs', function (Blueprint $table) {
            $table->dropColumn(['director_status', 'director_notes']);
        });
    }
};
