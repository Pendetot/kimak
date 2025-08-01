@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form BPJS (Badan Penyelenggara Jaminan Sosial)</h4>
                    <p class="mb-0">Pelamar: <strong>{{ $pelamar->nama_lengkap }}</strong> - {{ $pelamar->jenis_jabatan_pekerjaan }}</p>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
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

                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-bpjs-data', $pelamar) }}" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mb-3 text-primary">Informasi BPJS</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="bpjs_kesehatan_number" class="form-label">Nomor BPJS Kesehatan</label>
                                    <input type="text" class="form-control @error('bpjs_kesehatan_number') is-invalid @enderror" 
                                           id="bpjs_kesehatan_number" name="bpjs_kesehatan_number" 
                                           placeholder="Kosongkan jika belum memiliki"
                                           value="{{ old('bpjs_kesehatan_number', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->bpjs_kesehatan_number ?? '' : '') }}">
                                    @error('bpjs_kesehatan_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="bpjs_ketenagakerjaan_number" class="form-label">Nomor BPJS Ketenagakerjaan</label>
                                    <input type="text" class="form-control @error('bpjs_ketenagakerjaan_number') is-invalid @enderror" 
                                           id="bpjs_ketenagakerjaan_number" name="bpjs_ketenagakerjaan_number" 
                                           placeholder="Kosongkan jika belum memiliki"
                                           value="{{ old('bpjs_ketenagakerjaan_number', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->bpjs_ketenagakerjaan_number ?? '' : '') }}">
                                    @error('bpjs_ketenagakerjaan_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h5 class="mb-3 text-primary">Data Pribadi</h5>

                        <div class="form-group mb-3">
                            <label for="nama_ibu_kandung" class="form-label">Nama Ibu Kandung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_ibu_kandung') is-invalid @enderror" 
                                   id="nama_ibu_kandung" name="nama_ibu_kandung" 
                                   value="{{ old('nama_ibu_kandung', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_ibu_kandung ?? '' : '') }}" required>
                            @error('nama_ibu_kandung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status_perkawinan" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status_perkawinan') is-invalid @enderror" 
                                            id="status_perkawinan" name="status_perkawinan" required>
                                        <option value="">Pilih Status Perkawinan</option>
                                        <option value="belum_kawin" {{ old('status_perkawinan', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->status_perkawinan ?? '' : '') == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="kawin" {{ old('status_perkawinan', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->status_perkawinan ?? '' : '') == 'kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="cerai_hidup" {{ old('status_perkawinan', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->status_perkawinan ?? '' : '') == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="cerai_mati" {{ old('status_perkawinan', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->status_perkawinan ?? '' : '') == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                    @error('status_perkawinan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="jumlah_tanggungan" class="form-label">Jumlah Tanggungan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('jumlah_tanggungan') is-invalid @enderror" 
                                           id="jumlah_tanggungan" name="jumlah_tanggungan" min="0"
                                           value="{{ old('jumlah_tanggungan', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->jumlah_tanggungan ?? '0' : '0') }}" required>
                                    @error('jumlah_tanggungan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat_domisili" class="form-label">Alamat Domisili <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat_domisili') is-invalid @enderror" 
                                      id="alamat_domisili" name="alamat_domisili" rows="3" required>{{ old('alamat_domisili', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->alamat_domisili ?? '' : '') }}</textarea>
                            @error('alamat_domisili')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mb-3 text-primary">Informasi Rekening</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="no_rekening" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('no_rekening') is-invalid @enderror" 
                                           id="no_rekening" name="no_rekening" 
                                           value="{{ old('no_rekening', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->no_rekening ?? '' : '') }}" required>
                                    @error('no_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama_bank" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                                    <select class="form-control @error('nama_bank') is-invalid @enderror" 
                                            id="nama_bank" name="nama_bank" required>
                                        <option value="">Pilih Bank</option>
                                        <option value="BRI" {{ old('nama_bank', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_bank ?? '' : '') == 'BRI' ? 'selected' : '' }}>BRI</option>
                                        <option value="BCA" {{ old('nama_bank', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_bank ?? '' : '') == 'BCA' ? 'selected' : '' }}>BCA</option>
                                        <option value="BNI" {{ old('nama_bank', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_bank ?? '' : '') == 'BNI' ? 'selected' : '' }}>BNI</option>
                                        <option value="Mandiri" {{ old('nama_bank', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_bank ?? '' : '') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                        <option value="BTN" {{ old('nama_bank', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_bank ?? '' : '') == 'BTN' ? 'selected' : '' }}>BTN</option>
                                        <option value="CIMB Niaga" {{ old('nama_bank', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_bank ?? '' : '') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                        <option value="Danamon" {{ old('nama_bank', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_bank ?? '' : '') == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                                        <option value="Lainnya" {{ old('nama_bank', $pelamar->bpjs_data ? json_decode($pelamar->bpjs_data)->nama_bank ?? '' : '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('nama_bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="bpjs_form_file" class="form-label">Upload Form BPJS (PDF/JPG/PNG)</label>
                            <input type="file" class="form-control @error('bpjs_form_file') is-invalid @enderror" 
                                   id="bpjs_form_file" name="bpjs_form_file" accept=".pdf,.jpg,.jpeg,.png">
                            @error('bpjs_form_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pelamar->bpjs_data && isset(json_decode($pelamar->bpjs_data)->bpjs_form_file_path))
                                <small class="form-text text-muted">
                                    File saat ini: <a href="{{ Storage::url(json_decode($pelamar->bpjs_data)->bpjs_form_file_path) }}" target="_blank">Lihat File</a>
                                </small>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Data BPJS
                            </button>
                        </div>
                    </form>

                    @if($pelamar->bpjs_status === 'completed')
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i> Data BPJS telah lengkap dan tersimpan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format rekening number input
    const rekeningInput = document.getElementById('no_rekening');
    rekeningInput.addEventListener('input', function() {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // BPJS number formatting
    const bpjsKesehatanInput = document.getElementById('bpjs_kesehatan_number');
    const bpjsKetenagakerjaanInput = document.getElementById('bpjs_ketenagakerjaan_number');
    
    [bpjsKesehatanInput, bpjsKetenagakerjaanInput].forEach(input => {
        input.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
});
</script>
@endpush