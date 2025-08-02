@extends('layouts.main')

@section('title', 'Ajukan Cuti')
@section('breadcrumb-item')
    <a href="{{ route('karyawan.cuti.index') }}">Cuti</a>
    <span class="pc-micon"><i class="ph-duotone ph-caret-right"></i></span>
    Ajukan Cuti
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Formulir Pengajuan Cuti</h5>
            </div>
            <div class="card-body">
                <!-- Leave Balance Alert -->
                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="ph-duotone ph-info f-20 me-2"></i>
                    <div>
                        <strong>Sisa Cuti Tahunan:</strong> {{ $sisaCuti }} hari
                        <br><small class="text-muted">Pastikan pengajuan cuti tidak melebihi sisa cuti yang tersedia</small>
                    </div>
                </div>

                <form action="{{ route('karyawan.cuti.store') }}" method="POST" enctype="multipart/form-data" id="cutiForm">
                    @csrf
                    <div class="row">
                        <!-- Jenis Cuti -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jenis_cuti">Jenis Cuti <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_cuti') is-invalid @enderror" name="jenis_cuti" id="jenis_cuti" required>
                                <option value="">Pilih Jenis Cuti</option>
                                <option value="tahunan" {{ old('jenis_cuti') == 'tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                                <option value="sakit" {{ old('jenis_cuti') == 'sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                                <option value="melahirkan" {{ old('jenis_cuti') == 'melahirkan' ? 'selected' : '' }}>Cuti Melahirkan</option>
                                <option value="menikah" {{ old('jenis_cuti') == 'menikah' ? 'selected' : '' }}>Cuti Menikah</option>
                                <option value="ibadah" {{ old('jenis_cuti') == 'ibadah' ? 'selected' : '' }}>Cuti Ibadah</option>
                                <option value="lainnya" {{ old('jenis_cuti') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_cuti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Durasi -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Durasi Cuti</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="durasi_display" readonly placeholder="0">
                                <span class="input-group-text">hari</span>
                            </div>
                            <small class="text-muted">Durasi akan dihitung otomatis berdasarkan tanggal yang dipilih</small>
                        </div>

                        <!-- Alasan -->
                        <div class="col-12 mb-3">
                            <label class="form-label" for="alasan">Alasan Cuti <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alasan') is-invalid @enderror" name="alasan" 
                                      id="alasan" rows="3" placeholder="Jelaskan alasan pengajuan cuti..." required>{{ old('alasan') }}</textarea>
                            @error('alasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat Selama Cuti -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="alamat_selama_cuti">Alamat Selama Cuti</label>
                            <textarea class="form-control @error('alamat_selama_cuti') is-invalid @enderror" 
                                      name="alamat_selama_cuti" id="alamat_selama_cuti" rows="2" 
                                      placeholder="Alamat yang dapat dihubungi selama cuti">{{ old('alamat_selama_cuti') }}</textarea>
                            @error('alamat_selama_cuti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No Telepon Darurat -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="no_telepon_darurat">No. Telepon Darurat</label>
                            <input type="tel" class="form-control @error('no_telepon_darurat') is-invalid @enderror" 
                                   name="no_telepon_darurat" id="no_telepon_darurat" 
                                   value="{{ old('no_telepon_darurat') }}" placeholder="081234567890">
                            @error('no_telepon_darurat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Pendukung -->
                        <div class="col-12 mb-3">
                            <label class="form-label" for="file_pendukung">File Pendukung</label>
                            <input type="file" class="form-control @error('file_pendukung') is-invalid @enderror" 
                                   name="file_pendukung" id="file_pendukung" 
                                   accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile()">
                            @error('file_pendukung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Upload surat dokter untuk cuti sakit, undangan untuk cuti ibadah, dll. 
                                (Format: PDF, JPG, PNG. Max: 2MB)
                            </small>
                            <div id="file_preview" class="mt-2"></div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('karyawan.cuti.index') }}" class="btn btn-light">
                            <i class="ph-duotone ph-arrow-left me-2"></i>Kembali
                        </a>
                        <div>
                            <button type="button" class="btn btn-light me-2" onclick="resetForm()">
                                <i class="ph-duotone ph-arrow-clockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="ph-duotone ph-paper-plane-tilt me-2"></i>
                                <span class="btn-text">Ajukan Cuti</span>
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
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const durasiDisplay = document.getElementById('durasi_display');
    const jenisSelect = document.getElementById('jenis_cuti');
    const form = document.getElementById('cutiForm');
    const submitBtn = document.getElementById('submitBtn');

    // Calculate duration when dates change
    function calculateDuration() {
        if (tanggalMulai.value && tanggalSelesai.value) {
            const startDate = new Date(tanggalMulai.value);
            const endDate = new Date(tanggalSelesai.value);
            
            if (endDate >= startDate) {
                const timeDiff = endDate.getTime() - startDate.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                durasiDisplay.value = dayDiff;
                
                // Check leave balance for annual leave
                if (jenisSelect.value === 'tahunan') {
                    const sisaCuti = {{ $sisaCuti }};
                    if (dayDiff > sisaCuti) {
                        showAlert('warning', `Durasi cuti (${dayDiff} hari) melebihi sisa cuti tahunan Anda (${sisaCuti} hari)`);
                    }
                }
            } else {
                durasiDisplay.value = 0;
                showAlert('error', 'Tanggal selesai harus sama atau setelah tanggal mulai');
            }
        }
    }

    // Update minimum end date when start date changes
    tanggalMulai.addEventListener('change', function() {
        tanggalSelesai.min = this.value;
        if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
            tanggalSelesai.value = this.value;
        }
        calculateDuration();
    });

    tanggalSelesai.addEventListener('change', calculateDuration);
    jenisSelect.addEventListener('change', calculateDuration);

    // Form submission
    form.addEventListener('submit', function(e) {
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');
        
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        submitBtn.disabled = true;
    });
});

function previewFile() {
    const fileInput = document.getElementById('file_pendukung');
    const preview = document.getElementById('file_preview');
    const file = fileInput.files[0];
    
    if (file) {
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        let icon = 'ph-file';
        
        if (file.type.includes('image')) {
            icon = 'ph-image';
        } else if (file.type.includes('pdf')) {
            icon = 'ph-file-pdf';
        }
        
        preview.innerHTML = `
            <div class="d-flex align-items-center p-2 bg-light rounded">
                <i class="ph-duotone ${icon} f-20 me-2"></i>
                <div class="flex-grow-1">
                    <small class="d-block fw-medium">${file.name}</small>
                    <small class="text-muted">${fileSize} MB</small>
                </div>
                <button type="button" class="btn btn-sm btn-light-danger" onclick="removeFile()">
                    <i class="ph-duotone ph-x"></i>
                </button>
            </div>
        `;
    }
}

function removeFile() {
    document.getElementById('file_pendukung').value = '';
    document.getElementById('file_preview').innerHTML = '';
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mengosongkan formulir?')) {
        document.getElementById('cutiForm').reset();
        document.getElementById('durasi_display').value = '';
        removeFile();
    }
}

function showAlert(type, message) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.temp-alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alertClass = type === 'error' ? 'alert-danger' : 'alert-warning';
    const iconClass = type === 'error' ? 'ph-warning' : 'ph-info';
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${alertClass} temp-alert d-flex align-items-center mt-2`;
    alertDiv.innerHTML = `
        <i class="ph-duotone ${iconClass} f-16 me-2"></i>
        <small>${message}</small>
    `;
    
    document.getElementById('durasi_display').parentNode.appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
@endpush