@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form SPT (Surat Pemberitahuan Tahunan)</h4>
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

                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-spt-data', $pelamar) }}" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mb-3 text-primary">Status Pajak</h5>
                        
                        <div class="form-group mb-3">
                            <label for="status_pajak" class="form-label">Status NPWP <span class="text-danger">*</span></label>
                            <select class="form-control @error('status_pajak') is-invalid @enderror" 
                                    id="status_pajak" name="status_pajak" required>
                                <option value="">Pilih Status NPWP</option>
                                <option value="sudah_punya_npwp" {{ old('status_pajak', $pelamar->spt_data ? json_decode($pelamar->spt_data)->status_pajak ?? '' : '') == 'sudah_punya_npwp' ? 'selected' : '' }}>Sudah Memiliki NPWP</option>
                                <option value="belum_punya_npwp" {{ old('status_pajak', $pelamar->spt_data ? json_decode($pelamar->spt_data)->status_pajak ?? '' : '') == 'belum_punya_npwp' ? 'selected' : '' }}>Belum Memiliki NPWP</option>
                                <option value="proses_pembuatan" {{ old('status_pajak', $pelamar->spt_data ? json_decode($pelamar->spt_data)->status_pajak ?? '' : '') == 'proses_pembuatan' ? 'selected' : '' }}>Sedang Proses Pembuatan</option>
                            </select>
                            @error('status_pajak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="npwp_section" style="display: none;">
                            <h5 class="mb-3 text-primary">Informasi NPWP</h5>
                            
                            <div class="form-group mb-3">
                                <label for="npwp" class="form-label">Nomor NPWP</label>
                                <input type="text" class="form-control @error('npwp') is-invalid @enderror" 
                                       id="npwp" name="npwp" 
                                       placeholder="XX.XXX.XXX.X-XXX.XXX"
                                       value="{{ old('npwp', $pelamar->spt_data ? json_decode($pelamar->spt_data)->npwp ?? '' : '') }}">
                                @error('npwp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="alamat_npwp" class="form-label">Alamat sesuai NPWP</label>
                                <textarea class="form-control @error('alamat_npwp') is-invalid @enderror" 
                                          id="alamat_npwp" name="alamat_npwp" rows="3">{{ old('alamat_npwp', $pelamar->spt_data ? json_decode($pelamar->spt_data)->alamat_npwp ?? '' : '') }}</textarea>
                                @error('alamat_npwp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mb-3 text-primary">Data Pajak Tahun Sebelumnya</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="penghasilan_tahun_sebelumnya" class="form-label">Penghasilan Tahun Sebelumnya (Rp)</label>
                                    <input type="number" class="form-control @error('penghasilan_tahun_sebelumnya') is-invalid @enderror" 
                                           id="penghasilan_tahun_sebelumnya" name="penghasilan_tahun_sebelumnya" 
                                           step="0.01" min="0"
                                           placeholder="Kosongkan jika tidak ada penghasilan"
                                           value="{{ old('penghasilan_tahun_sebelumnya', $pelamar->spt_data ? json_decode($pelamar->spt_data)->penghasilan_tahun_sebelumnya ?? '' : '') }}">
                                    @error('penghasilan_tahun_sebelumnya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="pph_terutang" class="form-label">PPh Terutang (Rp)</label>
                                    <input type="number" class="form-control @error('pph_terutang') is-invalid @enderror" 
                                           id="pph_terutang" name="pph_terutang" 
                                           step="0.01" min="0"
                                           placeholder="Kosongkan jika tidak ada"
                                           value="{{ old('pph_terutang', $pelamar->spt_data ? json_decode($pelamar->spt_data)->pph_terutang ?? '' : '') }}">
                                    @error('pph_terutang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tanggungan_pajak" class="form-label">Jumlah Tanggungan untuk Pajak <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tanggungan_pajak') is-invalid @enderror" 
                                   id="tanggungan_pajak" name="tanggungan_pajak" min="0"
                                   value="{{ old('tanggungan_pajak', $pelamar->spt_data ? json_decode($pelamar->spt_data)->tanggungan_pajak ?? '0' : '0') }}" required>
                            <small class="form-text text-muted">Termasuk diri sendiri (minimal 1)</small>
                            @error('tanggungan_pajak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="spt_file" class="form-label">Upload File SPT/Dokumen Pendukung</label>
                            <input type="file" class="form-control @error('spt_file') is-invalid @enderror" 
                                   id="spt_file" name="spt_file" 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <small class="form-text text-muted">Format yang diizinkan: PDF, DOC, DOCX, XLS, XLSX (Max: 2MB)</small>
                            @error('spt_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pelamar->spt_data && isset(json_decode($pelamar->spt_data)->spt_file_path))
                                <small class="form-text text-muted">
                                    File saat ini: <a href="{{ Storage::url(json_decode($pelamar->spt_data)->spt_file_path) }}" target="_blank">Lihat File</a>
                                </small>
                            @endif
                        </div>

                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Penting:</h6>
                            <ul class="mb-0">
                                <li>Jika belum memiliki NPWP, akan dibantu proses pembuatannya</li>
                                <li>Data ini akan digunakan untuk perhitungan PPh 21</li>
                                <li>Pastikan data yang diisi sesuai dengan dokumen resmi</li>
                                <li>Tanggungan pajak mempengaruhi besaran PTKP (Penghasilan Tidak Kena Pajak)</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Data SPT
                            </button>
                        </div>
                    </form>

                    @if($pelamar->spt_status === 'completed')
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i> Data SPT telah lengkap dan tersimpan.
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
    const statusPajak = document.getElementById('status_pajak');
    const npwpSection = document.getElementById('npwp_section');
    const npwpInput = document.getElementById('npwp');
    const alamatNpwpInput = document.getElementById('alamat_npwp');

    // Show/hide NPWP section based on status
    function toggleNpwpSection() {
        if (statusPajak.value === 'sudah_punya_npwp' || statusPajak.value === 'proses_pembuatan') {
            npwpSection.style.display = 'block';
            if (statusPajak.value === 'sudah_punya_npwp') {
                npwpInput.required = true;
                alamatNpwpInput.required = true;
            } else {
                npwpInput.required = false;
                alamatNpwpInput.required = false;
            }
        } else {
            npwpSection.style.display = 'none';
            npwpInput.required = false;
            alamatNpwpInput.required = false;
        }
    }

    statusPajak.addEventListener('change', toggleNpwpSection);
    
    // Initialize on page load
    toggleNpwpSection();

    // Format NPWP input
    npwpInput.addEventListener('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');
        
        // Format: XX.XXX.XXX.X-XXX.XXX
        if (value.length > 0) {
            let formatted = '';
            if (value.length >= 2) formatted += value.substr(0, 2) + '.';
            else formatted += value;
            
            if (value.length >= 5) formatted += value.substr(2, 3) + '.';
            else if (value.length > 2) formatted += value.substr(2);
            
            if (value.length >= 8) formatted += value.substr(5, 3) + '.';
            else if (value.length > 5) formatted += value.substr(5);
            
            if (value.length >= 9) formatted += value.substr(8, 1) + '-';
            else if (value.length > 8) formatted += value.substr(8);
            
            if (value.length >= 12) formatted += value.substr(9, 3) + '.';
            else if (value.length > 9) formatted += value.substr(9);
            
            if (value.length > 12) formatted += value.substr(12, 3);
            
            this.value = formatted;
        }
    });

    // Format currency inputs
    const currencyInputs = ['penghasilan_tahun_sebelumnya', 'pph_terutang'];
    currencyInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        input.addEventListener('input', function() {
            // Remove non-numeric characters except decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
    });

    // Set minimum tanggungan to 1
    const tanggunganInput = document.getElementById('tanggungan_pajak');
    tanggunganInput.addEventListener('change', function() {
        if (this.value < 1) {
            this.value = 1;
        }
    });
});
</script>
@endpush