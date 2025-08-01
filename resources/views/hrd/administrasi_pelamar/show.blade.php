@extends('layouts.app')

@section('title', 'Detail Pelamar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Pelamar: {{ $pelamar->nama_lengkap }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Jenis/Jabatan Pekerjaan:</strong> {{ $pelamar->jenis_jabatan_pekerjaan }}</p>
                            <p><strong>Lokasi Penempatan:</strong> {{ $pelamar->lokasi_penempatan_diinginkan }}</p>
                            <p><strong>Nama Lengkap:</strong> {{ $pelamar->nama_lengkap }}</p>
                            <p><strong>Email:</strong> {{ $pelamar->email }}</p>
                            <p><strong>No. Whatsapp:</strong> {{ $pelamar->no_whatsapp }}</p>
                            <p><strong>No. Lain Dihubungi:</strong> {{ $pelamar->no_lain_dihubungi }}</p>
                            <p><strong>Alamat KTP:</strong> {{ $pelamar->alamat_ktp }}</p>
                            <p><strong>Alamat Domisili:</strong> {{ $pelamar->alamat_domisili }}</p>
                            <p><strong>Kelurahan:</strong> {{ $pelamar->kelurahan }}</p>
                            <p><strong>Kecamatan:</strong> {{ $pelamar->kecamatan }}</p>
                            <p><strong>Kabupaten/Kota:</strong> {{ $pelamar->kabupaten_kota }}</p>
                            <p><strong>Tempat Lahir:</strong> {{ $pelamar->tempat_lahir }}</p>
                            <p><strong>Tanggal Lahir:</strong> {{ $pelamar->tanggal_lahir }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ $pelamar->jenis_kelamin }}</p>
                            <p><strong>No. KTP:</strong> {{ $pelamar->no_ktp }}</p>
                            <p><strong>Warga Negara:</strong> {{ $pelamar->warga_negara }}</p>
                            <p><strong>Agama:</strong> {{ $pelamar->agama }}</p>
                            <p><strong>Status Pernikahan:</strong> {{ $pelamar->status_pernikahan }}</p>
                        </div>
                        <div class="col-md-6">
                            @if($pelamar->foto_ktp)
                                <p><strong>Foto KTP:</strong> <img src="{{ asset('storage/' . $pelamar->foto_ktp) }}" width="200"></p>
                            @endif
                            @if($pelamar->foto_kartu_keluarga)
                                <p><strong>Foto Kartu Keluarga:</strong> <img src="{{ asset('storage/' . $pelamar->foto_kartu_keluarga) }}" width="200"></p>
                            @endif
                            @if($pelamar->nama_suami_istri)
                                <h5>Data Keluarga (Suami/Istri)</h5>
                                <p><strong>Nama Suami/Istri:</strong> {{ $pelamar->nama_suami_istri }}</p>
                                <p><strong>Usia Suami/Istri:</strong> {{ $pelamar->usia_suami_istri }}</p>
                                <p><strong>Pekerjaan Suami/Istri:</strong> {{ $pelamar->pekerjaan_suami_istri }}</p>
                                <p><strong>Alamat Suami/Istri:</strong> {{ $pelamar->alamat_suami_istri }}</p>
                            @endif
                            @if($pelamar->nama_anak1 || $pelamar->nama_anak2 || $pelamar->nama_anak3)
                                <h5>Data Anak</h5>
                                @if($pelamar->nama_anak1)
                                    <p><strong>Anak 1:</strong> {{ $pelamar->nama_anak1 }} ({{ $pelamar->jk_anak1 }}, {{ $pelamar->ttl_anak1 }})</p>
                                @endif
                                @if($pelamar->nama_anak2)
                                    <p><strong>Anak 2:</strong> {{ $pelamar->nama_anak2 }} ({{ $pelamar->jk_anak2 }}, {{ $pelamar->ttl_anak2 }})</p>
                                @endif
                                @if($pelamar->nama_anak3)
                                    <p><strong>Anak 3:</strong> {{ $pelamar->nama_anak3 }} ({{ $pelamar->jk_anak3 }}, {{ $pelamar->ttl_anak3 }})</p>
                                @endif
                            @endif
                            <h5>Data Orang Tua</h5>
                            <p><strong>Nama Ayah:</strong> {{ $pelamar->nama_ayah }}</p>
                            <p><strong>Usia Ayah:</strong> {{ $pelamar->usia_ayah }}</p>
                            <p><strong>Pekerjaan Ayah:</strong> {{ $pelamar->pekerjaan_ayah }}</p>
                            <p><strong>Alamat Ayah:</strong> {{ $pelamar->alamat_ayah }}</p>
                            <p><strong>Nama Ibu:</strong> {{ $pelamar->nama_ibu }}</p>
                            <p><strong>Usia Ibu:</strong> {{ $pelamar->usia_ibu }}</p>
                            <p><strong>Pekerjaan Ibu:</strong> {{ $pelamar->pekerjaan_ibu }}</p>
                            <p><strong>Alamat Ibu:</strong> {{ $pelamar->alamat_ibu }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informasi Fisik & Kesehatan</h5>
                            <p><strong>Tinggi Badan:</strong> {{ $pelamar->tinggi_badan }} cm</p>
                            <p><strong>Berat Badan:</strong> {{ $pelamar->berat_badan }} kg</p>
                            <p><strong>Surat Keterangan Sehat:</strong> {{ $pelamar->surat_keterangan_sehat }}</p>
                            <p><strong>Golongan Darah:</strong> {{ $pelamar->golongan_darah }}</p>
                            <p><strong>Ukuran Seragam:</strong> {{ $pelamar->ukuran_seragam }}</p>
                            <p><strong>Ukuran Sepatu:</strong> {{ $pelamar->ukuran_sepatu }}</p>
                            <p><strong>Punya Tato:</strong> {{ $pelamar->punya_tato ? 'Ya' : 'Tidak' }}</p>
                            <p><strong>Perokok:</strong> {{ $pelamar->perokok ? 'Ya' : 'Tidak' }}</p>
                            <p><strong>Kesehatan Umum:</strong> {{ $pelamar->kesehatan_umum }}</p>
                            <p><strong>Olahraga Dilakukan:</strong> {{ $pelamar->olahraga_dilakukan }}</p>
                            <p><strong>Kesehatan Mata:</strong> {{ $pelamar->kesehatan_mata }}</p>
                            <p><strong>Cacat/Penyakit Serius:</strong> {{ $pelamar->cacat_penyakit_serius }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Pendidikan & Keahlian</h5>
                            <p><strong>Pendidikan Terakhir:</strong> {{ $pelamar->pendidikan_terakhir }}</p>
                            <p><strong>Sertifikasi Pelamar:</strong> {{ $pelamar->sertifikasi_pelamar }}</p>
                            @if($pelamar->foto_ijazah_terakhir)
                                <p><strong>Foto Ijazah Terakhir:</strong> <img src="{{ asset('storage/' . $pelamar->foto_ijazah_terakhir) }}" width="200"></p>
                            @endif
                            @if($pelamar->foto_sertifikat_keahlian1)
                                <p><strong>Foto Sertifikat Keahlian I:</strong> <img src="{{ asset('storage/' . $pelamar->foto_sertifikat_keahlian1) }}" width="200"></p>
                            @endif
                            @if($pelamar->foto_sertifikat_keahlian2)
                                <p><strong>Foto Sertifikat Keahlian II:</strong> <img src="{{ asset('storage/' . $pelamar->foto_sertifikat_keahlian2) }}" width="200"></p>
                            @endif
                            <p><strong>Keahlian Dimiliki:</strong> {{ $pelamar->keahlian_dimiliki }}</p>
                            <p><strong>Hobby & Keahlian Disukai:</strong> {{ $pelamar->hobby_keahlian_disukai }}</p>
                            <p><strong>Keterampilan Kerja Disukai:</strong> {{ $pelamar->keterampilan_kerja_disukai }}</p>
                            <p><strong>Peralatan Kerja Dikuasai:</strong> {{ $pelamar->peralatan_kerja_dikuasai }}</p>
                            <p><strong>Program Komputer Dikuasai:</strong> {{ $pelamar->program_komputer_dikuasai }}</p>
                            <p><strong>Keahlian Ingin Dicapai:</strong> {{ $pelamar->keahlian_ingin_dicapai }}</p>
                            <p><strong>Jenis Bahasa Dikuasai:</strong> {{ $pelamar->jenis_bahasa_dikuasai }}</p>
                            <p><strong>Kendaraan Dikuasai:</strong> {{ $pelamar->kendaraan_dikuasai }}</p>
                            <p><strong>SIM Dimiliki:</strong> {{ $pelamar->sim_dimiliki }}</p>
                        </div>
                    </div>
                    <hr>
                    <h5>Pengalaman Organisasi & Rencana Masa Depan</h5>
                    <p><strong>Rencana/Target Masa Depan:</strong> {{ $pelamar->rencana_target_masa_depan }}</p>
                    <p><strong>Suka Berorganisasi:</strong> {{ $pelamar->suka_berorganisasi ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Organisasi Diikuti:</strong> {{ $pelamar->organisasi_diikuti }}</p>
                    <hr>
                    <h5>Pengalaman Kerja</h5>
                    @if($pelamar->pengalaman_kerja1_perusahaan)
                        <h6>Pengalaman Kerja I</h6>
                        <p><strong>Perusahaan:</strong> {{ $pelamar->pengalaman_kerja1_perusahaan }}</p>
                        <p><strong>Alamat:</strong> {{ $pelamar->pengalaman_kerja1_alamat }}</p>
                        <p><strong>Masa Kerja:</strong> {{ $pelamar->pengalaman_kerja1_masa_kerja }}</p>
                        <p><strong>Jabatan:</strong> {{ $pelamar->pengalaman_kerja1_jabatan }}</p>
                        <p><strong>Gaji Awal:</strong> Rp {{ number_format($pelamar->pengalaman_kerja1_gaji_awal, 0, ',', '.') }}</p>
                        <p><strong>Gaji Akhir:</strong> Rp {{ number_format($pelamar->pengalaman_kerja1_gaji_akhir, 0, ',', '.') }}</p>
                        <p><strong>Alasan Berhenti:</strong> {{ $pelamar->pengalaman_kerja1_alasan_berhenti }}</p>
                    @endif
                    @if($pelamar->pengalaman_kerja2_perusahaan)
                        <h6>Pengalaman Kerja II</h6>
                        <p><strong>Perusahaan:</strong> {{ $pelamar->pengalaman_kerja2_perusahaan }}</p>
                        <p><strong>Alamat:</strong> {{ $pelamar->pengalaman_kerja2_alamat }}</p>
                        <p><strong>Masa Kerja:</strong> {{ $pelamar->pengalaman_kerja2_masa_kerja }}</p>
                        <p><strong>Jabatan:</strong> {{ $pelamar->pengalaman_kerja2_jabatan }}</p>
                        <p><strong>Gaji Awal:</strong> Rp {{ number_format($pelamar->pengalaman_kerja2_gaji_awal, 0, ',', '.') }}</p>
                        <p><strong>Gaji Akhir:</strong> Rp {{ number_format($pelamar->pengalaman_kerja2_gaji_akhir, 0, ',', '.') }}</p>
                        <p><strong>Alasan Berhenti:</strong> {{ $pelamar->pengalaman_kerja2_alasan_berhenti }}</p>
                    @endif
                    <hr>
                    <h5>Informasi Tambahan</h5>
                    <p><strong>Tanggungan Ekonomi:</strong> {{ $pelamar->tanggungan_ekonomi }}</p>
                    <p><strong>Nilai Tanggungan Perbulan:</strong> Rp {{ number_format($pelamar->nilai_tanggungan_perbulan, 0, ',', '.') }}</p>
                    <p><strong>Bersedia Lembur:</strong> {{ $pelamar->bersedia_lembur ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Alasan Lembur:</strong> {{ $pelamar->alasan_lembur }}</p>
                    <p><strong>Bersedia Dipindahkan Bagian Lain:</strong> {{ $pelamar->bersedia_dipindahkan_bagian_lain ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Alasan Dipindahkan Bagian Lain:</strong> {{ $pelamar->alasan_dipindahkan_bagian_lain }}</p>
                    <p><strong>Bersedia Ikut Pembinaan/Pelatihan:</strong> {{ $pelamar->bersedia_ikut_pembinaan_pelatihan ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Bersedia Penuhi Peraturan Pengamanan:</strong> {{ $pelamar->bersedia_penuhi_peraturan_pengamanan ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Bersedia Dipindahkan Luar Daerah:</strong> {{ $pelamar->bersedia_dipindahkan_luar_daerah ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Gaji Diharapkan:</strong> Rp {{ number_format($pelamar->gaji_diharapkan, 0, ',', '.') }}</p>
                    <p><strong>Batas Gaji Minimum:</strong> Rp {{ number_format($pelamar->batas_gaji_minimum, 0, ',', '.') }}</p>
                    <p><strong>Fasilitas Diharapkan:</strong> {{ $pelamar->fasilitas_diharapkan }}</p>
                    <p><strong>Kapan Bisa Mulai Bekerja:</strong> {{ $pelamar->kapan_bisa_mulai_bekerja }}</p>
                    <p><strong>Motivasi Utama Bekerja:</strong> {{ $pelamar->motivasi_utama_bekerja }}</p>
                    <p><strong>Alasan Diterima Perusahaan:</strong> {{ $pelamar->alasan_diterima_perusahaan }}</p>
                    <p><strong>Hal Lain Disampaikan:</strong> {{ $pelamar->hal_lain_disampaikan }}</p>
                    <p><strong>Pernah Ikut Beladiri:</strong> {{ $pelamar->pernah_ikut_beladiri ? 'Ya' : 'Tidak' }}</p>
                    @if($pelamar->sertifikat_beladiri)
                        <p><strong>Sertifikat Beladiri:</strong> <img src="{{ asset('storage/' . $pelamar->sertifikat_beladiri) }}" width="200"></p>
                    @endif
                    @if($pelamar->foto_full_body)
                        <p><strong>Foto Full Body:</strong> <img src="{{ asset('storage/' . $pelamar->foto_full_body) }}" width="200"></p>
                    @endif
                    <p><strong>Pernyataan Kebenaran Dokumen:</strong> {{ $pelamar->pernyataan_kebenaran_dokumen ? 'Ya' : 'Tidak' }}</p>
                    <p><strong>Pernyataan Lamaran Kerja:</strong> {{ $pelamar->pernyataan_lamaran_kerja ? 'Ya' : 'Tidak' }}</p>

                    <hr>
                    <h5>Hasil Tes</h5>
                    @if($pelamar->status === 'interview_confirmed')
                        <p>Pelamar telah mengkonfirmasi kehadiran interview.</p>
                        <a href="{{ route('hrd.administrasi-pelamar.show-pat-form', $pelamar->id) }}" class="btn btn-info">Input Hasil PAT</a>
                        <a href="{{ route('hrd.administrasi-pelamar.show-psikotest-form', $pelamar->id) }}" class="btn btn-info">Input Hasil Psikotest</a>
                        <a href="{{ route('hrd.administrasi-pelamar.show-health-test-form', $pelamar->id) }}" class="btn btn-info">Input Hasil Tes Kesehatan</a>
                        <a href="{{ route('hrd.administrasi-pelamar.show-interview-form', $pelamar->id) }}" class="btn btn-info">Input Hasil Interview</a>
                        <a href="{{ route('hrd.administrasi-pelamar.show-final-decision-form', $pelamar->id) }}" class="btn btn-success">Keputusan Akhir</a>
                    @elseif($pelamar->status === 'interview_not_confirmed')
                        <p>Pelamar tidak mengkonfirmasi kehadiran interview. Alasan: {{ $pelamar->tidakHadir->reason ?? 'Tidak ada alasan.' }}</p>
                    @else
                        <p>Menunggu konfirmasi kehadiran interview dari pelamar.</p>
                    @endif

                    <hr>
                    <h5>Form Administrasi</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">Dokumen Kontrak & Legal</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a href="{{ route('hrd.administrasi-pelamar.show-pkwt-form', $pelamar->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-file-contract"></i> Form PKWT
                                            @if($pelamar->pkwt_status === 'completed')
                                                <i class="fas fa-check-circle text-success"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <a href="{{ route('hrd.administrasi-pelamar.show-bpjs-form', $pelamar->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-shield-alt"></i> Form BPJS
                                            @if($pelamar->bpjs_status === 'completed')
                                                <i class="fas fa-check-circle text-success"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <a href="{{ route('hrd.administrasi-pelamar.show-spt-form', $pelamar->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-file-invoice"></i> Form SPT
                                            @if($pelamar->spt_status === 'completed')
                                                <i class="fas fa-check-circle text-success"></i>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">Dokumen Administrasi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a href="{{ route('hrd.administrasi-pelamar.show-document-receipt-form', $pelamar->id) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-receipt"></i> Tanda Terima Dokumen
                                            @if($pelamar->document_receipt_status === 'completed')
                                                <i class="fas fa-check-circle text-success"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <a href="{{ route('hrd.administrasi-pelamar.show-statement-form', $pelamar->id) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-file-signature"></i> Surat Pernyataan
                                            @if($pelamar->statement_status === 'completed')
                                                <i class="fas fa-check-circle text-success"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <a href="{{ route('hrd.administrasi-pelamar.show-banking-form', $pelamar->id) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-university"></i> Data Perbankan
                                            @if($pelamar->banking_status === 'completed')
                                                <i class="fas fa-check-circle text-success"></i>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $totalForms = 6;
                        $completedForms = 0;
                        if($pelamar->pkwt_status === 'completed') $completedForms++;
                        if($pelamar->bpjs_status === 'completed') $completedForms++;
                        if($pelamar->spt_status === 'completed') $completedForms++;
                        if($pelamar->document_receipt_status === 'completed') $completedForms++;
                        if($pelamar->statement_status === 'completed') $completedForms++;
                        if($pelamar->banking_status === 'completed') $completedForms++;
                        $progressPercentage = ($completedForms / $totalForms) * 100;
                    @endphp

                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">Progress Administrasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%" 
                                     aria-valuenow="{{ $completedForms }}" aria-valuemin="0" aria-valuemax="{{ $totalForms }}">
                                    {{ $completedForms }}/{{ $totalForms }} Form Selesai
                                </div>
                            </div>
                            
                            @if($progressPercentage == 100)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Semua form administrasi telah lengkap!
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Masih ada {{ $totalForms - $completedForms }} form yang belum diselesaikan.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
