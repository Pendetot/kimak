<?php

namespace App\Http\Requests\Pelamar;

use Illuminate\Foundation\Http\FormRequest;

class StorePelamarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_jabatan_pekerjaan' => 'nullable|string|max:255',
            'lokasi_penempatan_diinginkan' => 'nullable|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:pelamars',
            'no_whatsapp' => 'required|string|max:20',
            'no_lain_dihubungi' => 'nullable|string|max:20',
            'alamat_ktp' => 'required|string',
            'alamat_domisili' => 'nullable|string',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'no_ktp' => 'required|string|max:16|unique:pelamars',
            'foto_ktp' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'foto_kartu_keluarga' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'warga_negara' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'status_pernikahan' => 'required|string|max:255',
            'reference_name' => 'nullable|string|max:255',

            'nama_suami_istri' => 'nullable|string|max:255',
            'usia_suami_istri' => 'nullable|integer',
            'pekerjaan_suami_istri' => 'nullable|string|max:255',
            'alamat_suami_istri' => 'nullable|string',

            'nama_anak1' => 'nullable|string|max:255',
            'jk_anak1' => 'nullable|string|in:Laki-laki,Perempuan',
            'ttl_anak1' => 'nullable|string',
            'nama_anak2' => 'nullable|string|max:255',
            'jk_anak2' => 'nullable|string|in:Laki-laki,Perempuan',
            'ttl_anak2' => 'nullable|string',
            'nama_anak3' => 'nullable|string|max:255',
            'jk_anak3' => 'nullable|string|in:Laki-laki,Perempuan',
            'ttl_anak3' => 'nullable|string',

            'nama_ayah' => 'nullable|string|max:255',
            'usia_ayah' => 'nullable|integer',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'alamat_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string|max:255',
            'usia_ibu' => 'nullable|integer',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'alamat_ibu' => 'nullable|string',

            'tinggi_badan' => 'nullable|integer',
            'berat_badan' => 'nullable|integer',
            'surat_keterangan_sehat' => 'nullable|string',
            'golongan_darah' => 'nullable|string|max:5',
            'ukuran_seragam' => 'nullable|string|max:10',
            'ukuran_sepatu' => 'nullable|string|max:10',
            'punya_tato' => 'nullable|boolean',
            'perokok' => 'nullable|boolean',
            'kesehatan_umum' => 'nullable|string',
            'olahraga_dilakukan' => 'nullable|string',
            'kesehatan_mata' => 'nullable|string',
            'cacat_penyakit_serius' => 'nullable|string',

            'pendidikan_terakhir' => 'required|string|max:255',
            'sertifikasi_pelamar' => 'nullable|string',
            'foto_ijazah_terakhir' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'foto_sertifikat_keahlian1' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'foto_sertifikat_keahlian2' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'keahlian_dimiliki' => 'nullable|string',
            'hobby_keahlian_disukai' => 'nullable|string',
            'keterampilan_kerja_disukai' => 'nullable|string',
            'peralatan_kerja_dikuasai' => 'nullable|string',
            'program_komputer_dikuasai' => 'nullable|string',
            'keahlian_ingin_dicapai' => 'nullable|string',
            'jenis_bahasa_dikuasai' => 'nullable|string',
            'kendaraan_dikuasai' => 'nullable|string',
            'sim_dimiliki' => 'nullable|string',

            'rencana_target_masa_depan' => 'nullable|string',
            'suka_berorganisasi' => 'nullable|boolean',
            'organisasi_diikuti' => 'nullable|string',

            'punya_pengalaman_kerja' => 'nullable|boolean',
            'pengalaman_kerja1_perusahaan' => 'nullable|string|max:255',
            'pengalaman_kerja1_alamat' => 'nullable|string',
            'pengalaman_kerja1_masa_kerja' => 'nullable|string|max:255',
            'pengalaman_kerja1_jabatan' => 'nullable|string|max:255',
            'pengalaman_kerja1_gaji_awal' => 'nullable|numeric',
            'pengalaman_kerja1_gaji_akhir' => 'nullable|numeric',
            'pengalaman_kerja1_alasan_berhenti' => 'nullable|string',
            'pengalaman_kerja2_perusahaan' => 'nullable|string|max:255',
            'pengalaman_kerja2_alamat' => 'nullable|string',
            'pengalaman_kerja2_masa_kerja' => 'nullable|string|max:255',
            'pengalaman_kerja2_jabatan' => 'nullable|string|max:255',
            'pengalaman_kerja2_gaji_awal' => 'nullable|numeric',
            'pengalaman_kerja2_gaji_akhir' => 'nullable|numeric',
            'pengalaman_kerja2_alasan_berhenti' => 'nullable|string',

            'tanggungan_ekonomi' => 'nullable|string',
            'nilai_tanggungan_perbulan' => 'nullable|numeric',
            'bersedia_lembur' => 'nullable|boolean',
            'alasan_lembur' => 'nullable|string',
            'bersedia_dipindahkan_bagian_lain' => 'nullable|boolean',
            'alasan_dipindahkan_bagian_lain' => 'nullable|string',
            'bersedia_ikut_pembinaan_pelatihan' => 'nullable|boolean',
            'bersedia_penuhi_peraturan_pengamanan' => 'nullable|boolean',
            'bersedia_dipindahkan_luar_daerah' => 'nullable|boolean',
            'gaji_diharapkan' => 'nullable|numeric',
            'batas_gaji_minimum' => 'nullable|numeric',
            'fasilitas_diharapkan' => 'nullable|string',

            'kapan_bisa_mulai_bekerja' => 'nullable|string',
            'motivasi_utama_bekerja' => 'nullable|string',
            'alasan_diterima_perusahaan' => 'nullable|string',
            'hal_lain_disampaikan' => 'nullable|string',
            'pernah_ikut_beladiri' => 'nullable|boolean',
            'sertifikat_beladiri' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'foto_full_body' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',

            'pernyataan_kebenaran_dokumen' => 'required|boolean',
            'pernyataan_lamaran_kerja' => 'required|boolean',
        ];
    }
}