@extends('layouts.app')

@section('title', 'Detail Pembelian Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Pembelian Barang</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang:</label>
                        <p>{{ $pembelianBarang->item_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah:</label>
                        <p>{{ $pembelianBarang->quantity }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Logistik:</label>
                        <p>{{ $pembelianBarang->notes ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diajukan Oleh:</label>
                        <p>{{ $pembelianBarang->pengajuanBarang->requester->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pembelian:</label>
                        <p>
                            @if ($pembelianBarang->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($pembelianBarang->status === 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('superadmin.pembelian-barang.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
