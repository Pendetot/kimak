@extends('layouts.app')

@section('title', 'Detail Pengajuan Resign')

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
                          <p class="mb-0">{{ $resign->karyawan->nama }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">NIK</p>
                          <p class="mb-0">{{ $resign->karyawan->nik }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Alamat</p>
                          <p class="mb-0">{{ $resign->karyawan->alamat }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Penempatan</p>
                          <p class="mb-0">{{ $resign->karyawan->penempatan }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Jabatan</p>
                          <p class="mb-0">{{ $resign->karyawan->jabatan }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Lama Bekerja</p>
                          <p class="mb-0">{{ $tahunBekerja }} Tahun, {{ $bulanBekerja }} Bulan, {{ $hariBekerja }} Hari</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0 pb-0">
                      <p class="mb-1 text-muted">Alasan Resign</p>
                      <p class="mb-0">{{ $resign->alasan }}</p>
                    </li>
                  </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('hrd.data-resign') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Memo Resign</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 pt-0">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="mb-1 text-muted">Pengajuan Pengambilan Ijazah</p>
                          <p class="mb-0">{{-- Tambahkan logika untuk status pengajuan ijazah --}}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0 pb-0">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="mb-1 text-muted">Cek Hutang (sudah tercantum dari angsuran)</p>
                          <p class="mb-0">{{-- Tambahkan logika untuk status cek hutang --}}</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection