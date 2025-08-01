@extends('layouts.layout-components')

@section('title', 'Formulir Pendaftaran Pelamar')
@section('breadcrumb-title', 'Pendaftaran Pelamar')
@section('breadcrumb-text', 'Isi formulir di bawah ini untuk mengajukan lamaran kerja Anda.')
@section('breadcrumb-link', '#')

@section('css')
    <!-- [Page specific CSS] start -->
    <link href="{{ URL::asset('build/css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css">
    <!-- [Page specific CSS] end -->
@endsection

@section('css-bottom')
    <link rel="stylesheet" href="{{ URL::asset('build/css/uikit.css') }}">
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            @if ($is_form_enabled)
                <form action="{{ route('pelamar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Informasi Umum -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Informasi Umum</h5>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_jabatan_pekerjaan" class="form-label">Jenis/Jabatan Pekerjaan yang Diajukan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="jenis_jabatan_pekerjaan" name="jenis_jabatan_pekerjaan" value="{{ old('jenis_jabatan_pekerjaan') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lokasi_penempatan_diinginkan" class="form-label">Satuan/Lokasi Penempatan yang Diinginkan</label>
                                        <input type="text" class="form-control" id="lokasi_penempatan_diinginkan" name="lokasi_penempatan_diinginkan" value="{{ old('lokasi_penempatan_diinginkan') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_whatsapp" class="form-label">No. Whatsapp <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_whatsapp" name="no_whatsapp" value="{{ old('no_whatsapp') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_lain_dihubungi" class="form-label">No. Lain yang Bisa Dihubungi</label>
                                        <input type="text" class="form-control" id="no_lain_dihubungi" name="no_lain_dihubungi" value="{{ old('no_lain_dihubungi') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alamat_ktp" class="form-label">Alamat Sesuai KTP <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="alamat_ktp" name="alamat_ktp" rows="3" required>{{ old('alamat_ktp') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                                        <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" rows="3">{{ old('alamat_domisili') }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="kelurahan" class="form-label">Kelurahan</label>
                                            <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                                            <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_ktp" class="form-label">No. KTP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}" required maxlength="16">
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_ktp" class="form-label">Foto KTP</label>
                                        <input type="file" class="form-control" id="foto_ktp" name="foto_ktp" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_kartu_keluarga" class="form-label">Foto Kartu Keluarga</label>
                                        <input type="file" class="form-control" id="foto_kartu_keluarga" name="foto_kartu_keluarga" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="warga_negara" class="form-label">Warga Negara <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="warga_negara" name="warga_negara" value="{{ old('warga_negara', 'Indonesia') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                        <select class="form-select" id="agama" name="agama" required>
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status_pernikahan" class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status_pernikahan" name="status_pernikahan" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Lajang" {{ old('status_pernikahan') == 'Lajang' ? 'selected' : '' }}>Lajang</option>
                                            <option value="Menikah" {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                            <option value="Cerai Hidup" {{ old('status_pernikahan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                            <option value="Cerai Mati" {{ old('status_pernikahan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="referenceSwitch">
                                            <label class="form-check-label" for="referenceSwitch">Referensi</label>
                                        </div>
                                    </div>
                                    <div class="mb-3" id="referenceInputContainer" style="display: none;">
                                        <label for="referenceNameInput" class="form-label">Nama Referensi</label>
                                        <input type="text" class="form-control" id="referenceNameInput">
                                    </div>
                                    <div class="mb-3" id="referenceStatusIcon">
                                        <!-- Icon will be dynamically added here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Keluarga (Suami/Istri) -->
                    <div class="card" id="dataKeluargaCard">
                        <div class="card-header">
                            <h5>Data Keluarga (Suami/Istri)</h5>
                            <small class="text-muted">Isi jika sudah menikah</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_suami_istri" class="form-label">Nama Suami/Istri</label>
                                        <input type="text" class="form-control" id="nama_suami_istri" name="nama_suami_istri" value="{{ old('nama_suami_istri') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="usia_suami_istri" class="form-label">Usia</label>
                                        <input type="number" class="form-control" id="usia_suami_istri" name="usia_suami_istri" value="{{ old('usia_suami_istri') }}" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pekerjaan_suami_istri" class="form-label">Pekerjaan</label>
                                        <input type="text" class="form-control" id="pekerjaan_suami_istri" name="pekerjaan_suami_istri" value="{{ old('pekerjaan_suami_istri') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat_suami_istri" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_suami_istri" name="alamat_suami_istri" rows="3">{{ old('alamat_suami_istri') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Anak -->
                    <div class="card" id="dataAnakCard">
                        <div class="card-header">
                            <h5>Data Anak</h5>
                            <small class="text-muted">Isi jika memiliki anak</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="text-muted">Anak 1</h6>
                                    <div class="mb-3">
                                        <label for="nama_anak1" class="form-label">Nama Anak 1</label>
                                        <input type="text" class="form-control" id="nama_anak1" name="nama_anak1" value="{{ old('nama_anak1') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jk_anak1" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jk_anak1" name="jk_anak1">
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki" {{ old('jk_anak1') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jk_anak1') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ttl_anak1" class="form-label">Tempat dan Tanggal Lahir</label>
                                        <input type="text" class="form-control" id="ttl_anak1" name="ttl_anak1" value="{{ old('ttl_anak1') }}" placeholder="Contoh: Jakarta, 01 Januari 2010">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Anak 2</h6>
                                    <div class="mb-3">
                                        <label for="nama_anak2" class="form-label">Nama Anak 2</label>
                                        <input type="text" class="form-control" id="nama_anak2" name="nama_anak2" value="{{ old('nama_anak2') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jk_anak2" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jk_anak2" name="jk_anak2">
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki" {{ old('jk_anak2') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jk_anak2') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ttl_anak2" class="form-label">Tempat dan Tanggal Lahir</label>
                                        <input type="text" class="form-control" id="ttl_anak2" name="ttl_anak2" value="{{ old('ttl_anak2') }}" placeholder="Contoh: Jakarta, 01 Januari 2012">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Anak 3</h6>
                                    <div class="mb-3">
                                        <label for="nama_anak3" class="form-label">Nama Anak 3</label>
                                        <input type="text" class="form-control" id="nama_anak3" name="nama_anak3" value="{{ old('nama_anak3') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jk_anak3" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jk_anak3" name="jk_anak3">
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki" {{ old('jk_anak3') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jk_anak3') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ttl_anak3" class="form-label">Tempat dan Tanggal Lahir</label>
                                        <input type="text" class="form-control" id="ttl_anak3" name="ttl_anak3" value="{{ old('ttl_anak3') }}" placeholder="Contoh: Jakarta, 01 Januari 2014">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Orang Tua</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Data Ayah</h6>
                                    <div class="mb-3">
                                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="usia_ayah" class="form-label">Usia</label>
                                        <input type="number" class="form-control" id="usia_ayah" name="usia_ayah" value="{{ old('usia_ayah') }}" min="0" max="120">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan</label>
                                        <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat_ayah" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" rows="3">{{ old('alamat_ayah') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Data Ibu</h6>
                                    <div class="mb-3">
                                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="usia_ibu" class="form-label">Usia</label>
                                        <input type="number" class="form-control" id="usia_ibu" name="usia_ibu" value="{{ old('usia_ibu') }}" min="0" max="120">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan</label>
                                        <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat_ibu" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" rows="3">{{ old('alamat_ibu') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Fisik & Kesehatan -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Informasi Fisik & Kesehatan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan') }}" min="100" max="250">
                                    </div>
                                    <div class="mb-3">
                                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                        <input type="number" class="form-control" id="berat_badan" name="berat_badan" value="{{ old('berat_badan') }}" min="30" max="200">
                                    </div>
                                    <div class="mb-3">
                                        <label for="surat_keterangan_sehat" class="form-label">Surat Keterangan Sehat</label>
                                        <input type="text" class="form-control" id="surat_keterangan_sehat" name="surat_keterangan_sehat" value="{{ old('surat_keterangan_sehat') }}" placeholder="Contoh: Ada/Tidak Ada">
                                    </div>
                                    <div class="mb-3">
                                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                        <select class="form-select" id="golongan_darah" name="golongan_darah">
                                            <option value="">Pilih Golongan Darah</option>
                                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ukuran_seragam" class="form-label">Ukuran Seragam</label>
                                        <select class="form-select" id="ukuran_seragam" name="ukuran_seragam">
                                            <option value="">Pilih Ukuran</option>
                                            <option value="S" {{ old('ukuran_seragam') == 'S' ? 'selected' : '' }}>S</option>
                                            <option value="M" {{ old('ukuran_seragam') == 'M' ? 'selected' : '' }}>M</option>
                                            <option value="L" {{ old('ukuran_seragam') == 'L' ? 'selected' : '' }}>L</option>
                                            <option value="XL" {{ old('ukuran_seragam') == 'XL' ? 'selected' : '' }}>XL</option>
                                            <option value="XXL" {{ old('ukuran_seragam') == 'XXL' ? 'selected' : '' }}>XXL</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ukuran_sepatu" class="form-label">Ukuran Sepatu</label>
                                        <input type="number" class="form-control" id="ukuran_sepatu" name="ukuran_sepatu" value="{{ old('ukuran_sepatu') }}" min="35" max="50">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="punya_tato" name="punya_tato" value="1" {{ old('punya_tato') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="punya_tato">Apakah Anda mempunyai Tato?</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="perokok" name="perokok" value="1" {{ old('perokok') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perokok">Anda seorang perokok?</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kesehatan_umum" class="form-label">Keadaan Kesehatan Umum</label>
                                        <textarea class="form-control" id="kesehatan_umum" name="kesehatan_umum" rows="3">{{ old('kesehatan_umum') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="olahraga_dilakukan" class="form-label">Olahraga yang Dilakukan</label>
                                        <textarea class="form-control" id="olahraga_dilakukan" name="olahraga_dilakukan" rows="3">{{ old('olahraga_dilakukan') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kesehatan_mata" class="form-label">Kesehatan Mata</label>
                                        <textarea class="form-control" id="kesehatan_mata" name="kesehatan_mata" rows="3">{{ old('kesehatan_mata') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cacat_penyakit_serius" class="form-label">Cacat badan, penyakit serius dan masalah kesehatan yang sedang/pernah anda alami (termasuk alergi berat)?</label>
                                        <textarea class="form-control" id="cacat_penyakit_serius" name="cacat_penyakit_serius" rows="3">{{ old('cacat_penyakit_serius') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pendidikan & Keahlian -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Pendidikan & Keahlian</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                        <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                                            <option value="">Pilih Pendidikan</option>
                                            <option value="SD" {{ old('pendidikan_terakhir') == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('pendidikan_terakhir') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA/SMK" {{ old('pendidikan_terakhir') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                            <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                                            <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                                            <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                                            <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sertifikasi_pelamar" class="form-label">Sertifikasi Pelamar</label>
                                        <input type="text" class="form-control" id="sertifikasi_pelamar" name="sertifikasi_pelamar" value="{{ old('sertifikasi_pelamar') }}" placeholder="Contoh: Sertifikat Keahlian, Lisensi, dll">
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_ijazah_terakhir" class="form-label">Foto Ijazah Terakhir</label>
                                        <input type="file" class="form-control" id="foto_ijazah_terakhir" name="foto_ijazah_terakhir" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_sertifikat_keahlian1" class="form-label">Foto Sertifikat Keahlian I</label>
                                        <input type="file" class="form-control" id="foto_sertifikat_keahlian1" name="foto_sertifikat_keahlian1" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_sertifikat_keahlian2" class="form-label">Foto Sertifikat Keahlian II</label>
                                        <input type="file" class="form-control" id="foto_sertifikat_keahlian2" name="foto_sertifikat_keahlian2" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keahlian_dimiliki" class="form-label">Keahlian apa yang Anda miliki?</label>
                                        <textarea class="form-control" id="keahlian_dimiliki" name="keahlian_dimiliki" rows="3">{{ old('keahlian_dimiliki') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hobby_keahlian_disukai" class="form-label">Hobby dan keahlian apa yang Anda sukai?</label>
                                        <textarea class="form-control" id="hobby_keahlian_disukai" name="hobby_keahlian_disukai" rows="3">{{ old('hobby_keahlian_disukai') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="keterampilan_kerja_disukai" class="form-label">Keterampilan kerja apa yang Anda sukai?</label>
                                        <textarea class="form-control" id="keterampilan_kerja_disukai" name="keterampilan_kerja_disukai" rows="3">{{ old('keterampilan_kerja_disukai') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="peralatan_kerja_dikuasai" class="form-label">Peralatan kerja apa yang dikuasai?</label>
                                        <textarea class="form-control" id="peralatan_kerja_dikuasai" name="peralatan_kerja_dikuasai" rows="3">{{ old('peralatan_kerja_dikuasai') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="program_komputer_dikuasai" class="form-label">Program komputer apa yang dikuasai?</label>
                                        <textarea class="form-control" id="program_komputer_dikuasai" name="program_komputer_dikuasai" rows="3">{{ old('program_komputer_dikuasai') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keahlian_ingin_dicapai" class="form-label">Keahlian yang ingin dicapai/diperbaiki/dikembangkan?</label>
                                        <textarea class="form-control" id="keahlian_ingin_dicapai" name="keahlian_ingin_dicapai" rows="3">{{ old('keahlian_ingin_dicapai') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_bahasa_dikuasai" class="form-label">Jenis bahasa yang dikuasai?</label>
                                        <textarea class="form-control" id="jenis_bahasa_dikuasai" name="jenis_bahasa_dikuasai" rows="3">{{ old('jenis_bahasa_dikuasai') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kendaraan_dikuasai" class="form-label">Kendaraan yang dikuasai?</label>
                                        <textarea class="form-control" id="kendaraan_dikuasai" name="kendaraan_dikuasai" rows="3">{{ old('kendaraan_dikuasai') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sim_dimiliki" class="form-label">SIM yang dimiliki</label>
                                        <input type="text" class="form-control" id="sim_dimiliki" name="sim_dimiliki" value="{{ old('sim_dimiliki') }}" placeholder="Contoh: SIM A, SIM B1, SIM C">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengalaman Organisasi & Rencana Masa Depan -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Pengalaman Organisasi & Rencana Masa Depan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="rencana_target_masa_depan" class="form-label">Apa rencana/target Anda untuk masa depan (Jangka panjang 5 s/d 10 Tahun kedepan)?</label>
                                <textarea class="form-control" id="rencana_target_masa_depan" name="rencana_target_masa_depan" rows="4">{{ old('rencana_target_masa_depan') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="suka_berorganisasi" name="suka_berorganisasi" value="1" {{ old('suka_berorganisasi') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="suka_berorganisasi">Apakah Anda suka berorganisasi?</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="organisasi_diikuti" class="form-label">Organisasi apa yang pernah Anda ikuti</label>
                                <textarea class="form-control" id="organisasi_diikuti" name="organisasi_diikuti" rows="3">{{ old('organisasi_diikuti') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Pengalaman Kerja -->
                    <div class="card" id="pengalamanKerjaCard">
                        <div class="card-header">
                            <h5>Pengalaman Kerja</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Apakah Anda memiliki pengalaman kerja?</label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="punya_pengalaman_kerja" id="punya_pengalaman_kerja_ya" value="yes" {{ old('punya_pengalaman_kerja') == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="punya_pengalaman_kerja_ya">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="punya_pengalaman_kerja" id="punya_pengalaman_kerja_tidak" value="no" {{ old('punya_pengalaman_kerja') == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="punya_pengalaman_kerja_tidak">Tidak</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Pengalaman Kerja I</h6>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja1_perusahaan" class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control" id="pengalaman_kerja1_perusahaan" name="pengalaman_kerja1_perusahaan" value="{{ old('pengalaman_kerja1_perusahaan') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja1_alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="pengalaman_kerja1_alamat" name="pengalaman_kerja1_alamat" rows="3">{{ old('pengalaman_kerja1_alamat') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja1_masa_kerja" class="form-label">Masa Kerja</label>
                                        <input type="text" class="form-control" id="pengalaman_kerja1_masa_kerja" name="pengalaman_kerja1_masa_kerja" value="{{ old('pengalaman_kerja1_masa_kerja') }}" placeholder="Contoh: 2 tahun 3 bulan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja1_jabatan" class="form-label">Jabatan/Keahlian yang digunakan</label>
                                        <input type="text" class="form-control" id="pengalaman_kerja1_jabatan" name="pengalaman_kerja1_jabatan" value="{{ old('pengalaman_kerja1_jabatan') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja1_gaji_awal" class="form-label">Gaji Awal (Rp)</label>
                                        <input type="number" class="form-control" id="pengalaman_kerja1_gaji_awal" name="pengalaman_kerja1_gaji_awal" value="{{ old('pengalaman_kerja1_gaji_awal') }}" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja1_gaji_akhir" class="form-label">Gaji Akhir (Rp)</label>
                                        <input type="number" class="form-control" id="pengalaman_kerja1_gaji_akhir" name="pengalaman_kerja1_gaji_akhir" value="{{ old('pengalaman_kerja1_gaji_akhir') }}" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja1_alasan_berhenti" class="form-label">Alasan Berhenti</label>
                                        <textarea class="form-control" id="pengalaman_kerja1_alasan_berhenti" name="pengalaman_kerja1_alasan_berhenti" rows="3">{{ old('pengalaman_kerja1_alasan_berhenti') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Pengalaman Kerja II</h6>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja2_perusahaan" class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control" id="pengalaman_kerja2_perusahaan" name="pengalaman_kerja2_perusahaan" value="{{ old('pengalaman_kerja2_perusahaan') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja2_alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="pengalaman_kerja2_alamat" name="pengalaman_kerja2_alamat" rows="3">{{ old('pengalaman_kerja2_alamat') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja2_masa_kerja" class="form-label">Masa Kerja</label>
                                        <input type="text" class="form-control" id="pengalaman_kerja2_masa_kerja" name="pengalaman_kerja2_masa_kerja" value="{{ old('pengalaman_kerja2_masa_kerja') }}" placeholder="Contoh: 1 tahun 6 bulan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja2_jabatan" class="form-label">Jabatan/Keahlian yang digunakan</label>
                                        <input type="text" class="form-control" id="pengalaman_kerja2_jabatan" name="pengalaman_kerja2_jabatan" value="{{ old('pengalaman_kerja2_jabatan') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja2_gaji_awal" class="form-label">Gaji Awal (Rp)</label>
                                        <input type="number" class="form-control" id="pengalaman_kerja2_gaji_awal" name="pengalaman_kerja2_gaji_awal" value="{{ old('pengalaman_kerja2_gaji_awal') }}" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja2_gaji_akhir" class="form-label">Gaji Akhir (Rp)</label>
                                        <input type="number" class="form-control" id="pengalaman_kerja2_gaji_akhir" name="pengalaman_kerja2_gaji_akhir" value="{{ old('pengalaman_kerja2_gaji_akhir') }}" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengalaman_kerja2_alasan_berhenti" class="form-label">Alasan Berhenti</label>
                                        <textarea class="form-control" id="pengalaman_kerja2_alasan_berhenti" name="pengalaman_kerja2_alasan_berhenti" rows="3">{{ old('pengalaman_kerja2_alasan_berhenti') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Ekonomi & Kesediaan -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Informasi Ekonomi & Kesediaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggungan_ekonomi" class="form-label">Tanggungan Ekonomi</label>
                                        <input type="text" class="form-control" id="tanggungan_ekonomi" name="tanggungan_ekonomi" value="{{ old('tanggungan_ekonomi') }}" placeholder="Contoh: Orang tua, istri, anak">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nilai_tanggungan_perbulan" class="form-label">Nilai Tanggungan Per Bulan (Rp)</label>
                                        <input type="number" class="form-control" id="nilai_tanggungan_perbulan" name="nilai_tanggungan_perbulan" value="{{ old('nilai_tanggungan_perbulan') }}" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_lembur" name="bersedia_lembur" value="1" {{ old('bersedia_lembur') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_lembur">Bersedia Lembur?</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alasan_lembur" class="form-label">Alasan Lembur</label>
                                        <textarea class="form-control" id="alasan_lembur" name="alasan_lembur" rows="3">{{ old('alasan_lembur') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_dipindahkan_bagian_lain" name="bersedia_dipindahkan_bagian_lain" value="1" {{ old('bersedia_dipindahkan_bagian_lain') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_dipindahkan_bagian_lain">Bersedia Dipindahkan ke Bagian Lain?</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alasan_dipindahkan_bagian_lain" class="form-label">Alasan Dipindahkan Bagian Lain</label>
                                        <textarea class="form-control" id="alasan_dipindahkan_bagian_lain" name="alasan_dipindahkan_bagian_lain" rows="3">{{ old('alasan_dipindahkan_bagian_lain') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_ikut_pembinaan_pelatihan" name="bersedia_ikut_pembinaan_pelatihan" value="1" {{ old('bersedia_ikut_pembinaan_pelatihan') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_ikut_pembinaan_pelatihan">Bersedia Ikut Pembinaan/Pelatihan?</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_penuhi_peraturan_pengamanan" name="bersedia_penuhi_peraturan_pengamanan" value="1" {{ old('bersedia_penuhi_peraturan_pengamanan') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_penuhi_peraturan_pengamanan">Bersedia Memenuhi Peraturan Pengamanan?</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_dipindahkan_luar_daerah" name="bersedia_dipindahkan_luar_daerah" value="1" {{ old('bersedia_dipindahkan_luar_daerah') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_dipindahkan_luar_daerah">Bersedia Dipindahkan ke Luar Daerah?</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gaji_diharapkan" class="form-label">Gaji yang Diharapkan (Rp)</label>
                                        <input type="number" class="form-control" id="gaji_diharapkan" name="gaji_diharapkan" value="{{ old('gaji_diharapkan') }}" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label for="batas_gaji_minimum" class="form-label">Batas Gaji Minimum (Rp)</label>
                                        <input type="number" class="form-control" id="batas_gaji_minimum" name="batas_gaji_minimum" value="{{ old('batas_gaji_minimum') }}" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label for="fasilitas_diharapkan" class="form-label">Fasilitas yang Diharapkan</label>
                                        <textarea class="form-control" id="fasilitas_diharapkan" name="fasilitas_diharapkan" rows="3">{{ old('fasilitas_diharapkan') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Informasi Tambahan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kapan_bisa_mulai_bekerja" class="form-label">Kapan Bisa Mulai Bekerja?</label>
                                        <input type="text" class="form-control" id="kapan_bisa_mulai_bekerja" name="kapan_bisa_mulai_bekerja" value="{{ old('kapan_bisa_mulai_bekerja') }}" placeholder="Contoh: Segera, 2 minggu lagi, dll">
                                    </div>
                                    <div class="mb-3">
                                        <label for="motivasi_utama_bekerja" class="form-label">Motivasi Utama Bekerja</label>
                                        <textarea class="form-control" id="motivasi_utama_bekerja" name="motivasi_utama_bekerja" rows="3">{{ old('motivasi_utama_bekerja') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alasan_diterima_perusahaan" class="form-label">Alasan Mengapa Anda Harus Diterima di Perusahaan Ini</label>
                                        <textarea class="form-control" id="alasan_diterima_perusahaan" name="alasan_diterima_perusahaan" rows="3">{{ old('alasan_diterima_perusahaan') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hal_lain_disampaikan" class="form-label">Hal Lain yang Ingin Disampaikan</label>
                                        <textarea class="form-control" id="hal_lain_disampaikan" name="hal_lain_disampaikan" rows="3">{{ old('hal_lain_disampaikan') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="pernah_ikut_beladiri" name="pernah_ikut_beladiri" value="1" {{ old('pernah_ikut_beladiri') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pernah_ikut_beladiri">Pernah Ikut Beladiri?</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sertifikat_beladiri" class="form-label">Sertifikat Beladiri</label>
                                        <input type="file" class="form-control" id="sertifikat_beladiri" name="sertifikat_beladiri" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_full_body" class="form-label">Foto Full Body</label>
                                        <input type="file" class="form-control" id="foto_full_body" name="foto_full_body" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pernyataan -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Pernyataan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pernyataan_kebenaran_dokumen" name="pernyataan_kebenaran_dokumen" value="1" {{ old('pernyataan_kebenaran_dokumen') ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="pernyataan_kebenaran_dokumen">
                                        <strong>Saya menyatakan bahwa semua dokumen dan informasi yang saya berikan adalah benar dan dapat dipertanggungjawabkan.</strong> <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pernyataan_lamaran_kerja" name="pernyataan_lamaran_kerja" value="1" {{ old('pernyataan_lamaran_kerja') ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="pernyataan_lamaran_kerja">
                                        <strong>Saya bersedia mengikuti semua proses seleksi dan mematuhi peraturan perusahaan.</strong> <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="card">
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="ti ti-send me-2"></i>Kirim Lamaran
                            </button>
                            <p class="text-muted mt-2 mb-0">
                                <small>Pastikan semua data yang diisi sudah benar sebelum mengirim lamaran.</small>
                            </p>
                        </div>
                    </div>

                    
                </form>
            @else
                <div class="card">
                    <div class="card-body text-center">
                        <div class="alert alert-warning">
                            <h4>Formulir Pendaftaran Sedang Ditutup</h4>
                            <p>Maaf, saat ini formulir pendaftaran pelamar sedang tidak tersedia. Silakan coba lagi nanti.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

@section('scripts')
<script>
    // JavaScript untuk mengatur tampilan form berdasarkan status pernikahan
    document.getElementById('status_pernikahan').addEventListener('change', function() {
        const dataKeluargaCard = document.getElementById('dataKeluargaCard');
        const dataAnakCard = document.getElementById('dataAnakCard');
        
        if (this.value === 'Menikah') {
            dataKeluargaCard.style.display = 'block';
            dataAnakCard.style.display = 'block';
        } else {
            dataKeluargaCard.style.display = 'none';
            dataAnakCard.style.display = 'none';
        }
    });

    // Trigger pada load halaman
    document.addEventListener('DOMContentLoaded', function() {
        const statusPernikahan = document.getElementById('status_pernikahan').value;
        const dataKeluargaCard = document.getElementById('dataKeluargaCard');
        const dataAnakCard = document.getElementById('dataAnakCard');
        
        if (statusPernikahan !== 'Menikah') {
            dataKeluargaCard.style.display = 'none';
            dataAnakCard.style.display = 'none';
        }
    });

    // Validasi file upload
    function validateFileSize(input, maxSize = 2) {
        if (input.files && input.files[0]) {
            const fileSize = input.files[0].size / 1024 / 1024; // in MB
            if (fileSize > maxSize) {
                alert(`Ukuran file terlalu besar. Maksimal ${maxSize}MB`);
                input.value = '';
                return false;
            }
        }
        return true;
    }

    // Tambahkan event listener untuk semua input file
    document.querySelectorAll('input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            validateFileSize(this);
        });
    });

    // Format angka untuk input gaji
    document.querySelectorAll('input[type="number"]').forEach(function(input) {
        if (input.name.includes('gaji') || input.name.includes('tanggungan')) {
            input.addEventListener('input', function() {
                // Format number with thousand separators
                let value = this.value.replace(/\D/g, '');
                this.value = value;
            });
        }
    });

    // JavaScript untuk mengatur tampilan form referensi
    document.addEventListener('DOMContentLoaded', function() {
        const referenceSwitch = document.getElementById('referenceSwitch');
        const referenceInputContainer = document.getElementById('referenceInputContainer');
        const referenceNameInput = document.getElementById('referenceNameInput');
        const referenceStatusIcon = document.getElementById('referenceStatusIcon');

        function updateReferenceStatus() {
            if (referenceSwitch.checked) {
                referenceInputContainer.style.display = 'block';
                if (referenceNameInput.value.trim() !== '') {
                    referenceStatusIcon.innerHTML = '<i class="ti ti-check-circle text-success"></i>';
                } else {
                    referenceStatusIcon.innerHTML = '';
                }
            } else {
                referenceInputContainer.style.display = 'none';
                referenceNameInput.value = ''; // Clear input when switch is off
                referenceStatusIcon.innerHTML = '';
            }
        }

        referenceSwitch.addEventListener('change', updateReferenceStatus);
        referenceNameInput.addEventListener('input', updateReferenceStatus);

        // Initial state on page load
        updateReferenceStatus();
    });
</script>
@endsection