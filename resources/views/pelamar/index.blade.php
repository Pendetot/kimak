@extends('layouts.app')

@section('title', 'Daftar Pelamar')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5>Daftar Pelamar</h5>
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
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No. Whatsapp</th>
                                <th>Posisi Dilamar</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelamars as $pelamar)
                                <tr>
                                    <td>{{ $pelamar->nama_lengkap }}</td>
                                    <td>{{ $pelamar->email }}</td>
                                    <td>{{ $pelamar->no_whatsapp }}</td>
                                    <td>{{ $pelamar->jenis_jabatan_pekerjaan }}</td>
                                    <td>{{ ucfirst($pelamar->status) }}</td>
                                    <td class="text-end">
                                        <div class="d-inline-flex">
                                            <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                <i class="ti ti-search"></i>
                                            </a>
                                            <a href="{{ route('pelamar.dashboard', $pelamar->id) }}" class="btn avtar avtar-xs btn-light-primary">
                                                <i class="ti ti-dashboard"></i>
                                            </a>
                                            <form action="{{ route('hrd.administrasi-pelamar.approve', $pelamar->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn avtar avtar-xs btn-light-success" onclick="return confirm('Apakah Anda yakin ingin menerima pelamar ini?')">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('hrd.administrasi-pelamar.reject', $pelamar->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn avtar avtar-xs btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pelamar ini?')">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @unless(count($pelamars))
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Belum ada pelamar.
                                    </td>
                                </tr>
                            @endunless
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@include('components.delete-confirmation-modal')
@endsection