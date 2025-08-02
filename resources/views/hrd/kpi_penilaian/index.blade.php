@extends('layouts.app')

@section('title', 'Penilaian KPI Karyawan')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Penilaian KPI Karyawan</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('hrd.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Penilaian KPI</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="card bg-primary-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">48</h4>
                                <h6 class="text-white m-b-0">Total Karyawan</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-users f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-success-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">36</h4>
                                <h6 class="text-white m-b-0">Sudah Dinilai</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-check-circle f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-warning-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">12</h4>
                                <h6 class="text-white m-b-0">Pending Review</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-clock f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-info-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">8.4</h4>
                                <h6 class="text-white m-b-0">Rata-rata Score</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-chart-line f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">Manajemen Penilaian KPI</h6>
                                <p class="text-muted mb-0">Kelola penilaian kinerja karyawan secara berkala</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createKPIModal">
                                    <i class="ph-duotone ph-plus me-1"></i>Buat Penilaian Baru
                                </button>
                                <button class="btn btn-outline-warning" onclick="bulkEvaluation()">
                                    <i class="ph-duotone ph-users me-1"></i>Penilaian Massal
                                </button>
                                <button class="btn btn-outline-success" onclick="exportKPI()">
                                    <i class="ph-duotone ph-export me-1"></i>Export Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Cari Karyawan</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama atau NIP..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Departemen</label>
                                <select name="departemen" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="HRD" {{ request('departemen') == 'HRD' ? 'selected' : '' }}>HRD</option>
                                    <option value="Keuangan" {{ request('departemen') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                    <option value="Logistik" {{ request('departemen') == 'Logistik' ? 'selected' : '' }}>Logistik</option>
                                    <option value="Operasional" {{ request('departemen') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Periode</label>
                                <select name="periode" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="2024-01" {{ request('periode') == '2024-01' ? 'selected' : '' }}>Januari 2024</option>
                                    <option value="2024-02" {{ request('periode') == '2024-02' ? 'selected' : '' }}>Februari 2024</option>
                                    <option value="2024-03" {{ request('periode') == '2024-03' ? 'selected' : '' }}>Maret 2024</option>
                                    <option value="2024-04" {{ request('periode') == '2024-04' ? 'selected' : '' }}>April 2024</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Direview</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-duotone ph-magnifying-glass me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('hrd.kpi-penilaian.index') }}" class="btn btn-outline-secondary">
                                        <i class="ph-duotone ph-arrow-clockwise me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Evaluation List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Daftar Penilaian KPI</h5>
                        <div class="card-header-right">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="viewMode" id="listView" checked>
                                <label class="btn btn-outline-primary btn-sm" for="listView">
                                    <i class="ph-duotone ph-list"></i> List
                                </label>
                                <input type="radio" class="btn-check" name="viewMode" id="cardView">
                                <label class="btn btn-outline-primary btn-sm" for="cardView">
                                    <i class="ph-duotone ph-squares-four"></i> Cards
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- List View -->
                        <div id="listViewContent">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                </div>
                                            </th>
                                            <th>Karyawan</th>
                                            <th>Periode</th>
                                            <th>Target</th>
                                            <th>Pencapaian</th>
                                            <th>Score</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Sample Data -->
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input kpi-checkbox" value="1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar avtar-s bg-light-primary me-2">
                                                        <i class="ph-duotone ph-user"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Ahmad Fauzi</h6>
                                                        <p class="text-muted f-12 mb-0">Staff IT</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light-secondary">Maret 2024</span>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <h6 class="mb-0">85%</h6>
                                                    <small class="text-muted">Target</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <h6 class="mb-0 text-success">92%</h6>
                                                    <small class="text-success">Tercapai</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar bg-success" style="width: 92%"></div>
                                                    </div>
                                                    <span class="badge bg-success">9.2</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Selesai</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-info btn-sm" onclick="viewKPI(1)" title="Detail">
                                                        <i class="ph-duotone ph-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-warning btn-sm" onclick="editKPI(1)" title="Edit">
                                                        <i class="ph-duotone ph-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-success btn-sm" onclick="approveKPI(1)" title="Approve">
                                                        <i class="ph-duotone ph-check"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input kpi-checkbox" value="2">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar avtar-s bg-light-warning me-2">
                                                        <i class="ph-duotone ph-user"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Siti Aminah</h6>
                                                        <p class="text-muted f-12 mb-0">Marketing</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light-secondary">Maret 2024</span>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <h6 class="mb-0">80%</h6>
                                                    <small class="text-muted">Target</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <h6 class="mb-0 text-warning">75%</h6>
                                                    <small class="text-warning">Kurang</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar bg-warning" style="width: 75%"></div>
                                                    </div>
                                                    <span class="badge bg-warning">7.5</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">Review</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-info btn-sm" onclick="viewKPI(2)" title="Detail">
                                                        <i class="ph-duotone ph-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-warning btn-sm" onclick="editKPI(2)" title="Edit">
                                                        <i class="ph-duotone ph-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" onclick="rejectKPI(2)" title="Reject">
                                                        <i class="ph-duotone ph-x"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input kpi-checkbox" value="3">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar avtar-s bg-light-info me-2">
                                                        <i class="ph-duotone ph-user"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Budi Santoso</h6>
                                                        <p class="text-muted f-12 mb-0">Finance</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light-secondary">Maret 2024</span>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <h6 class="mb-0">90%</h6>
                                                    <small class="text-muted">Target</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <h6 class="mb-0 text-muted">-</h6>
                                                    <small class="text-muted">Pending</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar bg-light" style="width: 0%"></div>
                                                    </div>
                                                    <span class="badge bg-light-secondary">-</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light-secondary">Pending</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-info btn-sm" onclick="viewKPI(3)" title="Detail">
                                                        <i class="ph-duotone ph-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-primary btn-sm" onclick="startEvaluation(3)" title="Mulai Penilaian">
                                                        <i class="ph-duotone ph-play"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Card View (Hidden by default) -->
                        <div id="cardViewContent" style="display: none;">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar avtar-s bg-primary me-2">
                                                        <i class="ph-duotone ph-user"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Ahmad Fauzi</h6>
                                                        <small class="text-muted">Staff IT</small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success">9.2</span>
                                            </div>
                                            <div class="progress mb-2" style="height: 8px;">
                                                <div class="progress-bar bg-success" style="width: 92%"></div>
                                            </div>
                                            <div class="d-flex justify-content-between text-muted f-12 mb-3">
                                                <span>Target: 85%</span>
                                                <span>Pencapaian: 92%</span>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-outline-info flex-fill" onclick="viewKPI(1)">Detail</button>
                                                <button class="btn btn-sm btn-outline-success" onclick="approveKPI(1)">
                                                    <i class="ph-duotone ph-check"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- More cards would be generated dynamically -->
                            </div>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="KPI Pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item active">
                                    <span class="page-link">1</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create KPI Modal -->
<div class="modal fade" id="createKPIModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Penilaian KPI Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Karyawan</label>
                                <select name="karyawan_id" class="form-select" required>
                                    <option value="">Pilih Karyawan</option>
                                    <option value="1">Ahmad Fauzi - Staff IT</option>
                                    <option value="2">Siti Aminah - Marketing</option>
                                    <option value="3">Budi Santoso - Finance</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Periode</label>
                                <input type="month" name="periode" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Target (%)</label>
                                <input type="number" name="target" class="form-control" min="0" max="100" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bobot</label>
                                <input type="number" name="bobot" class="form-control" min="1" max="10" value="5">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi KPI</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Indikator Pencapaian</label>
                        <textarea name="indikator" class="form-control" rows="2" placeholder="Kriteria untuk mengukur pencapaian..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-duotone ph-check me-1"></i>Buat KPI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.kpi-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// View Mode Toggle
document.getElementById('listView').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('listViewContent').style.display = 'block';
        document.getElementById('cardViewContent').style.display = 'none';
    }
});

document.getElementById('cardView').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('listViewContent').style.display = 'none';
        document.getElementById('cardViewContent').style.display = 'block';
    }
});

// KPI Actions
function viewKPI(id) {
    // Redirect to detail page or open modal
    window.location.href = `/hrd/kpi-penilaian/${id}`;
}

function editKPI(id) {
    // Redirect to edit page or open modal
    window.location.href = `/hrd/kpi-penilaian/${id}/edit`;
}

function approveKPI(id) {
    if (confirm('Yakin ingin menyetujui penilaian KPI ini?')) {
        fetch(`/hrd/kpi-penilaian/${id}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('KPI berhasil disetujui!', 'success');
                location.reload();
            }
        });
    }
}

function rejectKPI(id) {
    if (confirm('Yakin ingin menolak penilaian KPI ini?')) {
        const reason = prompt('Alasan penolakan:');
        if (reason) {
            fetch(`/hrd/kpi-penilaian/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ reason: reason })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('KPI berhasil ditolak!', 'warning');
                    location.reload();
                }
            });
        }
    }
}

function startEvaluation(id) {
    // Redirect to evaluation form
    window.location.href = `/hrd/kpi-penilaian/${id}/evaluate`;
}

function bulkEvaluation() {
    const selectedCheckboxes = document.querySelectorAll('.kpi-checkbox:checked');
    if (selectedCheckboxes.length === 0) {
        alert('Pilih minimal satu KPI untuk penilaian massal');
        return;
    }
    
    const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    window.location.href = `/hrd/kpi-penilaian/bulk-evaluate?ids=${selectedIds.join(',')}`;
}

function exportKPI() {
    window.open('/hrd/kpi-penilaian/export', '_blank');
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alert.style.top = '20px';
    alert.style.right = '20px';
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => alert.remove(), 5000);
}

// Auto-refresh every 5 minutes
setInterval(function() {
    if (document.visibilityState === 'visible') {
        // Could refresh data via AJAX
    }
}, 300000);
</script>
@endpush