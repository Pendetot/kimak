@extends('layouts.app')

@section('title', 'Daftar Penalti SP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Penalti SP</h5>
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
                                    <th>Nama Karyawan</th>
                                    <th>Jenis SP</th>
                                    <th>Tanggal SP</th>
                                    <th>Jumlah Penalti</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suratPeringatans as $suratPeringatan)
                                    <tr>
                                        <td>{{ $suratPeringatan->user->name ?? 'N/A' }}</td>
                                        <td>{{ $suratPeringatan->jenis_sp }}</td>
                                        <td>{{ $suratPeringatan->tanggal_sp }}</td>
                                        <td>Rp {{ number_format($suratPeringatan->penalty_amount, 0, ',', '.') }}</td>
                                        <td>{{ $suratPeringatan->keterangan ?? '-' }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('keuangan.surat-peringatan.show', $suratPeringatan->id) }}" class="btn avtar avtar-xs btn-light-info" title="Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            Belum ada data penalti SP.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection