@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Barang</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('logistik.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('logistik.barang.index') }}">Barang</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Form Tambah Barang</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('logistik.barang.store') }}" method="POST" enctype="multipart/form-data" id="barangForm">
                            @csrf
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6>Informasi Dasar</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                                                        <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" 
                                                               placeholder="Contoh: BRG001" value="{{ old('kode_barang') }}" required>
                                                        @error('kode_barang')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <div class="form-text">Kode unik untuk identifikasi barang</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Barcode</label>
                                                        <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" 
                                                               placeholder="Auto-generate jika kosong" value="{{ old('barcode') }}">
                                                        @error('barcode')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" 
                                                       placeholder="Nama lengkap barang" value="{{ old('nama_barang') }}" required>
                                                @error('nama_barang')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                                            <option value="">Pilih Kategori</option>
                                                            <option value="Elektronik" {{ old('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                                            <option value="Furniture" {{ old('kategori') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                                            <option value="Stationery" {{ old('kategori') == 'Stationery' ? 'selected' : '' }}>Stationery</option>
                                                            <option value="Consumables" {{ old('kategori') == 'Consumables' ? 'selected' : '' }}>Consumables</option>
                                                            <option value="Tools" {{ old('kategori') == 'Tools' ? 'selected' : '' }}>Tools</option>
                                                            <option value="Other" {{ old('kategori') == 'Other' ? 'selected' : '' }}>Lainnya</option>
                                                        </select>
                                                        @error('kategori')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Unit Satuan <span class="text-danger">*</span></label>
                                                        <select name="unit" class="form-select @error('unit') is-invalid @enderror" required>
                                                            <option value="">Pilih Unit</option>
                                                            <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                                            <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Box</option>
                                                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                                            <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>Liter</option>
                                                            <option value="meter" {{ old('unit') == 'meter' ? 'selected' : '' }}>Meter</option>
                                                            <option value="set" {{ old('unit') == 'set' ? 'selected' : '' }}>Set</option>
                                                        </select>
                                                        @error('unit')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                                          rows="3" placeholder="Deskripsi detail barang">{{ old('deskripsi') }}</textarea>
                                                @error('deskripsi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pricing & Stock -->
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h6>Harga & Stock</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="number" name="harga_satuan" class="form-control @error('harga_satuan') is-invalid @enderror" 
                                                                   placeholder="0" min="0" step="100" value="{{ old('harga_satuan') }}" required>
                                                        </div>
                                                        @error('harga_satuan')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Supplier</label>
                                                        <input type="text" name="supplier" class="form-control @error('supplier') is-invalid @enderror" 
                                                               placeholder="Nama supplier utama" value="{{ old('supplier') }}">
                                                        @error('supplier')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Minimum Stock <span class="text-danger">*</span></label>
                                                        <input type="number" name="minimum_stock" class="form-control @error('minimum_stock') is-invalid @enderror" 
                                                               placeholder="0" min="0" value="{{ old('minimum_stock') }}" required>
                                                        @error('minimum_stock')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <div class="form-text">Alert akan muncul jika stock di bawah nilai ini</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Maximum Stock</label>
                                                        <input type="number" name="maximum_stock" class="form-control @error('maximum_stock') is-invalid @enderror" 
                                                               placeholder="0 = unlimited" min="0" value="{{ old('maximum_stock') }}">
                                                        @error('maximum_stock')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Lokasi Penyimpanan</label>
                                                <input type="text" name="lokasi_penyimpanan" class="form-control @error('lokasi_penyimpanan') is-invalid @enderror" 
                                                       placeholder="Contoh: Gudang A-1, Rak B-2" value="{{ old('lokasi_penyimpanan') }}">
                                                @error('lokasi_penyimpanan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Photo & Additional Info -->
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6>Foto Barang</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Upload Foto</label>
                                                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" 
                                                       accept="image/jpeg,image/png,image/jpg" id="fotoInput">
                                                @error('foto')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Format: JPG, PNG. Max: 2MB</div>
                                            </div>

                                            <!-- Preview Area -->
                                            <div id="photoPreview" class="text-center" style="display: none;">
                                                <img id="previewImage" src="" alt="Preview" 
                                                     class="img-fluid rounded border" style="max-height: 200px;">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePhoto()">
                                                        <i class="ph-duotone ph-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Default Preview -->
                                            <div id="defaultPreview" class="text-center">
                                                <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="height: 200px;">
                                                    <div class="text-muted">
                                                        <i class="ph-duotone ph-image f-32"></i>
                                                        <p class="mt-2 mb-0">Preview foto akan muncul di sini</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h6>Status & Catatan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Catatan</label>
                                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                                          rows="3" placeholder="Catatan tambahan">{{ old('notes') }}</textarea>
                                                @error('notes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ph-duotone ph-check me-1"></i>Simpan Barang
                                        </button>
                                        <button type="button" class="btn btn-outline-success" onclick="saveAndAddStock()">
                                            <i class="ph-duotone ph-plus-circle me-1"></i>Simpan & Tambah Stock
                                        </button>
                                        <a href="{{ route('logistik.barang.index') }}" class="btn btn-outline-secondary">
                                            <i class="ph-duotone ph-arrow-left me-1"></i>Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Photo preview functionality
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('photoPreview').style.display = 'block';
                document.getElementById('defaultPreview').style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    function removePhoto() {
        document.getElementById('fotoInput').value = '';
        document.getElementById('photoPreview').style.display = 'none';
        document.getElementById('defaultPreview').style.display = 'block';
    }

    // Auto-generate kode barang
    document.getElementById('barangForm').addEventListener('input', function(e) {
        if (e.target.name === 'nama_barang' && !document.querySelector('input[name="kode_barang"]').value) {
            const nama = e.target.value;
            if (nama.length > 3) {
                const kode = 'BRG' + nama.substring(0, 3).toUpperCase() + Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                document.querySelector('input[name="kode_barang"]').value = kode;
            }
        }
    });

    // Currency formatting
    document.querySelector('input[name="harga_satuan"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        e.target.value = value;
    });

    // Form validation
    document.getElementById('barangForm').addEventListener('submit', function(e) {
        const minimumStock = parseInt(document.querySelector('input[name="minimum_stock"]').value) || 0;
        const maximumStock = parseInt(document.querySelector('input[name="maximum_stock"]').value) || 0;
        
        if (maximumStock > 0 && maximumStock < minimumStock) {
            e.preventDefault();
            alert('Maximum stock tidak boleh lebih kecil dari minimum stock');
            return false;
        }
    });

    // Save and add stock
    function saveAndAddStock() {
        const form = document.getElementById('barangForm');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'redirect_to_stock';
        input.value = '1';
        form.appendChild(input);
        form.submit();
    }

    // Real-time validation
    document.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
</script>
@endpush