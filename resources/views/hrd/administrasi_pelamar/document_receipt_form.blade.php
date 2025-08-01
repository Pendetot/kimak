@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tanda Terima Dokumen</h4>
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

                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-document-receipt', $pelamar) }}" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mb-3 text-primary">Dokumen yang Diterima</h5>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Pilih Dokumen yang Telah Diterima <span class="text-danger">*</span></label>
                            @php
                                $existingDocuments = [];
                                if ($pelamar->document_receipt_data) {
                                    $receiptData = json_decode($pelamar->document_receipt_data);
                                    $existingDocuments = $receiptData->documents_received ?? [];
                                }
                                $oldDocuments = old('documents_received', $existingDocuments);
                            @endphp
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="CV" id="doc_cv"
                                               {{ in_array('CV', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_cv">CV (Curriculum Vitae)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="KTP" id="doc_ktp"
                                               {{ in_array('KTP', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_ktp">Fotocopy KTP</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="Kartu Keluarga" id="doc_kk"
                                               {{ in_array('Kartu Keluarga', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_kk">Fotocopy Kartu Keluarga</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="Ijazah" id="doc_ijazah"
                                               {{ in_array('Ijazah', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_ijazah">Fotocopy Ijazah Terakhir</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="Transkrip Nilai" id="doc_transkrip"
                                               {{ in_array('Transkrip Nilai', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_transkrip">Fotocopy Transkrip Nilai</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="Paklaring" id="doc_paklaring"
                                               {{ in_array('Paklaring', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_paklaring">Surat Paklaring/Pengalaman Kerja</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="SKCK" id="doc_skck"
                                               {{ in_array('SKCK', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_skck">SKCK (Surat Keterangan Catatan Kepolisian)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="SIM" id="doc_sim"
                                               {{ in_array('SIM', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_sim">Fotocopy SIM (jika diperlukan)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="Surat Sehat" id="doc_sehat"
                                               {{ in_array('Surat Sehat', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_sehat">Surat Keterangan Sehat</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="Sertifikat Beladiri" id="doc_beladiri"
                                               {{ in_array('Sertifikat Beladiri', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_beladiri">Sertifikat Beladiri</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="Sertifikat Keahlian" id="doc_keahlian"
                                               {{ in_array('Sertifikat Keahlian', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_keahlian">Sertifikat Keahlian/Pelatihan</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="documents_received[]" value="Foto" id="doc_foto"
                                               {{ in_array('Foto', $oldDocuments) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="doc_foto">Pas Foto Terbaru</label>
                                    </div>
                                </div>
                            </div>
                            @error('documents_received')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mb-3 text-primary">Informasi Penerimaan</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="receipt_date" class="form-label">Tanggal Penerimaan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('receipt_date') is-invalid @enderror" 
                                           id="receipt_date" name="receipt_date" 
                                           value="{{ old('receipt_date', $pelamar->document_receipt_data ? json_decode($pelamar->document_receipt_data)->receipt_date ?? date('Y-m-d') : date('Y-m-d')) }}" required>
                                    @error('receipt_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="received_by" class="form-label">Diterima Oleh <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('received_by') is-invalid @enderror" 
                                           id="received_by" name="received_by" 
                                           value="{{ old('received_by', $pelamar->document_receipt_data ? json_decode($pelamar->document_receipt_data)->received_by ?? auth()->user()->name : auth()->user()->name) }}" required>
                                    @error('received_by')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Catatan kondisi dokumen, kelengkapan, atau hal lain yang perlu dicatat">{{ old('notes', $pelamar->document_receipt_data ? json_decode($pelamar->document_receipt_data)->notes ?? '' : '') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="receipt_file" class="form-label">Upload Tanda Terima (PDF/DOC/DOCX)</label>
                            <input type="file" class="form-control @error('receipt_file') is-invalid @enderror" 
                                   id="receipt_file" name="receipt_file" accept=".pdf,.doc,.docx">
                            <small class="form-text text-muted">Upload scan tanda terima yang sudah ditandatangani (opsional)</small>
                            @error('receipt_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pelamar->document_receipt_data && isset(json_decode($pelamar->document_receipt_data)->receipt_file_path))
                                <small class="form-text text-muted">
                                    File saat ini: <a href="{{ Storage::url(json_decode($pelamar->document_receipt_data)->receipt_file_path) }}" target="_blank">Lihat File</a>
                                </small>
                            @endif
                        </div>

                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi:</h6>
                            <ul class="mb-0">
                                <li>Pastikan semua dokumen yang diterima dalam kondisi baik dan lengkap</li>
                                <li>Tanda terima ini akan menjadi bukti penerimaan dokumen oleh perusahaan</li>
                                <li>Dokumen asli akan dikembalikan setelah proses verifikasi selesai</li>
                                <li>Jika ada dokumen yang kurang, catat di bagian catatan tambahan</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Tanda Terima
                            </button>
                        </div>
                    </form>

                    @if($pelamar->document_receipt_status === 'completed')
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i> Tanda terima dokumen telah lengkap dan tersimpan.
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
    // Select all / deselect all functionality
    const selectAllBtn = document.createElement('button');
    selectAllBtn.type = 'button';
    selectAllBtn.className = 'btn btn-sm btn-outline-primary me-2 mb-3';
    selectAllBtn.innerHTML = '<i class="fas fa-check-square"></i> Pilih Semua';
    
    const deselectAllBtn = document.createElement('button');
    deselectAllBtn.type = 'button';
    deselectAllBtn.className = 'btn btn-sm btn-outline-secondary mb-3';
    deselectAllBtn.innerHTML = '<i class="fas fa-square"></i> Batal Pilih';
    
    const checkboxContainer = document.querySelector('.row');
    checkboxContainer.parentNode.insertBefore(selectAllBtn, checkboxContainer);
    checkboxContainer.parentNode.insertBefore(deselectAllBtn, checkboxContainer);
    
    const checkboxes = document.querySelectorAll('input[name="documents_received[]"]');
    
    selectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => checkbox.checked = true);
    });
    
    deselectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => checkbox.checked = false);
    });
    
    // Update button states based on selection
    function updateButtonStates() {
        const checkedCount = document.querySelectorAll('input[name="documents_received[]"]:checked').length;
        const totalCount = checkboxes.length;
        
        if (checkedCount === totalCount) {
            selectAllBtn.disabled = true;
            deselectAllBtn.disabled = false;
        } else if (checkedCount === 0) {
            selectAllBtn.disabled = false;
            deselectAllBtn.disabled = true;
        } else {
            selectAllBtn.disabled = false;
            deselectAllBtn.disabled = false;
        }
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateButtonStates);
    });
    
    // Initial state
    updateButtonStates();
});
</script>
@endpush