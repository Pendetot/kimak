@extends('layouts.app')

@section('title', 'Detail Pengajuan Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Pengajuan Barang</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang:</label>
                        <p>{{ $pengajuanBarang->item_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah:</label>
                        <p>{{ $pengajuanBarang->quantity }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Logistik:</label>
                        <p>{{ $pengajuanBarang->notes ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <p>
                            @if ($pengajuanBarang->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($pengajuanBarang->status === 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($pengajuanBarang->status === 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Superadmin:</label>
                        <p>{{ $pengajuanBarang->superadmin_notes ?? '-' }}</p>
                    </div>
                    <a href="{{ route('logistik.pengajuan-barang.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
