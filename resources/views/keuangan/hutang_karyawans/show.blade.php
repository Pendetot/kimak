@extends('layouts.app')

@section('title', 'Detail Hutang Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Hutang Karyawan</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama Karyawan:</strong> {{ $hutangKaryawan->karyawan->nama ?? 'N/A' }}</p>
                    <p><strong>Jumlah:</strong> Rp {{ number_format($hutangKaryawan->amount, 0, ',', '.') }}</p>
                    <p><strong>Tanggal Pinjam:</strong> {{ $hutangKaryawan->tanggal_pinjam->format('d M Y') }}</p>
                    <p><strong>Tanggal Kembali:</strong> {{ $hutangKaryawan->tanggal_kembali ? $hutangKaryawan->tanggal_kembali->format('d M Y') : '-' }}</p>
                    <p><strong>Status:</strong> {{ str_replace('_', ' ', ucfirst($hutangKaryawan->status->value)) }}</p>
                    <p><strong>Asal Hutang:</strong>
                        @if ($hutangKaryawan->asal_hutang)
                            @switch($hutangKaryawan->asal_hutang->value)
                                @case('sp')
                                    SP
                                    @break
                                @case('pinjaman')
                                    Pinjaman
                                    @break
                                @case('surat_peringatan')
                                    Surat Peringatan
                                    @break
                                @default
                                    {{ $hutangKaryawan->asal_hutang->value }}
                            @endswitch
                        @else
                            -
                        @endif
                    </p>
                    <p><strong>Keterangan:</strong> {{ $hutangKaryawan->keterangan ?? '-' }}</p>

                    @if($hutangKaryawan->asal_hutang && $hutangKaryawan->asal_hutang->value === 'sp' && $hutangKaryawan->suratPeringatan)
                        <h6>Detail Surat Peringatan Terkait:</h6>
                        <p><strong>Jenis SP:</strong> {{ $hutangKaryawan->suratPeringatan->jenis_sp->value }}</p>
                        <p><strong>Tanggal SP:</strong> {{ $hutangKaryawan->suratPeringatan->tanggal_sp->format('d M Y') }}</p>
                        <p><strong>Alasan SP:</strong> {{ $hutangKaryawan->suratPeringatan->alasan ?? '-' }}</p>
                        <p><strong>Tindakan SP:</strong> {{ $hutangKaryawan->suratPeringatan->tindakan ?? '-' }}</p>
                    @endif

                    <a href="{{ route('keuangan.hutang-karyawans.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection