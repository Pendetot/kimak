@extends('layouts.app')

@section('title', 'Keputusan Akhir Pelamar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Keputusan Akhir untuk {{ $pelamar->nama_lengkap }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-final-decision', $pelamar->id) }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="final_decision">Keputusan Akhir:</label>
                            <select class="form-control" id="final_decision" name="final_decision" required>
                                <option value="">Pilih Keputusan</option>
                                <option value="MS" {{ (old('final_decision', $pelamar->final_decision ?? '') == 'MS') ? 'selected' : '' }}>Memenuhi Kualifikasi (MS)</option>
                                <option value="TMS" {{ (old('final_decision', $pelamar->final_decision ?? '') == 'TMS') ? 'selected' : '' }}>Tidak Memenuhi Kualifikasi (TMS)</option>
                            </select>
                            @error('final_decision')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="final_notes">Catatan Akhir:</label>
                            <textarea class="form-control" id="final_notes" name="final_notes" rows="3">{{ old('final_notes', $pelamar->final_notes ?? '') }}</textarea>
                            @error('final_notes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
