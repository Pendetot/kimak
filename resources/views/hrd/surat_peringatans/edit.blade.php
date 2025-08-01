@extends('layouts.app')

@section('title', 'Edit Surat Peringatan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Surat Peringatan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('hrd.surat-peringatan.update', $suratPeringatan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="karyawan_id">Karyawan</label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror">
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}" {{ old('karyawan_id', $suratPeringatan->karyawan_id) == $karyawan->id ? 'selected' : '' }}>{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_sp">Jenis SP</label>
                            <select name="jenis_sp" id="jenis_sp" class="form-control @error('jenis_sp') is-invalid @enderror">
                                <option value="">Pilih Jenis SP</option>
                                @foreach (\App\Enums\JenisSPEnum::cases() as $jenisSp)
                                    <option value="{{ $jenisSp->value }}" {{ old('jenis_sp', $suratPeringatan->jenis_sp->value) == $jenisSp->value ? 'selected' : '' }}>{{ $jenisSp->value }}</option>
                                @endforeach
                            </select>
                            @error('jenis_sp')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                            <small class="form-text text-muted">
                                Rekomendasi: SP1, SP2, SP3.<br>
                                SP1: Penalti Rp 100.000 x 3 bulan (dicek dari keuangan).<br>
                                SP2: Penalti Rp 200.000 x 6 bulan (dicek dari keuangan).
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_sp">Tanggal SP</label>
                            <input type="date" name="tanggal_sp" id="tanggal_sp" class="form-control @error('tanggal_sp') is-invalid @enderror" value="{{ old('tanggal_sp', $suratPeringatan->tanggal_sp->format('Y-m-d')) }}">
                            @error('tanggal_sp')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $suratPeringatan->keterangan) }}</textarea>
                            @error('keterangan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('hrd.surat-peringatan') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection