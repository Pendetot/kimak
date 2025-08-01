@extends('layouts.app')

@section('title', 'Edit Laporan Dokumen')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Laporan Dokumen</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan.lap-dokumens.update', $lapDokumen->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="karyawan_id">Karyawan ID</label>
                            <input type="text" name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" value="{{ old('karyawan_id', $lapDokumen->karyawan_id) }}" required>
                            @error('karyawan_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_dokumen">Nama Dokumen</label>
                            <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control @error('nama_dokumen') is-invalid @enderror" value="{{ old('nama_dokumen', $lapDokumen->nama_dokumen) }}" required>
                            @error('nama_dokumen')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="file_path">File Path</label>
                            <input type="text" name="file_path" id="file_path" class="form-control @error('file_path') is-invalid @enderror" value="{{ old('file_path', $lapDokumen->file_path) }}" required>
                            @error('file_path')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('karyawan.lap-dokumens.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection