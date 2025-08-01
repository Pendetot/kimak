<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\HutangKaryawan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        HutangKaryawan::where('asal_hutang', 'surat_peringatan')
                      ->update(['asal_hutang' => 'sp']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        HutangKaryawan::where('asal_hutang', 'sp')
                      ->update(['asal_hutang' => 'surat_peringatan']);
    }
};