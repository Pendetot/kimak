@extends('layouts.main')

@section('title', 'Dashboard Karyawan')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('karyawan.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <!-- Notifications & Alerts -->
    @if($contractInfo && $contractInfo['is_expiring_soon'])
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> Kontrak kerja Anda akan berakhir pada {{ $contractInfo['end_date']->format('d M Y') }} 
                ({{ $contractInfo['days_until_expiry'] }} hari lagi). Silakan hubungi HRD untuk perpanjangan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if($activeSP > 0)
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Peringatan!</strong> Anda memiliki {{ $activeSP }} surat peringatan yang masih aktif. 
                Pastikan untuk mematuhi aturan perusahaan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if($activeHutang > 0)
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Info!</strong> Anda memiliki hutang sebesar Rp {{ number_format($activeHutang, 0, ',', '.') }}. 
                Pastikan untuk melakukan pembayaran tepat waktu.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- [ Row 1 ] start -->
    <div class="col-md-12 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="{{ URL::asset('build/images/widget/img-status-2.svg') }}" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-1 text-white me-3">
                        <i class="ph-duotone ph-calendar-check f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Kehadiran Bulan Ini</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $absensiStats['hadir'] }}/{{ $absensiStats['total'] }}</h2>
                            <span class="badge bg-light-success ms-2">
                                @if($absensiStats['total'] > 0)
                                    {{ round(($absensiStats['hadir'] / $absensiStats['total']) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="{{ URL::asset('build/images/widget/img-status-1.svg') }}" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-2 text-white me-3">
                        <i class="ph-duotone ph-chart-line-up f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">KPI Terakhir</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">
                                @if($latestKPI)
                                    {{ $latestKPI->nilai_kpi }}
                                @else
                                    -
                                @endif
                            </h2>
                            @if($latestKPI)
                                <span class="badge bg-light-primary ms-2">{{ $latestKPI->periode->format('M Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="{{ URL::asset('build/images/widget/img-status-3.svg') }}" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-3 text-white me-3">
                        <i class="ph-duotone ph-calendar-blank f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Cuti Pending</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $pendingCuti }}</h2>
                            <span class="badge bg-light-warning ms-2">Menunggu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="{{ URL::asset('build/images/widget/img-status-4.svg') }}" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-1 text-white me-3">
                        <i class="ph-duotone ph-clock f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Masa Kerja</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $karyawan->work_duration }}</h2>
                            <span class="badge bg-light-info ms-2">{{ $karyawan->tanggal_masuk->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="{{ URL::asset('build/images/widget/img-status-5.svg') }}" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-2 text-white me-3">
                        <i class="ph-duotone ph-package f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Pengajuan Barang</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $recentPengajuan->count() }}</h2>
                            <span class="badge bg-light-secondary ms-2">Total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-4">
        <div class="card statistics-card-1">
            <div class="card-body">
                <img src="{{ URL::asset('build/images/widget/img-status-3.svg') }}" alt="img" class="img-fluid img-bg" />
                <div class="d-flex align-items-center">
                    <div class="avtar bg-brand-color-3 text-white me-3">
                        <i class="ph-duotone ph-user-circle f-26"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0">Status Karyawan</p>
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 f-w-500">{{ $karyawan->status_karyawan->label() }}</h2>
                            <span class="badge bg-{{ $karyawan->status_karyawan->color() }} ms-2">{{ $karyawan->jenis_kontrak->label() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Row 1 ] end -->
</div>

<!-- Additional Content Sections -->
<div class="row">
    <!-- Today's Attendance -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Absensi Hari Ini - {{ now()->format('d M Y') }}</h5>
                    <div class="d-flex align-items-center">
                        @if(!$todayAbsensi || !$todayAbsensi->jam_masuk)
                            <button class="btn btn-success btn-sm me-2" onclick="checkIn()">
                                <i class="ph-duotone ph-sign-in me-1"></i>Check In
                            </button>
                        @endif
                        @if($todayAbsensi && $todayAbsensi->jam_masuk && !$todayAbsensi->jam_keluar)
                            <button class="btn btn-danger btn-sm" onclick="checkOut()">
                                <i class="ph-duotone ph-sign-out me-1"></i>Check Out
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($todayAbsensi)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avtar avtar-s bg-light-success me-3">
                                    <i class="ph-duotone ph-sign-in"></i>
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
                                    <i class="ph-duotone ph-sign-out"></i>
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
                            <i class="ph-duotone ph-clock me-2"></i>
                            Total jam kerja: {{ $todayAbsensi->getWorkingHours() }} jam
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="ph-duotone ph-calendar-x f-40 text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada absensi hari ini</h6>
                        <p class="text-muted">Silakan lakukan check-in untuk memulai hari kerja</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Profile & Quick Actions -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="chat-avtar d-inline-flex mx-auto">
                    <img class="rounded-circle img-fluid wid-90 img-thumbnail" 
                         src="{{ $karyawan->getPhotoUrl() }}" alt="User image">
                </div>
                <h5 class="mb-0 mt-3">{{ $karyawan->display_name }}</h5>
                <p class="text-muted text-sm">{{ $karyawan->jabatan }}</p>
                <p class="text-muted text-sm">{{ $karyawan->departemen }}</p>
                
                <div class="row g-3 mt-3">
                    <div class="col-6">
                        <a href="{{ route('karyawan.profile.show') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ph-duotone ph-user-circle me-1"></i>Profile
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('karyawan.absensi.index') }}" class="btn btn-primary btn-sm">
                            <i class="ph-duotone ph-calendar-check me-1"></i>Absensi
                        </a>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <a href="{{ route('karyawan.kpi.index') }}" class="btn btn-outline-info btn-sm">
                            <i class="ph-duotone ph-chart-line-up me-1"></i>KPI
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('karyawan.cuti.create') }}" class="btn btn-outline-warning btn-sm">
                            <i class="ph-duotone ph-calendar-plus me-1"></i>Cuti
                        </a>
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
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Pengajuan Barang Terbaru</h5>
                    <a href="{{ route('karyawan.pengajuan-barang.index') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recentPengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-sm mb-0">
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
                @else
                    <div class="text-center py-4">
                        <i class="ph-duotone ph-package f-40 text-muted mb-3"></i>
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