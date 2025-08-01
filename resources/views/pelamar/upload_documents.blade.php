@extends('layouts.app')

@section('title', 'Unggah Dokumen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Unggah Dokumen untuk {{ $pelamar->nama_lengkap }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pelamar.upload-document', $pelamar->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="document_type" class="form-label">Jenis Dokumen:</label>
                        <input type="text" name="document_type" id="document_type" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="document_file" class="form-label">File Dokumen:</label>
                        <input type="file" name="document_file" id="document_file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Unggah Dokumen</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
