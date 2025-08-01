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
        Schema::create('pelamars', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_jabatan_pekerjaan')->nullable();
            $table->string('lokasi_penempatan_diinginkan')->nullable();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_whatsapp')->nullable();
            $table->string('no_lain_dihubungi')->nullable();
            $table->text('alamat_ktp')->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_kartu_keluarga')->nullable();
            $table->string('warga_negara')->nullable();
            $table->string('agama')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('reference_name')->nullable();

            // Data Keluarga (Suami/Istri)
            $table->string('nama_suami_istri')->nullable();
            $table->integer('usia_suami_istri')->nullable();
            $table->string('pekerjaan_suami_istri')->nullable();
            $table->text('alamat_suami_istri')->nullable();

            // Data Anak
            $table->string('nama_anak1')->nullable();
            $table->string('jk_anak1')->nullable();
            $table->string('ttl_anak1')->nullable();
            $table->string('nama_anak2')->nullable();
            $table->string('jk_anak2')->nullable();
            $table->string('ttl_anak2')->nullable();
            $table->string('nama_anak3')->nullable();
            $table->string('jk_anak3')->nullable();
            $table->string('ttl_anak3')->nullable();

            // Data Orang Tua
            $table->string('nama_ayah')->nullable();
            $table->integer('usia_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->integer('usia_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->text('alamat_ibu')->nullable();

            // Informasi Fisik & Kesehatan
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('surat_keterangan_sehat')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('ukuran_seragam')->nullable();
            $table->integer('ukuran_sepatu')->nullable();
            $table->boolean('punya_tato')->nullable();
            $table->boolean('perokok')->nullable();
            $table->text('kesehatan_umum')->nullable();
            $table->text('olahraga_dilakukan')->nullable();
            $table->text('kesehatan_mata')->nullable();
            $table->text('cacat_penyakit_serius')->nullable();

            // Pendidikan & Keahlian
            $table->string('pendidikan_terakhir')->nullable();
            $table->text('sertifikasi_pelamar')->nullable();
            $table->string('foto_ijazah_terakhir')->nullable();
            $table->string('foto_sertifikat_keahlian1')->nullable();
            $table->string('foto_sertifikat_keahlian2')->nullable();
            $table->text('keahlian_dimiliki')->nullable();
            $table->text('hobby_keahlian_disukai')->nullable();
            $table->text('keterampilan_kerja_disukai')->nullable();
            $table->text('peralatan_kerja_dikuasai')->nullable();
            $table->text('program_komputer_dikuasai')->nullable();
            $table->text('keahlian_ingin_dicapai')->nullable();
            $table->text('jenis_bahasa_dikuasai')->nullable();
            $table->text('kendaraan_dikuasai')->nullable();
            $table->string('sim_dimiliki')->nullable();

            // Pengalaman Organisasi & Rencana Masa Depan
            $table->text('rencana_target_masa_depan')->nullable();
            $table->boolean('suka_berorganisasi')->nullable();
            $table->text('organisasi_diikuti')->nullable();

            // Pengalaman Kerja
            $table->boolean('punya_pengalaman_kerja')->nullable();
            $table->string('pengalaman_kerja1_perusahaan')->nullable();
            $table->text('pengalaman_kerja1_alamat')->nullable();
            $table->string('pengalaman_kerja1_masa_kerja')->nullable();
            $table->string('pengalaman_kerja1_jabatan')->nullable();
            $table->bigInteger('pengalaman_kerja1_gaji_awal')->nullable();
            $table->bigInteger('pengalaman_kerja1_gaji_akhir')->nullable();
            $table->text('pengalaman_kerja1_alasan_berhenti')->nullable();
            $table->string('pengalaman_kerja2_perusahaan')->nullable();
            $table->text('pengalaman_kerja2_alamat')->nullable();
            $table->string('pengalaman_kerja2_masa_kerja')->nullable();
            $table->string('pengalaman_kerja2_jabatan')->nullable();
            $table->bigInteger('pengalaman_kerja2_gaji_awal')->nullable();
            $table->bigInteger('pengalaman_kerja2_gaji_akhir')->nullable();
            $table->text('pengalaman_kerja2_alasan_berhenti')->nullable();

            // Informasi Ekonomi & Kesediaan
            $table->string('tanggungan_ekonomi')->nullable();
            $table->bigInteger('nilai_tanggungan_perbulan')->nullable();
            $table->boolean('bersedia_lembur')->nullable();
            $table->text('alasan_lembur')->nullable();
            $table->boolean('bersedia_dipindahkan_bagian_lain')->nullable();
            $table->text('alasan_dipindahkan_bagian_lain')->nullable();
            $table->boolean('bersedia_ikut_pembinaan_pelatihan')->nullable();
            $table->boolean('bersedia_penuhi_peraturan_pengamanan')->nullable();
            $table->boolean('bersedia_dipindahkan_luar_daerah')->nullable();
            $table->bigInteger('gaji_diharapkan')->nullable();
            $table->bigInteger('batas_gaji_minimum')->nullable();
            $table->text('fasilitas_diharapkan')->nullable();

            // Informasi Tambahan
            $table->string('kapan_bisa_mulai_bekerja')->nullable();
            $table->text('motivasi_utama_bekerja')->nullable();
            $table->text('alasan_diterima_perusahaan')->nullable();
            $table->text('hal_lain_disampaikan')->nullable();
            $table->boolean('pernah_ikut_beladiri')->nullable();
            $table->string('sertifikat_beladiri')->nullable();
            $table->string('foto_full_body')->nullable();

            // Pernyataan
            $table->boolean('pernyataan_kebenaran_dokumen')->nullable();
            $table->boolean('pernyataan_lamaran_kerja')->nullable();

            $table->string('status_lamaran')->default('pending');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelamars');
    }
};
