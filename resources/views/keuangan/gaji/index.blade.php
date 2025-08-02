@extends('layouts.app')

@section('title', 'Manajemen Gaji')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Manajemen Gaji</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('keuangan.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Gaji</li>
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
                                <h4 class="text-white">Rp {{ number_format($stats['total_gaji'], 0, ',', '.') }}</h4>
                                <h6 class="text-white m-b-0">Total Gaji</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-currency-circle-dollar f-28 text-white"></i>
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
                                <h4 class="text-white">Rp {{ number_format($stats['gaji_bulan_ini'], 0, ',', '.') }}</h4>
                                <h6 class="text-white m-b-0">Bulan Ini</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-calendar f-28 text-white"></i>
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
                                <h4 class="text-white">{{ $stats['karyawan_dibayar'] }}</h4>
                                <h6 class="text-white m-b-0">Dibayar</h6>
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
                                <h4 class="text-white">{{ $stats['pending_approval'] }}</h4>
                                <h6 class="text-white m-b-0">Pending</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-clock f-28 text-white"></i>
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
                        <h5>Daftar Gaji Karyawan</h5>
                        <a href="{{ route('keuangan.gaji.create') }}" class="btn btn-primary">
                            <i class="ph-duotone ph-plus me-1"></i>Hitung Gaji
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Cari Karyawan</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama atau NIK..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Karyawan</label>
                                <select name="karyawan_id" class="form-select">
                                    <option value="">Semua</option>
                                    @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}" {{ request('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                            {{ $karyawan->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" class="form-select">
                                    <option value="">Semua</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tahun</label>
                                <select name="tahun" class="form-select">
                                    <option value="">Semua</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-1">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="ph-duotone ph-magnifying-glass"></i>
                                    </button>
                                    <a href="{{ route('keuangan.gaji.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="ph-duotone ph-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th>Karyawan</th>
                                        <th>Gaji Pokok</th>
                                        <th>Tunjangan</th>
                                        <th>Potongan</th>
                                        <th>Total Gaji</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gajis as $gaji)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-info me-2">
                                                    <i class="ph-duotone ph-calendar-check"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $gaji->periode_bulan_formatted }}</h6>
                                                    <p class="text-muted f-12 mb-0">{{ $gaji->periode_bulan->format('M Y') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-s bg-light-primary">
                                                        <i class="ph-duotone ph-user"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $gaji->karyawan->nama_lengkap }}</h6>
                                                    <p class="text-muted f-12 mb-0">{{ $gaji->karyawan->nik }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><strong>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <span class="text-success">+Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}</span>
                                            @if($gaji->upah_lembur > 0)
                                                <br><small class="text-muted">Lembur: {{ $gaji->lembur_jam }}h</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($gaji->total_potongan > 0)
                                                <span class="text-danger">-Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td><strong class="text-primary">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <span class="{{ $gaji->status_badge }}">{{ $gaji->status_text }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('keuangan.gaji.show', $gaji->id) }}" 
                                                   class="btn btn-outline-info btn-sm" title="Detail">
                                                    <i class="ph-duotone ph-eye"></i>
                                                </a>
                                                @if($gaji->canBeEdited())
                                                <a href="{{ route('keuangan.gaji.edit', $gaji->id) }}" 
                                                   class="btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="ph-duotone ph-pencil"></i>
                                                </a>
                                                @endif
                                                @if($gaji->status === 'pending')
                                                <button type="button" class="btn btn-outline-success btn-sm" 
                                                        onclick="processPayment({{ $gaji->id }})" title="Proses Pembayaran">
                                                    <i class="ph-duotone ph-check-circle"></i>
                                                </button>
                                                @endif
                                                @if($gaji->status === 'dibayar')
                                                <a href="{{ route('keuangan.gaji.generateSlip', $gaji->id) }}" 
                                                   class="btn btn-outline-secondary btn-sm" title="Download Slip">
                                                    <i class="ph-duotone ph-download"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="ph-duotone ph-folder-open f-48 text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data gaji</p>
                                            <a href="{{ route('keuangan.gaji.create') }}" class="btn btn-primary">
                                                <i class="ph-duotone ph-plus me-1"></i>Hitung Gaji Pertama
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($gajis->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $gajis->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Process Payment Modal -->
<div class="modal fade" id="processPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proses Pembayaran Gaji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="processPaymentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pembayaran</label>
                        <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="">Pilih Metode</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cash">Cash</option>
                            <option value="check">Cek/Giro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Referensi</label>
                        <input type="text" name="nomor_referensi" class="form-control" placeholder="Nomor bukti transfer/cek">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Pembayaran</label>
                        <textarea name="catatan_pembayaran" class="form-control" rows="3" placeholder="Catatan tambahan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ph-duotone ph-check me-1"></i>Proses Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function processPayment(gajiId) {
        const modal = new bootstrap.Modal(document.getElementById('processPaymentModal'));
        const form = document.getElementById('processPaymentForm');
        form.action = '{{ route("keuangan.gaji.process", ":id") }}'.replace(':id', gajiId);
        modal.show();
    }

    // Auto-refresh every 30 seconds
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            window.location.reload();
        }
    }, 30000);
</script>
@endpush