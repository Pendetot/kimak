@extends('layouts.app')

@section('title', 'Daftar Pengajuan Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pengajuan Barang</h5>
                    
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
                                    <th>Status</th>
                                    <th>Catatan Logistik</th>
                                    <th>Catatan Superadmin</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanBarangs as $pengajuan)
                                    <tr>
                                        <td>{{ $pengajuan->item_name }}</td>
                                        <td>{{ $pengajuan->quantity }}</td>
                                        <td>
                                            @if ($pengajuan->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($pengajuan->status === 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($pengajuan->status === 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $pengajuan->logistic_notes ?? '-' }}</td>
                                        <td>{{ $pengajuan->superadmin_notes ?? '-' }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('logistik.pengajuan-barang.show', $pengajuan->id) }}" class="btn avtar avtar-xs btn-light-info" title="Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @if ($pengajuan->status === 'pending')
                                                    <a href="{{ route('logistik.pengajuan-barang.edit', $pengajuan->id) }}" class="btn avtar avtar-xs btn-light-warning" title="Edit">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('logistik.pengajuan-barang.destroy', $pengajuan->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn avtar avtar-xs btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')" title="Hapus">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @unless(count($pengajuanBarangs))
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
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
