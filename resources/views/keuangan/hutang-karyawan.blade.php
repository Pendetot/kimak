@extends('layouts.app')

@section('title', 'Daftar Hutang Karyawan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Hutang Karyawan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                                                <th>Cicilan</th>
                                <th>Asal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hutangKaryawans as $hutang)
                            <tr>
                                <td>{{ $hutang->karyawan->nama ?? 'N/A' }}</td>
                                <td>{{ $hutang->tanggal_hutang }}</td>
                                <td>{{ $hutang->jumlah }}</td>
                                <td>{{ $hutang->alasan }}</td>
                                <td>{{ $hutang->asal_hutang->value }}</td>
                                <td>{{ $hutang->status->value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection