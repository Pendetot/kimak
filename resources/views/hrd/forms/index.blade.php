@extends('layouts.app')

@section('title', 'Form Templates')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Form Templates</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('hrd.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Form Templates</li>
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
                                <h4 class="text-white">12</h4>
                                <h6 class="text-white m-b-0">Total Templates</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-files f-28 text-white"></i>
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
                                <h4 class="text-white">8</h4>
                                <h6 class="text-white m-b-0">Active Templates</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-check-circle f-28 text-white"></i>
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
                                <h4 class="text-white">245</h4>
                                <h6 class="text-white m-b-0">Downloads</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-download f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-info-dark">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white">4</h4>
                                <h6 class="text-white m-b-0">Recent Updates</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-clock f-28 text-white"></i>
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
                        <h5>Available Form Templates</h5>
                        <div class="card-header-right">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <i class="ph-duotone ph-upload me-1"></i>Upload New Template
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- HR Forms Category -->
                            <div class="col-lg-6 col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light-primary">
                                        <h6 class="mb-0"><i class="ph-duotone ph-user-check me-2"></i>HR Forms</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Form Lamaran Kerja</h6>
                                                    <small class="text-muted">Template standar untuk pelamar</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('hrd.forms.download', 'form-lamaran.docx') }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="ph-duotone ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Form Evaluasi Karyawan</h6>
                                                    <small class="text-muted">Template penilaian kinerja</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('hrd.forms.download', 'form-evaluasi.xlsx') }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="ph-duotone ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Form Cuti Karyawan</h6>
                                                    <small class="text-muted">Template pengajuan cuti</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('hrd.forms.download', 'form-cuti.pdf') }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="ph-duotone ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Form Mutasi Karyawan</h6>
                                                    <small class="text-muted">Template mutasi internal</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('hrd.forms.download', 'form-mutasi.docx') }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="ph-duotone ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Administrative Forms Category -->
                            <div class="col-lg-6 col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light-success">
                                        <h6 class="mb-0"><i class="ph-duotone ph-file-text me-2"></i>Administrative Forms</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Surat Peringatan Template</h6>
                                                    <small class="text-muted">Template surat peringatan karyawan</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('hrd.forms.download', 'template-sp.docx') }}" class="btn btn-sm btn-outline-success">
                                                        <i class="ph-duotone ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Kontrak Kerja PKWT</h6>
                                                    <small class="text-muted">Template kontrak waktu tertentu</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('hrd.forms.download', 'kontrak-pkwt.docx') }}" class="btn btn-sm btn-outline-success">
                                                        <i class="ph-duotone ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Form Exit Interview</h6>
                                                    <small class="text-muted">Template interview keluar karyawan</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('hrd.forms.download', 'exit-interview.pdf') }}" class="btn btn-sm btn-outline-success">
                                                        <i class="ph-duotone ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Form Resign Karyawan</h6>
                                                    <small class="text-muted">Template pengunduran diri</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('hrd.forms.download', 'form-resign.docx') }}" class="btn btn-sm btn-outline-success">
                                                        <i class="ph-duotone ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Templates Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-light-warning">
                                        <h6 class="mb-0"><i class="ph-duotone ph-certificate me-2"></i>Training & Development Forms</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center p-3 border rounded">
                                                    <div class="flex-shrink-0">
                                                        <div class="avtar avtar-s bg-warning">
                                                            <i class="ph-duotone ph-graduation-cap"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Training Request Form</h6>
                                                        <p class="text-muted f-12 mb-0">Form permintaan pelatihan</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <a href="{{ route('hrd.forms.download', 'training-request.docx') }}" class="btn btn-sm btn-outline-warning">
                                                            <i class="ph-duotone ph-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center p-3 border rounded">
                                                    <div class="flex-shrink-0">
                                                        <div class="avtar avtar-s bg-info">
                                                            <i class="ph-duotone ph-chart-bar"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Performance Review</h6>
                                                        <p class="text-muted f-12 mb-0">Template review kinerja</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <a href="{{ route('hrd.forms.download', 'performance-review.xlsx') }}" class="btn btn-sm btn-outline-info">
                                                            <i class="ph-duotone ph-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center p-3 border rounded">
                                                    <div class="flex-shrink-0">
                                                        <div class="avtar avtar-s bg-danger">
                                                            <i class="ph-duotone ph-warning-circle"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Disciplinary Action</h6>
                                                        <p class="text-muted f-12 mb-0">Form tindakan disipliner</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <a href="{{ route('hrd.forms.download', 'disciplinary-action.pdf') }}" class="btn btn-sm btn-outline-danger">
                                                            <i class="ph-duotone ph-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Template Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload New Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Template Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="hr_forms">HR Forms</option>
                            <option value="administrative">Administrative Forms</option>
                            <option value="training">Training & Development</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Template File</label>
                        <input type="file" name="file" class="form-control" accept=".docx,.xlsx,.pdf" required>
                        <div class="form-text">Supported formats: DOCX, XLSX, PDF</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-duotone ph-upload me-1"></i>Upload Template
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Download tracking
document.querySelectorAll('[href*="forms.download"]').forEach(link => {
    link.addEventListener('click', function() {
        // Track download analytics
        console.log('Template downloaded:', this.href);
    });
});

// Auto-refresh download statistics
setInterval(function() {
    // Could fetch updated download counts via AJAX
}, 30000);
</script>
@endpush