<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pelamar;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PelamarUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Pelamar User',
            'email' => 'pelamar@example.com',
            'password' => Hash::make('password'),
            'role' => RoleEnum::Pelamar,
        ]);

        Pelamar::create([
            'user_id' => $user->id,
            'jenis_jabatan_pekerjaan' => 'Staff Administrasi',
            'lokasi_penempatan_diinginkan' => 'Jakarta',
            'nama' => $user->name,
            'email' => $user->email,
            'no_whatsapp' => '081234567890',
            'no_lain_dihubungi' => null,
            'alamat_ktp' => 'Jl. Contoh KTP No. 123',
            'alamat_domisili' => 'Jl. Contoh Domisili No. 456',
            'kelurahan' => 'Kel. Contoh',
            'kecamatan' => 'Kec. Contoh',
            'kabupaten_kota' => 'Kota Contoh',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'no_ktp' => '1234567890123456',
            'foto_ktp' => null,
            'foto_kartu_keluarga' => null,
            'warga_negara' => 'Indonesia',
            'agama' => 'Islam',
            'status_pernikahan' => 'Lajang',
            'reference_name' => null,

            'nama_suami_istri' => null,
            'usia_suami_istri' => null,
            'pekerjaan_suami_istri' => null,
            'alamat_suami_istri' => null,

            'nama_anak1' => null,
            'jk_anak1' => null,
            'ttl_anak1' => null,
            'nama_anak2' => null,
            'jk_anak2' => null,
            'ttl_anak2' => null,
            'nama_anak3' => null,
            'jk_anak3' => null,
            'ttl_anak3' => null,

            'nama_ayah' => null,
            'usia_ayah' => null,
            'pekerjaan_ayah' => null,
            'alamat_ayah' => null,
            'nama_ibu' => null,
            'usia_ibu' => null,
            'pekerjaan_ibu' => null,
            'alamat_ibu' => null,

            'tinggi_badan' => 170,
            'berat_badan' => 65,
            'surat_keterangan_sehat' => 'Ada',
            'golongan_darah' => 'A',
            'ukuran_seragam' => 'M',
            'ukuran_sepatu' => 42,
            'punya_tato' => false,
            'perokok' => false,
            'kesehatan_umum' => 'Sehat',
            'olahraga_dilakukan' => 'Futsal',
            'kesehatan_mata' => 'Normal',
            'cacat_penyakit_serius' => null,

            'pendidikan_terakhir' => 'S1',
            'sertifikasi_pelamar' => null,
            'foto_ijazah_terakhir' => null,
            'foto_sertifikat_keahlian1' => null,
            'foto_sertifikat_keahlian2' => null,
            'keahlian_dimiliki' => 'Microsoft Office',
            'hobby_keahlian_disukai' => 'Membaca',
            'keterampilan_kerja_disukai' => 'Analisis Data',
            'peralatan_kerja_dikuasai' => 'Komputer',
            'program_komputer_dikuasai' => 'Microsoft Excel',
            'keahlian_ingin_dicapai' => 'Data Science',
            'jenis_bahasa_dikuasai' => 'Indonesia, Inggris',
            'kendaraan_dikuasai' => 'Motor',
            'sim_dimiliki' => 'SIM C',

            'rencana_target_masa_depan' => 'Menjadi Manajer',
            'suka_berorganisasi' => true,
            'organisasi_diikuti' => 'Organisasi Mahasiswa',

            'punya_pengalaman_kerja' => false,
            'pengalaman_kerja1_perusahaan' => null,
            'pengalaman_kerja1_alamat' => null,
            'pengalaman_kerja1_masa_kerja' => null,
            'pengalaman_kerja1_jabatan' => null,
            'pengalaman_kerja1_gaji_awal' => null,
            'pengalaman_kerja1_gaji_akhir' => null,
            'pengalaman_kerja1_alasan_berhenti' => null,
            'pengalaman_kerja2_perusahaan' => null,
            'pengalaman_kerja2_alamat' => null,
            'pengalaman_kerja2_masa_kerja' => null,
            'pengalaman_kerja2_jabatan' => null,
            'pengalaman_kerja2_gaji_awal' => null,
            'pengalaman_kerja2_gaji_akhir' => null,
            'pengalaman_kerja2_alasan_berhenti' => null,

            'tanggungan_ekonomi' => null,
            'nilai_tanggungan_perbulan' => null,
            'bersedia_lembur' => true,
            'alasan_lembur' => null,
            'bersedia_dipindahkan_bagian_lain' => true,
            'alasan_dipindahkan_bagian_lain' => null,
            'bersedia_ikut_pembinaan_pelatihan' => true,
            'bersedia_penuhi_peraturan_pengamanan' => true,
            'bersedia_dipindahkan_luar_daerah' => false,
            'gaji_diharapkan' => 5000000,
            'batas_gaji_minimum' => 4000000,
            'fasilitas_diharapkan' => 'Asuransi Kesehatan',

            'kapan_bisa_mulai_bekerja' => 'Segera',
            'motivasi_utama_bekerja' => 'Mencari pengalaman',
            'alasan_diterima_perusahaan' => 'Sesuai kualifikasi',
            'hal_lain_disampaikan' => null,
            'pernah_ikut_beladiri' => false,
            'sertifikat_beladiri' => null,
            'foto_full_body' => null,

            'pernyataan_kebenaran_dokumen' => true,
            'pernyataan_lamaran_kerja' => true,
            'status_lamaran' => 'pending',
            'interview_attendance_status' => 'belum_dikonfirmasi', // Default status
        ]);
    }
}
