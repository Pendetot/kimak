@extends('layouts.app')

@section('title', 'Manajemen Cuti')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pengajuan Cuti</h5>
                    <div>
                        <a href="{{ route('hrd.pengajuan-cuti.download-template') }}" class="btn btn-outline-primary btn-sm me-2">
                            <i class="ti ti-download me-1"></i> Download Template
                        </a>
                        <a href="{{ route('hrd.forms.index') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-files me-1"></i> All Forms
                        </a>
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
                                @foreach ($cuti as $cutisItem)
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block">
                                                    <h6 class="m-b-0">{{ $cutisItem->karyawan->nama }}</h6>
                                                    <p class="m-b-0">{{ $cutisItem->jenis_cuti->value }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($cutisItem->status->value === 'pending')
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-warning f-12"></i> {{ $cutisItem->status->value }}</p>
                                            @elseif ($cutisItem->status->value === 'disetujui')
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> {{ $cutisItem->status->value }}</p>
                                            @else
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> {{ $cutisItem->status->value }}</p>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('hrd.pengajuan-cuti.show', $cutisItem->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                
                                                <a href="{{ route('hrd.pengajuan-cuti.generate-document', $cutisItem->id) }}" class="btn avtar avtar-xs btn-light-success" title="Generate Document">
                                                    <i class="ti ti-file-download"></i>
                                                </a>
                                                
                                                <form action="{{ route('hrd.pengajuan-cuti.destroy', $cutisItem->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn avtar avtar-xs btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @if ($cutisItem->status->value === 'pending')
                                                <form action="{{ route('hrd.pengajuan-cuti.approve', $cutisItem->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn avtar avtar-xs btn-light-success">
                                                        <i class="ti ti-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('hrd.pengajuan-cuti.reject', $cutisItem->id) }}" method="POST" style="display: inline-block;">
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