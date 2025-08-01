@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Karyawan</h5>
                    
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
                                @foreach ($karyawans as $karyawan)
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block">
                                                    <h6 class="m-b-0">{{ $karyawan->nama }}</h6>
                                                    <p class="m-b-0">{{ $karyawan->jabatan }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($karyawan->status->value === 'aktif')
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> {{ $karyawan->status->value }}</p>
                                            @else
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> {{ $karyawan->status->value }}</p>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('hrd.data-karyawan.show', $karyawan->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('hrd.data-karyawan.edit', $karyawan->id) }}" class="btn avtar avtar-xs btn-light-warning">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('hrd.data-karyawan.destroy', $karyawan->id) }}" method="POST" style="display: inline-block;">
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