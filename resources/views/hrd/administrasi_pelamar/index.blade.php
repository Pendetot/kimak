@extends('layouts.app')

@section('title', 'Daftar Pelamar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pelamar</h5>
                    <div class="d-flex align-items-center">
                        <form action="{{ route('hrd.administrasi-pelamar') }}" method="GET" class="me-3">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Pelamar</option>
                                <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="tidak_hadir" {{ request('status') == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                            </select>
                        </form>
                        
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
                                    <th>Detail Pelamar</th>
                                    <th>Pekerjaan & Lokasi</th>
                                    <th>Identitas</th>
                                    <th>Lain-lain</th>
                                    <th>Status</th>
                                    <th>Status Kehadiran</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelamars as $pelamar)
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block">
                                                    <h6 class="m-b-0">{{ $pelamar->user->name ?? 'N/A' }}</h6>
                                                    <p class="m-b-0 text-muted">{{ $pelamar->email }}</p>
                                                    <p class="m-b-0 text-muted">{{ $pelamar->no_whatsapp }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="m-b-0 text-muted">{{ $pelamar->jenis_jabatan_pekerjaan }}</p>
                                            <p class="m-b-0 text-muted">{{ $pelamar->lokasi_penempatan_diinginkan }}</p>
                                        </td>
                                        <td>
                                            <p class="m-b-0 text-muted">KTP: {{ $pelamar->no_ktp }}</p>
                                            <p class="m-b-0 text-muted">Warga Negara: {{ $pelamar->warga_negara }}</p>
                                            <p class="m-b-0 text-muted">Agama: {{ $pelamar->agama }}</p>
                                        </td>
                                        <td>
                                            <p class="m-b-0 text-muted">Referensi: {{ $pelamar->reference_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            @if ($pelamar->status === 'pending')
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-warning f-12"></i> {{ $pelamar->status }}</p>
                                            @elseif ($pelamar->status === 'diterima')
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> {{ $pelamar->status }}</p>
                                            @else
                                                <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> {{ $pelamar->status }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pelamar->status === 'ditolak')
                                                <p class="mb-0"><i class="ph-duotone ph-x-circle text-danger f-12"></i> -</p>
                                            @elseif ($pelamar->status === 'pending')
                                                <p class="mb-0"><i class="ph-duotone ph-info text-info f-12"></i> -</p>
                                            @else
                                                @if ($pelamar->interview_attendance_status === 'hadir')
                                                    <p class="mb-0"><i class="ph-duotone ph-check-circle text-success f-12"></i> Hadir</p>
                                                @elseif ($pelamar->interview_attendance_status === 'tidak_hadir')
                                                    <p class="mb-0"><i class="ph-duotone ph-x-circle text-danger f-12"></i> Tidak Hadir</p>
                                                @else
                                                    <p class="mb-0"><i class="ph-duotone ph-info text-info f-12"></i> Belum Konfirmasi</p>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @if($pelamar->status == 'pending')
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
                                                @endif
                                                @if($pelamar->interview_attendance_status == 'hadir')
                                                    <a href="{{ route('hrd.administrasi-pelamar.show-interview-form', $pelamar->id) }}" class="btn avtar avtar-xs btn-light-primary" title="Input Hasil Interview">
                                                        <i class="ti ti-microphone"></i>
                                                    </a>
                                                    <a href="{{ route('hrd.administrasi-pelamar.show-pat-form', $pelamar->id) }}" class="btn avtar avtar-xs btn-light-secondary" title="Input Hasil PAT">
                                                        <i class="ti ti-file-text"></i>
                                                    </a>
                                                    <a href="{{ route('hrd.administrasi-pelamar.show-psikotest-form', $pelamar->id) }}" class="btn avtar avtar-xs btn-light-warning" title="Input Hasil Psikotes">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                    <a href="{{ route('hrd.administrasi-pelamar.show-health-test-form', $pelamar->id) }}" class="btn avtar avtar-xs btn-light-danger" title="Input Hasil Tes Kesehatan">
                                                        <i class="ti ti-heartbeat"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('hrd.administrasi-pelamar.destroy', $pelamar->id) }}" method="POST" style="display: inline-block;">
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
                                @unless(count($pelamars))
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
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
    </div>
</div>

@include('components.delete-confirmation-modal')
@endsection