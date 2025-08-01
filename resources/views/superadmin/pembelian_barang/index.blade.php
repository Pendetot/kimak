@extends('layouts.app')

@section('title', 'Daftar Pembelian Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pembelian Barang</h5>
                </div>
                <div class="card-body py-2 px-0">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Diajukan Oleh</th>
                                    <th>Status Pembelian</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelianBarangs as $pembelian)
                                    <tr>
                                        <td>{{ $pembelian->item_name }}</td>
                                        <td>{{ $pembelian->quantity }}</td>
                                        <td>{{ $pembelian->pengajuanBarang->requester->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($pembelian->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($pembelian->status === 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('superadmin.pembelian-barang.show', $pembelian->id) }}" class="btn avtar avtar-xs btn-light-info" title="Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @unless(count($pembelianBarangs))
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Belum ada pembelian barang.
                                        </td>
                                    </tr>
                                @endunless
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection