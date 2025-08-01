@extends('layouts.app')

@section('title', 'Detail Pengajuan Cuti')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Pengajuan Cuti</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 pt-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Nama Karyawan</p>
                          <p class="mb-0">{{ $cuti->karyawan->nama }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Jenis Cuti</p>
                          <p class="mb-0">{{ $cuti->jenis_cuti->value }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Tanggal Mulai</p>
                          <p class="mb-0">{{ $cuti->tanggal_mulai->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Tanggal Selesai</p>
                          <p class="mb-0">{{ $cuti->tanggal_selesai->format('d M Y') }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Alasan</p>
                          <p class="mb-0">{{ $cuti->alasan }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Status</p>
                          <p class="mb-0">{{ $cuti->status->value }}</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('hrd.pengajuan-cuti') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection