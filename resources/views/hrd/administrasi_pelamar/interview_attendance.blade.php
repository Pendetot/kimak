@extends('layouts.app')

@section('title', 'Daftar Kehadiran Interview Pelamar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Daftar Kehadiran Interview Pelamar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Pelamar</th>
                                    <th>Tanggal Interview</th>
                                    <th>Status Kehadiran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pelamars as $pelamar)
                                    <tr>
                                        <td>{{ $pelamar->nama_lengkap }}</td>
                                        <td>{{ $pelamar->tanggal_interview ? \Carbon\Carbon::parse($pelamar->tanggal_interview)->format('d M Y') : 'N/A' }}</td>
                                        <td>
                                            @if($pelamar->interview_attendance_status === 'can_attend')
                                                <span class="badge bg-success">Bisa Hadir</span>
                                            @elseif($pelamar->interview_attendance_status === 'cannot_attend')
                                                <span class="badge bg-danger">Tidak Bisa Hadir</span>
                                            @else
                                                <span class="badge bg-warning">Belum Konfirmasi</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('hrd.administrasi-pelamar.show', $pelamar->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Tidak ada data kehadiran interview pelamar.
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