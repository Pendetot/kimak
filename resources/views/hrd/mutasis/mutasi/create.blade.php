@extends('layouts.app')

@section('title', 'Buat Mutasi Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buat Mutasi Karyawan Baru</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('hrd.mutasi-karyawan.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="karyawan_id">Karyawan</label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror">
                                <option value="">Pilih Karyawan</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('karyawan_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="departemen_lama">Departemen Lama</label>
                            <input type="text" name="departemen_lama" id="departemen_lama" class="form-control @error('departemen_lama') is-invalid @enderror" value="{{ old('departemen_lama') }}">
                            @error('departemen_lama')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="departemen_baru">Departemen Baru</label>
                            <input type="text" name="departemen_baru" id="departemen_baru" class="form-control @error('departemen_baru') is-invalid @enderror" value="{{ old('departemen_baru') }}">
                            @error('departemen_baru')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="jabatan_lama">Jabatan Lama</label>
                            <input type="text" name="jabatan_lama" id="jabatan_lama" class="form-control @error('jabatan_lama') is-invalid @enderror" value="{{ old('jabatan_lama') }}">
                            @error('jabatan_lama')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="jabatan_baru">Jabatan Baru</label>
                            <input type="text" name="jabatan_baru" id="jabatan_baru" class="form-control @error('jabatan_baru') is-invalid @enderror" value="{{ old('jabatan_baru') }}">
                            @error('jabatan_baru')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="alasan">Alasan</label>
                            <textarea name="alasan" id="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="3">{{ old('alasan') }}</textarea>
                            @error('alasan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_mutasi">Tanggal Mutasi</label>
                            <input type="date" name="tanggal_mutasi" id="tanggal_mutasi" class="form-control @error('tanggal_mutasi') is-invalid @enderror" value="{{ old('tanggal_mutasi') }}">
                            @error('tanggal_mutasi')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('hrd.mutasi-karyawan.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
