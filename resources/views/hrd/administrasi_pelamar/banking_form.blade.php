@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Data Perbankan</h4>
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

                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-banking-data', $pelamar) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Penting:</h6>
                            <ul class="mb-0">
                                <li>Data rekening ini akan digunakan untuk transfer gaji bulanan</li>
                                <li>Pastikan nama pemilik rekening sesuai dengan nama lengkap pada KTP</li>
                                <li>Rekening harus aktif dan dapat menerima transfer</li>
                                <li>Jika belum memiliki rekening, silakan buat terlebih dahulu di bank yang diinginkan</li>
                            </ul>
                        </div>

                        <h5 class="mb-3 text-primary">Informasi Rekening Bank</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="bank_name" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                                    <select class="form-control @error('bank_name') is-invalid @enderror" 
                                            id="bank_name" name="bank_name" required>
                                        <option value="">Pilih Bank</option>
                                        <option value="BRI" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                                        <option value="BCA" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                        <option value="BNI" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                                        <option value="Mandiri" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                        <option value="BTN" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'BTN' ? 'selected' : '' }}>Bank Tabungan Negara (BTN)</option>
                                        <option value="CIMB Niaga" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                        <option value="Danamon" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'Danamon' ? 'selected' : '' }}>Bank Danamon</option>
                                        <option value="Permata" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'Permata' ? 'selected' : '' }}>Bank Permata</option>
                                        <option value="OCBC NISP" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                                        <option value="Maybank" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'Maybank' ? 'selected' : '' }}>Maybank Indonesia</option>
                                        <option value="Bank Jatim" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'Bank Jatim' ? 'selected' : '' }}>Bank Jatim</option>
                                        <option value="Bank Jateng" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'Bank Jateng' ? 'selected' : '' }}>Bank Jateng</option>
                                        <option value="Lainnya" {{ old('bank_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->bank_name ?? '' : '') == 'Lainnya' ? 'selected' : '' }}>Bank Lainnya</option>
                                    </select>
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="account_type" class="form-label">Jenis Rekening <span class="text-danger">*</span></label>
                                    <select class="form-control @error('account_type') is-invalid @enderror" 
                                            id="account_type" name="account_type" required>
                                        <option value="">Pilih Jenis Rekening</option>
                                        <option value="tabungan" {{ old('account_type', $pelamar->banking_data ? json_decode($pelamar->banking_data)->account_type ?? '' : '') == 'tabungan' ? 'selected' : '' }}>Tabungan</option>
                                        <option value="giro" {{ old('account_type', $pelamar->banking_data ? json_decode($pelamar->banking_data)->account_type ?? '' : '') == 'giro' ? 'selected' : '' }}>Giro</option>
                                    </select>
                                    @error('account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="account_number" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                                   id="account_number" name="account_number" 
                                   placeholder="Masukkan nomor rekening tanpa spasi atau tanda baca"
                                   value="{{ old('account_number', $pelamar->banking_data ? json_decode($pelamar->banking_data)->account_number ?? '' : '') }}" required>
                            @error('account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="account_holder_name" class="form-label">Nama Pemilik Rekening <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('account_holder_name') is-invalid @enderror" 
                                   id="account_holder_name" name="account_holder_name" 
                                   placeholder="Nama sesuai dengan yang tertera di buku tabungan/kartu ATM"
                                   value="{{ old('account_holder_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->account_holder_name ?? $pelamar->nama_lengkap : $pelamar->nama_lengkap) }}" required>
                            <small class="form-text text-muted">Pastikan nama sesuai dengan KTP dan buku tabungan</small>
                            @error('account_holder_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="branch_name" class="form-label">Nama Cabang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('branch_name') is-invalid @enderror" 
                                   id="branch_name" name="branch_name" 
                                   placeholder="Contoh: BRI Cabang Malang, BCA KCP Dinoyo"
                                   value="{{ old('branch_name', $pelamar->banking_data ? json_decode($pelamar->banking_data)->branch_name ?? '' : '') }}" required>
                            @error('branch_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="buku_tabungan_file" class="form-label">Upload Foto/Scan Buku Tabungan atau Kartu ATM</label>
                            <input type="file" class="form-control @error('buku_tabungan_file') is-invalid @enderror" 
                                   id="buku_tabungan_file" name="buku_tabungan_file" 
                                   accept=".pdf,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Upload halaman depan buku tabungan atau foto kartu ATM yang menunjukkan nama dan nomor rekening (PDF/JPG/PNG, Max: 2MB)</small>
                            @error('buku_tabungan_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pelamar->banking_data && isset(json_decode($pelamar->banking_data)->buku_tabungan_file_path))
                                <small class="form-text text-muted">
                                    File saat ini: <a href="{{ Storage::url(json_decode($pelamar->banking_data)->buku_tabungan_file_path) }}" target="_blank">Lihat File</a>
                                </small>
                            @endif
                        </div>

                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle"></i> Perhatian:</h6>
                            <ul class="mb-0">
                                <li><strong>Verifikasi Rekening:</strong> Tim keuangan akan melakukan verifikasi rekening sebelum transfer pertama</li>
                                <li><strong>Biaya Admin:</strong> Pastikan rekening tidak memiliki biaya admin bulanan yang tinggi</li>
                                <li><strong>Status Aktif:</strong> Rekening harus dalam status aktif dan dapat menerima transfer</li>
                                <li><strong>Perubahan Data:</strong> Jika ada perubahan rekening di kemudian hari, segera laporkan ke HRD</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Data Perbankan
                            </button>
                        </div>
                    </form>

                    @if($pelamar->banking_status === 'completed')
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i> Data perbankan telah lengkap dan tersimpan.
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
    // Format account number input (remove non-numeric characters)
    const accountNumberInput = document.getElementById('account_number');
    accountNumberInput.addEventListener('input', function() {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Add spacing for better readability (but store without spaces)
        let value = this.value;
        if (value.length > 4) {
            value = value.replace(/(.{4})/g, '$1 ').trim();
        }
        
        // Update display with spaces but keep actual value without spaces
        const cursorPosition = this.selectionStart;
        this.setAttribute('data-value', this.value.replace(/\s/g, ''));
        this.value = value;
        
        // Restore cursor position
        const newPosition = cursorPosition + (value.length - this.value.replace(/\s/g, '').length);
        this.setSelectionRange(newPosition, newPosition);
    });

    // Validate account number length based on bank
    const bankSelect = document.getElementById('bank_name');
    const accountInput = document.getElementById('account_number');
    
    function validateAccountNumber() {
        const bank = bankSelect.value;
        const accountNumber = accountInput.value.replace(/\s/g, '');
        
        let minLength = 10;
        let maxLength = 16;
        
        // Set specific length requirements for different banks
        switch(bank) {
            case 'BCA':
                minLength = 10;
                maxLength = 10;
                break;
            case 'BRI':
                minLength = 15;
                maxLength = 15;
                break;
            case 'BNI':
                minLength = 10;
                maxLength = 10;
                break;
            case 'Mandiri':
                minLength = 13;
                maxLength = 13;
                break;
        }
        
        if (accountNumber.length > 0 && (accountNumber.length < minLength || accountNumber.length > maxLength)) {
            accountInput.setCustomValidity(`Nomor rekening ${bank} harus ${minLength === maxLength ? minLength : minLength + '-' + maxLength} digit`);
        } else {
            accountInput.setCustomValidity('');
        }
    }
    
    bankSelect.addEventListener('change', validateAccountNumber);
    accountInput.addEventListener('input', validateAccountNumber);
    
    // Auto-fill account holder name with pelamar name if empty
    const accountHolderInput = document.getElementById('account_holder_name');
    if (!accountHolderInput.value.trim()) {
        accountHolderInput.value = '{{ $pelamar->nama_lengkap }}';
    }
    
    // Convert account holder name to uppercase
    accountHolderInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
@endpush