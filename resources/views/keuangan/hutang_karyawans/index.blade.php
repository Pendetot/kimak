@extends('layouts.app')

@section('title', 'Daftar Hutang Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Hutang Karyawan</h5>
                    <div class="dropdown">
                        <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="material-icons-two-tone f-18">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('keuangan.hutang-karyawans.create') }}">Tambah Hutang Baru</a>
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
                                    <th>Jumlah</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                    <th>Asal Hutang</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hutangKaryawans as $hutang)
                                    <tr>
                                        <td>{{ $hutang->karyawan ? $hutang->karyawan->nama : 'N/A' }}</td>
                                        <td>Rp {{ number_format($hutang->amount, 0, ',', '.') }}</td>
                                        <td>{{ $hutang->alasan }}</td>
                                        <td>{{ str_replace('_', ' ', ucfirst($hutang->status->value)) }}</td>
                                        <td>
                                            @if ($hutang->asal_hutang)
                                                @switch($hutang->asal_hutang->value)
                                                    @case('sp')
                                                        SP
                                                        @break
                                                    @case('pinjaman')
                                                        Pinjaman
                                                        @break
                                                    @default
                                                        {{ $hutang->asal_hutang->value }}
                                                @endswitch
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                @if($hutang->asal_hutang->value === 'sp' && $hutang->suratPeringatan && $hutang->suratPeringatan->id)
                                                    <a href="{{ route('keuangan.surat-peringatan.show', $hutang->suratPeringatan->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('keuangan.hutang-karyawans.show', $hutang->id) }}" class="btn avtar avtar-xs btn-light-info">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('keuangan.hutang-karyawans.edit', $hutang->id) }}" class="btn avtar avtar-xs btn-light-warning">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('keuangan.hutang-karyawans.destroy', $hutang->id) }}" method="POST" style="display: inline-block;">
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