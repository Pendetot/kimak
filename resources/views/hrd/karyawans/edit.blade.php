@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Data Karyawan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('hrd.data-karyawan.update', $karyawan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $karyawan->nama) }}">
                            @error('nama')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $karyawan->nik) }}">
                            @error('nik')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $karyawan->alamat) }}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $karyawan->telepon) }}">
                            @error('telepon')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($roles as $roleValue => $roleName)
                                    <option value="{{ $roleValue }}" {{ old('jabatan', $karyawan->jabatan) == $roleValue ? 'selected' : '' }}>{{ $roleName }}</option>
                                @endforeach
                            </select>
                            @error('jabatan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="penempatan" class="form-label">Penempatan</label>
                            <input type="text" name="penempatan" id="penempatan" class="form-control @error('penempatan') is-invalid @enderror" value="{{ old('penempatan', $karyawan->penempatan) }}">
                            @error('penempatan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="">Pilih Status</option>
                                @foreach (\App\Enums\StatusKaryawanEnum::cases() as $statusKaryawan)
                                    <option value="{{ $statusKaryawan->value }}" {{ old('status', $karyawan->status->value) == $statusKaryawan->value ? 'selected' : '' }}>{{ $statusKaryawan->value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('hrd.data-karyawan') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection