@extends('layouts.main')

@section('title', 'Dashboard Karyawan')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('karyawan.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body position-relative">
                <div class="text-center">
                    <div class="chat-avtar d-inline-flex mx-auto">
                        <img class="rounded-circle img-fluid wid-90 img-thumbnail" 
                             src="{{ $karyawan->getPhotoUrl() }}" alt="User image">
                    </div>
                    <h5 class="mb-0">{{ $karyawan->display_name }}</h5>
                    <p class="text-muted text-sm">{{ $karyawan->jabatan }}</p>
                    <div class="row g-3">
                        <div class="col-4">
                            <h5 class="mb-0">{{ $absensiStats['hadir'] }}</h5>
                            <small class="text-muted">Hadir</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0">{{ $latestKPI ? $latestKPI->nilai_kpi : '-' }}</h5>
                            <small class="text-muted">KPI</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0">{{ $karyawan->work_duration }}</h5>
                            <small class="text-muted">Masa Kerja</small>
                        </div>
                    </div>
                    <div class="row g-2 mt-3">
                        <div class="col-6">
                            <a href="{{ route('karyawan.profile.show') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="feather icon-edit"></i> Profile
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('karyawan.absensi.index') }}" class="btn btn-primary btn-sm">
                                <i class="feather icon-calendar"></i> Absensi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-md-8 col-sm-12">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card bg-primary-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="text-white">{{ $absensiStats['hadir'] }}/{{ $absensiStats['total'] }}</h3>
                                <h6 class="text-white m-b-0">Kehadiran Bulan Ini</h6>
                            </div>
                            <div class="col-auto">
                                <i class="feather icon-calendar text-white f-28"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card bg-success-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="text-white">{{ $latestKPI ? $latestKPI->nilai_kpi : 0 }}</h3>
                                <h6 class="text-white m-b-0">KPI Terakhir</h6>
                            </div>
                            <div class="col-auto">
                                <i class="feather icon-trending-up text-white f-28"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card bg-warning-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="text-white">{{ $pendingCuti }}</h3>
                                <h6 class="text-white m-b-0">Cuti Pending</h6>
                            </div>
                            <div class="col-auto">
                                <i class="feather icon-clock text-white f-28"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card bg-info-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="text-white">{{ $recentPengajuan->count() }}</h3>
                                <h6 class="text-white m-b-0">Pengajuan Barang</h6>
                            </div>
                            <div class="col-auto">
                                <i class="feather icon-package text-white f-28"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alerts Section -->
@if($contractInfo && $contractInfo['is_expiring_soon'])
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> Kontrak kerja Anda akan berakhir pada {{ $contractInfo['end_date']->format('d M Y') }} 
                ({{ $contractInfo['days_until_expiry'] }} hari lagi). Silakan hubungi HRD untuk perpanjangan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@if($activeSP > 0)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Peringatan!</strong> Anda memiliki {{ $activeSP }} surat peringatan yang masih aktif. 
                Pastikan untuk mematuhi aturan perusahaan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@if($activeHutang > 0)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Info!</strong> Anda memiliki hutang sebesar Rp {{ number_format($activeHutang, 0, ',', '.') }}. 
                Pastikan untuk melakukan pembayaran tepat waktu.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<!-- Quick Actions & Today's Attendance -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Absensi Hari Ini - {{ now()->format('d M Y') }}</h5>
            </div>
            <div class="card-body">
                @if($todayAbsensi)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avtar avtar-s bg-light-success me-3">
                                    <i class="feather icon-log-in"></i>
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
                                <div class="avtar avtar-s bg-light-danger me-3">
                                    <i class="feather icon-log-out"></i>
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
                        <div class="alert alert-success">
                            <i class="feather icon-clock me-2"></i>
                            Total jam kerja: {{ $todayAbsensi->getWorkingHours() }} jam
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="feather icon-calendar f-40 text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada absensi hari ini</h6>
                        <p class="text-muted">Silakan lakukan check-in untuk memulai hari kerja</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @if(!$todayAbsensi || !$todayAbsensi->jam_masuk)
                        <div class="col-6">
                            <div class="d-grid">
                                <button class="btn btn-success btn-sm" onclick="checkIn()">
                                    <i class="feather icon-log-in"></i><br>Check In
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($todayAbsensi && $todayAbsensi->jam_masuk && !$todayAbsensi->jam_keluar)
                        <div class="col-6">
                            <div class="d-grid">
                                <button class="btn btn-danger btn-sm" onclick="checkOut()">
                                    <i class="feather icon-log-out"></i><br>Check Out
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="col-6">
                        <div class="d-grid">
                            <a href="{{ route('karyawan.kpi.index') }}" class="btn btn-info btn-sm">
                                <i class="feather icon-trending-up"></i><br>KPI
                            </a>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-grid">
                            <a href="{{ route('karyawan.cuti.create') }}" class="btn btn-warning btn-sm">
                                <i class="feather icon-calendar"></i><br>Ajukan Cuti
                            </a>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-grid">
                            <a href="{{ route('karyawan.pengajuan-barang.create') }}" class="btn btn-secondary btn-sm">
                                <i class="feather icon-package"></i><br>Pengajuan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Pengajuan Barang Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recentPengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPengajuan as $pengajuan)
                                    <tr>
                                        <td>{{ $pengajuan->nama_barang }}</td>
                                        <td>{{ $pengajuan->spesifikasi ?? '-' }}</td>
                                        <td>{{ $pengajuan->jumlah }}</td>
                                        <td>
                                            <span class="badge bg-{{ $pengajuan->getStatusColor() }}">
                                                {{ $pengajuan->status->label() }}
                                            </span>
                                        </td>
                                        <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('karyawan.pengajuan-barang.index') }}" class="btn btn-outline-primary">
                            Lihat Semua Pengajuan
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="feather icon-inbox f-40 text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada pengajuan barang</h6>
                        <a href="{{ route('karyawan.pengajuan-barang.create') }}" class="btn btn-primary">
                            Buat Pengajuan Baru
                        </a>
                    </div>
                @endif
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

@section('scripts')
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
@endsection