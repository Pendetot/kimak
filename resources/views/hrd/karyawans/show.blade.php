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
                          <p class="mb-0">{{ $karyawan->nama }}</p>
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
                          <p class="mb-1 text-muted">Telepon</p>
                          <p class="mb-0">{{ $karyawan->telepon }}</p>
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
                          <p class="mb-1 text-muted">Penempatan</p>
                          <p class="mb-0">{{ $karyawan->penempatan }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Status</p>
                          <p class="mb-0">{{ $karyawan->status->value }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0 pb-0">
                      <p class="mb-1 text-muted">Alamat</p>
                      <p class="mb-0">{{ $karyawan->alamat }}</p>
                    </li>
                  </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('hrd.data-karyawan') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection