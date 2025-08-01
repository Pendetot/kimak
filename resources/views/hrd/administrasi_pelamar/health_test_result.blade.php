@extends('layouts.app')

@section('title', 'Input Hasil Tes Kesehatan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Input Hasil Tes Kesehatan untuk {{ $pelamar->nama_lengkap }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-health-test-result', $pelamar->id) }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="result">Hasil Tes Kesehatan:</label>
                            <select class="form-control" id="result" name="result" required>
                                <option value="">Pilih Hasil</option>
                                <option value="fit" {{ (old('result', $pelamar->healthTestResult->result ?? '') == 'fit') ? 'selected' : '' }}>Fit</option>
                                <option value="unfit" {{ (old('result', $pelamar->healthTestResult->result ?? '') == 'unfit') ? 'selected' : '' }}>Unfit</option>
                                <option value="pending" {{ (old('result', $pelamar->healthTestResult->result ?? '') == 'pending') ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('result')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="notes">Catatan:</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $pelamar->healthTestResult->notes ?? '') }}</textarea>
                            @error('notes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Hasil Tes Kesehatan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
