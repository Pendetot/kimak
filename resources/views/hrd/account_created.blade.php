@extends('layouts.main')

@section('title', 'Akun Berhasil Dibuat')

@section('breadcrumb-item', 'Manajemen Akun')

@section('breadcrumb-item-active', 'Akun Dibuat')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Akun {{ ucfirst($role) }} Berhasil Dibuat</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        Akun {{ ucfirst($role) }} dengan nama <strong>{{ $user->nama }}</strong> dan email <strong>{{ $user->email }}</strong> telah berhasil dibuat.
                    </div>
                    <p>Silakan gunakan detail berikut untuk login:</p>
                    <ul>
                        <li><strong>Kode Karyawan:</strong> {{ $karyawanCode }}</li>
                        <li><strong>Email:</strong> {{ $user->email }}</li>
                        <li><strong>Password:</strong> Password yang Anda masukkan saat pembuatan</li>
                        <li><strong>Link Login:</strong> <a href="{{ $loginLink }}">{{ $loginLink }}</a></li>
                    </ul>
                    <a href="{{ route('superadmin.' . $role . '.list') }}" class="btn btn-primary">Kembali ke Daftar {{ ucfirst($role) }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
