@extends('layouts.app')

@section('title', 'Dokumen Pelamar')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5>Dokumen yang Diunggah oleh {{ $pelamar->nama_lengkap }}</h5>
            </div>
            <div class="card-body">
                @if($documents->isEmpty())
                    <p>Belum ada dokumen yang diunggah oleh pelamar ini.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis Dokumen</th>
                                <th>File</th>
                                <th>Tanggal Unggah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                                <tr>
                                    <td>{{ $document->document_type }}</td>
                                    <td><a href="{{ Storage::url($document->file_path) }}" target="_blank">Lihat Dokumen</a></td>
                                    <td>{{ $document->uploaded_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
