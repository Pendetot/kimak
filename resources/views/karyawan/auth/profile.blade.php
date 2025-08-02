@extends('layouts.main')

@section('title', 'Profile Karyawan')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="{{ route('karyawan.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('content')
<div class="row">
    <!-- Profile Information -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="position-relative">
                    <img src="{{ auth('karyawan')->user()->getPhotoUrl() }}" 
                         alt="Profile Photo" 
                         class="rounded-circle img-fluid wid-120 img-thumbnail">
                    <div class="position-absolute bottom-0 end-0">
                        <button class="btn btn-sm btn-primary rounded-circle" 
                                data-bs-toggle="modal" 
                                data-bs-target="#photoModal">
                            <i class="feather icon-camera"></i>
                        </button>
                    </div>
                </div>
                <h5 class="mt-3 mb-1">{{ auth('karyawan')->user()->display_name }}</h5>
                <p class="text-muted">{{ auth('karyawan')->user()->jabatan }}</p>
                
                <div class="row g-3 mt-3">
                    <div class="col-4">
                        <h6 class="mb-0">{{ auth('karyawan')->user()->nik }}</h6>
                        <small class="text-muted">NIK</small>
                    </div>
                    <div class="col-4">
                        <h6 class="mb-0">{{ auth('karyawan')->user()->departemen }}</h6>
                        <small class="text-muted">Departemen</small>
                    </div>
                    <div class="col-4">
                        <h6 class="mb-0">{{ auth('karyawan')->user()->work_duration }}</h6>
                        <small class="text-muted">Masa Kerja</small>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <span class="badge bg-{{ auth('karyawan')->user()->status_karyawan->color() }}">
                            {{ auth('karyawan')->user()->status_karyawan->label() }}
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="badge bg-{{ auth('karyawan')->user()->jenis_kontrak->color() }}">
                            {{ auth('karyawan')->user()->jenis_kontrak->label() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="card mt-3">
            <div class="card-header">
                <h5>Informasi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Email</span>
                        <small class="text-muted">{{ auth('karyawan')->user()->email }}</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Tanggal Lahir</span>
                        <small class="text-muted">
                            {{ auth('karyawan')->user()->tanggal_lahir ? auth('karyawan')->user()->tanggal_lahir->format('d M Y') : '-' }}
                        </small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Tanggal Masuk</span>
                        <small class="text-muted">{{ auth('karyawan')->user()->tanggal_masuk->format('d M Y') }}</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Last Login</span>
                        <small class="text-muted">
                            {{ auth('karyawan')->user()->last_login_at ? auth('karyawan')->user()->last_login_at->diffForHumans() : 'Belum pernah' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#basic-info" role="tab">
                            <i class="feather icon-user me-2"></i>Informasi Dasar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#contact-info" role="tab">
                            <i class="feather icon-phone me-2"></i>Kontak
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#security" role="tab">
                            <i class="feather icon-lock me-2"></i>Keamanan
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                        <form method="POST" action="{{ route('karyawan.profile.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" 
                                           class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                           name="nama_lengkap" 
                                           value="{{ old('nama_lengkap', auth('karyawan')->user()->nama_lengkap) }}" 
                                           required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email', auth('karyawan')->user()->email) }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           name="tanggal_lahir" 
                                           value="{{ old('tanggal_lahir', auth('karyawan')->user()->tanggal_lahir?->format('Y-m-d')) }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" 
                                           class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                           name="tempat_lahir" 
                                           value="{{ old('tempat_lahir', auth('karyawan')->user()->tempat_lahir) }}">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                            name="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        @foreach(\App\Enums\JenisKelaminEnum::options() as $value => $label)
                                            <option value="{{ $value }}" 
                                                    {{ old('jenis_kelamin', auth('karyawan')->user()->jenis_kelamin?->value) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Pernikahan</label>
                                    <select class="form-select @error('status_pernikahan') is-invalid @enderror" 
                                            name="status_pernikahan">
                                        <option value="">Pilih Status</option>
                                        @foreach(\App\Enums\StatusPernikahanEnum::options() as $value => $label)
                                            <option value="{{ $value }}" 
                                                    {{ old('status_pernikahan', auth('karyawan')->user()->status_pernikahan?->value) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_pernikahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          name="alamat" 
                                          rows="3">{{ old('alamat', auth('karyawan')->user()->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather icon-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Contact Info Tab -->
                    <div class="tab-pane fade" id="contact-info" role="tabpanel">
                        <form method="POST" action="{{ route('karyawan.profile.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" 
                                           class="form-control @error('no_telepon') is-invalid @enderror" 
                                           name="no_telepon" 
                                           value="{{ old('no_telepon', auth('karyawan')->user()->no_telepon) }}">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. WhatsApp</label>
                                    <input type="text" 
                                           class="form-control @error('no_whatsapp') is-invalid @enderror" 
                                           name="no_whatsapp" 
                                           value="{{ old('no_whatsapp', auth('karyawan')->user()->no_whatsapp) }}">
                                    @error('no_whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kontak Darurat (Nama)</label>
                                    <input type="text" 
                                           class="form-control @error('kontak_darurat_nama') is-invalid @enderror" 
                                           name="kontak_darurat_nama" 
                                           value="{{ old('kontak_darurat_nama', auth('karyawan')->user()->kontak_darurat_nama) }}">
                                    @error('kontak_darurat_nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kontak Darurat (No. Telepon)</label>
                                    <input type="text" 
                                           class="form-control @error('kontak_darurat_telepon') is-invalid @enderror" 
                                           name="kontak_darurat_telepon" 
                                           value="{{ old('kontak_darurat_telepon', auth('karyawan')->user()->kontak_darurat_telepon) }}">
                                    @error('kontak_darurat_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hubungan Kontak Darurat</label>
                                <input type="text" 
                                       class="form-control @error('kontak_darurat_hubungan') is-invalid @enderror" 
                                       name="kontak_darurat_hubungan" 
                                       value="{{ old('kontak_darurat_hubungan', auth('karyawan')->user()->kontak_darurat_hubungan) }}">
                                @error('kontak_darurat_hubungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather icon-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <form method="POST" action="{{ route('karyawan.change-password') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Password Lama</label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       name="current_password" 
                                       required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" 
                                       class="form-control" 
                                       name="password_confirmation" 
                                       required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="feather icon-lock me-2"></i>Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Foto Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('karyawan.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Foto</label>
                        <input type="file" 
                               class="form-control @error('foto_profil') is-invalid @enderror" 
                               name="foto_profil" 
                               accept="image/*" 
                               required>
                        @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Show success/error messages
@if(session('success'))
    toastr.success('{{ session('success') }}');
@endif

@if(session('error'))
    toastr.error('{{ session('error') }}');
@endif

// File input preview
document.querySelector('input[name="foto_profil"]').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const file = e.target.files[0];
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            e.target.value = '';
        }
    }
});
</script>
@endsection