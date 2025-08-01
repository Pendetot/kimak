@extends('layouts.app')

@section('title', 'Detail Pengajuan Barang & Approval')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Pengajuan Barang</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

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
                        <label class="form-label">Diajukan Oleh:</label>
                        <p>{{ $pengajuanBarang->requester->name ?? 'N/A' }}</p>
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
                    @if ($pengajuanBarang->status === 'approved' || $pengajuanBarang->status === 'rejected')
                        <div class="mb-3">
                            <label class="form-label">Catatan Superadmin:</label>
                            <p>{{ $pengajuanBarang->superadmin_notes ?? '-' }}</p>
                        </div>
                    @endif

                    @if ($pengajuanBarang->status === 'pending')
                        <hr>
                        <h5>Aksi Approval</h5>
                        <form action="{{ route('superadmin.pengajuan-barang-approval.approve', $pengajuanBarang->id) }}" method="POST" class="d-inline">
                            @csrf
                            <div class="mb-3">
                                <label for="superadmin_notes_approve" class="form-label">Catatan Approval (Opsional)</label>
                                <textarea class="form-control" id="superadmin_notes_approve" name="superadmin_notes" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success" onclick="return confirm('Setujui pengajuan ini?')">Setujui</button>
                        </form>
                        <form action="{{ route('superadmin.pengajuan-barang-approval.reject', $pengajuanBarang->id) }}" method="POST" class="d-inline ms-2">
                            @csrf
                            <div class="mb-3">
                                <label for="superadmin_notes_reject" class="form-label">Catatan Penolakan (Opsional)</label>
                                <textarea class="form-control" id="superadmin_notes_reject" name="superadmin_notes" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak pengajuan ini?')">Tolak</button>
                        </form>
                    @endif

                    <a href="{{ route('superadmin.pengajuan-barang-approval.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
