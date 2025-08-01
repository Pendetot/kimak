@extends('layouts.app')

@section('title', 'Edit KPI')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit KPI</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan.kpis.update', $kpi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="karyawan_id">Karyawan</label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}" {{ (old('karyawan_id', $kpi->karyawan_id) == $karyawan->id) ? 'selected' : '' }}>{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="periode">Periode</label>
                            <input type="text" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" value="{{ old('periode', $kpi->periode) }}" required>
                            @error('periode')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nilai_kpi">Nilai KPI</label>
                            <input type="number" name="nilai_kpi" id="nilai_kpi" class="form-control @error('nilai_kpi') is-invalid @enderror" value="{{ old('nilai_kpi', $kpi->nilai_kpi) }}" required>
                            @error('nilai_kpi')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="evaluasi">Evaluasi</label>
                            <textarea name="evaluasi" id="evaluasi" class="form-control @error('evaluasi') is-invalid @enderror" rows="3">{{ old('evaluasi', $kpi->evaluasi) }}</textarea>
                            @error('evaluasi')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('karyawan.kpis.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection