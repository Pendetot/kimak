@extends('layouts.app')

@section('title', 'Manajemen Resign')

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
                            <a class="dropdown-item" href="{{ route('hrd.data-resign.create') }}">Buat Pengajuan Resign Baru</a>
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
                            <tbody>
                                @foreach ($resigns as $resign)
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block">
                                                    <h6 class="m-b-0">{{ $resign->karyawan->nama }}</h6>
                                                    <p class="m-b-0">{{ $resign->tanggal_pengajuan ? $resign->tanggal_pengajuan->format('d M Y') : '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($resign->status->value === 'pending')
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-warning f-12"></i> {{ $resign->status->value }}</p>
                                            @elseif ($resign->status->value === 'disetujui')
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> {{ $resign->status->value }}</p>
                                            @else
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> {{ $resign->status->value }}</p>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('hrd.data-resign.show', $resign->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <form action="{{ route('hrd.data-resign.destroy', $resign->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn avtar avtar-xs btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @if ($resign->status->value === 'pending')
                                                <form action="{{ route('hrd.data-resign.approve', $resign->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn avtar avtar-xs btn-light-success">
                                                        <i class="ti ti-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('hrd.data-resign.reject', $resign->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn avtar avtar-xs btn-light-danger">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
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