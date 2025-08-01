@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form PKWT (Perjanjian Kerja Waktu Tertentu)</h4>
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

                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-pkwt-data', $pelamar) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kontrak_mulai" class="form-label">Tanggal Mulai Kontrak <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('kontrak_mulai') is-invalid @enderror" 
                                           id="kontrak_mulai" name="kontrak_mulai" 
                                           value="{{ old('kontrak_mulai', $pelamar->pkwt_data ? json_decode($pelamar->pkwt_data)->kontrak_mulai ?? '' : '') }}" required>
                                    @error('kontrak_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kontrak_selesai" class="form-label">Tanggal Selesai Kontrak <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('kontrak_selesai') is-invalid @enderror" 
                                           id="kontrak_selesai" name="kontrak_selesai" 
                                           value="{{ old('kontrak_selesai', $pelamar->pkwt_data ? json_decode($pelamar->pkwt_data)->kontrak_selesai ?? '' : '') }}" required>
                                    @error('kontrak_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jabatan_kontrak" class="form-label">Jabatan dalam Kontrak <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jabatan_kontrak') is-invalid @enderror" 
                                   id="jabatan_kontrak" name="jabatan_kontrak" 
                                   value="{{ old('jabatan_kontrak', $pelamar->pkwt_data ? json_decode($pelamar->pkwt_data)->jabatan_kontrak ?? $pelamar->jenis_jabatan_pekerjaan : $pelamar->jenis_jabatan_pekerjaan) }}" required>
                            @error('jabatan_kontrak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="gaji_pokok" class="form-label">Gaji Pokok (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror" 
                                           id="gaji_pokok" name="gaji_pokok" step="0.01" min="0"
                                           value="{{ old('gaji_pokok', $pelamar->pkwt_data ? json_decode($pelamar->pkwt_data)->gaji_pokok ?? '' : '') }}" required>
                                    @error('gaji_pokok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tunjangan" class="form-label">Tunjangan (Rp)</label>
                                    <input type="number" class="form-control @error('tunjangan') is-invalid @enderror" 
                                           id="tunjangan" name="tunjangan" step="0.01" min="0"
                                           value="{{ old('tunjangan', $pelamar->pkwt_data ? json_decode($pelamar->pkwt_data)->tunjangan ?? '' : '') }}">
                                    @error('tunjangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="lokasi_kerja" class="form-label">Lokasi Kerja <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi_kerja') is-invalid @enderror" 
                                   id="lokasi_kerja" name="lokasi_kerja" 
                                   value="{{ old('lokasi_kerja', $pelamar->pkwt_data ? json_decode($pelamar->pkwt_data)->lokasi_kerja ?? '' : '') }}" required>
                            @error('lokasi_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="jam_kerja" class="form-label">Jam Kerja <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jam_kerja') is-invalid @enderror" 
                                   id="jam_kerja" name="jam_kerja" 
                                   placeholder="Contoh: 08:00 - 17:00 WIB"
                                   value="{{ old('jam_kerja', $pelamar->pkwt_data ? json_decode($pelamar->pkwt_data)->jam_kerja ?? '' : '') }}" required>
                            @error('jam_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="pkwt_file" class="form-label">Upload File PKWT (PDF/DOC/DOCX)</label>
                            <input type="file" class="form-control @error('pkwt_file') is-invalid @enderror" 
                                   id="pkwt_file" name="pkwt_file" accept=".pdf,.doc,.docx">
                            @error('pkwt_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pelamar->pkwt_data && isset(json_decode($pelamar->pkwt_data)->pkwt_file_path))
                                <small class="form-text text-muted">
                                    File saat ini: <a href="{{ Storage::url(json_decode($pelamar->pkwt_data)->pkwt_file_path) }}" target="_blank">Lihat File</a>
                                </small>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Data PKWT
                            </button>
                        </div>
                    </form>

                    @if($pelamar->pkwt_status === 'completed')
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i> Data PKWT telah lengkap dan tersimpan.
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
    // Auto-calculate contract end date (1 year from start date)
    const startDate = document.getElementById('kontrak_mulai');
    const endDate = document.getElementById('kontrak_selesai');
    
    startDate.addEventListener('change', function() {
        if (this.value && !endDate.value) {
            const start = new Date(this.value);
            const end = new Date(start.getFullYear() + 1, start.getMonth(), start.getDate());
            endDate.value = end.toISOString().split('T')[0];
        }
    });

    // Format currency input
    const gajiInput = document.getElementById('gaji_pokok');
    const tunjanganInput = document.getElementById('tunjangan');
    
    [gajiInput, tunjanganInput].forEach(input => {
        input.addEventListener('input', function() {
            // Remove non-numeric characters except decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
    });
});
</script>
@endpush