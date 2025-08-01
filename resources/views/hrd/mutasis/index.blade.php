@extends('layouts.app')

@section('title', 'Manajemen Mutasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Mutasi Karyawan</h5>
                    
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
                                    <th>Tanggal Mutasi</th>
                                    <th>Data Personal Berubah</th>
                                    <th>Jaminan Seragam Mutasi</th>
                                    <th>Seragam Mutasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mutasis as $mutasi)
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block">
                                                    <h6 class="m-b-0">{{ $mutasi->karyawan->nama }}</h6>
                                                    <p class="m-b-0">{{ $mutasi->jabatan_lama }} -> {{ $mutasi->jabatan_baru }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0"><i class="ph-duotone ph-circle text-primary f-12"></i> {{ $mutasi->tanggal_mutasi->format('d M Y') }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">N/A</p> {{-- Placeholder for Data Personal Berubah --}}
                                        </td>
                                        <td>
                                            <p class="mb-0">N/A</p> {{-- Placeholder for Jaminan Seragam Mutasi --}}
                                        </td>
                                        <td>
                                            <p class="mb-0">N/A</p> {{-- Placeholder for Seragam Mutasi --}}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('hrd.mutasi-karyawan.edit', $mutasi->id) }}" class="btn avtar avtar-xs btn-light-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <button type="button" class="btn avtar avtar-xs btn-light-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-action="{{ route('hrd.mutasi-karyawan.destroy', $mutasi->id) }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
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