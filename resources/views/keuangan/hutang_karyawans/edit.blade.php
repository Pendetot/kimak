@extends('layouts.app')

@section('title', 'Edit Hutang Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Hutang Karyawan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('keuangan.hutang-karyawans.update', $hutangKaryawan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="karyawan_id">Karyawan</label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror">
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}" {{ old('karyawan_id', $hutangKaryawan->karyawan_id) == $karyawan->id ? 'selected' : '' }}>{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $hutangKaryawan->jumlah) }}" step="0.01">
                            @error('jumlah')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alasan">Alasan</label>
                            <textarea name="alasan" id="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="3">{{ old('alasan', $hutangKaryawan->alasan) }}</textarea>
                            @error('alasan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="asal_hutang">Asal Hutang</label>
                            <select name="asal_hutang" id="asal_hutang" class="form-control @error('asal_hutang') is-invalid @enderror">
                                <option value="">Pilih Asal Hutang</option>
                                @foreach (\App\Enums\AsalHutangEnum::cases() as $asalHutang)
                                    <option value="{{ $asalHutang->value }}" {{ old('asal_hutang', $hutangKaryawan->asal_hutang->value) == $asalHutang->value ? 'selected' : '' }}>{{ $asalHutang->value }}</option>
                                @endforeach
                            </select>
                            @error('asal_hutang')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="">Pilih Status</option>
                                @foreach (\App\Enums\StatusHutangEnum::cases() as $statusHutang)
                                    <option value="{{ $statusHutang->value }}" {{ old('status', $hutangKaryawan->status->value) == $statusHutang->value ? 'selected' : '' }}>{{ $statusHutang->value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('keuangan.hutang-karyawans.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection