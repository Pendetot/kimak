@extends('layouts.main')

@section('title', 'Dashboard Karyawan')

@push('css')
<style>
    .stat-card {
        border-radius: 12px;
        transition: transform 0.2s ease-in-out;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
    .quick-action-btn {
        border-radius: 8px;
        padding: 12px;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: all 0.2s ease-in-out;
    }
    .quick-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .activity-item {
        border-left: 3px solid transparent;
        padding-left: 15px;
        margin-bottom: 15px;
    }
    .activity-item.success { border-left-color: #28a745; }
    .activity-item.warning { border-left-color: #ffc107; }
    .activity-item.danger { border-left-color: #dc3545; }
    .activity-item.info { border-left-color: #17a2b8; }
    .activity-item.primary { border-left-color: #007bff; }
    
    .notification-alert {
        border-radius: 8px;
        border: none;
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .contract-warning {
        background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 100%);
        color: white;
    }
    
    .debt-warning {
        background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h4 class="m-b-10">Selamat Datang, {{ $karyawan->display_name }}!</h4>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('karyawan.dashboard') }}">
                                        <i class="fas fa-home"></i> Dashboard
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Overview</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications & Alerts -->
    @if($contractInfo && $contractInfo['is_expiring_soon'])
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert contract-warning notification-alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-1">Kontrak Akan Berakhir!</h6>
                            <p class="mb-0">
                                Kontrak kerja Anda akan berakhir pada {{ $contractInfo['end_date']->format('d M Y') }} 
                                ({{ $contractInfo['days_until_expiry'] }} hari lagi). Silakan hubungi HRD untuk perpanjangan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($activeSP > 0)
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-danger notification-alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-1">Surat Peringatan Aktif</h6>
                            <p class="mb-0">Anda memiliki {{ $activeSP }} surat peringatan yang masih aktif. Pastikan untuk mematuhi aturan perusahaan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($activeHutang > 0)
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert debt-warning notification-alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-credit-card fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-1">Hutang Aktif</h6>
                            <p class="mb-0">Anda memiliki hutang sebesar Rp {{ number_format($activeHutang, 0, ',', '.') }}. Pastikan untuk melakukan pembayaran tepat waktu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-white-50 mb-1">Kehadiran Bulan Ini</h6>
                            <h4 class="mb-0">{{ $absensiStats['hadir'] }}/{{ $absensiStats['total'] }} Hari</h4>
                            <small class="text-white-50">
                                @if($absensiStats['total'] > 0)
                                    {{ round(($absensiStats['hadir'] / $absensiStats['total']) * 100, 1) }}% Kehadiran
                                @else
                                    Belum ada data
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line fa-2x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-white-50 mb-1">KPI Terakhir</h6>
                            <h4 class="mb-0">
                                @if($latestKPI)
                                    {{ $latestKPI->nilai_kpi }}
                                @else
                                    -
                                @endif
                            </h4>
                            <small class="text-white-50">
                                @if($latestKPI)
                                    {{ $latestKPI->periode->format('M Y') }}
                                @else
                                    Belum ada evaluasi
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card stat-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-white-50 mb-1">Cuti Pending</h6>
                            <h4 class="mb-0">{{ $pendingCuti }}</h4>
                            <small class="text-white-50">Pengajuan menunggu approval</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-clock fa-2x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-white-50 mb-1">Masa Kerja</h6>
                            <h4 class="mb-0">{{ $karyawan->work_duration }}</h4>
                            <small class="text-white-50">Sejak {{ $karyawan->tanggal_masuk->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance & Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-day me-2"></i>
                        Absensi Hari Ini - {{ now()->format('d M Y') }}
                    </h5>
                </div>
                <div class="card-body">
                    @if($todayAbsensi)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-sign-in-alt text-success fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Jam Masuk</h6>
                                        <span class="text-muted">
                                            @if($todayAbsensi->jam_masuk)
                                                {{ $todayAbsensi->jam_masuk->format('H:i') }}
                                                @if($todayAbsensi->isLate())
                                                    <span class="badge bg-warning ms-1">Terlambat</span>
                                                @endif
                                            @else
                                                <span class="text-danger">Belum check-in</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-sign-out-alt text-danger fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Jam Keluar</h6>
                                        <span class="text-muted">
                                            @if($todayAbsensi->jam_keluar)
                                                {{ $todayAbsensi->jam_keluar->format('H:i') }}
                                            @else
                                                <span class="text-warning">Belum check-out</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($todayAbsensi->jam_masuk && $todayAbsensi->jam_keluar)
                            <div class="alert alert-info">
                                <i class="fas fa-clock me-2"></i>
                                Total jam kerja: {{ $todayAbsensi->getWorkingHours() }} jam
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada absensi hari ini</h6>
                            <p class="text-muted">Silakan lakukan check-in untuk memulai hari kerja</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @if(!$todayAbsensi || !$todayAbsensi->jam_masuk)
                            <div class="col-6">
                                <a href="#" class="quick-action-btn bg-success bg-opacity-10 text-success" onclick="checkIn()">
                                    <i class="fas fa-sign-in-alt fa-lg mb-2"></i>
                                    <br><small>Check In</small>
                                </a>
                            </div>
                        @endif

                        @if($todayAbsensi && $todayAbsensi->jam_masuk && !$todayAbsensi->jam_keluar)
                            <div class="col-6">
                                <a href="#" class="quick-action-btn bg-danger bg-opacity-10 text-danger" onclick="checkOut()">
                                    <i class="fas fa-sign-out-alt fa-lg mb-2"></i>
                                    <br><small>Check Out</small>
                                </a>
                            </div>
                        @endif

                        <div class="col-6">
                            <a href="{{ route('karyawan.absensi.index') }}" class="quick-action-btn bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-calendar-check fa-lg mb-2"></i>
                                <br><small>Absensi</small>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('karyawan.kpi.index') }}" class="quick-action-btn bg-info bg-opacity-10 text-info">
                                <i class="fas fa-chart-line fa-lg mb-2"></i>
                                <br><small>KPI</small>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('karyawan.cuti.create') }}" class="quick-action-btn bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-calendar-plus fa-lg mb-2"></i>
                                <br><small>Ajukan Cuti</small>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('karyawan.pengajuan-barang.create') }}" class="quick-action-btn bg-secondary bg-opacity-10 text-secondary">
                                <i class="fas fa-box fa-lg mb-2"></i>
                                <br><small>Pengajuan</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Information -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Pengajuan Barang Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentPengajuan->count() > 0)
                        @foreach($recentPengajuan as $pengajuan)
                            <div class="activity-item {{ $pengajuan->getStatusColor() }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $pengajuan->nama_barang }}</h6>
                                        <p class="text-muted mb-0">
                                            <small>
                                                {{ $pengajuan->spesifikasi ?? 'Tidak ada spesifikasi' }} - 
                                                Qty: {{ $pengajuan->jumlah }}
                                            </small>
                                        </p>
                                        <small class="text-muted">{{ $pengajuan->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge bg-{{ $pengajuan->getStatusColor() }}">
                                        {{ $pengajuan->status->label() }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('karyawan.pengajuan-barang.index') }}" class="btn btn-outline-primary btn-sm">
                                Lihat Semua Pengajuan
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada pengajuan barang</h6>
                            <a href="{{ route('karyawan.pengajuan-barang.create') }}" class="btn btn-primary btn-sm">
                                Buat Pengajuan Baru
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Informasi Karyawan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="{{ $karyawan->getPhotoUrl() }}" 
                             alt="Profile" 
                             class="rounded-circle" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>NIK:</strong></td>
                            <td>{{ $karyawan->nik }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan:</strong></td>
                            <td>{{ $karyawan->jabatan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Departemen:</strong></td>
                            <td>{{ $karyawan->departemen }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ $karyawan->status_karyawan->color() }}">
                                    {{ $karyawan->status_karyawan->label() }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Kontrak:</strong></td>
                            <td>
                                <span class="badge bg-{{ $karyawan->jenis_kontrak->color() }}">
                                    {{ $karyawan->jenis_kontrak->label() }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="text-center mt-3">
                        <a href="{{ route('karyawan.profile.show') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Check-in Modal -->
<div class="modal fade" id="checkinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Check In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="checkinForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" name="lokasi_absensi" placeholder="Masukkan lokasi Anda">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan jika diperlukan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Check In</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Check-out Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Check Out</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="checkoutForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan akhir hari kerja"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Check Out</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function checkIn() {
    $('#checkinModal').modal('show');
}

function checkOut() {
    $('#checkoutModal').modal('show');
}

document.getElementById('checkinForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("karyawan.absensi.check-in") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#checkinModal').modal('hide');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat check-in');
    });
});

document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("karyawan.absensi.check-out") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#checkoutModal').modal('hide');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat check-out');
    });
});
</script>
@endpush