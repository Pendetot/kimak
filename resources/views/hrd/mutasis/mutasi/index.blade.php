@extends('layouts.app')

@section('title', 'Daftar Mutasi Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Mutasi Karyawan</h5>
                    <div class="dropdown">
                        <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="material-icons-two-tone f-18">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('hrd.mutasi-karyawan.create') }}">Tambah Mutasi Baru</a>
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
                                    <th>Jabatan Lama</th>
                                    <th>Jabatan Baru</th>
                                    <th>Tanggal Mutasi</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mutasis as $mutasi)
                                    <tr>
                                        <td>{{ $mutasi->karyawan->nama }}</td>
                                        <td>{{ $mutasi->jabatan_lama }}</td>
                                        <td>{{ $mutasi->jabatan_baru }}</td>
                                        <td>{{ $mutasi->tanggal_mutasi->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('hrd.mutasi-karyawan.show', $mutasi->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('hrd.mutasi-karyawan.edit', $mutasi->id) }}" class="btn avtar avtar-xs btn-light-warning">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('hrd.mutasi-karyawan.destroy', $mutasi->id) }}" method="POST" style="display: inline-block;">
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
                                @unless($mutasis->count())
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Belum ada data mutasi.
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
