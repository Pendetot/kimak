@extends('layouts.app')

@section('title', 'Konfirmasi Kehadiran Interview')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Konfirmasi Kehadiran Interview</h5>
            </div>
            <div class="card-body">
                <p>Halo {{ $pelamar->nama_lengkap }},</p>
                <p>Anda diundang untuk mengikuti interview pada:</p>
                <ul>
                    <li>Tanggal: {{ \Carbon\Carbon::parse($pelamar->tanggal_interview)->translatedFormat('l, d F Y') }}</li>
                    <li>Waktu: {{ $pelamar->waktu_interview }}</li>
                    <li>Via: {{ $pelamar->via_interview }}</li>
                </ul>
                <p>Mohon konfirmasi kehadiran Anda:</p>

                <form method="POST" action="{{ route('pelamar.confirm-interview', $pelamar->id) }}">
                    @csrf
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="attendance_status" id="confirmAttend" value="hadir" required>
                            <label class="form-check-label" for="confirmAttend">
                                Saya akan hadir
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="attendance_status" id="cannotAttend" value="tidak_hadir">
                            <label class="form-check-label" for="cannotAttend">
                                Saya tidak bisa hadir
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" id="reasonField" style="display: none;">
                        <label for="reason" class="form-label">Alasan tidak bisa hadir:</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cannotAttendRadio = document.getElementById('cannotAttend');
        const reasonField = document.getElementById('reasonField');

        cannotAttendRadio.addEventListener('change', function () {
            if (this.checked) {
                reasonField.style.display = 'block';
                reasonField.querySelector('textarea').setAttribute('required', 'required');
            } else {
                reasonField.style.display = 'none';
                reasonField.querySelector('textarea').removeAttribute('required');
            }
        });

        document.getElementById('confirmAttend').addEventListener('change', function () {
            if (this.checked) {
                reasonField.style.display = 'none';
                reasonField.querySelector('textarea').removeAttribute('required');
            }
        });
    });
</script>
@endsection