@extends('layouts.app')

@section('title', 'Konfirmasi Kehadiran Administrasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Konfirmasi Kehadiran Administrasi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pelamar.confirm_administration', $pelamar) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="attendance_status" class="form-label">Status Kehadiran:</label>
                        <select name="attendance_status" id="attendance_status" class="form-select">
                            <option value="hadir">Hadir</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="mb-3" id="reason_div" style="display: none;">
                        <label for="reason" class="form-label">Alasan Tidak Hadir:</label>
                        <textarea name="reason" id="reason" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('attendance_status').addEventListener('change', function () {
        if (this.value === 'tidak_hadir') {
            document.getElementById('reason_div').style.display = 'block';
        } else {
            document.getElementById('reason_div').style.display = 'none';
        }
    });
</script>
@endsection