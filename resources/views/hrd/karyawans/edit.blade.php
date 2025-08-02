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
                    <form action="{{ route('hrd.karyawans.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}">
                            @error('nama_lengkap')
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
                            <label for="no_telepon" class="form-label">No Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon', $karyawan->no_telepon) }}">
                            @error('no_telepon')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $karyawan->email) }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatanList as $roleValue => $roleName)
                                    <option value="{{ $roleValue }}" {{ old('jabatan', $karyawan->jabatan) == $roleValue ? 'selected' : '' }}>{{ $roleName }}</option>
                                @endforeach
                            </select>
                            @error('jabatan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="departemen" class="form-label">Departemen</label>
                            <select name="departemen" id="departemen" class="form-control @error('departemen') is-invalid @enderror">
                                <option value="">Pilih Departemen</option>
                                <option value="HRD" {{ old('departemen', $karyawan->departemen) == 'HRD' ? 'selected' : '' }}>HRD</option>
                                <option value="Keuangan" {{ old('departemen', $karyawan->departemen) == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                <option value="Logistik" {{ old('departemen', $karyawan->departemen) == 'Logistik' ? 'selected' : '' }}>Logistik</option>
                                <option value="Operasional" {{ old('departemen', $karyawan->departemen) == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                                <option value="IT" {{ old('departemen', $karyawan->departemen) == 'IT' ? 'selected' : '' }}>IT</option>
                            </select>
                            @error('departemen')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status_karyawan" class="form-label">Status Karyawan</label>
                            <select name="status_karyawan" id="status_karyawan" class="form-control @error('status_karyawan') is-invalid @enderror">
                                <option value="">Pilih Status</option>
                                @foreach (\App\Enums\StatusKaryawanEnum::cases() as $statusKaryawan)
                                    <option value="{{ $statusKaryawan->value }}" {{ old('status_karyawan', $karyawan->status_karyawan) == $statusKaryawan->value ? 'selected' : '' }}>{{ $statusKaryawan->value }}</option>
                                @endforeach
                            </select>
                            @error('status_karyawan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control @error('gaji_pokok') is-invalid @enderror" value="{{ old('gaji_pokok', $karyawan->gaji_pokok) }}">
                            @error('gaji_pokok')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('hrd.karyawans.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection