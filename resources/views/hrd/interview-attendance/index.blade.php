@extends('layouts.app')

@section('title', 'Kehadiran Interview')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Kehadiran Interview</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('hrd.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Interview Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="card bg-primary-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">{{ $stats['total_interviews'] }}</h4>
                                <h6 class="text-white m-b-0">Total Interview</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-users-three f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-warning-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">{{ $stats['scheduled_today'] }}</h4>
                                <h6 class="text-white m-b-0">Hari Ini</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-calendar-check f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-success-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">{{ $stats['attended'] }}</h4>
                                <h6 class="text-white m-b-0">Hadir</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-check-circle f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-danger-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">{{ $stats['absent'] }}</h4>
                                <h6 class="text-white m-b-0">Tidak Hadir</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-x-circle f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">Manajemen Interview</h6>
                                <p class="text-muted mb-0">Kelola jadwal dan kehadiran interview kandidat</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('hrd.interview-attendance.create') }}" class="btn btn-primary">
                                    <i class="ph-duotone ph-plus me-1"></i>Jadwalkan Interview
                                </a>
                                <button type="button" class="btn btn-outline-success" onclick="bulkAttendance()">
                                    <i class="ph-duotone ph-check-square me-1"></i>Bulk Kehadiran
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="sendReminders()">
                                    <i class="ph-duotone ph-bell me-1"></i>Kirim Reminder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Daftar Interview</h5>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Cari Kandidat</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama atau email kandidat..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                    <option value="attended" {{ request('status') == 'attended' ? 'selected' : '' }}>Hadir</option>
                                    <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Dijadwal Ulang</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Posisi</label>
                                <select name="posisi" class="form-select">
                                    <option value="">Semua</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position }}" {{ request('posisi') == $position ? 'selected' : '' }}>
                                            {{ $position }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-duotone ph-magnifying-glass me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('hrd.interview-attendance.index') }}" class="btn btn-outline-secondary">
                                        <i class="ph-duotone ph-arrow-clockwise me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </div>
                                        </th>
                                        <th>Kandidat</th>
                                        <th>Posisi</th>
                                        <th>Jadwal</th>
                                        <th>Interviewer</th>
                                        <th>Status</th>
                                        <th>Hasil</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($interviews as $interview)
                                    <tr class="{{ $interview->isToday() ? 'table-warning' : '' }}">
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input interview-checkbox" value="{{ $interview->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    @if($interview->pelamar->foto)
                                                        <img src="{{ $interview->pelamar->foto_url }}" alt="Foto" 
                                                             class="avtar avtar-s" style="object-fit: cover;">
                                                    @else
                                                        <div class="avtar avtar-s bg-light-primary">
                                                            <i class="ph-duotone ph-user"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $interview->pelamar->nama_lengkap }}</h6>
                                                    <p class="text-muted f-12 mb-0">{{ $interview->pelamar->email }}</p>
                                                    <p class="text-muted f-12 mb-0">{{ $interview->pelamar->no_telepon }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-0">{{ $interview->pelamar->posisi_dilamar }}</h6>
                                                <p class="text-muted f-12 mb-0">{{ $interview->pelamar->jenis_pekerjaan }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-warning me-2">
                                                    <i class="ph-duotone ph-calendar"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $interview->tanggal_interview->format('d/m/Y') }}</h6>
                                                    <p class="text-muted f-12 mb-0">{{ $interview->waktu_interview->format('H:i') }}</p>
                                                    @if($interview->isToday())
                                                        <span class="badge bg-warning">Hari Ini</span>
                                                    @elseif($interview->isOverdue())
                                                        <span class="badge bg-danger">Terlewat</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($interview->interviewer)
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar avtar-s bg-light-info me-2">
                                                        <i class="ph-duotone ph-user-check"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $interview->interviewer->name }}</h6>
                                                        <p class="text-muted f-12 mb-0">{{ $interview->interviewer->getRoleNames()->first() }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Belum ditentukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="{{ $interview->status_badge }}">
                                                {{ $interview->status_text }}
                                            </span>
                                            @if($interview->status == 'attended' && $interview->feedback_rating)
                                                <div class="mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="ph-duotone ph-star{{ $i <= $interview->feedback_rating ? '-fill' : '' }} text-warning"></i>
                                                    @endfor
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($interview->hasil_interview)
                                                <span class="badge {{ $interview->hasil_interview == 'lulus' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($interview->hasil_interview) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Belum ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('hrd.interview-attendance.show', $interview->id) }}" 
                                                   class="btn btn-outline-info btn-sm" title="Detail">
                                                    <i class="ph-duotone ph-eye"></i>
                                                </a>
                                                @if($interview->canBeEdited())
                                                <a href="{{ route('hrd.interview-attendance.edit', $interview->id) }}" 
                                                   class="btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="ph-duotone ph-pencil"></i>
                                                </a>
                                                @endif
                                                @if($interview->status == 'scheduled')
                                                <button type="button" class="btn btn-outline-success btn-sm" 
                                                        onclick="markAttendance({{ $interview->id }}, 'attended')" title="Hadir">
                                                    <i class="ph-duotone ph-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        onclick="markAttendance({{ $interview->id }}, 'absent')" title="Tidak Hadir">
                                                    <i class="ph-duotone ph-x"></i>
                                                </button>
                                                @endif
                                                @if($interview->status == 'attended' && !$interview->hasil_interview)
                                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                                        onclick="addResult({{ $interview->id }})" title="Tambah Hasil">
                                                    <i class="ph-duotone ph-note"></i>
                                                </button>
                                                @endif
                                                @if(in_array($interview->status, ['scheduled', 'rescheduled']))
                                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                                        onclick="rescheduleInterview({{ $interview->id }})" title="Reschedule">
                                                    <i class="ph-duotone ph-calendar-plus"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="ph-duotone ph-users-three f-48 text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data interview</p>
                                            <a href="{{ route('hrd.interview-attendance.create') }}" class="btn btn-primary">
                                                <i class="ph-duotone ph-plus me-1"></i>Jadwalkan Interview Pertama
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($interviews->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $interviews->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mark Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tandai Kehadiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="attendanceForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div id="candidateInfo" class="mb-3 p-3 bg-light rounded">
                        <!-- Candidate info will be loaded here -->
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Kehadiran</label>
                        <select name="status" class="form-select" required id="attendanceStatus">
                            <option value="attended">Hadir</option>
                            <option value="absent">Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="mb-3" id="feedbackSection" style="display: none;">
                        <label class="form-label">Rating Interview (1-5)</label>
                        <select name="feedback_rating" class="form-select">
                            <option value="">Pilih Rating</option>
                            <option value="1">1 - Sangat Buruk</option>
                            <option value="2">2 - Buruk</option>
                            <option value="3">3 - Cukup</option>
                            <option value="4">4 - Baik</option>
                            <option value="5">5 - Sangat Baik</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="3" 
                                  placeholder="Catatan kehadiran atau alasan ketidakhadiran"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-duotone ph-check me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Hasil Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="resultForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hasil Interview</label>
                        <select name="hasil_interview" class="form-select" required>
                            <option value="">Pilih Hasil</option>
                            <option value="lulus">Lulus</option>
                            <option value="tidak_lulus">Tidak Lulus</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Skor (1-100)</label>
                        <input type="number" name="skor" class="form-control" min="1" max="100" placeholder="85">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Feedback</label>
                        <textarea name="feedback" class="form-control" rows="4" 
                                  placeholder="Feedback detail tentang kandidat..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rekomendasi</label>
                        <select name="rekomendasi" class="form-select">
                            <option value="">Pilih Rekomendasi</option>
                            <option value="sangat_direkomendasikan">Sangat Direkomendasikan</option>
                            <option value="direkomendasikan">Direkomendasikan</option>
                            <option value="dipertimbangkan">Dipertimbangkan</option>
                            <option value="tidak_direkomendasikan">Tidak Direkomendasikan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-duotone ph-check me-1"></i>Simpan Hasil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Select All functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.interview-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Mark attendance
    function markAttendance(interviewId, status) {
        const modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
        const form = document.getElementById('attendanceForm');
        form.action = '{{ route("hrd.interview-attendance.mark-attendance", ":id") }}'.replace(':id', interviewId);
        
        document.getElementById('attendanceStatus').value = status;
        
        // Show feedback section for attended status
        if (status === 'attended') {
            document.getElementById('feedbackSection').style.display = 'block';
        } else {
            document.getElementById('feedbackSection').style.display = 'none';
        }
        
        modal.show();
    }

    // Add result
    function addResult(interviewId) {
        const modal = new bootstrap.Modal(document.getElementById('resultModal'));
        const form = document.getElementById('resultForm');
        form.action = '{{ route("hrd.interview-attendance.add-result", ":id") }}'.replace(':id', interviewId);
        modal.show();
    }

    // Reschedule interview
    function rescheduleInterview(interviewId) {
        window.location.href = '{{ route("hrd.interview-attendance.edit", ":id") }}'.replace(':id', interviewId);
    }

    // Bulk attendance
    function bulkAttendance() {
        const selectedCheckboxes = document.querySelectorAll('.interview-checkbox:checked');
        if (selectedCheckboxes.length === 0) {
            alert('Pilih minimal satu interview terlebih dahulu');
            return;
        }

        const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
        window.location.href = '{{ route("hrd.interview-attendance.bulk-attendance") }}?ids=' + selectedIds.join(',');
    }

    // Send reminders
    function sendReminders() {
        const selectedCheckboxes = document.querySelectorAll('.interview-checkbox:checked');
        if (selectedCheckboxes.length === 0) {
            alert('Pilih interview yang akan dikirim reminder');
            return;
        }

        if (confirm('Kirim reminder ke kandidat yang dipilih?')) {
            const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
            
            fetch('{{ route("hrd.interview-attendance.send-reminders") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    interview_ids: selectedIds
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Reminder berhasil dikirim!', 'success');
                } else {
                    showNotification('Gagal mengirim reminder', 'danger');
                }
            });
        }
    }

    // Auto-refresh for today's interviews
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            fetch('{{ route("hrd.interview-attendance.index") }}?ajax=1')
                .then(response => response.json())
                .then(data => {
                    if (data.scheduled_today > {{ $stats['scheduled_today'] }}) {
                        showNotification('New interviews scheduled for today!', 'info');
                    }
                });
        }
    }, 60000);

    function showNotification(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alert.style.top = '20px';
        alert.style.right = '20px';
        alert.style.zIndex = '9999';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => alert.remove(), 5000);
    }
</script>
@endpush