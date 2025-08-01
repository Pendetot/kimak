@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pelamar Dashboard</div>

                <div class="card-body">
                                        <p>Selamat datang di Dashboard Pelamar!</p>

                    <div class="card mt-4">
                        <div class="card-header">Status Kehadiran Wawancara</div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($pelamar)
                                <p>Status Anda saat ini: <strong>{{ $pelamar->interview_attendance_status }}</strong></p>

                                <form action="{{ route('pelamar.update-attendance', $pelamar->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" id="attendance_status">
                                    <button type="submit" class="btn btn-success" onclick="document.getElementById('attendance_status').value='hadir'">Hadir</button>
                                    <button type="submit" class="btn btn-danger ms-2" onclick="document.getElementById('attendance_status').value='tidak_hadir'">Tidak Hadir</button>
                                </form>
                            @else
                                <p>Data pelamar tidak ditemukan. Silakan hubungi administrator.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection