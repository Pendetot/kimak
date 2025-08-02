@extends('layouts.main')

@section('title', 'Detail Penalti SP')
@section('breadcrumb-item')
    <a href="{{ route('keuangan.penalti-sp.index') }}">Penalti SP</a>
    <span class="pc-micon"><i class="ph-duotone ph-caret-right"></i></span>
    Detail Penalti
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0">Detail Penalti Surat Peringatan</h5>
                    <small class="text-muted">ID Penalti: #{{ $penaltiSP->id }}</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('keuangan.penalti-sp.index') }}" class="btn btn-light btn-sm">
                        <i class="ph-duotone ph-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Penalty Information -->
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Penalti</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" style="width: 40%">Jumlah Penalti:</td>
                                        <td>
                                            <span class="f-w-600 text-danger">
                                                Rp {{ number_format($penaltiSP->jumlah_penalti, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Pencatatan:</td>
                                        <td class="f-w-500">{{ $penaltiSP->tanggal_pencatatan->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status Pembayaran:</td>
                                        <td>
                                            @if($penaltiSP->status_pembayaran == 'lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @elseif($penaltiSP->status_pembayaran == 'sebagian')
                                                <span class="badge bg-warning">Sebagian</span>
                                            @else
                                                <span class="badge bg-danger">Belum Lunas</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($penaltiSP->jumlah_dibayar > 0)
                                        <tr>
                                            <td class="text-muted">Jumlah Dibayar:</td>
                                            <td class="text-success f-w-500">
                                                Rp {{ number_format($penaltiSP->jumlah_dibayar, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Sisa Hutang:</td>
                                            <td class="text-danger f-w-500">
                                                Rp {{ number_format($penaltiSP->jumlah_penalti - $penaltiSP->jumlah_dibayar, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if($penaltiSP->tanggal_lunas)
                                        <tr>
                                            <td class="text-muted">Tanggal Lunas:</td>
                                            <td class="text-success f-w-500">{{ $penaltiSP->tanggal_lunas->format('d M Y') }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Information -->
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Karyawan</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $penaltiSP->karyawan->getPhotoUrl() }}" 
                                             alt="{{ $penaltiSP->karyawan->display_name }}" 
                                             class="img-fluid rounded-circle" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $penaltiSP->karyawan->display_name }}</h6>
                                        <small class="text-muted">{{ $penaltiSP->karyawan->nik }}</small>
                                        <br><small class="text-muted">{{ $penaltiSP->karyawan->jabatan }} - {{ $penaltiSP->karyawan->departemen }}</small>
                                    </div>
                                </div>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" style="width: 40%">Email:</td>
                                        <td>
                                            <a href="mailto:{{ $penaltiSP->karyawan->email }}" class="text-decoration-none">
                                                {{ $penaltiSP->karyawan->email }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">No. Telepon:</td>
                                        <td>
                                            @if($penaltiSP->karyawan->no_telepon)
                                                <a href="tel:{{ $penaltiSP->karyawan->no_telepon }}" class="text-decoration-none">
                                                    {{ $penaltiSP->karyawan->no_telepon }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status:</td>
                                        <td>
                                            <span class="badge {{ $penaltiSP->karyawan->status_karyawan->color() }}">
                                                {{ $penaltiSP->karyawan->status_karyawan->label() }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Warning Letter Information -->
                    <div class="col-12 mt-3">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Surat Peringatan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="text-muted" style="width: 40%">Jenis SP:</td>
                                                <td>
                                                    <span class="badge {{ $penaltiSP->suratPeringatan->jenis === 'SP3' ? 'bg-danger' : ($penaltiSP->suratPeringatan->jenis === 'SP2' ? 'bg-warning' : 'bg-info') }}">
                                                        {{ $penaltiSP->suratPeringatan->jenis }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tanggal SP:</td>
                                                <td class="f-w-500">{{ $penaltiSP->suratPeringatan->tanggal_sp->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Nomor SP:</td>
                                                <td>{{ $penaltiSP->suratPeringatan->nomor_sp ?: '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="text-muted" style="width: 40%">Status SP:</td>
                                                <td>
                                                    @switch($penaltiSP->suratPeringatan->status)
                                                        @case('aktif')
                                                            <span class="badge bg-success">Aktif</span>
                                                            @break
                                                        @case('selesai')
                                                            <span class="badge bg-secondary">Selesai</span>
                                                            @break
                                                        @case('dibatalkan')
                                                            <span class="badge bg-danger">Dibatalkan</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-warning">{{ ucfirst($penaltiSP->suratPeringatan->status) }}</span>
                                                    @endswitch
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Masa Berlaku:</td>
                                                <td>
                                                    @if($penaltiSP->suratPeringatan->tanggal_berakhir)
                                                        {{ $penaltiSP->suratPeringatan->tanggal_berakhir->format('d M Y') }}
                                                        @if($penaltiSP->suratPeringatan->tanggal_berakhir->isPast())
                                                            <small class="text-muted">(Expired)</small>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($penaltiSP->suratPeringatan->pelanggaran)
                                    <div class="mt-3">
                                        <h6 class="text-muted mb-2">Pelanggaran:</h6>
                                        <p class="mb-0 p-3 bg-light rounded">{{ $penaltiSP->suratPeringatan->pelanggaran }}</p>
                                    </div>
                                @endif

                                <div class="mt-3 d-flex justify-content-end">
                                    <a href="{{ route('hrd.surat-peringatans.show', $penaltiSP->suratPeringatan) }}" 
                                       class="btn btn-light-primary btn-sm">
                                        <i class="ph-duotone ph-eye me-2"></i>Lihat Detail SP
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment History -->
                    @if($penaltiSP->jumlah_dibayar > 0)
                        <div class="col-12 mt-3">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Riwayat Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        @if($penaltiSP->tanggal_lunas)
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-success"></div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-1 text-success">Pembayaran Lunas</h6>
                                                    <small class="text-muted">{{ $penaltiSP->tanggal_lunas->format('d M Y H:i') }}</small>
                                                    <div class="mt-1">
                                                        <span class="badge bg-light-success">
                                                            Rp {{ number_format($penaltiSP->jumlah_penalti, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-primary"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Penalti Dicatat</h6>
                                                <small class="text-muted">{{ $penaltiSP->tanggal_pencatatan->format('d M Y H:i') }}</small>
                                                <div class="mt-1">
                                                    <span class="badge bg-light-danger">
                                                        Rp {{ number_format($penaltiSP->jumlah_penalti, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Related Debts -->
                    @if($penaltiSP->karyawan->hutangKaryawan->where('asal_hutang', 'sp')->where('surat_peringatan_id', $penaltiSP->surat_peringatan_id)->count() > 0)
                        <div class="col-12 mt-3">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Hutang Terkait</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <th>Jumlah</th>
                                                    <th>Status</th>
                                                    <th>Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($penaltiSP->karyawan->hutangKaryawan->where('asal_hutang', 'sp')->where('surat_peringatan_id', $penaltiSP->surat_peringatan_id) as $hutang)
                                                    <tr>
                                                        <td>{{ $hutang->keterangan }}</td>
                                                        <td>Rp {{ number_format($hutang->jumlah, 0, ',', '.') }}</td>
                                                        <td>
                                                            <span class="badge {{ $hutang->status == 'lunas' ? 'bg-success' : 'bg-danger' }}">
                                                                {{ ucfirst($hutang->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $hutang->created_at->format('d M Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #e9ecef;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px currentColor;
}

.timeline-content {
    padding-left: 10px;
}
</style>
@endpush