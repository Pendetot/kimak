@extends('layouts.app')

@section('title', 'Daftar Pengajuan Cuti')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pengajuan Cuti</h5>
                    <div class="dropdown">
                        <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="material-icons-two-tone f-18">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('hrd.pengajuan-cuti.create') }}">Tambah Pengajuan Cuti</a>
                        </div>
                    </div>
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
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jenis Cuti</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cutis as $cuti)
                                    <tr>
                                        <td>{{ $cuti->karyawan->nama }}</td>
                                        <td>{{ $cuti->tanggal_mulai->format('d M Y') }}</td>
                                        <td>{{ $cuti->tanggal_selesai->format('d M Y') }}</td>
                                        <td>{{ ucfirst($cuti->jenis_cuti->value) }}</td>
                                        <td>{{ ucfirst($cuti->status->value) }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('hrd.pengajuan-cuti.show', $cuti->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @if($cuti->status->value === 'pending')
                                                    <form action="{{ route('hrd.pengajuan-cuti.approve', $cuti->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn avtar avtar-xs btn-light-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui cuti ini?')">
                                                            <i class="ti ti-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('hrd.pengajuan-cuti.reject', $cuti->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn avtar avtar-xs btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin menolak cuti ini?')">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('hrd.pengajuan-cuti.edit', $cuti->id) }}" class="btn avtar avtar-xs btn-light-warning">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('hrd.pengajuan-cuti.destroy', $cuti->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn avtar avtar-xs btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @unless($cutis->count())
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            Belum ada pengajuan cuti.
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

@include('components.delete-confirmation-modal')
@endsection
