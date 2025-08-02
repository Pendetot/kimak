@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Personal Details</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 pt-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Nama Lengkap</p>
                          <p class="mb-0">{{ $karyawan->nama_lengkap }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">NIK</p>
                          <p class="mb-0">{{ $karyawan->nik }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">No Telepon</p>
                          <p class="mb-0">{{ $karyawan->no_telepon }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Jabatan</p>
                          <p class="mb-0">{{ $karyawan->jabatan }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Departemen</p>
                          <p class="mb-0">{{ $karyawan->departemen }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Status Karyawan</p>
                          <p class="mb-0">{{ $karyawan->status_karyawan }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Email</p>
                          <p class="mb-0">{{ $karyawan->email }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Tanggal Masuk</p>
                          <p class="mb-0">{{ $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->format('d/m/Y') : '-' }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Jenis Kontrak</p>
                          <p class="mb-0">{{ $karyawan->jenis_kontrak ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Gaji Pokok</p>
                          <p class="mb-0">Rp {{ number_format($karyawan->gaji_pokok ?? 0, 0, ',', '.') }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0 pb-0">
                      <p class="mb-1 text-muted">Alamat</p>
                      <p class="mb-0">{{ $karyawan->alamat ?? '-' }}</p>
                    </li>
                  </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('hrd.karyawans.edit', $karyawan->id) }}" class="btn btn-warning me-2">Edit</a>
                    <a href="{{ route('hrd.karyawans.index') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection