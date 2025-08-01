@extends('layouts.app')

@section('title', 'Pengaturan Formulir Pendaftaran')

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

                    <form action="{{ route('superadmin.settings.form.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_form_enabled" name="is_form_enabled" value="1" {{ $is_form_enabled->value === 'true' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_form_enabled">Aktifkan Formulir Pendaftaran Pelamar</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection