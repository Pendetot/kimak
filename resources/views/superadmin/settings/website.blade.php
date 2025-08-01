@extends('layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Pengaturan Website</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('superadmin.settings.website.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                        <div class="mb-3">
                            <label for="website_footer_description" class="form-label">Deskripsi Footer Website</label>
                            <textarea class="form-control" id="website_footer_description" name="website_footer_description" rows="3">{{ $website_footer_description->value ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="website_made_by_text" class="form-label">Teks "Made By" Footer</label>
                            <input type="text" class="form-control" id="website_made_by_text" name="website_made_by_text" value="{{ $website_made_by_text->value ?? '' }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection