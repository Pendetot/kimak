@extends('layouts.app')

@section('title', 'Daftar Pengajuan Barang untuk Direktur')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pengajuan Barang untuk Persetujuan Direktur</h5>
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
                                    <th>ID Pengajuan</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Catatan HRD</th>
                                    <th>Status Logistik</th>
                                    <th>Catatan Logistik</th>
                                    <th>Status Direktur</th>
                                    <th>Catatan Direktur</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanBarangs as $pengajuanBarang)
                                    <tr>
                                        <td>{{ $pengajuanBarang->id }}</td>
                                        <td>{{ $pengajuanBarang->item_name }}</td>
                                        <td>{{ $pengajuanBarang->quantity }}</td>
                                        <td>{{ $pengajuanBarang->catatan ?? '-' }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $pengajuanBarang->logistic_status ?? '-')) }}</td>
                                        <td>{{ $pengajuanBarang->logistic_notes ?? '-' }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $pengajuanBarang->director_status ?? 'pending')) }}</td>
                                        <td>{{ $pengajuanBarang->director_notes ?? '-' }}</td>
                                        <td class="text-end">
                                            @if($pengajuanBarang->director_status == null)
                                                <form action="{{ route('superadmin.pengajuan-barang.approve', $pengajuanBarang->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="text" name="notes" class="form-control form-control-sm" placeholder="Catatan Direktur (opsional)">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">Setujui</button>
                                                    </div>
                                                </form>
                                                <form action="{{ route('superadmin.pengajuan-barang.reject', $pengajuanBarang->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="text" name="notes" class="form-control form-control-sm" placeholder="Alasan Penolakan" required>
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">Tolak</button>
                                                    </div>
                                                </form>
                                                <form action="{{ route('superadmin.pengajuan-barang.postpone', $pengajuanBarang->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="text" name="notes" class="form-control form-control-sm" placeholder="Alasan Penundaan" required>
                                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Apakah Anda yakin ingin menunda pengajuan ini?')">Tunda</button>
                                                    </div>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary">Sudah Diproses</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @unless(count($pengajuanBarangs))
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">
                                            Belum ada pengajuan barang untuk persetujuan direktur.
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