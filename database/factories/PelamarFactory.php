<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pelamar;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelamar>
 */
class PelamarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'jenis_jabatan_pekerjaan' => $this->faker->jobTitle(),
            'lokasi_penempatan_diinginkan' => $this->faker->city(),
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_whatsapp' => $this->faker->phoneNumber(),
            'no_lain_dihubungi' => $this->faker->boolean(50) ? $this->faker->phoneNumber() : null,
            'alamat_ktp' => $this->faker->address(),
            'alamat_domisili' => $this->faker->address(),
            'kelurahan' => $this->faker->citySuffix(),
            'kecamatan' => $this->faker->citySuffix(),
            'kabupaten_kota' => $this->faker->city(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2000-01-01'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'no_ktp' => $this->faker->unique()->numerify('################'),
            'foto_ktp' => $this->faker->boolean(50) ? 'pelamar_docs/' . $this->faker->uuid() . '.jpg' : null,
            'foto_kartu_keluarga' => $this->faker->boolean(50) ? 'pelamar_docs/' . $this->faker->uuid() . '.jpg' : null,
            'warga_negara' => 'Indonesia',
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'status_pernikahan' => $this->faker->randomElement(['Lajang', 'Menikah', 'Cerai Hidup', 'Cerai Mati']),
            'reference_name' => $this->faker->boolean(50) ? $this->faker->name() : null,

            'nama_suami_istri' => $this->faker->boolean(50) ? $this->faker->name() : null,
            'usia_suami_istri' => $this->faker->boolean(50) ? $this->faker->numberBetween(20, 60) : null,
            'pekerjaan_suami_istri' => $this->faker->boolean(50) ? $this->faker->jobTitle() : null,
            'alamat_suami_istri' => $this->faker->boolean(50) ? $this->faker->address() : null,

            'nama_anak1' => $this->faker->boolean(50) ? $this->faker->name() : null,
            'jk_anak1' => $this->faker->boolean(50) ? $this->faker->randomElement(['Laki-laki', 'Perempuan']) : null,
            'ttl_anak1' => $this->faker->boolean(50) ? $this->faker->city() . ', ' . $this->faker->date('d F Y') : null,
            'nama_anak2' => $this->faker->boolean(30) ? $this->faker->name() : null,
            'jk_anak2' => $this->faker->boolean(30) ? $this->faker->randomElement(['Laki-laki', 'Perempuan']) : null,
            'ttl_anak2' => $this->faker->boolean(30) ? $this->faker->city() . ', ' . $this->faker->date('d F Y') : null,
            'nama_anak3' => $this->faker->boolean(10) ? $this->faker->name() : null,
            'jk_anak3' => $this->faker->boolean(10) ? $this->faker->randomElement(['Laki-laki', 'Perempuan']) : null,
            'ttl_anak3' => $this->faker->boolean(10) ? $this->faker->city() . ', ' . $this->faker->date('d F Y') : null,

            'nama_ayah' => $this->faker->name(),
            'usia_ayah' => $this->faker->numberBetween(40, 80),
            'pekerjaan_ayah' => $this->faker->jobTitle(),
            'alamat_ayah' => $this->faker->address(),
            'nama_ibu' => $this->faker->name(),
            'usia_ibu' => $this->faker->numberBetween(40, 80),
            'pekerjaan_ibu' => $this->faker->jobTitle(),
            'alamat_ibu' => $this->faker->address(),

            'tinggi_badan' => $this->faker->numberBetween(150, 190),
            'berat_badan' => $this->faker->numberBetween(45, 90),
            'surat_keterangan_sehat' => $this->faker->randomElement(['Ada', 'Tidak Ada']),
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'ukuran_seragam' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'ukuran_sepatu' => $this->faker->numberBetween(38, 45),
            'punya_tato' => $this->faker->boolean(),
            'perokok' => $this->faker->boolean(),
            'kesehatan_umum' => $this->faker->sentence(),
            'olahraga_dilakukan' => $this->faker->sentence(),
            'kesehatan_mata' => $this->faker->sentence(),
            'cacat_penyakit_serius' => $this->faker->boolean(30) ? $this->faker->sentence() : null,

            'pendidikan_terakhir' => $this->faker->randomElement(['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3']),
            'sertifikasi_pelamar' => $this->faker->boolean(50) ? $this->faker->sentence() : null,
            'foto_ijazah_terakhir' => $this->faker->boolean(50) ? 'pelamar_docs/' . $this->faker->uuid() . '.jpg' : null,
            'foto_sertifikat_keahlian1' => $this->faker->boolean(50) ? 'pelamar_docs/' . $this->faker->uuid() . '.jpg' : null,
            'foto_sertifikat_keahlian2' => $this->faker->boolean(30) ? 'pelamar_docs/' . $this->faker->uuid() . '.jpg' : null,
            'keahlian_dimiliki' => $this->faker->sentence(),
            'hobby_keahlian_disukai' => $this->faker->sentence(),
            'keterampilan_kerja_disukai' => $this->faker->sentence(),
            'peralatan_kerja_dikuasai' => $this->faker->sentence(),
            'program_komputer_dikuasai' => $this->faker->sentence(),
            'keahlian_ingin_dicapai' => $this->faker->sentence(),
            'jenis_bahasa_dikuasai' => $this->faker->randomElement(['Indonesia', 'Inggris', 'Indonesia, Inggris']),
            'kendaraan_dikuasai' => $this->faker->randomElement(['Motor', 'Mobil', 'Motor, Mobil']),
            'sim_dimiliki' => $this->faker->boolean(70) ? $this->faker->randomElement(['SIM A', 'SIM C', 'SIM A, SIM C']) : null,

            'rencana_target_masa_depan' => $this->faker->paragraph(),
            'suka_berorganisasi' => $this->faker->boolean(),
            'organisasi_diikuti' => $this->faker->boolean(50) ? $this->faker->sentence() : null,

            'punya_pengalaman_kerja' => $this->faker->boolean(),
            'pengalaman_kerja1_perusahaan' => $this->faker->boolean(70) ? $this->faker->company() : null,
            'pengalaman_kerja1_alamat' => $this->faker->boolean(70) ? $this->faker->address() : null,
            'pengalaman_kerja1_masa_kerja' => $this->faker->boolean(70) ? $this->faker->numberBetween(1, 5) . ' tahun ' . $this->faker->numberBetween(0, 11) . ' bulan' : null,
            'pengalaman_kerja1_jabatan' => $this->faker->boolean(70) ? $this->faker->jobTitle() : null,
            'pengalaman_kerja1_gaji_awal' => $this->faker->boolean(70) ? $this->faker->numberBetween(2000000, 5000000) : null,
            'pengalaman_kerja1_gaji_akhir' => $this->faker->boolean(70) ? $this->faker->numberBetween(5000000, 10000000) : null,
            'pengalaman_kerja1_alasan_berhenti' => $this->faker->boolean(70) ? $this->faker->sentence() : null,
            'pengalaman_kerja2_perusahaan' => $this->faker->boolean(30) ? $this->faker->company() : null,
            'pengalaman_kerja2_alamat' => $this->faker->boolean(30) ? $this->faker->address() : null,
            'pengalaman_kerja2_masa_kerja' => $this->faker->boolean(30) ? $this->faker->numberBetween(1, 3) . ' tahun ' . $this->faker->numberBetween(0, 11) . ' bulan' : null,
            'pengalaman_kerja2_jabatan' => $this->faker->boolean(30) ? $this->faker->jobTitle() : null,
            'pengalaman_kerja2_gaji_awal' => $this->faker->boolean(30) ? $this->faker->numberBetween(2000000, 5000000) : null,
            'pengalaman_kerja2_gaji_akhir' => $this->faker->boolean(30) ? $this->faker->numberBetween(5000000, 10000000) : null,
            'pengalaman_kerja2_alasan_berhenti' => $this->faker->boolean(30) ? $this->faker->sentence() : null,

            'tanggungan_ekonomi' => $this->faker->boolean(50) ? $this->faker->sentence() : null,
            'nilai_tanggungan_perbulan' => $this->faker->boolean(50) ? $this->faker->numberBetween(500000, 2000000) : null,
            'bersedia_lembur' => $this->faker->boolean(),
            'alasan_lembur' => $this->faker->boolean(50) ? $this->faker->sentence() : null,
            'bersedia_dipindahkan_bagian_lain' => $this->faker->boolean(),
            'alasan_dipindahkan_bagian_lain' => $this->faker->boolean(50) ? $this->faker->sentence() : null,
            'bersedia_ikut_pembinaan_pelatihan' => $this->faker->boolean(),
            'bersedia_penuhi_peraturan_pengamanan' => $this->faker->boolean(),
            'bersedia_dipindahkan_luar_daerah' => $this->faker->boolean(),
            'gaji_diharapkan' => $this->faker->numberBetween(3000000, 8000000),
            'batas_gaji_minimum' => $this->faker->numberBetween(2500000, 7000000),
            'fasilitas_diharapkan' => $this->faker->boolean(50) ? $this->faker->sentence() : null,

            'kapan_bisa_mulai_bekerja' => $this->faker->randomElement(['Segera', '1 minggu lagi', '2 minggu lagi', '1 bulan lagi']),
            'motivasi_utama_bekerja' => $this->faker->paragraph(),
            'alasan_diterima_perusahaan' => $this->faker->paragraph(),
            'hal_lain_disampaikan' => $this->faker->boolean(50) ? $this->faker->paragraph() : null,
            'pernah_ikut_beladiri' => $this->faker->boolean(),
            'sertifikat_beladiri' => $this->faker->boolean(30) ? 'pelamar_docs/' . $this->faker->uuid() . '.jpg' : null,
            'foto_full_body' => $this->faker->boolean(70) ? 'pelamar_docs/' . $this->faker->uuid() . '.jpg' : null,

            'pernyataan_kebenaran_dokumen' => true,
            'pernyataan_lamaran_kerja' => true,
            'status_lamaran' => $this->faker->randomElement(['pending', 'diterima', 'ditolak']),
            'interview_attendance_status' => $this->faker->randomElement(['hadir', 'tidak_hadir', 'belum_dikonfirmasi']),
        ];
    }
}