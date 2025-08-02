@extends('layouts.main')

@section('title', 'Pengajuan Barang')
@section('breadcrumb-item', 'Pengajuan Barang')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-2 col-xxl-2">
        <div class="card statistics-card-1">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-2">
                        <i class="ph-duotone ph-package f-26" data-bs-toggle="tooltip" title="Total Pengajuan"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $statistics['total'] }}</h5>
                        <p class="text-muted mb-0 f-w-500">Total</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-xxl-2">
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
    <div class="col-md-2 col-xxl-2">
        <div class="card statistics-card-1">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-3">
                        <i class="ph-duotone ph-check-circle f-26" data-bs-toggle="tooltip" title="Disetujui"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $statistics['approved'] }}</h5>
                        <p class="text-muted mb-0 f-w-500">Disetujui</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-xxl-2">
        <div class="card statistics-card-1">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-4">
                        <i class="ph-duotone ph-x-circle f-26" data-bs-toggle="tooltip" title="Ditolak"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $statistics['rejected'] }}</h5>
                        <p class="text-muted mb-0 f-w-500">Ditolak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-xxl-2">
        <div class="card statistics-card-1">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-5">
                        <i class="ph-duotone ph-truck f-26" data-bs-toggle="tooltip" title="Diterima"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $statistics['delivered'] }}</h5>
                        <p class="text-muted mb-0 f-w-500">Diterima</p>
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
                <h5 class="mb-0">Riwayat Pengajuan Barang</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('karyawan.pengajuan-barang.create') }}" class="btn btn-primary">
                        <i class="ph-duotone ph-plus me-2"></i>Ajukan Barang
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
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="purchased" {{ request('status') == 'purchased' ? 'selected' : '' }}>Dibeli</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Diterima</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="prioritas" onchange="filterData()">
                            <option value="">Semua Prioritas</option>
                            <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="mendesak" {{ request('prioritas') == 'mendesak' ? 'selected' : '' }}>Mendesak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="month" onchange="filterData()">
                            <option value="">Semua Bulan</option>
                            @for($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Spesifikasi</th>
                                <th>Jumlah</th>
                                <th>Prioritas</th>
                                <th>Tanggal Butuh</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuans as $pengajuan)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="f-w-500">{{ $pengajuan->nama_barang }}</span>
                                            @if($pengajuan->harga_estimasi)
                                                <small class="text-muted">Est: Rp {{ number_format($pengajuan->harga_estimasi, 0, ',', '.') }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-truncate" style="max-width: 150px;" title="{{ $pengajuan->spesifikasi }}">
                                            {{ $pengajuan->spesifikasi ? Str::limit($pengajuan->spesifikasi, 30) : '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $pengajuan->jumlah }} {{ $pengajuan->satuan }}</td>
                                    <td>
                                        @switch($pengajuan->prioritas)
                                            @case('mendesak')
                                                <span class="badge bg-danger">Mendesak</span>
                                                @break
                                            @case('tinggi')
                                                <span class="badge bg-warning">Tinggi</span>
                                                @break
                                            @case('sedang')
                                                <span class="badge bg-info">Sedang</span>
                                                @break
                                            @case('rendah')
                                                <span class="badge bg-secondary">Rendah</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $pengajuan->tanggal_dibutuhkan->format('d M Y') }}</td>
                                    <td>
                                        @switch($pengajuan->status->value)
                                            @case('pending')
                                                <span class="badge bg-light-warning">Pending</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-light-success">Disetujui</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-light-danger">Ditolak</span>
                                                @break
                                            @case('purchased')
                                                <span class="badge bg-light-info">Dibeli</span>
                                                @break
                                            @case('delivered')
                                                <span class="badge bg-light-primary">Diterima</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="ph-duotone ph-dots-three-outline"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('karyawan.pengajuan-barang.show', $pengajuan) }}">
                                                    <i class="ph-duotone ph-eye me-2"></i>Detail
                                                </a></li>
                                                @if($pengajuan->status->value == 'pending')
                                                    <li><a class="dropdown-item" href="{{ route('karyawan.pengajuan-barang.edit', $pengajuan) }}">
                                                        <i class="ph-duotone ph-pencil me-2"></i>Edit
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="cancelPengajuan({{ $pengajuan->id }})">
                                                        <i class="ph-duotone ph-x me-2"></i>Batalkan
                                                    </a></li>
                                                @endif
                                                @if($pengajuan->status->value == 'delivered' && !$pengajuan->received_by)
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-success" href="#" onclick="confirmReceipt({{ $pengajuan->id }})">
                                                        <i class="ph-duotone ph-check me-2"></i>Konfirmasi Terima
                                                    </a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ph-duotone ph-package f-48 text-muted mb-3"></i>
                                            <h6 class="text-muted">Belum ada pengajuan barang</h6>
                                            <small class="text-muted">Silakan ajukan barang yang Anda butuhkan</small>
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
                            Menampilkan {{ $pengajuans->firstItem() ?? 0 }} - {{ $pengajuans->lastItem() ?? 0 }} dari {{ $pengajuans->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $pengajuans->links() }}
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
                <p>Apakah Anda yakin ingin membatalkan pengajuan barang ini?</p>
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

<!-- Receipt Confirmation Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Penerimaan Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="receiptForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Penerimaan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="konfirmasi_penerimaan" value="1" id="received_yes" checked>
                            <label class="form-check-label" for="received_yes">
                                Barang diterima dengan baik
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="konfirmasi_penerimaan" value="0" id="received_no">
                            <label class="form-check-label" for="received_no">
                                Ada masalah dengan barang yang diterima
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="catatan_penerimaan">Catatan (Opsional)</label>
                        <textarea class="form-control" name="catatan_penerimaan" id="catatan_penerimaan" rows="3" 
                                  placeholder="Tambahkan catatan mengenai kondisi barang atau masalah yang ditemukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi Penerimaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterData() {
    const status = document.querySelector('select[name="status"]').value;
    const prioritas = document.querySelector('select[name="prioritas"]').value;
    const month = document.querySelector('select[name="month"]').value;
    
    const url = new URL(window.location);
    
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    
    if (prioritas) {
        url.searchParams.set('prioritas', prioritas);
    } else {
        url.searchParams.delete('prioritas');
    }
    
    if (month) {
        url.searchParams.set('month', month);
    } else {
        url.searchParams.delete('month');
    }
    
    window.location = url;
}

function cancelPengajuan(pengajuanId) {
    const form = document.getElementById('cancelForm');
    form.action = `/karyawan/pengajuan-barang/${pengajuanId}/cancel`;
    
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}

function confirmReceipt(pengajuanId) {
    const form = document.getElementById('receiptForm');
    form.action = `/karyawan/pengajuan-barang/${pengajuanId}/confirm-receipt`;
    
    const modal = new bootstrap.Modal(document.getElementById('receiptModal'));
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