@extends('layouts.app')

@section('title', 'Edit Pelamar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pelamar</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('hrd.administrasi-pelamar.update', $pelamar->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $pelamar->nama_lengkap) }}">
                            @error('nama_lengkap')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $pelamar->email) }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $pelamar->telepon) }}">
                            @error('telepon')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $pelamar->alamat) }}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status_aplikasi">Status Aplikasi</label>
                            <input type="text" name="status_aplikasi" id="status_aplikasi" class="form-control @error('status_aplikasi') is-invalid @enderror" value="{{ old('status_aplikasi', $pelamar->status_aplikasi) }}">
                            @error('status_aplikasi')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_interview">Tanggal Interview</label>
                            <input type="date" name="tanggal_interview" id="tanggal_interview" class="form-control @error('tanggal_interview') is-invalid @enderror" value="{{ old('tanggal_interview', $pelamar->tanggal_interview ? $pelamar->tanggal_interview->format('Y-m-d') : '') }}">
                            @error('tanggal_interview')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="catatan_hrd">Catatan HRD</label>
                            <textarea name="catatan_hrd" id="catatan_hrd" class="form-control @error('catatan_hrd') is-invalid @enderror" rows="3">{{ old('catatan_hrd', $pelamar->catatan_hrd) }}</textarea>
                            @error('catatan_hrd')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('hrd.administrasi-pelamar.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection