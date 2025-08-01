@extends('layouts.main')

@section('title', 'Data Absensi')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('karyawan.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Absensi</li>
@endsection

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3 col-sm-6">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="text-white">{{ $statistics['total'] }}</h3>
                        <h6 class="text-white m-b-0">Total Hari</h6>
                    </div>
                    <div class="col-auto">
                        <i class="feather icon-calendar text-white f-28"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card bg-success-dark">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="text-white">{{ $statistics['hadir'] }}</h3>
                        <h6 class="text-white m-b-0">Hadir</h6>
                    </div>
                    <div class="col-auto">
                        <i class="feather icon-check text-white f-28"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card bg-warning-dark">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="text-white">{{ $statistics['terlambat'] }}</h3>
                        <h6 class="text-white m-b-0">Terlambat</h6>
                    </div>
                    <div class="col-auto">
                        <i class="feather icon-clock text-white f-28"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card bg-danger-dark">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="text-white">{{ $statistics['alfa'] }}</h3>
                        <h6 class="text-white m-b-0">Alfa</h6>
                    </div>
                    <div class="col-auto">
                        <i class="feather icon-x text-white f-28"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5>Quick Actions</h5>
                    <div class="d-flex align-items-center">
                        @if($todayAbsensi && !$todayAbsensi->jam_masuk)
                            <button class="btn btn-success btn-sm me-2" onclick="checkIn()">
                                <i class="feather icon-log-in me-1"></i>Check In
                            </button>
                        @endif
                        @if($todayAbsensi && $todayAbsensi->jam_masuk && !$todayAbsensi->jam_keluar)
                            <button class="btn btn-danger btn-sm me-2" onclick="checkOut()">
                                <i class="feather icon-log-out me-1"></i>Check Out
                            </button>
                        @endif
                        <a href="{{ route('karyawan.absensi.create') }}" class="btn btn-primary btn-sm">
                            <i class="feather icon-plus me-1"></i>Tambah Absensi
                        </a>
                    </div>
                </div>
            </div>
            @if($todayAbsensi)
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Absensi Hari Ini:</strong>
                        Masuk: {{ $todayAbsensi->jam_masuk ? $todayAbsensi->jam_masuk->format('H:i') : '-' }} |
                        Keluar: {{ $todayAbsensi->jam_keluar ? $todayAbsensi->jam_keluar->format('H:i') : '-' }}
                        @if($todayAbsensi->jam_masuk && $todayAbsensi->jam_keluar)
                            | Total: {{ $todayAbsensi->getWorkingHours() }} jam
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Filter -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Filter Data</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('karyawan.absensi.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Bulan</label>
                            <select name="month" class="form-select">
                                <option value="">Semua Bulan</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tahun</label>
                            <select name="year" class="form-select">
                                <option value="">Semua Tahun</option>
                                @for($year = 2020; $year <= date('Y'); $year++)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="pulang_awal" {{ request('status') == 'pulang_awal' ? 'selected' : '' }}>Pulang Awal</option>
                                <option value="alfa" {{ request('status') == 'alfa' ? 'selected' : '' }}>Alfa</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="feather icon-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('karyawan.absensi.index') }}" class="btn btn-outline-secondary">
                                <i class="feather icon-refresh-cw me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Data Absensi</h5>
            </div>
            <div class="card-body">
                @if($absensi->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($absensi as $item)
                                    <tr>
                                        <td>{{ $item->tanggal->format('d M Y') }}</td>
                                        <td>
                                            @if($item->jam_masuk)
                                                {{ $item->jam_masuk->format('H:i') }}
                                                @if($item->isLate())
                                                    <span class="badge bg-warning ms-1">Terlambat</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->jam_keluar ? $item->jam_keluar->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ $item->lokasi_absensi ?? '-' }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($item->status) {
                                                    'hadir' => 'success',
                                                    'terlambat' => 'warning',
                                                    'pulang_awal' => 'info',
                                                    'alfa' => 'danger',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('karyawan.absensi.show', $item) }}" 
                                                   class="btn btn-outline-info btn-sm">
                                                    <i class="feather icon-eye"></i>
                                                </a>
                                                @if($item->tanggal->isToday() && (!$item->jam_masuk || !$item->jam_keluar))
                                                    <a href="{{ route('karyawan.absensi.edit', $item) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="feather icon-edit"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $absensi->firstItem() }} to {{ $absensi->lastItem() }} of {{ $absensi->total() }} results
                        </div>
                        <div>
                            {{ $absensi->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="feather icon-calendar f-40 text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada data absensi</h6>
                        <a href="{{ route('karyawan.absensi.create') }}" class="btn btn-primary">
                            Tambah Absensi Pertama
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
                        <input type="text" class="form-control" name="lokasi_absensi" placeholder="Masukkan lokasi Anda" required>
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