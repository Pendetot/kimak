@extends('layouts.main')

@section('title', 'Ajukan Barang')
@section('breadcrumb-item')
    <a href="{{ route('karyawan.pengajuan-barang.index') }}">Pengajuan Barang</a>
    <span class="pc-micon"><i class="ph-duotone ph-caret-right"></i></span>
    Ajukan Barang
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Formulir Pengajuan Barang</h5>
            </div>
            <div class="card-body">
                <!-- Info Alert -->
                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="ph-duotone ph-info f-20 me-2"></i>
                    <div>
                        <strong>Catatan:</strong> Pengajuan barang akan melalui proses persetujuan berlapis (HRD → Logistik → Direktur)
                        <br><small class="text-muted">Pastikan informasi yang diisi sudah benar dan lengkap</small>
                    </div>
                </div>

                <form action="{{ route('karyawan.pengajuan-barang.store') }}" method="POST" id="pengajuanForm">
                    @csrf
                    <div class="row">
                        <!-- Nama Barang -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                                   name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" 
                                   placeholder="Contoh: Laptop Dell Latitude 7420" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah & Satuan -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                   name="jumlah" id="jumlah" value="{{ old('jumlah') }}" 
                                   min="1" placeholder="1" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="satuan">Satuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('satuan') is-invalid @enderror" name="satuan" id="satuan" required>
                                <option value="">Pilih Satuan</option>
                                <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>Unit</option>
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>Set</option>
                                <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : '' }}>Pack</option>
                                <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
                                <option value="meter" {{ old('satuan') == 'meter' ? 'selected' : '' }}>Meter</option>
                                <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
                                <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                                <option value="lainnya" {{ old('satuan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Spesifikasi -->
                        <div class="col-12 mb-3">
                            <label class="form-label" for="spesifikasi">Spesifikasi Barang</label>
                            <textarea class="form-control @error('spesifikasi') is-invalid @enderror" 
                                      name="spesifikasi" id="spesifikasi" rows="3" 
                                      placeholder="Jelaskan spesifikasi detail barang yang dibutuhkan (warna, ukuran, merk, model, dll)">{{ old('spesifikasi') }}</textarea>
                            @error('spesifikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga Estimasi -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="harga_estimasi">Harga Estimasi (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga_estimasi') is-invalid @enderror" 
                                       name="harga_estimasi" id="harga_estimasi" value="{{ old('harga_estimasi') }}" 
                                       min="0" placeholder="0" onkeyup="formatCurrency(this)">
                            </div>
                            @error('harga_estimasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Perkiraan harga per unit untuk membantu proses persetujuan</small>
                        </div>

                        <!-- Prioritas -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="prioritas">Prioritas <span class="text-danger">*</span></label>
                            <select class="form-select @error('prioritas') is-invalid @enderror" name="prioritas" id="prioritas" required>
                                <option value="">Pilih Prioritas</option>
                                <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>
                                    Rendah (Bisa ditunda, tidak urgent)
                                </option>
                                <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>
                                    Sedang (Perlu dalam 1-2 minggu)
                                </option>
                                <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>
                                    Tinggi (Perlu dalam beberapa hari)
                                </option>
                                <option value="mendesak" {{ old('prioritas') == 'mendesak' ? 'selected' : '' }}>
                                    Mendesak (Perlu segera)
                                </option>
                            </select>
                            @error('prioritas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Dibutuhkan -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_dibutuhkan">Tanggal Dibutuhkan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_dibutuhkan') is-invalid @enderror" 
                                   name="tanggal_dibutuhkan" id="tanggal_dibutuhkan" value="{{ old('tanggal_dibutuhkan') }}" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('tanggal_dibutuhkan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keperluan -->
                        <div class="col-12 mb-3">
                            <label class="form-label" for="keperluan">Keperluan/Tujuan Penggunaan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('keperluan') is-invalid @enderror" 
                                      name="keperluan" id="keperluan" rows="3" 
                                      placeholder="Jelaskan untuk apa barang ini akan digunakan dan mengapa dibutuhkan" required>{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="col-12 mb-3">
                            <label class="form-label" for="catatan">Catatan Tambahan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                      name="catatan" id="catatan" rows="2" 
                                      placeholder="Tambahkan catatan atau informasi tambahan jika diperlukan">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Budget Estimate Display -->
                    <div class="row" id="budgetInfo" style="display: none;">
                        <div class="col-12">
                            <div class="alert alert-secondary d-flex align-items-center">
                                <i class="ph-duotone ph-calculator f-20 me-2"></i>
                                <div>
                                    <strong>Total Estimasi Budget:</strong> 
                                    <span id="totalBudget" class="f-w-600 text-primary">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('karyawan.pengajuan-barang.index') }}" class="btn btn-light">
                            <i class="ph-duotone ph-arrow-left me-2"></i>Kembali
                        </a>
                        <div>
                            <button type="button" class="btn btn-light me-2" onclick="resetForm()">
                                <i class="ph-duotone ph-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="ph-duotone ph-paper-plane-tilt me-2"></i>
                                <span class="btn-text">Ajukan Barang</span>
                                <span class="btn-loading d-none">
                                    <span class="spinner-border spinner-border-sm me-2"></span>Memproses...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pengajuanForm');
    const submitBtn = document.getElementById('submitBtn');
    const jumlahInput = document.getElementById('jumlah');
    const hargaInput = document.getElementById('harga_estimasi');
    const budgetInfo = document.getElementById('budgetInfo');
    const totalBudget = document.getElementById('totalBudget');

    // Calculate total budget
    function calculateBudget() {
        const jumlah = parseInt(jumlahInput.value) || 0;
        const harga = parseInt(hargaInput.value) || 0;
        const total = jumlah * harga;

        if (total > 0) {
            totalBudget.textContent = 'Rp ' + total.toLocaleString('id-ID');
            budgetInfo.style.display = 'block';
        } else {
            budgetInfo.style.display = 'none';
        }
    }

    // Add event listeners
    jumlahInput.addEventListener('input', calculateBudget);
    hargaInput.addEventListener('input', calculateBudget);

    // Form submission
    form.addEventListener('submit', function(e) {
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');
        
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        submitBtn.disabled = true;
    });

    // Custom satuan input
    const satuanSelect = document.getElementById('satuan');
    satuanSelect.addEventListener('change', function() {
        if (this.value === 'lainnya') {
            const customSatuan = prompt('Masukkan satuan custom:');
            if (customSatuan) {
                const option = new Option(customSatuan, customSatuan, true, true);
                this.appendChild(option);
            } else {
                this.value = '';
            }
        }
    });

    // Priority guidance
    const prioritasSelect = document.getElementById('prioritas');
    const tanggalInput = document.getElementById('tanggal_dibutuhkan');
    
    prioritasSelect.addEventListener('change', function() {
        const today = new Date();
        let suggestedDate;
        
        switch(this.value) {
            case 'mendesak':
                suggestedDate = new Date(today.getTime() + (3 * 24 * 60 * 60 * 1000)); // 3 days
                break;
            case 'tinggi':
                suggestedDate = new Date(today.getTime() + (7 * 24 * 60 * 60 * 1000)); // 1 week
                break;
            case 'sedang':
                suggestedDate = new Date(today.getTime() + (14 * 24 * 60 * 60 * 1000)); // 2 weeks
                break;
            case 'rendah':
                suggestedDate = new Date(today.getTime() + (30 * 24 * 60 * 60 * 1000)); // 1 month
                break;
        }
        
        if (suggestedDate && !tanggalInput.value) {
            tanggalInput.value = suggestedDate.toISOString().split('T')[0];
        }
    });
});

function formatCurrency(input) {
    // Remove non-digits
    let value = input.value.replace(/\D/g, '');
    
    // Format with thousand separators
    if (value) {
        input.setAttribute('data-value', value);
    }
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mengosongkan formulir?')) {
        document.getElementById('pengajuanForm').reset();
        document.getElementById('budgetInfo').style.display = 'none';
    }
}
</script>
@endpush