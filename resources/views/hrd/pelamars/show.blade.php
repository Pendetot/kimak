@extends('layouts.app')

@section('title', 'Detail Pelamar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Pelamar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $pelamar->nama_lengkap }}</p>
                            <p><strong>NIK:</strong> {{ $pelamar->nik }}</p>
                            <p><strong>No KK:</strong> {{ $pelamar->no_kk }}</p>
                            <p><strong>Alamat:</strong> {{ $pelamar->alamat }}</p>
                            <p><strong>Telepon:</strong> {{ $pelamar->telepon }}</p>
                            <p><strong>Email:</strong> {{ $pelamar->email }}</p>
                            <p><strong>Pengalaman:</strong> {{ $pelamar->pengalaman }}</p>
                            <p><strong>Penempatan:</strong> {{ $pelamar->penempatan }}</p>
                            <p><strong>Nama PT:</strong> {{ $pelamar->nama_pt }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Foto Formal:</strong></p>
                            <img src="{{ Storage::url($pelamar->foto_formal) }}" alt="Foto Formal" class="img-fluid">
                            <p><strong>Ijazah SMA:</strong></p>
                            <a href="{{ Storage::url($pelamar->ijazah_sma) }}" target="_blank">Lihat Ijazah</a>
                            @if($pelamar->ijazah_gp)
                            <p><strong>Ijazah GP:</strong></p>
                            <a href="{{ Storage::url($pelamar->ijazah_gp) }}" target="_blank">Lihat Ijazah</a>
                            @endif
                            @if($pelamar->sertifikat_lsp)
                            <p><strong>Sertifikat LSP:</strong></p>
                            <a href="{{ Storage::url($pelamar->sertifikat_lsp) }}" target="_blank">Lihat Sertifikat</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection