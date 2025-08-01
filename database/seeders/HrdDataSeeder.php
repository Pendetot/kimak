<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\HealthTestResult;
use App\Models\HutangKaryawan;
use App\Models\InterviewResult;
use App\Models\Karyawan;
use App\Models\KaryawanOperasional;
use App\Models\LapDokumen;
use App\Models\Mutasi;
use App\Models\PatResult;
use App\Models\Pelamar;
use App\Models\PelamarDocument;
use App\Models\Pembinaan;
use App\Models\PenaltiSP;
use App\Models\PsikotestResult;
use App\Models\Resign;
use App\Models\SuratPeringatan;
use App\Models\TidakHadir;
use App\Models\User;
use App\Models\KPI;

class HrdDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some users for HRD related models
        $users = User::factory()->count(10)->create();

        // Create Pelamar data
        Pelamar::factory()->count(20)->create();

        // Create Karyawan data (assuming some users are employees)
        Karyawan::factory()->count(10)->create();

        // Create KPI data
        KPI::factory()->count(10)->create();

        // Create Absensi data
        Absensi::factory()->count(50)->create();

        // Create Cuti data
        Cuti::factory()->count(15)->create();

        // Create HealthTestResult data
        HealthTestResult::factory()->count(10)->create();

        // Create SuratPeringatan data
        SuratPeringatan::factory()->count(10)->create()->each(function ($suratPeringatan) {
            // Create HutangKaryawan data related to this SuratPeringatan
            HutangKaryawan::factory()->count(1)->create([
                'karyawan_id' => $suratPeringatan->karyawan_id,
                'amount' => $suratPeringatan->penalty_amount,
                'keterangan' => 'Penalti ' . $suratPeringatan->jenis_sp->value,
                'status' => 'belum_lunas',
                'asal_hutang' => \App\Enums\AsalHutangEnum::SP->value,
                'surat_peringatan_id' => $suratPeringatan->id,
            ]);
        });

        // Create additional HutangKaryawan data (not related to SP)
        HutangKaryawan::factory()->count(5)->create(['asal_hutang' => \App\Enums\AsalHutangEnum::Pinjaman->value]);
    }
}