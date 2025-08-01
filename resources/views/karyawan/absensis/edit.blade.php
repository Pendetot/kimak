@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Absensi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan.absensis.update', $absensi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="karyawan_id">Karyawan ID</label>
                            <input type="text" name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" value="{{ old('karyawan_id', $absensi->karyawan_id) }}" required>
                            @error('karyawan_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $absensi->tanggal) }}" required>
                            @error('tanggal')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="status_absensi">Status Absensi</label>
                            <select name="status_absensi" id="status_absensi" class="form-control @error('status_absensi') is-invalid @enderror" required>
                                <option value="hadir" {{ old('status_absensi', $absensi->status_absensi) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ old('status_absensi', $absensi->status_absensi) == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ old('status_absensi', $absensi->status_absensi) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ old('status_absensi', $absensi->status_absensi) == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                            @error('status_absensi')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                            @error('keterangan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('karyawan.absensis.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection