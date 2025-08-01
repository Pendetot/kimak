@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Pengaturan Formulir Pendaftaran Pelamar</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_form_enabled" name="is_form_enabled" value="1" {{ $is_form_enabled->value === 'true' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_form_enabled">Aktifkan Formulir Pendaftaran Pelamar</label>
                        </div>

                        <hr>

                        <h5>Pengaturan Website</h5>
                        <div class="mb-3">
                            <label for="website_name" class="form-label">Nama Website</label>
                            <input type="text" class="form-control" id="website_name" name="website_name" value="{{ $website_name->value ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="website_description" class="form-label">Deskripsi Website</label>
                            <textarea class="form-control" id="website_description" name="website_description" rows="3">{{ $website_description->value ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="website_logo" class="form-label">Logo Website</label>
                            <input class="form-control" type="file" id="website_logo" name="website_logo">
                            @if($website_logo->value)
                                <img src="{{ asset('storage/' . $website_logo->value) }}" alt="Website Logo" class="img-thumbnail mt-2" style="max-width: 150px;">
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
