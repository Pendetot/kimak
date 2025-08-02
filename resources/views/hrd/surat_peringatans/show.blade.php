@extends('layouts.app')

@section('title', 'Detail Surat Peringatan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Surat Peringatan</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 pt-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Nama Karyawan</p>
                          <p class="mb-0">{{ $suratPeringatan->karyawan ? $suratPeringatan->karyawan->nama_lengkap : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Jenis SP</p>
                          <p class="mb-0">{{ ucfirst($suratPeringatan->jenis_sp->value) }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Tanggal SP</p>
                          <p class="mb-0">{{ $suratPeringatan->tanggal_sp->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Keterangan</p>
                          <p class="mb-0">{{ $suratPeringatan->keterangan }}</p>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item px-0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Nilai Potongan</p>
                          <p class="mb-0">Rp {{ number_format($suratPeringatan->penalty_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1 text-muted">Bulan Potongan</p>
                          <p class="mb-0">{{ $penaltyMonths }} Bulan</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('hrd.surat-peringatans.edit', $suratPeringatan->id) }}" class="btn btn-warning me-2">Edit</a>
                    <a href="{{ route('hrd.surat-peringatans.index') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h5>Riwayat Surat Peringatan</h5>
                </div>
                <div class="card-body py-2 px-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Jenis SP</th>
                                    <th>Tanggal SP</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($historySuratPeringatan as $historySp)
                                    <tr>
                                        <td>{{ ucfirst($historySp->jenis_sp->value) }}</td>
                                        <td>{{ $historySp->tanggal_sp->format('d M Y') }}</td>
                                        <td>{{ $historySp->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            Tidak ada riwayat surat peringatan untuk karyawan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection