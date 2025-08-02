@extends('layouts.app')

@section('title', 'Tambah Pembayaran')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Pembayaran</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('keuangan.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('keuangan.pembayaran.index') }}">Pembayaran</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Form Tambah Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('keuangan.pembayaran.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="hutang" {{ old('type') == 'hutang' ? 'selected' : '' }}>Pelunasan Hutang</option>
                                            <option value="advance" {{ old('type') == 'advance' ? 'selected' : '' }}>Kasbon</option>
                                            <option value="bonus" {{ old('type') == 'bonus' ? 'selected' : '' }}>Bonus</option>
                                            <option value="reimburse" {{ old('type') == 'reimburse' ? 'selected' : '' }}>Reimburse</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Karyawan <span class="text-danger">*</span></label>
                                        <select name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror" required>
                                            <option value="">Pilih Karyawan</option>
                                            @foreach($karyawans as $karyawan)
                                                <option value="{{ $karyawan->id }}" {{ old('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                                    {{ $karyawan->nama_lengkap }} - {{ $karyawan->nik }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('karyawan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                                   placeholder="0" min="0" step="1000" value="{{ old('amount') }}" required>
                                        </div>
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                                        <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" 
                                               value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                        @error('payment_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                                        <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                            <option value="">Pilih Metode</option>
                                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                            <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Cek/Giro</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Referensi</label>
                                        <input type="text" name="reference_number" class="form-control @error('reference_number') is-invalid @enderror" 
                                               placeholder="Nomor bukti/referensi" value="{{ old('reference_number') }}">
                                        @error('reference_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Nomor bukti transfer, cek, atau referensi lainnya</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" 
                                       placeholder="Deskripsi pembayaran" value="{{ old('description') }}" required>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" 
                                          placeholder="Catatan tambahan">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph-duotone ph-check me-1"></i>Simpan Pembayaran
                                </button>
                                <a href="{{ route('keuangan.pembayaran.index') }}" class="btn btn-outline-secondary">
                                    <i class="ph-duotone ph-arrow-left me-1"></i>Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format currency input
    document.querySelector('input[name="amount"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        e.target.value = value;
    });

    // Auto-fill reference number based on payment method
    document.querySelector('select[name="payment_method"]').addEventListener('change', function(e) {
        const refInput = document.querySelector('input[name="reference_number"]');
        const today = new Date().toISOString().slice(0, 10).replace(/-/g, '');
        
        switch(e.target.value) {
            case 'transfer':
                refInput.placeholder = 'No. transfer (contoh: TRF' + today + ')';
                break;
            case 'check':
                refInput.placeholder = 'No. cek/giro';
                break;
            case 'cash':
                refInput.placeholder = 'No. kwitansi/bukti';
                break;
            default:
                refInput.placeholder = 'Nomor bukti/referensi';
        }
    });
</script>
@endpush