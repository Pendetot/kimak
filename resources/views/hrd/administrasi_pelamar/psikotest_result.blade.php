@extends('layouts.app')

@section('title', 'Input Hasil Psikotest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Input Hasil Psikotest untuk {{ $pelamar->nama_lengkap }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-psikotest-result', $pelamar->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="scan_file">Scan Hasil Psikotest (PDF/Image):</label>
                            <input type="file" class="form-control" id="scan_file" name="scan_file" accept=".pdf,.jpg,.jpeg,.png" {{ $pelamar->psikotestResult ? '' : 'required' }}>
                            @error('scan_file')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @if($pelamar->psikotestResult && $pelamar->psikotestResult->scan_path)
                                <p class="mt-2">File saat ini: <a href="{{ Storage::url($pelamar->psikotestResult->scan_path) }}" target="_blank">Lihat File</a></p>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="conclusion">Kesimpulan:</label>
                            <textarea class="form-control" id="conclusion" name="conclusion" rows="5" required>{{ old('conclusion', $pelamar->psikotestResult->conclusion ?? '') }}</textarea>
                            @error('conclusion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Hasil Psikotest</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
