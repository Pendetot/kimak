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
        Schema::table('pelamars', function (Blueprint $table) {
            $table->string('interview_attendance_status')->nullable()->default('pending')->after('status_lamaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelamars', function (Blueprint $table) {
            $table->dropColumn('interview_attendance_status');
        });
    }
};
