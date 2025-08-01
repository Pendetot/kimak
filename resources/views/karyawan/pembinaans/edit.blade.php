@extends('layouts.app')

@section('title', 'Edit Pembinaan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pembinaan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan.pembinaans.update', $pembinaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="karyawan_id">Karyawan ID</label>
                            <input type="text" name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" value="{{ old('karyawan_id', $pembinaan->karyawan_id) }}" required>
                            @error('karyawan_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_pembinaan">Tanggal Pembinaan</label>
                            <input type="date" name="tanggal_pembinaan" id="tanggal_pembinaan" class="form-control @error('tanggal_pembinaan') is-invalid @enderror" value="{{ old('tanggal_pembinaan', $pembinaan->tanggal_pembinaan) }}" required>
                            @error('tanggal_pembinaan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="catatan">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan', $pembinaan->catatan) }}</textarea>
                            @error('catatan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="hasil">Hasil</label>
                            <input type="text" name="hasil" id="hasil" class="form-control @error('hasil') is-invalid @enderror" value="{{ old('hasil', $pembinaan->hasil) }}" required>
                            @error('hasil')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('karyawan.pembinaans.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection