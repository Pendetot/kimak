@extends('layouts.app')

@section('title', 'Input Hasil PAT')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Input Hasil PAT untuk {{ $pelamar->nama_lengkap }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-pat-result', $pelamar->id) }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="score">Skor PAT:</label>
                            <input type="number" class="form-control" id="score" name="score" value="{{ old('score', $pelamar->patResult->score ?? '') }}" required>
                            @error('score')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="notes">Catatan:</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $pelamar->patResult->notes ?? '') }}</textarea>
                            @error('notes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Hasil PAT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
