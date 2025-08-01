@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Surat Pernyataan</h4>
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

                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-statement-data', $pelamar) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="statement_type" class="form-label">Jenis Surat Pernyataan <span class="text-danger">*</span></label>
                            <select class="form-control @error('statement_type') is-invalid @enderror" 
                                    id="statement_type" name="statement_type" required>
                                <option value="">Pilih Jenis Surat Pernyataan</option>
                                <option value="peraturan" {{ old('statement_type', $pelamar->statement_data ? json_decode($pelamar->statement_data)->statement_type ?? '' : '') == 'peraturan' ? 'selected' : '' }}>Surat Pernyataan Mentaati Peraturan</option>
                                <option value="pembayaran" {{ old('statement_type', $pelamar->statement_data ? json_decode($pelamar->statement_data)->statement_type ?? '' : '') == 'pembayaran' ? 'selected' : '' }}>Surat Pernyataan Pembayaran</option>
                                <option value="ijin" {{ old('statement_type', $pelamar->statement_data ? json_decode($pelamar->statement_data)->statement_type ?? '' : '') == 'ijin' ? 'selected' : '' }}>Surat Pernyataan Ijin</option>
                            </select>
                            @error('statement_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="statement_templates">
                            <!-- Template for Peraturan -->
                            <div id="template_peraturan" class="statement-template" style="display: none;">
                                <div class="alert alert-info">
                                    <h6><strong>Surat Pernyataan Mentaati Peraturan Perusahaan</strong></h6>
                                    <p>Yang bertanda tangan di bawah ini:</p>
                                    <ul>
                                        <li>Nama: {{ $pelamar->nama_lengkap }}</li>
                                        <li>Tempat/Tanggal Lahir: {{ $pelamar->tempat_lahir ?? '-' }}, {{ $pelamar->tanggal_lahir ? $pelamar->tanggal_lahir->format('d F Y') : '-' }}</li>
                                        <li>Alamat: {{ $pelamar->alamat ?? '-' }}</li>
                                        <li>Jabatan: {{ $pelamar->jenis_jabatan_pekerjaan }}</li>
                                    </ul>
                                    <p>Dengan ini menyatakan bahwa saya bersedia dan sanggup untuk:</p>
                                    <ol>
                                        <li>Mentaati semua peraturan dan tata tertib perusahaan yang berlaku</li>
                                        <li>Melaksanakan tugas dan tanggung jawab sesuai dengan jabatan yang diberikan</li>
                                        <li>Menjaga kerahasiaan perusahaan dan tidak membocorkan informasi internal</li>
                                        <li>Bekerja dengan profesional dan menjunjung tinggi etika kerja</li>
                                        <li>Bersedia menerima sanksi sesuai peraturan perusahaan jika melanggar ketentuan</li>
                                    </ol>
                                </div>
                            </div>

                            <!-- Template for Pembayaran -->
                            <div id="template_pembayaran" class="statement-template" style="display: none;">
                                <div class="alert alert-warning">
                                    <h6><strong>Surat Pernyataan Pembayaran</strong></h6>
                                    <p>Yang bertanda tangan di bawah ini:</p>
                                    <ul>
                                        <li>Nama: {{ $pelamar->nama_lengkap }}</li>
                                        <li>Tempat/Tanggal Lahir: {{ $pelamar->tempat_lahir ?? '-' }}, {{ $pelamar->tanggal_lahir ? $pelamar->tanggal_lahir->format('d F Y') : '-' }}</li>
                                        <li>Alamat: {{ $pelamar->alamat ?? '-' }}</li>
                                        <li>Jabatan: {{ $pelamar->jenis_jabatan_pekerjaan }}</li>
                                    </ul>
                                    <p>Dengan ini menyatakan bahwa:</p>
                                    <ol>
                                        <li>Saya bersedia membayar biaya administrasi dan pelatihan sesuai ketentuan perusahaan</li>
                                        <li>Pembayaran akan dilakukan sesuai dengan jadwal yang telah ditentukan</li>
                                        <li>Jika terjadi pengunduran diri sebelum masa kerja minimum, saya bersedia mengganti biaya pelatihan</li>
                                        <li>Semua pembayaran akan dilakukan melalui rekening resmi perusahaan</li>
                                    </ol>
                                </div>
                            </div>

                            <!-- Template for Ijin -->
                            <div id="template_ijin" class="statement-template" style="display: none;">
                                <div class="alert alert-secondary">
                                    <h6><strong>Surat Pernyataan Ijin</strong></h6>
                                    <p>Yang bertanda tangan di bawah ini:</p>
                                    <ul>
                                        <li>Nama: {{ $pelamar->nama_lengkap }}</li>
                                        <li>Tempat/Tanggal Lahir: {{ $pelamar->tempat_lahir ?? '-' }}, {{ $pelamar->tanggal_lahir ? $pelamar->tanggal_lahir->format('d F Y') : '-' }}</li>
                                        <li>Alamat: {{ $pelamar->alamat ?? '-' }}</li>
                                        <li>Jabatan: {{ $pelamar->jenis_jabatan_pekerjaan }}</li>
                                    </ul>
                                    <p>Dengan ini menyatakan bahwa:</p>
                                    <ol>
                                        <li>Saya memberikan ijin kepada perusahaan untuk melakukan verifikasi data pribadi</li>
                                        <li>Saya memberikan ijin untuk penggunaan foto dan data untuk keperluan internal perusahaan</li>
                                        <li>Saya bersedia mengikuti tes kesehatan dan psikologi yang diperlukan</li>
                                        <li>Saya memberikan ijin untuk pemeriksaan latar belakang (background check)</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="statement_content" class="form-label">Isi Surat Pernyataan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('statement_content') is-invalid @enderror" 
                                      id="statement_content" name="statement_content" rows="8" required>{{ old('statement_content', $pelamar->statement_data ? json_decode($pelamar->statement_data)->statement_content ?? '' : '') }}</textarea>
                            <small class="form-text text-muted">Anda dapat memodifikasi template di atas sesuai kebutuhan</small>
                            @error('statement_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="signature_date" class="form-label">Tanggal Tanda Tangan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('signature_date') is-invalid @enderror" 
                                           id="signature_date" name="signature_date" 
                                           value="{{ old('signature_date', $pelamar->statement_data ? json_decode($pelamar->statement_data)->signature_date ?? date('Y-m-d') : date('Y-m-d')) }}" required>
                                    @error('signature_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="witness_name" class="form-label">Nama Saksi</label>
                                    <input type="text" class="form-control @error('witness_name') is-invalid @enderror" 
                                           id="witness_name" name="witness_name" 
                                           placeholder="Nama saksi (jika diperlukan)"
                                           value="{{ old('witness_name', $pelamar->statement_data ? json_decode($pelamar->statement_data)->witness_name ?? '' : '') }}">
                                    @error('witness_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('agreed') is-invalid @enderror" 
                                       type="checkbox" id="agreed" name="agreed" value="1" 
                                       {{ old('agreed', $pelamar->statement_data ? json_decode($pelamar->statement_data)->agreed ?? false : false) ? 'checked' : '' }} required>
                                <label class="form-check-label" for="agreed">
                                    <strong>Saya menyetujui dan menandatangani surat pernyataan ini dengan penuh kesadaran dan tanpa paksaan</strong>
                                </label>
                                @error('agreed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="statement_file" class="form-label">Upload Surat Pernyataan yang Sudah Ditandatangani</label>
                            <input type="file" class="form-control @error('statement_file') is-invalid @enderror" 
                                   id="statement_file" name="statement_file" accept=".pdf,.doc,.docx">
                            <small class="form-text text-muted">Upload scan surat pernyataan yang sudah ditandatangani (PDF/DOC/DOCX)</small>
                            @error('statement_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pelamar->statement_data && isset(json_decode($pelamar->statement_data)->statement_file_path))
                                <small class="form-text text-muted">
                                    File saat ini: <a href="{{ Storage::url(json_decode($pelamar->statement_data)->statement_file_path) }}" target="_blank">Lihat File</a>
                                </small>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Surat Pernyataan
                            </button>
                        </div>
                    </form>

                    @if($pelamar->statement_status === 'completed')
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i> Surat pernyataan telah lengkap dan tersimpan.
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
    const statementType = document.getElementById('statement_type');
    const statementContent = document.getElementById('statement_content');
    const templates = document.querySelectorAll('.statement-template');

    function showTemplate() {
        // Hide all templates
        templates.forEach(template => template.style.display = 'none');
        
        if (statementType.value) {
            const selectedTemplate = document.getElementById('template_' + statementType.value);
            if (selectedTemplate) {
                selectedTemplate.style.display = 'block';
                
                // Auto-fill content if textarea is empty
                if (!statementContent.value.trim()) {
                    const templateText = selectedTemplate.querySelector('.alert').innerText;
                    statementContent.value = templateText;
                }
            }
        }
    }

    statementType.addEventListener('change', showTemplate);
    
    // Initialize on page load
    showTemplate();

    // Copy template to textarea
    templates.forEach(template => {
        const copyBtn = document.createElement('button');
        copyBtn.type = 'button';
        copyBtn.className = 'btn btn-sm btn-outline-primary mt-2';
        copyBtn.innerHTML = '<i class="fas fa-copy"></i> Gunakan Template Ini';
        copyBtn.addEventListener('click', function() {
            const templateText = template.querySelector('.alert').innerText;
            statementContent.value = templateText;
            statementContent.focus();
        });
        template.appendChild(copyBtn);
    });
});
</script>
@endpush