@extends('layouts.app')

@section('title', 'Daftar Pengajuan Resign')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pengajuan Resign</h5>
                    <div class="dropdown">
                        <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="material-icons-two-tone f-18">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('hrd.data-resign.create') }}">Tambah Pengajuan Resign</a>
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
                                    <th>Tanggal Pengajuan</th>
                                    <th>Tanggal Efektif</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resigns as $resign)
                                    <tr>
                                        <td>{{ $resign->karyawan->nama }}</td>
                                        <td>{{ $resign->tanggal_pengajuan->format('d M Y') }}</td>
                                        <td>{{ $resign->tanggal_efektif->format('d M Y') }}</td>
                                        <td>{{ ucfirst($resign->status->value) }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('hrd.data-resign.show', $resign->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @if($resign->status->value === 'pending')
                                                    <form action="{{ route('hrd.data-resign.approve', $resign->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn avtar avtar-xs btn-light-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui resign ini?')">
                                                            <i class="ti ti-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('hrd.data-resign.reject', $resign->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn avtar avtar-xs btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin menolak resign ini?')">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('hrd.data-resign.edit', $resign->id) }}" class="btn avtar avtar-xs btn-light-warning">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('hrd.data-resign.destroy', $resign->id) }}" method="POST" style="display: inline-block;">
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
                                @unless($resigns->count())
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Belum ada pengajuan resign.
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
