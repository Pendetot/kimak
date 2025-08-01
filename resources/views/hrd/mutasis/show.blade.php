@extends('layouts.app')

@section('title', 'Detail Mutasi Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Mutasi Karyawan</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 pt-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Nama Karyawan</p>
                          <p class="mb-0">{{ $mutasi->karyawan->nama }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Tanggal Mutasi</p>
                          <p class="mb-0">{{ $mutasi->tanggal_mutasi->format('d M Y') }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Jabatan Lama</p>
                          <p class="mb-0">{{ $mutasi->jabatan_lama }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Jabatan Baru</p>
                          <p class="mb-0">{{ $mutasi->jabatan_baru }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0 pb-0">
                      <p class="mb-1 text-muted">Alasan Mutasi</p>
                      <p class="mb-0">{{ $mutasi->alasan }}</p>
                    </li>
                  </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('hrd.mutasi-karyawan') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
            
            {{-- Bagian Tambahan untuk Mutasi --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Informasi Tambahan Mutasi</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 pt-0">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="mb-1 text-muted">Data Personal Berubah</p>
                          <p class="mb-0">{{-- Tambahkan logika untuk status data personal berubah --}}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="mb-1 text-muted">Jaminan Seragam Mutasi</p>
                          <p class="mb-0">{{-- Tambahkan logika untuk status jaminan seragam mutasi --}}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0 pb-0">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="mb-1 text-muted">Seragam Mutasi</p>
                          <p class="mb-0">{{-- Tambahkan logika untuk status seragam mutasi --}}</p>
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