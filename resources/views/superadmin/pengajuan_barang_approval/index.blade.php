@extends('layouts.app')

@section('title', 'Daftar Pengajuan Barang untuk Approval')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pengajuan Barang untuk Approval</h5>
                </div>
                <div class="card-body py-2 px-0">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Diajukan Oleh</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanBarangs as $pengajuan)
                                    <tr>
                                        <td>{{ $pengajuan->item_name }}</td>
                                        <td>{{ $pengajuan->quantity }}</td>
                                        <td>{{ $pengajuan->requester->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($pengajuan->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($pengajuan->status === 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($pengajuan->status === 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('superadmin.pengajuan-barang-approval.show', $pengajuan->id) }}" class="btn avtar avtar-xs btn-light-info" title="Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @unless(count($pengajuanBarangs))
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Belum ada pengajuan barang.
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
