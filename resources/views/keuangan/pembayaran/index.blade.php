@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Manajemen Pembayaran</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('keuangan.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pembayaran</li>
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
                                <h4 class="text-white">{{ $stats['total_payments'] }}</h4>
                                <h6 class="text-white m-b-0">Total Pembayaran</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-money f-28 text-white"></i>
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
                                <h4 class="text-white">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</h4>
                                <h6 class="text-white m-b-0">Total Nilai</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-currency-circle-dollar f-28 text-white"></i>
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
                                <h4 class="text-white">{{ $stats['pending_payments'] }}</h4>
                                <h6 class="text-white m-b-0">Pending</h6>
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
                                <h4 class="text-white">{{ $stats['completed_payments'] }}</h4>
                                <h6 class="text-white m-b-0">Selesai</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-check-circle f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Daftar Pembayaran</h5>
                        <a href="{{ route('keuangan.pembayaran.create') }}" class="btn btn-primary">
                            <i class="ph-duotone ph-plus me-1"></i>Tambah Pembayaran
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Cari</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama karyawan atau NIK..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-duotone ph-magnifying-glass me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('keuangan.pembayaran.index') }}" class="btn btn-outline-secondary">
                                        <i class="ph-duotone ph-arrow-clockwise me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Karyawan</th>
                                        <th>Jenis</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paginatedPayments as $payment)
                                    <tr>
                                        <td><span class="badge bg-light-secondary">{{ $payment['id'] }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-s bg-light-primary">
                                                        <i class="ph-duotone ph-user"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $payment['karyawan']->nama_lengkap ?? 'N/A' }}</h6>
                                                    <p class="text-muted f-12 mb-0">{{ $payment['karyawan']->nik ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-{{ $payment['type'] == 'hutang' ? 'warning' : 'info' }}">
                                                {{ ucfirst($payment['type']) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment['description'] }}</td>
                                        <td><strong>Rp {{ number_format($payment['amount'], 0, ',', '.') }}</strong></td>
                                        <td>
                                            @if($payment['status'] == 'lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @else
                                                <span class="badge bg-warning">Belum Lunas</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment['created_at']->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('keuangan.pembayaran.show', $payment['id']) }}" 
                                                   class="btn btn-outline-info btn-sm">
                                                    <i class="ph-duotone ph-eye"></i>
                                                </a>
                                                @if($payment['type'] == 'hutang' && $payment['status'] != 'lunas')
                                                <a href="{{ route('keuangan.pembayaran.edit', $payment['id']) }}" 
                                                   class="btn btn-outline-warning btn-sm">
                                                    <i class="ph-duotone ph-pencil"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="ph-duotone ph-folder-open f-48 text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data pembayaran</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($paginatedPayments->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $paginatedPayments->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh every 30 seconds for real-time updates
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            window.location.reload();
        }
    }, 30000);
</script>
@endpush