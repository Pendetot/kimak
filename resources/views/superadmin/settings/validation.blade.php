@extends('layouts.app')

@section('title', 'Pengaturan Validasi Pelamar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Pengaturan Validasi Pelamar</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('superadmin.settings.validation.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="min_height">Tinggi Minimum (cm)</label>
                            <input type="number" name="min_height" id="min_height" class="form-control" value="{{ $min_height->value ?? '' }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="max_weight_tolerance">Toleransi Berat Badan Maksimum (kg)</label>
                            <input type="number" name="max_weight_tolerance" id="max_weight_tolerance" class="form-control" value="{{ $max_weight_tolerance->value ?? '' }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="min_age">Usia Minimum</label>
                            <input type="number" name="min_age" id="min_age" class="form-control" value="{{ $min_age->value ?? '' }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="max_age">Usia Maksimum</label>
                            <input type="number" name="max_age" id="max_age" class="form-control" value="{{ $max_age->value ?? '' }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="required_education">Pendidikan Wajib</label>
                            <input type="text" name="required_education" id="required_education" class="form-control" value="{{ $required_education->value ?? '' }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="required_certifications">Sertifikasi Wajib (pisahkan dengan koma)</label>
                            <input type="text" name="required_certifications" id="required_certifications" class="form-control" value="{{ $required_certifications->value ?? '' }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection