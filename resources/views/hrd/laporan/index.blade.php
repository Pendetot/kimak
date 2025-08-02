@extends('layouts.app')

@section('title', 'Laporan HR')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Laporan HR</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('hrd.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Laporan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Statistics -->
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
                                <h4 class="text-white">15</h4>
                                <h6 class="text-white m-b-0">Baru Bulan Ini</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-user-plus f-28 text-white"></i>
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
                                <h4 class="text-white">23</h4>
                                <h6 class="text-white m-b-0">Cuti Pending</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-calendar-blank f-28 text-white"></i>
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
                                <h6 class="text-white m-b-0">Rata-rata KPI</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-chart-line f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="row">
            <!-- Employee Reports -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-users me-2"></i>Laporan Karyawan</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('hrd.laporan.karyawan') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-primary me-3">
                                            <i class="ph-duotone ph-chart-bar"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Data Karyawan</h6>
                                            <small class="text-muted">Laporan lengkap data karyawan aktif</small>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-primary">48 Data</span>
                            </a>
                            <a href="{{ route('hrd.laporan.absensi') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-success me-3">
                                            <i class="ph-duotone ph-clock"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Absensi</h6>
                                            <small class="text-muted">Laporan kehadiran dan ketidakhadiran</small>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-success">92%</span>
                            </a>
                            <a href="{{ route('hrd.laporan.kpi') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-warning me-3">
                                            <i class="ph-duotone ph-chart-line"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Penilaian KPI</h6>
                                            <small class="text-muted">Laporan evaluasi kinerja karyawan</small>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-warning">8.4</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HR Management Reports -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-clipboard-text me-2"></i>Manajemen HR</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('hrd.laporan.cuti') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-info me-3">
                                            <i class="ph-duotone ph-calendar-blank"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Cuti Karyawan</h6>
                                            <small class="text-muted">Laporan pengajuan dan approval cuti</small>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-info">23 Pending</span>
                            </a>
                            <a href="{{ route('hrd.laporan.mutasi') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-secondary me-3">
                                            <i class="ph-duotone ph-arrows-left-right"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Mutasi</h6>
                                            <small class="text-muted">Laporan perpindahan jabatan/departemen</small>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-secondary">5 Bulan Ini</span>
                            </a>
                            <a href="{{ route('hrd.laporan.resign') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-danger me-3">
                                            <i class="ph-duotone ph-door-open"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Resign</h6>
                                            <small class="text-muted">Laporan pengunduran diri karyawan</small>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-danger">2 Bulan Ini</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recruitment Reports -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-user-plus me-2"></i>Laporan Rekrutmen</h5>
                        <div class="card-header-right">
                            <button class="btn btn-outline-primary btn-sm" onclick="exportAllReports()">
                                <i class="ph-duotone ph-export me-1"></i>Export All
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <a href="{{ route('hrd.laporan.pelamar') }}" class="text-decoration-none">
                                    <div class="card border border-primary">
                                        <div class="card-body text-center">
                                            <div class="avtar avtar-lg bg-primary mx-auto mb-3">
                                                <i class="ph-duotone ph-user-plus f-24"></i>
                                            </div>
                                            <h5 class="mb-2">Laporan Pelamar</h5>
                                            <p class="text-muted mb-3">Status aplikasi dan proses seleksi</p>
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <h4 class="text-primary mb-0">45</h4>
                                                    <small class="text-muted">Total Pelamar</small>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="text-success mb-0">12</h4>
                                                    <small class="text-muted">Diterima</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card border border-success">
                                    <div class="card-body text-center">
                                        <div class="avtar avtar-lg bg-success mx-auto mb-3">
                                            <i class="ph-duotone ph-chart-line f-24"></i>
                                        </div>
                                        <h5 class="mb-2">Analisis Rekrutmen</h5>
                                        <p class="text-muted mb-3">Efektivitas proses rekrutmen</p>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <h4 class="text-success mb-0">75%</h4>
                                                <small class="text-muted">Success Rate</small>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="text-warning mb-0">14</h4>
                                                <small class="text-muted">Avg Days</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card border border-warning">
                                    <div class="card-body text-center">
                                        <div class="avtar avtar-lg bg-warning mx-auto mb-3">
                                            <i class="ph-duotone ph-calendar-check f-24"></i>
                                        </div>
                                        <h5 class="mb-2">Interview Schedule</h5>
                                        <p class="text-muted mb-3">Jadwal dan hasil interview</p>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <h4 class="text-warning mb-0">8</h4>
                                                <small class="text-muted">Scheduled</small>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="text-info mb-0">5</h4>
                                                <small class="text-muted">Completed</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Filters -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-funnel me-2"></i>Filter & Export Options</h5>
                    </div>
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Periode</label>
                                <select class="form-select" name="periode">
                                    <option value="">Pilih Periode</option>
                                    <option value="today">Hari Ini</option>
                                    <option value="this_week">Minggu Ini</option>
                                    <option value="this_month">Bulan Ini</option>
                                    <option value="this_quarter">Kuartal Ini</option>
                                    <option value="this_year">Tahun Ini</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Departemen</label>
                                <select class="form-select" name="departemen">
                                    <option value="">Semua Departemen</option>
                                    <option value="HRD">HRD</option>
                                    <option value="Keuangan">Keuangan</option>
                                    <option value="Logistik">Logistik</option>
                                    <option value="Operasional">Operasional</option>
                                    <option value="IT">IT</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Format Export</label>
                                <select class="form-select" name="format">
                                    <option value="">Pilih Format</option>
                                    <option value="excel">Excel (.xlsx)</option>
                                    <option value="pdf">PDF</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-duotone ph-magnifying-glass me-1"></i>Filter
                                    </button>
                                    <button type="button" class="btn btn-outline-success" onclick="generateReport()">
                                        <i class="ph-duotone ph-file-text me-1"></i>Generate
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Report Activity -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-clock me-2"></i>Recent Report Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline-content">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Laporan Absensi Bulanan</h6>
                                    <p class="text-muted mb-1">Generated report for March 2024</p>
                                    <small class="text-muted">2 hours ago by Admin HRD</small>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Export Data Karyawan</h6>
                                    <p class="text-muted mb-1">Excel export completed successfully</p>
                                    <small class="text-muted">5 hours ago by HR Manager</small>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Laporan KPI Q1</h6>
                                    <p class="text-muted mb-1">Quarterly performance report generated</p>
                                    <small class="text-muted">1 day ago by System</small>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Laporan Rekrutmen</h6>
                                    <p class="text-muted mb-1">Monthly recruitment summary</p>
                                    <small class="text-muted">3 days ago by HR Staff</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportAllReports() {
    if (confirm('Yakin ingin export semua laporan? Proses ini mungkin membutuhkan waktu beberapa menit.')) {
        // Show loading indicator
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="ph-duotone ph-spinner ph-spin me-1"></i>Exporting...';
        btn.disabled = true;
        
        // Simulate export process
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            showNotification('Export berhasil! File akan didownload otomatis.', 'success');
        }, 3000);
    }
}

function generateReport() {
    const form = event.target.closest('form');
    const formData = new FormData(form);
    
    if (!formData.get('periode') || !formData.get('format')) {
        alert('Mohon pilih periode dan format export terlebih dahulu');
        return;
    }
    
    // Show loading indicator
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="ph-duotone ph-spinner ph-spin me-1"></i>Generating...';
    btn.disabled = true;
    
    // Simulate report generation
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showNotification('Report berhasil digenerate!', 'success');
    }, 2000);
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

// Custom date range functionality
document.querySelector('[name="periode"]').addEventListener('change', function() {
    if (this.value === 'custom') {
        // Show date range picker or additional inputs
        console.log('Show custom date range picker');
    }
});
</script>

<style>
.timeline-content .timeline-item {
    position: relative;
    padding-left: 30px;
    margin-bottom: 20px;
}

.timeline-content .timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-content .timeline-marker {
    position: absolute;
    left: 0;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content .timeline-item::before {
    content: '';
    position: absolute;
    left: 5px;
    top: 17px;
    bottom: -20px;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-content .timeline-item:last-child::before {
    display: none;
}

.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
</style>
@endpush