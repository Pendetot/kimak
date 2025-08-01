@extends('layouts.app')

@section('title', 'Detail Pelamar')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div id="basicwizard" class="form-wizard row justify-content-center">
                <div class="col-sm-12 col-md-6 col-xxl-4 text-center">
                    <h3>Detail Pelamar</h3>
                    <p class="text-muted mb-4">Informasi lengkap mengenai pelamar.</p>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item" data-target-form="#contactDetailForm">
                                    <a href="#contactDetail" data-bs-toggle="tab" data-toggle="tab" class="nav-link active">
                                        <i class="ph-duotone ph-user-circle"></i>
                                        <span class="d-none d-sm-inline">Informasi Umum</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item" data-target-form="#addressDetailForm">
                                    <a href="#addressDetail" data-bs-toggle="tab" data-toggle="tab" class="nav-link icon-btn">
                                        <i class="ph-duotone ph-map-pin"></i>
                                        <span class="d-none d-sm-inline">Alamat & Kontak</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item" data-target-form="#familyDetailForm">
                                    <a href="#familyDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-users"></i>
                                        <span class="d-none d-sm-inline">Keluarga</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item" data-target-form="#healthDetailForm">
                                    <a href="#healthDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-heartbeat"></i>
                                        <span class="d-none d-sm-inline">Fisik & Kesehatan</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item" data-target-form="#educationDetailForm">
                                    <a href="#educationDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-graduation-cap"></i>
                                        <span class="d-none d-sm-inline">Pendidikan & Keahlian</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item" data-target-form="#experienceDetailForm">
                                    <a href="#experienceDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-briefcase"></i>
                                        <span class="d-none d-sm-inline">Pengalaman & Rencana</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item" data-target-form="#economicDetailForm">
                                    <a href="#economicDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-currency-dollar"></i>
                                        <span class="d-none d-sm-inline">Ekonomi & Kesediaan</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item" data-target-form="#additionalDetailForm">
                                    <a href="#additionalDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-info"></i>
                                        <span class="d-none d-sm-inline">Informasi Tambahan</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item" data-target-form="#statementDetailForm">
                                    <a href="#statementDetail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <i class="ph-duotone ph-file-text"></i>
                                        <span class="d-none d-sm-inline">Pernyataan</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                                <li class="nav-item">
                                    <a href="#finish" data-bs-toggle="tab" data-toggle="tab" class="nav-link icon-btn">
                                        <i class="ph-duotone ph-check-circle"></i>
                                        <span class="d-none d-sm-inline">Selesai</span>
                                    </a>
                                </li>
                                <!-- end nav item -->
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- START: Define your progress bar here -->
                                <div id="bar" class="progress mb-3" style="height: 7px">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                    </div>
                                </div>
                                <!-- END: Define your progress bar here -->
                                <!-- START: Define your tab pans here -->
                                <div class="tab-pane show active" id="contactDetail">
                                    <form id="contactForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Informasi Umum Pelamar</h3>
                                            <small class="text-muted">Detail dasar mengenai pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis/Jabatan Pekerjaan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->jenis_jabatan_pekerjaan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Lokasi Penempatan Diinginkan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->lokasi_penempatan_diinginkan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Lengkap</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->user->name ?? 'N/A' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="{{ $pelamar->email }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No. Whatsapp</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->no_whatsapp }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No. Lain yang Bisa Dihubungi</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->no_lain_dihubungi }}" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat Sesuai KTP</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->alamat_ktp }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat Domisili</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->alamat_domisili }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kelurahan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->kelurahan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kecamatan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->kecamatan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kabupaten/Kota</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->kabupaten_kota }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tempat Lahir</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->tempat_lahir }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" value="{{ $pelamar->tanggal_lahir }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Kelamin</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->jenis_kelamin }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No. KTP</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->no_ktp }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Warga Negara</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->warga_negara }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Agama</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->agama }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status Pernikahan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->status_pernikahan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Referensi</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->reference_name ?? '-' }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end contact detail tab pane -->

                                <div class="tab-pane" id="addressDetail">
                                    <form id="addressForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Data Keluarga (Suami/Istri)</h3>
                                            <small class="text-muted">Informasi mengenai keluarga pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Suami/Istri</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->nama_suami_istri }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Usia Suami/Istri</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->usia_suami_istri }}" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Pekerjaan Suami/Istri</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pekerjaan_suami_istri }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat Suami/Istri</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->alamat_suami_istri }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end address detail tab pane -->

                                <div class="tab-pane" id="familyDetail">
                                    <form id="familyForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Data Anak & Orang Tua</h3>
                                            <small class="text-muted">Informasi mengenai anak dan orang tua pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <h5>Data Anak</h5>
                                                <div class="mb-3">
                                                    <label class="form-label">Anak 1</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->nama_anak1 }} ({{ $pelamar->jk_anak1 }}, {{ $pelamar->ttl_anak1 }})" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Anak 2</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->nama_anak2 }} ({{ $pelamar->jk_anak2 }}, {{ $pelamar->ttl_anak2 }})" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Anak 3</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->nama_anak3 }} ({{ $pelamar->jk_anak3 }}, {{ $pelamar->ttl_anak3 }})" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Data Orang Tua</h5>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Ayah</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->nama_ayah }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Usia Ayah</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->usia_ayah }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Pekerjaan Ayah</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pekerjaan_ayah }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat Ayah</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->alamat_ayah }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Ibu</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->nama_ibu }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Usia Ibu</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->usia_ibu }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Pekerjaan Ibu</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pekerjaan_ibu }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat Ibu</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->alamat_ibu }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end family detail tab pane -->

                                <div class="tab-pane" id="healthDetail">
                                    <form id="healthForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Informasi Fisik & Kesehatan</h3>
                                            <small class="text-muted">Detail mengenai kondisi fisik dan kesehatan pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tinggi Badan (cm)</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->tinggi_badan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Berat Badan (kg)</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->berat_badan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Surat Keterangan Sehat</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->surat_keterangan_sehat }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Golongan Darah</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->golongan_darah }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Ukuran Seragam</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->ukuran_seragam }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Ukuran Sepatu</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->ukuran_sepatu }}" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Punya Tato</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->punya_tato ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Perokok</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->perokok ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Keadaan Kesehatan Umum</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->kesehatan_umum }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Olahraga yang Dilakukan</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->olahraga_dilakukan }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kesehatan Mata</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->kesehatan_mata }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Cacat badan, penyakit serius dan masalah kesehatan yang sedang/pernah anda alami (termasuk alergi berat)?</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->cacat_penyakit_serius }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end health detail tab pane -->

                                <div class="tab-pane" id="educationDetail">
                                    <form id="educationForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Pendidikan & Keahlian</h3>
                                            <small class="text-muted">Detail mengenai riwayat pendidikan dan keahlian pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Pendidikan Terakhir</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pendidikan_terakhir }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Sertifikasi Pelamar</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->sertifikasi_pelamar }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Keahlian yang Dimiliki</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->keahlian_dimiliki }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hobby dan Keahlian Disukai</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->hobby_keahlian_disukai }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Keterampilan Kerja Disukai</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->keterampilan_kerja_disukai }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Peralatan Kerja Dikuasai</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->peralatan_kerja_dikuasai }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Program Komputer Dikuasai</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->program_komputer_dikuasai }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Keahlian yang Ingin Dicapai</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->keahlian_ingin_dicapai }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Bahasa Dikuasai</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->jenis_bahasa_dikuasai }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kendaraan Dikuasai</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->kendaraan_dikuasai }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">SIM Dimiliki</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->sim_dimiliki }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end education detail tab pane -->

                                <div class="tab-pane" id="experienceDetail">
                                    <form id="experienceForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Pengalaman Organisasi & Rencana Masa Depan</h3>
                                            <small class="text-muted">Detail mengenai pengalaman organisasi dan rencana masa depan pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Rencana/Target Masa Depan</label>
                                                    <textarea class="form-control" rows="4" readonly>{{ $pelamar->rencana_target_masa_depan }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Suka Berorganisasi</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->suka_berorganisasi ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Organisasi yang Diikuti</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->organisasi_diikuti }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text-center">
                                            <h3 class="mb-2">Pengalaman Kerja</h3>
                                            <small class="text-muted">Detail mengenai riwayat pengalaman kerja pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <h5>Pengalaman Kerja I</h5>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Perusahaan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pengalaman_kerja1_perusahaan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->pengalaman_kerja1_alamat }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Masa Kerja</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pengalaman_kerja1_masa_kerja }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jabatan/Keahlian</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pengalaman_kerja1_jabatan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gaji Awal (Rp)</label>
                                                    <input type="text" class="form-control" value="{{ number_format($pelamar->pengalaman_kerja1_gaji_awal, 0, ',', '.') }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gaji Akhir (Rp)</label>
                                                    <input type="text" class="form-control" value="{{ number_format($pelamar->pengalaman_kerja1_gaji_akhir, 0, ',', '.') }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Berhenti</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->pengalaman_kerja1_alasan_berhenti }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Pengalaman Kerja II</h5>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Perusahaan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pengalaman_kerja2_perusahaan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->pengalaman_kerja2_alamat }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Masa Kerja</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pengalaman_kerja2_masa_kerja }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jabatan/Keahlian</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pengalaman_kerja2_jabatan }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gaji Awal (Rp)</label>
                                                    <input type="text" class="form-control" value="{{ number_format($pelamar->pengalaman_kerja2_gaji_awal, 0, ',', '.') }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gaji Akhir (Rp)</label>
                                                    <input type="text" class="form-control" value="{{ number_format($pelamar->pengalaman_kerja2_gaji_akhir, 0, ',', '.') }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Berhenti</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->pengalaman_kerja2_alasan_berhenti }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end experience detail tab pane -->

                                <div class="tab-pane" id="economicDetail">
                                    <form id="economicForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Informasi Ekonomi & Kesediaan</h3>
                                            <small class="text-muted">Detail mengenai kondisi ekonomi dan kesediaan pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggungan Ekonomi</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->tanggungan_ekonomi }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nilai Tanggungan Per Bulan (Rp)</label>
                                                    <input type="text" class="form-control" value="{{ number_format($pelamar->nilai_tanggungan_perbulan, 0, ',', '.') }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Bersedia Lembur</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->bersedia_lembur ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Lembur</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->alasan_lembur }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Bersedia Dipindahkan ke Bagian Lain</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->bersedia_dipindahkan_bagian_lain ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Dipindahkan Bagian Lain</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->alasan_dipindahkan_bagian_lain }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Bersedia Ikut Pembinaan/Pelatihan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->bersedia_ikut_pembinaan_pelatihan ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Bersedia Memenuhi Peraturan Pengamanan</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->bersedia_penuhi_peraturan_pengamanan ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Bersedia Dipindahkan ke Luar Daerah</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->bersedia_dipindahkan_luar_daerah ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gaji yang Diharapkan (Rp)</label>
                                                    <input type="text" class="form-control" value="{{ number_format($pelamar->gaji_diharapkan, 0, ',', '.') }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Batas Gaji Minimum (Rp)</label>
                                                    <input type="text" class="form-control" value="{{ number_format($pelamar->batas_gaji_minimum, 0, ',', '.') }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Fasilitas yang Diharapkan</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->fasilitas_diharapkan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end economic detail tab pane -->

                                <div class="tab-pane" id="additionalDetail">
                                    <form id="additionalForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Informasi Tambahan</h3>
                                            <small class="text-muted">Detail informasi tambahan dari pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Kapan Bisa Mulai Bekerja?</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->kapan_bisa_mulai_bekerja }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Motivasi Utama Bekerja</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->motivasi_utama_bekerja }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Mengapa Anda Harus Diterima di Perusahaan Ini</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->alasan_diterima_perusahaan }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hal Lain yang Ingin Disampaikan</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $pelamar->hal_lain_disampaikan }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Pernah Ikut Beladiri</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pernah_ikut_beladiri ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                @if($pelamar->sertifikat_beladiri)
                                                    <div class="mb-3">
                                                        <label class="form-label">Sertifikat Beladiri</label>
                                                        <img src="{{ asset('storage/' . $pelamar->sertifikat_beladiri) }}" class="img-fluid" width="200" />
                                                    </div>
                                                @endif
                                                @if($pelamar->foto_full_body)
                                                    <div class="mb-3">
                                                        <label class="form-label">Foto Full Body</label>
                                                        <img src="{{ asset('storage/' . $pelamar->foto_full_body) }}" class="img-fluid" width="200" />
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end additional detail tab pane -->

                                <div class="tab-pane" id="statementDetail">
                                    <form id="statementForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Pernyataan</h3>
                                            <small class="text-muted">Pernyataan yang dibuat oleh pelamar.</small>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Pernyataan Kebenaran Dokumen</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pernyataan_kebenaran_dokumen ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Pernyataan Lamaran Kerja</label>
                                                    <input type="text" class="form-control" value="{{ $pelamar->pernyataan_lamaran_kerja ? 'Ya' : 'Tidak' }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end statement detail tab pane -->

                                <div class="tab-pane" id="finish">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="text-center">
                                                <i class="ph-duotone ph-gift f-50 text-danger"></i>
                                                <h3 class="mt-4 mb-3">Terima Kasih !</h3>
                                                <p class="text-muted">Data pelamar telah berhasil ditampilkan.</p>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- END: Define your tab pans here -->
                                <!-- START: Define your controller buttons here-->
                                <div class="d-flex wizard justify-content-between flex-wrap gap-2 mt-3">
                                    <div class="first">
                                        <a href="javascript:void(0);" class="btn btn-secondary"> Pertama </a>
                                    </div>
                                    <div class="d-flex">
                                        <div class="previous me-2">
                                            <a href="javascript:void(0);" class="btn btn-secondary"> Kembali </a>
                                        </div>
                                        <div class="next">
                                            <a href="javascript:void(0);" class="btn btn-secondary"> Selanjutnya </a>
                                        </div>
                                    </div>
                                    <div class="last">
                                        <a href="javascript:void(0);" class="btn btn-secondary"> Selesai </a>
                                    </div>
                                </div>
                                <!-- END: Define your controller buttons here-->
                            </div>
                        </div>
                    </div>
                    <!-- end tab content-->
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
 @endsection @section('scripts')
    <!-- [Page specific Javascript] start -->
    <script src="{{ URL::asset('build/js/plugins/wizard.min.js') }}"></script>
    <script>
        new Wizard("#basicwizard", {
            validate: true,
            progress: true
        });
    </script>
    <!-- [Page specific Javascript] end -->
 @endsection