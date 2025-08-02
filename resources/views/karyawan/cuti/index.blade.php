@extends('layouts.main')

@section('title', 'Pengajuan Cuti')
@section('breadcrumb-item', 'Cuti')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3 col-xxl-3">
        <div class="card statistics-card-1">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-2">
                        <i class="ph-duotone ph-calendar-check f-26" data-bs-toggle="tooltip" title="Total Cuti"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $statistics['total'] }}</h5>
                        <p class="text-muted mb-0 f-w-500">Total Cuti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xxl-3">
        <div class="card statistics-card-1">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-3">
                        <i class="ph-duotone ph-check-circle f-26" data-bs-toggle="tooltip" title="Disetujui"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $statistics['disetujui'] }}</h5>
                        <p class="text-muted mb-0 f-w-500">Disetujui</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xxl-3">
        <div class="card statistics-card-1">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-1">
                        <i class="ph-duotone ph-clock f-26" data-bs-toggle="tooltip" title="Pending"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $statistics['pending'] }}</h5>
                        <p class="text-muted mb-0 f-w-500">Pending</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xxl-3">
        <div class="card statistics-card-1">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-4">
                        <i class="ph-duotone ph-calendar-x f-26" data-bs-toggle="tooltip" title="Sisa Cuti"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $statistics['sisa_cuti_tahun_ini'] }}</h5>
                        <p class="text-muted mb-0 f-w-500">Sisa Cuti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Riwayat Pengajuan Cuti</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('karyawan.cuti.create') }}" class="btn btn-primary">
                        <i class="ph-duotone ph-plus me-2"></i>Ajukan Cuti
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" name="status" onchange="filterData()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="year" onchange="filterData()">
                            <option value="">Semua Tahun</option>
                            @for($year = date('Y'); $year >= date('Y') - 3; $year--)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Jenis Cuti</th>
                                <th>Tanggal</th>
                                <th>Durasi</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cutis as $cuti)
                                <tr>
                                    <td>
                                        <span class="badge bg-light-secondary">{{ ucfirst($cuti->jenis_cuti) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="f-w-500">{{ $cuti->tanggal_mulai->format('d M Y') }}</span>
                                            <small class="text-muted">s/d {{ $cuti->tanggal_selesai->format('d M Y') }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $cuti->durasi_hari }} hari</td>
                                    <td>
                                        <span class="text-truncate" style="max-width: 200px;" title="{{ $cuti->alasan }}">
                                            {{ Str::limit($cuti->alasan, 50) }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($cuti->status)
                                            @case('pending')
                                                <span class="badge bg-light-warning">Pending</span>
                                                @break
                                            @case('disetujui')
                                                <span class="badge bg-light-success">Disetujui</span>
                                                @break
                                            @case('ditolak')
                                                <span class="badge bg-light-danger">Ditolak</span>
                                                @break
                                            @case('dibatalkan')
                                                <span class="badge bg-light-secondary">Dibatalkan</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="ph-duotone ph-dots-three-outline"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('karyawan.cuti.show', $cuti) }}">
                                                    <i class="ph-duotone ph-eye me-2"></i>Detail
                                                </a></li>
                                                @if($cuti->status == 'pending')
                                                    <li><a class="dropdown-item" href="{{ route('karyawan.cuti.edit', $cuti) }}">
                                                        <i class="ph-duotone ph-pencil me-2"></i>Edit
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="cancelCuti({{ $cuti->id }})">
                                                        <i class="ph-duotone ph-x me-2"></i>Batalkan
                                                    </a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ph-duotone ph-calendar-x f-48 text-muted mb-3"></i>
                                            <h6 class="text-muted">Belum ada pengajuan cuti</h6>
                                            <small class="text-muted">Silakan ajukan cuti pertama Anda</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $cutis->firstItem() ?? 0 }} - {{ $cutis->lastItem() ?? 0 }} dari {{ $cutis->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $cutis->links() }}
                    </div>
                </div>
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
                <form id="cancelForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterData() {
    const status = document.querySelector('select[name="status"]').value;
    const year = document.querySelector('select[name="year"]').value;
    
    const url = new URL(window.location);
    
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    
    if (year) {
        url.searchParams.set('year', year);
    } else {
        url.searchParams.delete('year');
    }
    
    window.location = url;
}

function cancelCuti(cutiId) {
    const form = document.getElementById('cancelForm');
    form.action = `/karyawan/cuti/${cutiId}/cancel`;
    
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush