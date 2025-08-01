@extends('layouts.app')

@section('title', 'Edit Pelamar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Pelamar: {{ $pelamar->nama_lengkap }}</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pelamar.update', $pelamar->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pribadi-tab" data-bs-toggle="tab" data-bs-target="#pribadi" type="button" role="tab" aria-controls="pribadi" aria-selected="true">Data Pribadi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="kesehatan-tab" data-bs-toggle="tab" data-bs-target="#kesehatan" type="button" role="tab" aria-controls="kesehatan" aria-selected="false">Fisik & Kesehatan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pendidikan-tab" data-bs-toggle="tab" data-bs-target="#pendidikan" type="button" role="tab" aria-controls="pendidikan" aria-selected="false">Pendidikan & Keahlian</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pengalaman-tab" data-bs-toggle="tab" data-bs-target="#pengalaman" type="button" role="tab" aria-controls="pengalaman" aria-selected="false">Pengalaman & Rencana</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="lain-lain-tab" data-bs-toggle="tab" data-bs-target="#lain-lain" type="button" role="tab" aria-controls="lain-lain" aria-selected="false">Lain-lain</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="pribadi" role="tabpanel" aria-labelledby="pribadi-tab">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jenis_jabatan_pekerjaan" class="form-label">Jenis/Jabatan Pekerjaan yang Diajukan</label>
                                            <input type="text" class="form-control" id="jenis_jabatan_pekerjaan" name="jenis_jabatan_pekerjaan" value="{{ old('jenis_jabatan_pekerjaan', $pelamar->jenis_jabatan_pekerjaan) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="lokasi_penempatan_diinginkan" class="form-label">Satuan/Lokasi Penempatan yang Diinginkan</label>
                                            <input type="text" class="form-control" id="lokasi_penempatan_diinginkan" name="lokasi_penempatan_diinginkan" value="{{ old('lokasi_penempatan_diinginkan', $pelamar->lokasi_penempatan_diinginkan) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $pelamar->nama_lengkap) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $pelamar->email) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_whatsapp" class="form-label">No. Whatsapp</label>
                                            <input type="text" class="form-control" id="no_whatsapp" name="no_whatsapp" value="{{ old('no_whatsapp', $pelamar->no_whatsapp) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_lain_dihubungi" class="form-label">No. Lain yang Bisa Dihubungi</label>
                                            <input type="text" class="form-control" id="no_lain_dihubungi" name="no_lain_dihubungi" value="{{ old('no_lain_dihubungi', $pelamar->no_lain_dihubungi) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="alamat_ktp" class="form-label">Alamat Sesuai KTP</label>
                                            <textarea class="form-control" id="alamat_ktp" name="alamat_ktp" rows="3" required>{{ old('alamat_ktp', $pelamar->alamat_ktp) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                                            <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" rows="3">{{ old('alamat_domisili', $pelamar->alamat_domisili) }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="kelurahan" class="form-label">Kelurahan</label>
                                                <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $pelamar->kelurahan) }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $pelamar->kecamatan) }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                                                <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota', $pelamar->kabupaten_kota) }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $pelamar->tempat_lahir) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pelamar->tanggal_lahir) }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="">Pilih</option>
                                                <option value="Laki-laki" {{ old('jenis_kelamin', $pelamar->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin', $pelamar->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_ktp" class="form-label">No. KTP</label>
                                            <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $pelamar->no_ktp) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto_ktp" class="form-label">Foto KTP</label>
                                            <input type="file" class="form-control" id="foto_ktp" name="foto_ktp">
                                            @if($pelamar->foto_ktp) <img src="{{ asset('storage/' . $pelamar->foto_ktp) }}" width="100"> @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto_kartu_keluarga" class="form-label">Foto Kartu Keluarga</label>
                                            <input type="file" class="form-control" id="foto_kartu_keluarga" name="foto_kartu_keluarga">
                                            @if($pelamar->foto_kartu_keluarga) <img src="{{ asset('storage/' . $pelamar->foto_kartu_keluarga) }}" width="100"> @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="warga_negara" class="form-label">Warga Negara</label>
                                            <input type="text" class="form-control" id="warga_negara" name="warga_negara" value="{{ old('warga_negara', $pelamar->warga_negara) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="agama" class="form-label">Agama</label>
                                            <input type="text" class="form-control" id="agama" name="agama" value="{{ old('agama', $pelamar->agama) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                                            <select class="form-select" id="status_pernikahan" name="status_pernikahan" required>
                                                <option value="">Pilih</option>
                                                <option value="Lajang" {{ old('status_pernikahan', $pelamar->status_pernikahan) == 'Lajang' ? 'selected' : '' }}>Lajang</option>
                                                <option value="Menikah" {{ old('status_pernikahan', $pelamar->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                                <option value="Cerai Hidup" {{ old('status_pernikahan', $pelamar->status_pernikahan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                                <option value="Cerai Mati" {{ old('status_pernikahan', $pelamar->status_pernikahan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="dataKeluargaCard">
                                    <div class="card-header">
                                        <h5>Data Keluarga (Suami/Istri)</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nama_suami_istri" class="form-label">Nama Suami/Istri Anda</label>
                                                    <input type="text" class="form-control" id="nama_suami_istri" name="nama_suami_istri" value="{{ old('nama_suami_istri', $pelamar->nama_suami_istri) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="usia_suami_istri" class="form-label">Usia (angka)</label>
                                                    <input type="number" class="form-control" id="usia_suami_istri" name="usia_suami_istri" value="{{ old('usia_suami_istri', $pelamar->usia_suami_istri) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="pekerjaan_suami_istri" class="form-label">Pekerjaan</label>
                                                    <input type="text" class="form-control" id="pekerjaan_suami_istri" name="pekerjaan_suami_istri" value="{{ old('pekerjaan_suami_istri', $pelamar->pekerjaan_suami_istri) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat_suami_istri" class="form-label">Alamat</label>
                                                    <textarea class="form-control" id="alamat_suami_istri" name="alamat_suami_istri" rows="3">{{ old('alamat_suami_istri', $pelamar->alamat_suami_istri) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card" id="dataAnakCard">
                                    <div class="card-header">
                                        <h5>Data Anak</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="text-muted">Anak 1</p>
                                                <div class="mb-3">
                                                    <label for="nama_anak1" class="form-label">Nama Anak 1</label>
                                                    <input type="text" class="form-control" id="nama_anak1" name="nama_anak1" value="{{ old('nama_anak1', $pelamar->nama_anak1) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jk_anak1" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-select" id="jk_anak1" name="jk_anak1">
                                                        <option value="">Pilih</option>
                                                        <option value="Laki-laki" {{ old('jk_anak1', $pelamar->jk_anak1) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="Perempuan" {{ old('jk_anak1', $pelamar->jk_anak1) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ttl_anak1" class="form-label">Tempat dan Tanggal Lahir</label>
                                                    <input type="text" class="form-control" id="ttl_anak1" name="ttl_anak1" value="{{ old('ttl_anak1', $pelamar->ttl_anak1) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-muted">Anak 2</p>
                                                <div class="mb-3">
                                                    <label for="nama_anak2" class="form-label">Nama Anak 2</label>
                                                    <input type="text" class="form-control" id="nama_anak2" name="nama_anak2" value="{{ old('nama_anak2', $pelamar->nama_anak2) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jk_anak2" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-select" id="jk_anak2" name="jk_anak2">
                                                        <option value="">Pilih</option>
                                                        <option value="Laki-laki" {{ old('jk_anak2', $pelamar->jk_anak2) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="Perempuan" {{ old('jk_anak2', $pelamar->jk_anak2) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ttl_anak2" class="form-label">Tempat dan Tanggal Lahir</label>
                                                    <input type="text" class="form-control" id="ttl_anak2" name="ttl_anak2" value="{{ old('ttl_anak2', $pelamar->ttl_anak2) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-muted">Anak 3</p>
                                                <div class="mb-3">
                                                    <label for="nama_anak3" class="form-label">Nama Anak 3</label>
                                                    <input type="text" class="form-control" id="nama_anak3" name="nama_anak3" value="{{ old('nama_anak3', $pelamar->nama_anak3) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jk_anak3" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-select" id="jk_anak3" name="jk_anak3">
                                                        <option value="">Pilih</option>
                                                        <option value="Laki-laki" {{ old('jk_anak3', $pelamar->jk_anak3) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="Perempuan" {{ old('jk_anak3', $pelamar->jk_anak3) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ttl_anak3" class="form-label">Tempat dan Tanggal Lahir</label>
                                                    <input type="text" class="form-control" id="ttl_anak3" name="ttl_anak3" value="{{ old('ttl_anak3', $pelamar->ttl_anak3) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Data Orang Tua</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-muted">Ayah</p>
                                                <div class="mb-3">
                                                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $pelamar->nama_ayah) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="usia_ayah" class="form-label">Usia (angka)</label>
                                                    <input type="number" class="form-control" id="usia_ayah" name="usia_ayah" value="{{ old('usia_ayah', $pelamar->usia_ayah) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan</label>
                                                    <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $pelamar->pekerjaan_ayah) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat_ayah" class="form-label">Alamat</label>
                                                    <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" rows="3">{{ old('alamat_ayah', $pelamar->alamat_ayah) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted">Ibu</p>
                                                <div class="mb-3">
                                                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $pelamar->nama_ibu) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="usia_ibu" class="form-label">Usia (angka)</label>
                                                    <input type="number" class="form-control" id="usia_ibu" name="usia_ibu" value="{{ old('usia_ibu', $pelamar->usia_ibu) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan</label>
                                                    <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $pelamar->pekerjaan_ibu) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat_ibu" class="form-label">Alamat</label>
                                                    <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" rows="3">{{ old('alamat_ibu', $pelamar->alamat_ibu) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="kesehatan" role="tabpanel" aria-labelledby="kesehatan-tab">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                            <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan', $pelamar->tinggi_badan) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                            <input type="number" class="form-control" id="berat_badan" name="berat_badan" value="{{ old('berat_badan', $pelamar->berat_badan) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="surat_keterangan_sehat" class="form-label">SURAT KETERANGAN SEHAT</label>
                                            <input type="text" class="form-control" id="surat_keterangan_sehat" name="surat_keterangan_sehat" value="{{ old('surat_keterangan_sehat', $pelamar->surat_keterangan_sehat) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                            <input type="text" class="form-control" id="golongan_darah" name="golongan_darah" value="{{ old('golongan_darah', $pelamar->golongan_darah) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ukuran_seragam" class="form-label">Ukuran Seragam</label>
                                            <input type="text" class="form-control" id="ukuran_seragam" name="ukuran_seragam" value="{{ old('ukuran_seragam', $pelamar->ukuran_seragam) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ukuran_sepatu" class="form-label">Ukuran Sepatu</label>
                                            <input type="text" class="form-control" id="ukuran_sepatu" name="ukuran_sepatu" value="{{ old('ukuran_sepatu', $pelamar->ukuran_sepatu) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="punya_tato" name="punya_tato" value="1" {{ old('punya_tato', $pelamar->punya_tato) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="punya_tato">Apakah Anda mempunyai Tato?</label>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="perokok" name="perokok" value="1" {{ old('perokok', $pelamar->perokok) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perokok">Anda seorang perokok?</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kesehatan_umum" class="form-label">Keadaan Kesehatan Umum</label>
                                            <textarea class="form-control" id="kesehatan_umum" name="kesehatan_umum" rows="3">{{ old('kesehatan_umum', $pelamar->kesehatan_umum) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="olahraga_dilakukan" class="form-label">Olahraga yang Dilakukan</label>
                                            <textarea class="form-control" id="olahraga_dilakukan" name="olahraga_dilakukan" rows="3">{{ old('olahraga_dilakukan', $pelamar->olahraga_dilakukan) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kesehatan_mata" class="form-label">Kesehatan Mata</label>
                                            <textarea class="form-control" id="kesehatan_mata" name="kesehatan_mata" rows="3">{{ old('kesehatan_mata', $pelamar->kesehatan_mata) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="cacat_penyakit_serius" class="form-label">Cacat badan, penyakit serius dan masalah kesehatan yang sedang/pernah anda alami (termasuk alergi berat)?</label>
                                            <textarea class="form-control" id="cacat_penyakit_serius" name="cacat_penyakit_serius" rows="3">{{ old('cacat_penyakit_serius', $pelamar->cacat_penyakit_serius) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pendidikan" role="tabpanel" aria-labelledby="pendidikan-tab">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                            <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $pelamar->pendidikan_terakhir) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sertifikasi_pelamar" class="form-label">Sertifikasi Pelamar</label>
                                            <input type="text" class="form-control" id="sertifikasi_pelamar" name="sertifikasi_pelamar" value="{{ old('sertifikasi_pelamar', $pelamar->sertifikasi_pelamar) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto_ijazah_terakhir" class="form-label">Foto Ijazah Terakhir</label>
                                            <input type="file" class="form-control" id="foto_ijazah_terakhir" name="foto_ijazah_terakhir">
                                            @if($pelamar->foto_ijazah_terakhir) <img src="{{ asset('storage/' . $pelamar->foto_ijazah_terakhir) }}" width="100"> @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto_sertifikat_keahlian1" class="form-label">Foto Sertifikat Keahlian I</label>
                                            <input type="file" class="form-control" id="foto_sertifikat_keahlian1" name="foto_sertifikat_keahlian1">
                                            @if($pelamar->foto_sertifikat_keahlian1) <img src="{{ asset('storage/' . $pelamar->foto_sertifikat_keahlian1) }}" width="100"> @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto_sertifikat_keahlian2" class="form-label">Foto Sertifikat Keahlian II</label>
                                            <input type="file" class="form-control" id="foto_sertifikat_keahlian2" name="foto_sertifikat_keahlian2">
                                            @if($pelamar->foto_sertifikat_keahlian2) <img src="{{ asset('storage/' . $pelamar->foto_sertifikat_keahlian2) }}" width="100"> @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="keahlian_dimiliki" class="form-label">Keahlian apa yang Anda miliki?</label>
                                            <textarea class="form-control" id="keahlian_dimiliki" name="keahlian_dimiliki" rows="3">{{ old('keahlian_dimiliki', $pelamar->keahlian_dimiliki) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="hobby_keahlian_disukai" class="form-label">Hobby dan keahlian apa yang Anda sukai?</label>
                                            <textarea class="form-control" id="hobby_keahlian_disukai" name="hobby_keahlian_disukai" rows="3">{{ old('hobby_keahlian_disukai', $pelamar->hobby_keahlian_disukai) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="keterampilan_kerja_disukai" class="form-label">Ketrampilan kerja apa yang Anda sukai?</label>
                                            <textarea class="form-control" id="keterampilan_kerja_disukai" name="keterampilan_kerja_disukai" rows="3">{{ old('keterampilan_kerja_disukai', $pelamar->keterampilan_kerja_disukai) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="peralatan_kerja_dikuasai" class="form-label">Peralatan kerja apa yang dikuasai?</label>
                                            <textarea class="form-control" id="peralatan_kerja_dikuasai" name="peralatan_kerja_dikuasai" rows="3">{{ old('peralatan_kerja_dikuasai', $pelamar->peralatan_kerja_dikuasai) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="program_komputer_dikuasai" class="form-label">Program komputer apa yang dikuasai?</label>
                                            <textarea class="form-control" id="program_komputer_dikuasai" name="program_komputer_dikuasai" rows="3">{{ old('program_komputer_dikuasai', $pelamar->program_komputer_dikuasai) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="keahlian_ingin_dicapai" class="form-label">Keahlian yang ingin dicapai/diperbaiki/dikembangkan?</label>
                                            <textarea class="form-control" id="keahlian_ingin_dicapai" name="keahlian_ingin_dicapai" rows="3">{{ old('keahlian_ingin_dicapai', $pelamar->keahlian_ingin_dicapai) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenis_bahasa_dikuasai" class="form-label">Jenis bahasa yang dikuasai?</label>
                                            <textarea class="form-control" id="jenis_bahasa_dikuasai" name="jenis_bahasa_dikuasai" rows="3">{{ old('jenis_bahasa_dikuasai', $pelamar->jenis_bahasa_dikuasai) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kendaraan_dikuasai" class="form-label">Kendaraan yang dikuasai?</label>
                                            <textarea class="form-control" id="kendaraan_dikuasai" name="kendaraan_dikuasai" rows="3">{{ old('kendaraan_dikuasai', $pelamar->kendaraan_dikuasai) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sim_dimiliki" class="form-label">SIM yang dimiliki</label>
                                            <input type="text" class="form-control" id="sim_dimiliki" name="sim_dimiliki" value="{{ old('sim_dimiliki', $pelamar->sim_dimiliki) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pengalaman" role="tabpanel" aria-labelledby="pengalaman-tab">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5>Pengalaman Organisasi & Rencana Masa Depan</h5>
                                        <div class="mb-3">
                                            <label for="rencana_target_masa_depan" class="form-label">Apa rencana/target Anda untuk masa depan (Jangka panjang 5 s/d 10 Tahun kedepan)?</label>
                                            <textarea class="form-control" id="rencana_target_masa_depan" name="rencana_target_masa_depan" rows="3">{{ old('rencana_target_masa_depan', $pelamar->rencana_target_masa_depan) }}</textarea>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="suka_berorganisasi" name="suka_berorganisasi" value="1" {{ old('suka_berorganisasi', $pelamar->suka_berorganisasi) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="suka_berorganisasi">Apakah Anda suka berorganisasi?</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="organisasi_diikuti" class="form-label">Organisasi apa yang pernah Anda ikuti</label>
                                            <textarea class="form-control" id="organisasi_diikuti" name="organisasi_diikuti" rows="3">{{ old('organisasi_diikuti', $pelamar->organisasi_diikuti) }}</textarea>
                                        </div>
                                        <hr>
                                        <h5>Pengalaman Kerja</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah Anda memiliki pengalaman kerja?</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="punya_pengalaman_kerja" id="pengalaman_kerja_ya" value="yes" {{ old('punya_pengalaman_kerja', $pelamar->pengalaman_kerja1_perusahaan ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pengalaman_kerja_ya">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="punya_pengalaman_kerja" id="pengalaman_kerja_tidak" value="no" {{ old('punya_pengalaman_kerja', $pelamar->pengalaman_kerja1_perusahaan ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pengalaman_kerja_tidak">Tidak</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-muted">Pengalaman Kerja I</p>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja1_perusahaan" class="form-label">Nama Perusahaan</label>
                                                    <input type="text" class="form-control" id="pengalaman_kerja1_perusahaan" name="pengalaman_kerja1_perusahaan" value="{{ old('pengalaman_kerja1_perusahaan', $pelamar->pengalaman_kerja1_perusahaan) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja1_alamat" class="form-label">Alamat</label>
                                                    <textarea class="form-control" id="pengalaman_kerja1_alamat" name="pengalaman_kerja1_alamat" rows="3">{{ old('pengalaman_kerja1_alamat', $pelamar->pengalaman_kerja1_alamat) }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja1_masa_kerja" class="form-label">Masa Kerja</label>
                                                    <input type="text" class="form-control" id="pengalaman_kerja1_masa_kerja" name="pengalaman_kerja1_masa_kerja" value="{{ old('pengalaman_kerja1_masa_kerja', $pelamar->pengalaman_kerja1_masa_kerja) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja1_jabatan" class="form-label">Jabatan/Keahlian yang digunakan</label>
                                                    <input type="text" class="form-control" id="pengalaman_kerja1_jabatan" name="pengalaman_kerja1_jabatan" value="{{ old('pengalaman_kerja1_jabatan', $pelamar->pengalaman_kerja1_jabatan) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja1_gaji_awal" class="form-label">Gaji Awal (Angka)</label>
                                                    <input type="number" class="form-control" id="pengalaman_kerja1_gaji_awal" name="pengalaman_kerja1_gaji_awal" value="{{ old('pengalaman_kerja1_gaji_awal', $pelamar->pengalaman_kerja1_gaji_awal) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja1_gaji_akhir" class="form-label">Gaji Akhir (Angka)</label>
                                                    <input type="number" class="form-control" id="pengalaman_kerja1_gaji_akhir" name="pengalaman_kerja1_gaji_akhir" value="{{ old('pengalaman_kerja1_gaji_akhir', $pelamar->pengalaman_kerja1_gaji_akhir) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja1_alasan_berhenti" class="form-label">Alasan Berhenti</label>
                                                    <textarea class="form-control" id="pengalaman_kerja1_alasan_berhenti" name="pengalaman_kerja1_alasan_berhenti" rows="3">{{ old('pengalaman_kerja1_alasan_berhenti', $pelamar->pengalaman_kerja1_alasan_berhenti) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted">Pengalaman Kerja II</p>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja2_perusahaan" class="form-label">Nama Perusahaan</label>
                                                    <input type="text" class="form-control" id="pengalaman_kerja2_perusahaan" name="pengalaman_kerja2_perusahaan" value="{{ old('pengalaman_kerja2_perusahaan', $pelamar->pengalaman_kerja2_perusahaan) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja2_alamat" class="form-label">Alamat</label>
                                                    <textarea class="form-control" id="pengalaman_kerja2_alamat" name="pengalaman_kerja2_alamat" rows="3">{{ old('pengalaman_kerja2_alamat', $pelamar->pengalaman_kerja2_alamat) }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja2_masa_kerja" class="form-label">Masa Kerja</label>
                                                    <input type="text" class="form-control" id="pengalaman_kerja2_masa_kerja" name="pengalaman_kerja2_masa_kerja" value="{{ old('pengalaman_kerja2_masa_kerja', $pelamar->pengalaman_kerja2_masa_kerja) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja2_jabatan" class="form-label">Jabatan/Keahlian yang digunakan</label>
                                                    <input type="text" class="form-control" id="pengalaman_kerja2_jabatan" name="pengalaman_kerja2_jabatan" value="{{ old('pengalaman_kerja2_jabatan', $pelamar->pengalaman_kerja2_jabatan) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja2_gaji_awal" class="form-label">Gaji Awal (Angka)</label>
                                                    <input type="number" class="form-control" id="pengalaman_kerja2_gaji_awal" name="pengalaman_kerja2_gaji_awal" value="{{ old('pengalaman_kerja2_gaji_awal', $pelamar->pengalaman_kerja2_gaji_awal) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja2_gaji_akhir" class="form-label">Gaji Akhir (Angka)</label>
                                                    <input type="number" class="form-control" id="pengalaman_kerja2_gaji_akhir" name="pengalaman_kerja2_gaji_akhir" value="{{ old('pengalaman_kerja2_gaji_akhir', $pelamar->pengalaman_kerja2_gaji_akhir) }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengalaman_kerja2_alasan_berhenti" class="form-label">Alasan Berhenti</label>
                                                    <textarea class="form-control" id="pengalaman_kerja2_alasan_berhenti" name="pengalaman_kerja2_alasan_berhenti" rows="3">{{ old('pengalaman_kerja2_alasan_berhenti', $pelamar->pengalaman_kerja2_alasan_berhenti) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="lain-lain" role="tabpanel" aria-labelledby="lain-lain-tab">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggungan_ekonomi" class="form-label">Siapa saja anggota keluarga yang secara ekonomis menjadi tanggungan Anda?</label>
                                            <textarea class="form-control" id="tanggungan_ekonomi" name="tanggungan_ekonomi" rows="3">{{ old('tanggungan_ekonomi', $pelamar->tanggungan_ekonomi) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nilai_tanggungan_perbulan" class="form-label">Berapa besar nilai tanggungan ekonomi perbulannya</label>
                                            <input type="number" class="form-control" id="nilai_tanggungan_perbulan" name="nilai_tanggungan_perbulan" value="{{ old('nilai_tanggungan_perbulan', $pelamar->nilai_tanggungan_perbulan) }}">
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_lembur" name="bersedia_lembur" value="1" {{ old('bersedia_lembur', $pelamar->bersedia_lembur) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_lembur">Bersediakah Anda bekerja lembur bilamana diperlukan?</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alasan_lembur" class="form-label">Berikan alasan (lembur)</label>
                                            <textarea class="form-control" id="alasan_lembur" name="alasan_lembur" rows="3">{{ old('alasan_lembur', $pelamar->alasan_lembur) }}</textarea>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_dipindahkan_bagian_lain" name="bersedia_dipindahkan_bagian_lain" value="1" {{ old('bersedia_dipindahkan_bagian_lain', $pelamar->bersedia_dipindahkan_bagian_lain) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_dipindahkan_bagian_lain">Bersediakah Anda diperbantukan/dipindahkan ke bagian lain bilamana diperlukan?</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alasan_dipindahkan_bagian_lain" class="form-label">Berikan alasan (dipindahkan bagian lain)</label>
                                            <textarea class="form-control" id="alasan_dipindahkan_bagian_lain" name="alasan_dipindahkan_bagian_lain" rows="3">{{ old('alasan_dipindahkan_bagian_lain', $pelamar->alasan_dipindahkan_bagian_lain) }}</textarea>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_ikut_pembinaan_pelatihan" name="bersedia_ikut_pembinaan_pelatihan" value="1" {{ old('bersedia_ikut_pembinaan_pelatihan', $pelamar->bersedia_ikut_pembinaan_pelatihan) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_ikut_pembinaan_pelatihan">Bersediakah Anda mengikuti semua program pembinaan dan pelatihan yang dibuat oleh Perusahaan?</label>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_penuhi_peraturan_pengamanan" name="bersedia_penuhi_peraturan_pengamanan" value="1" {{ old('bersedia_penuhi_peraturan_pengamanan', $pelamar->bersedia_penuhi_peraturan_pengamanan) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_penuhi_peraturan_pengamanan">Bersediakah Anda memenuhi semua yang dipersyaratkan oleh peraturan perundangan yang berkaitan dengan jasa pengamanan?</label>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="bersedia_dipindahkan_luar_daerah" name="bersedia_dipindahkan_luar_daerah" value="1" {{ old('bersedia_dipindahkan_luar_daerah', $pelamar->bersedia_dipindahkan_luar_daerah) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bersedia_dipindahkan_luar_daerah">Bersediakah Anda diperbantukan/dipindahkan keluar daerah/keluar kota bilamana diperlukan?</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="gaji_diharapkan" class="form-label">Gaji yang diharapkan</label>
                                            <input type="number" class="form-control" id="gaji_diharapkan" name="gaji_diharapkan" value="{{ old('gaji_diharapkan', $pelamar->gaji_diharapkan) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="batas_gaji_minimum" class="form-label">Batas gaji minimum</label>
                                            <input type="number" class="form-control" id="batas_gaji_minimum" name="batas_gaji_minimum" value="{{ old('batas_gaji_minimum', $pelamar->batas_gaji_minimum) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="fasilitas_diharapkan" class="form-label">Fasilitas yang diharapkan</label>
                                            <textarea class="form-control" id="fasilitas_diharapkan" name="fasilitas_diharapkan" rows="3">{{ old('fasilitas_diharapkan', $pelamar->fasilitas_diharapkan) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kapan_bisa_mulai_bekerja" class="form-label">Bilamana Anda Diterima, kapan Anda bisa mulai bekerja?</label>
                                            <input type="date" class="form-control" id="kapan_bisa_mulai_bekerja" name="kapan_bisa_mulai_bekerja" value="{{ old('kapan_bisa_mulai_bekerja', $pelamar->kapan_bisa_mulai_bekerja) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="motivasi_utama_bekerja" class="form-label">Motivasi utama Anda dalam bekerja</label>
                                            <textarea class="form-control" id="motivasi_utama_bekerja" name="motivasi_utama_bekerja" rows="3">{{ old('motivasi_utama_bekerja', $pelamar->motivasi_utama_bekerja) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alasan_diterima_perusahaan" class="form-label">Menurut Anda, mengapa sebaiknya Anda kami terima bekerja di perusahaan kami?</label>
                                            <textarea class="form-control" id="alasan_diterima_perusahaan" name="alasan_diterima_perusahaan" rows="3">{{ old('alasan_diterima_perusahaan', $pelamar->alasan_diterima_perusahaan) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="hal_lain_disampaikan" class="form-label">Ada hal lain yang ingin Anda sampaikan?</label>
                                            <textarea class="form-control" id="hal_lain_disampaikan" name="hal_lain_disampaikan" rows="3">{{ old('hal_lain_disampaikan', $pelamar->hal_lain_disampaikan) }}</textarea>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="pernah_ikut_beladiri" name="pernah_ikut_beladiri" value="1" {{ old('pernah_ikut_beladiri', $pelamar->pernah_ikut_beladiri) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pernah_ikut_beladiri">Apakah Anda pernah mengikuti beladiri?</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sertifikat_beladiri" class="form-label">Sertifikat Beladiri</label>
                                            <input type="file" class="form-control" id="sertifikat_beladiri" name="sertifikat_beladiri">
                                            @if($pelamar->sertifikat_beladiri) <img src="{{ asset('storage/' . $pelamar->sertifikat_beladiri) }}" width="100"> @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto_full_body" class="form-label">Melampirkan foto full body dengan pakaian bebas rapi</label>
                                            <input type="file" class="form-control" id="foto_full_body" name="foto_full_body">
                                            @if($pelamar->foto_full_body) <img src="{{ asset('storage/' . $pelamar->foto_full_body) }}" width="100"> @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Pernyataan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="pernyataan_kebenaran_dokumen" name="pernyataan_kebenaran_dokumen" value="1" {{ old('pernyataan_kebenaran_dokumen', $pelamar->pernyataan_kebenaran_dokumen) ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="pernyataan_kebenaran_dokumen">Dengan ini saya menyatakan bahwa isi dokumen ini benar adanya dan dapat dipertanggung jawabkan, apabila ada ketidak sesuaian pada isi dokumen maka segala konsekuensi yang ada akibat kesalahan tersebut menjadi tanggungjawab saya</label>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="pernyataan_lamaran_kerja" name="pernyataan_lamaran_kerja" value="1" {{ old('pernyataan_lamaran_kerja', $pelamar->pernyataan_lamaran_kerja) ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="pernyataan_lamaran_kerja">Dengan ini saya menyatakan bahwa dengan mengisi link ini, saya telah mengajukan lamaran kerja saya.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Update Lamaran</button>
                        <a href="{{ route('hrd.administrasi-pelamar.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusPernikahanSelect = document.getElementById('status_pernikahan');
            const dataKeluargaCard = document.getElementById('dataKeluargaCard');
            const dataKeluargaInputs = dataKeluargaCard.querySelectorAll('input, textarea, select');
            const dataAnakCard = document.getElementById('dataAnakCard');
            const dataAnakInputs = dataAnakCard.querySelectorAll('input, textarea, select');

            const punyaPengalamanKerjaRadios = document.querySelectorAll('input[name="punya_pengalaman_kerja"]');
            const pengalamanKerjaCard = document.getElementById('pengalamanKerjaCard');
            const pengalamanKerjaInputs = pengalamanKerjaCard.querySelectorAll('input, textarea, select');

            function toggleDataKeluargaAndAnak() {
                if (statusPernikahanSelect.value === 'Menikah') {
                    dataKeluargaCard.style.display = 'block';
                    dataKeluargaInputs.forEach(input => {
                        input.removeAttribute('disabled');
                    });
                    dataAnakCard.style.display = 'block';
                    dataAnakInputs.forEach(input => {
                        input.removeAttribute('disabled');
                    });
                } else {
                    dataKeluargaCard.style.display = 'none';
                    dataKeluargaInputs.forEach(input => {
                        input.setAttribute('disabled', 'disabled');
                        input.value = '';
                    });
                    dataAnakCard.style.display = 'none';
                    dataAnakInputs.forEach(input => {
                        input.setAttribute('disabled', 'disabled');
                        input.value = '';
                    });
                }
            }

            function togglePengalamanKerja() {
                let hasExperience = false;
                punyaPengalamanKerjaRadios.forEach(radio => {
                    if (radio.value === 'yes' && radio.checked) {
                        hasExperience = true;
                    }
                });

                if (hasExperience) {
                    pengalamanKerjaCard.style.display = 'block';
                    pengalamanKerjaInputs.forEach(input => {
                        input.removeAttribute('disabled');
                    });
                } else {
                    pengalamanKerjaCard.style.display = 'none';
                    pengalamanKerjaInputs.forEach(input => {
                        input.setAttribute('disabled', 'disabled');
                        input.value = '';
                    });
                }
            }

            // Initial calls on page load
            toggleDataKeluargaAndAnak();
            togglePengalamanKerja();

            // Listen for changes
            statusPernikahanSelect.addEventListener('change', toggleDataKeluargaAndAnak);
            punyaPengalamanKerjaRadios.forEach(radio => {
                radio.addEventListener('change', togglePengalamanKerja);
            });
        });
    </script>
@endsection