<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_jabatan_pekerjaan',
        'lokasi_penempatan_diinginkan',
        'nama_lengkap',
        'email',
        'alamat_ktp',
        'alamat_domisili',
        'kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_ktp',
        'foto_ktp',
        'foto_kartu_keluarga',
        'no_whatsapp',
        'no_lain_dihubungi',
        'warga_negara',
        'agama',
        'status_pernikahan',
        'nama_suami_istri',
        'usia_suami_istri',
        'pekerjaan_suami_istri',
        'alamat_suami_istri',
        'nama_anak1',
        'jk_anak1',
        'ttl_anak1',
        'nama_anak2',
        'jk_anak2',
        'ttl_anak2',
        'nama_anak3',
        'jk_anak3',
        'ttl_anak3',
        'nama_ayah',
        'usia_ayah',
        'pekerjaan_ayah',
        'alamat_ayah',
        'nama_ibu',
        'usia_ibu',
        'pekerjaan_ibu',
        'alamat_ibu',
        'tinggi_badan',
        'berat_badan',
        'surat_keterangan_sehat',
        'golongan_darah',
        'ukuran_seragam',
        'ukuran_sepatu',
        'punya_tato',
        'perokok',
        'kesehatan_umum',
        'olahraga_dilakukan',
        'kesehatan_mata',
        'cacat_penyakit_serius',
        'pendidikan_terakhir',
        'sertifikasi_pelamar',
        'foto_ijazah_terakhir',
        'foto_sertifikat_keahlian1',
        'foto_sertifikat_keahlian2',
        'keahlian_dimiliki',
        'hobby_keahlian_disukai',
        'keterampilan_kerja_disukai',
        'peralatan_kerja_dikuasai',
        'program_komputer_dikuasai',
        'keahlian_ingin_dicapai',
        'jenis_bahasa_dikuasai',
        'kendaraan_dikuasai',
        'sim_dimiliki',
        'rencana_target_masa_depan',
        'suka_berorganisasi',
        'organisasi_diikuti',
        'punya_pengalaman_kerja',
        'pengalaman_kerja1_perusahaan',
        'pengalaman_kerja1_alamat',
        'pengalaman_kerja1_masa_kerja',
        'pengalaman_kerja1_jabatan',
        'pengalaman_kerja1_gaji_awal',
        'pengalaman_kerja1_gaji_akhir',
        'pengalaman_kerja1_alasan_berhenti',
        'pengalaman_kerja2_perusahaan',
        'pengalaman_kerja2_alamat',
        'pengalaman_kerja2_masa_kerja',
        'pengalaman_kerja2_jabatan',
        'pengalaman_kerja2_gaji_awal',
        'pengalaman_kerja2_gaji_akhir',
        'pengalaman_kerja2_alasan_berhenti',
        'tanggungan_ekonomi',
        'nilai_tanggungan_perbulan',
        'bersedia_lembur',
        'alasan_lembur',
        'bersedia_dipindahkan_bagian_lain',
        'alasan_dipindahkan_bagian_lain',
        'bersedia_ikut_pembinaan_pelatihan',
        'bersedia_penuhi_peraturan_pengamanan',
        'bersedia_dipindahkan_luar_daerah',
        'gaji_diharapkan',
        'batas_gaji_minimum',
        'fasilitas_diharapkan',
        'kapan_bisa_mulai_bekerja',
        'motivasi_utama_bekerja',
        'alasan_diterima_perusahaan',
        'hal_lain_disampaikan',
        'pernah_ikut_beladiri',
        'sertifikat_beladiri',
        'foto_full_body',
        'pernyataan_kebenaran_dokumen',
        'pernyataan_lamaran_kerja',
        'status',
        'user_id',
        'tanggal_interview',
        'final_decision',
        'final_notes',
        'interview_attendance_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patResult()
    {
        return $this->hasOne(PatResult::class);
    }

    public function psikotestResult()
    {
        return $this->hasOne(PsikotestResult::class);
    }

    public function healthTestResult()
    {
        return $this->hasOne(HealthTestResult::class);
    }

    public function interviewResult()
    {
        return $this->hasOne(InterviewResult::class);
    }
}