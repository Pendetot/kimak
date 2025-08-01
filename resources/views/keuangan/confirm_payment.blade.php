@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Konfirmasi Pembayaran untuk {{ $pelamar->nama_lengkap }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('keuangan.confirm_payment', $pelamar) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Bukti Pembayaran:</label>
                        <input type="file" name="payment_proof" id="payment_proof" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan:</label>
                        <textarea name="notes" id="notes" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection