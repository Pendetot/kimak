@extends('layouts.main')

@section('title', 'Detail Cuti')
@section('breadcrumb-item')
    <a href="{{ route('karyawan.cuti.index') }}">Cuti</a>
    <span class="pc-micon"><i class="ph-duotone ph-caret-right"></i></span>
    Detail Cuti
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0">Detail Pengajuan Cuti</h5>
                    <small class="text-muted">ID: #{{ $cuti->id }}</small>
                </div>
                <div class="d-flex gap-2">
                    @if($cuti->status == 'pending')
                        <a href="{{ route('karyawan.cuti.edit', $cuti) }}" class="btn btn-light-primary btn-sm">
                            <i class="ph-duotone ph-pencil me-2"></i>Edit
                        </a>
                        <button type="button" class="btn btn-light-danger btn-sm" onclick="cancelCuti()">
                            <i class="ph-duotone ph-x me-2"></i>Batalkan
                        </button>
                    @endif
                    <a href="{{ route('karyawan.cuti.index') }}" class="btn btn-light btn-sm">
                        <i class="ph-duotone ph-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Status Card -->
                    <div class="col-12 mb-4">
                        <div class="alert {{ $cuti->status == 'disetujui' ? 'alert-success' : ($cuti->status == 'ditolak' ? 'alert-danger' : ($cuti->status == 'dibatalkan' ? 'alert-secondary' : 'alert-warning')) }} d-flex align-items-center">
                            <i class="ph-duotone {{ $cuti->status == 'disetujui' ? 'ph-check-circle' : ($cuti->status == 'ditolak' ? 'ph-x-circle' : ($cuti->status == 'dibatalkan' ? 'ph-minus-circle' : 'ph-clock')) }} f-20 me-3"></i>
                            <div>
                                <h6 class="mb-1">Status: {{ ucfirst($cuti->status) }}</h6>
                                @if($cuti->status == 'pending')
                                    <small>Pengajuan cuti sedang menunggu persetujuan dari HRD</small>
                                @elseif($cuti->status == 'disetujui')
                                    <small>Pengajuan cuti telah disetujui pada {{ $cuti->updated_at->format('d M Y H:i') }}</small>
                                @elseif($cuti->status == 'ditolak')
                                    <small>Pengajuan cuti ditolak pada {{ $cuti->updated_at->format('d M Y H:i') }}</small>
                                    @if($cuti->alasan_penolakan)
                                        <br><small><strong>Alasan:</strong> {{ $cuti->alasan_penolakan }}</small>
                                    @endif
                                @elseif($cuti->status == 'dibatalkan')
                                    <small>Pengajuan cuti dibatalkan pada {{ $cuti->updated_at->format('d M Y H:i') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Cuti</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" style="width: 40%">Jenis Cuti:</td>
                                        <td>
                                            <span class="badge bg-light-secondary">{{ ucfirst($cuti->jenis_cuti) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Mulai:</td>
                                        <td class="f-w-500">{{ $cuti->tanggal_mulai->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Selesai:</td>
                                        <td class="f-w-500">{{ $cuti->tanggal_selesai->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Durasi:</td>
                                        <td>
                                            <span class="badge bg-light-primary">{{ $cuti->durasi_hari }} hari</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Pengajuan:</td>
                                        <td>{{ $cuti->tanggal_pengajuan->format('d M Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Kontak</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" style="width: 40%">Alamat Selama Cuti:</td>
                                        <td>{{ $cuti->alamat_selama_cuti ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">No. Telepon Darurat:</td>
                                        <td>
                                            @if($cuti->no_telepon_darurat)
                                                <a href="tel:{{ $cuti->no_telepon_darurat }}" class="text-decoration-none">
                                                    <i class="ph-duotone ph-phone me-1"></i>{{ $cuti->no_telepon_darurat }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div class="col-12 mt-3">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Alasan Cuti</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $cuti->alasan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Supporting Document -->
                    @if($cuti->file_pendukung)
                        <div class="col-12 mt-3">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">File Pendukung</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        @php
                                            $fileExtension = pathinfo($cuti->file_pendukung, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                                            $isPdf = strtolower($fileExtension) === 'pdf';
                                        @endphp
                                        
                                        <div class="me-3">
                                            @if($isImage)
                                                <i class="ph-duotone ph-image f-24 text-success"></i>
                                            @elseif($isPdf)
                                                <i class="ph-duotone ph-file-pdf f-24 text-danger"></i>
                                            @else
                                                <i class="ph-duotone ph-file f-24 text-secondary"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ basename($cuti->file_pendukung) }}</h6>
                                            <small class="text-muted">Dokumen pendukung pengajuan cuti</small>
                                        </div>
                                        <div>
                                            <a href="{{ Storage::url($cuti->file_pendukung) }}" target="_blank" class="btn btn-light-primary btn-sm">
                                                <i class="ph-duotone ph-eye me-1"></i>Lihat
                                            </a>
                                            <a href="{{ Storage::url($cuti->file_pendukung) }}" download class="btn btn-light-secondary btn-sm ms-1">
                                                <i class="ph-duotone ph-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    @if($isImage)
                                        <div class="mt-3">
                                            <img src="{{ Storage::url($cuti->file_pendukung) }}" 
                                                 alt="File Pendukung" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 300px; cursor: pointer;"
                                                 onclick="openImageModal(this.src)">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Timeline/History -->
                    @if($cuti->status != 'pending')
                        <div class="col-12 mt-3">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Riwayat Status</h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-primary"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Pengajuan Dibuat</h6>
                                                <small class="text-muted">{{ $cuti->tanggal_pengajuan->format('d M Y H:i') }}</small>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-{{ $cuti->status == 'disetujui' ? 'success' : ($cuti->status == 'ditolak' ? 'danger' : 'secondary') }}"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">{{ $cuti->status == 'disetujui' ? 'Disetujui' : ($cuti->status == 'ditolak' ? 'Ditolak' : 'Dibatalkan') }}</h6>
                                                <small class="text-muted">{{ $cuti->updated_at->format('d M Y H:i') }}</small>
                                                @if($cuti->approved_by)
                                                    <br><small class="text-muted">oleh: {{ $cuti->approver->name ?? 'System' }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">File Pendukung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="File Pendukung" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan pengajuan cuti ini?</p>
                <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('karyawan.cuti.cancel', $cuti) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #e9ecef;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px currentColor;
}

.timeline-content {
    padding-left: 10px;
}
</style>
@endpush

@push('scripts')
<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

function cancelCuti() {
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}
</script>
@endpush