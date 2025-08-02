@extends('layouts.app')

@section('title', 'Tambah Stock Barang')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Tambah Stock Barang</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('logistik.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('logistik.stock.index') }}">Stock Barang</a></li>
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
                        <h5>Form Tambah Stock</h5>
                        <div class="card-header-right">
                            <button class="btn btn-outline-info btn-sm" onclick="scanBarcode()">
                                <i class="ph-duotone ph-qr-code me-1"></i>Scan Barcode
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('logistik.stock.store') }}" method="POST" id="stockForm">
                            @csrf
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6>Informasi Barang</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                                        <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required id="barangSelect">
                                                            <option value="">Pilih Barang</option>
                                                            <!-- Sample data - should be dynamic from controller -->
                                                            <option value="1" data-kode="BRG001" data-nama="Laptop Dell XPS 13" data-kategori="Elektronik">BRG001 - Laptop Dell XPS 13</option>
                                                            <option value="2" data-kode="BRG002" data-nama="Meja Kantor" data-kategori="Furniture">BRG002 - Meja Kantor</option>
                                                            <option value="3" data-kode="BRG003" data-nama="Printer HP LaserJet" data-kategori="Elektronik">BRG003 - Printer HP LaserJet</option>
                                                        </select>
                                                        @error('barang_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kode Barang</label>
                                                        <input type="text" id="kodeBarang" class="form-control" readonly placeholder="Auto-filled">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Barang</label>
                                                        <input type="text" id="namaBarang" class="form-control" readonly placeholder="Auto-filled">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="adjustQuantity(-1)">
                                                                <i class="ph-duotone ph-minus"></i>
                                                            </button>
                                                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror text-center" 
                                                                   value="{{ old('quantity', 1) }}" min="1" required id="quantityInput">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="adjustQuantity(1)">
                                                                <i class="ph-duotone ph-plus"></i>
                                                            </button>
                                                        </div>
                                                        @error('quantity')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Unit</label>
                                                        <input type="text" id="unitBarang" class="form-control" readonly placeholder="Auto-filled">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Minimum Stock</label>
                                                        <input type="number" name="minimum_stock" class="form-control @error('minimum_stock') is-invalid @enderror" 
                                                               value="{{ old('minimum_stock') }}" min="0">
                                                        @error('minimum_stock')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Maximum Stock</label>
                                                        <input type="number" name="maximum_stock" class="form-control @error('maximum_stock') is-invalid @enderror" 
                                                               value="{{ old('maximum_stock') }}" min="0">
                                                        @error('maximum_stock')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Lokasi Penyimpanan</label>
                                                <select name="location" class="form-select @error('location') is-invalid @enderror">
                                                    <option value="">Pilih Lokasi</option>
                                                    <option value="Gudang A-1" {{ old('location') == 'Gudang A-1' ? 'selected' : '' }}>Gudang A-1</option>
                                                    <option value="Gudang A-2" {{ old('location') == 'Gudang A-2' ? 'selected' : '' }}>Gudang A-2</option>
                                                    <option value="Gudang B-1" {{ old('location') == 'Gudang B-1' ? 'selected' : '' }}>Gudang B-1</option>
                                                    <option value="Gudang B-2" {{ old('location') == 'Gudang B-2' ? 'selected' : '' }}>Gudang B-2</option>
                                                    <option value="Rak Display" {{ old('location') == 'Rak Display' ? 'selected' : '' }}>Rak Display</option>
                                                    <option value="Cold Storage" {{ old('location') == 'Cold Storage' ? 'selected' : '' }}>Cold Storage</option>
                                                </select>
                                                @error('location')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6>Informasi Tambahan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Batch Number</label>
                                                <input type="text" name="batch_number" class="form-control @error('batch_number') is-invalid @enderror" 
                                                       value="{{ old('batch_number') }}" placeholder="Contoh: BATCH001">
                                                @error('batch_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Opsional: Nomor batch untuk tracking</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Kadaluarsa</label>
                                                <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                                       value="{{ old('expiry_date') }}">
                                                @error('expiry_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Khusus untuk barang yang memiliki expired date</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Catatan</label>
                                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                                          rows="4" placeholder="Catatan tambahan tentang stock ini...">{{ old('notes') }}</textarea>
                                                @error('notes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Stock Preview -->
                                            <div class="card border border-info" id="stockPreview" style="display: none;">
                                                <div class="card-header bg-light-info">
                                                    <h6 class="mb-0">Preview Stock</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="text-center">
                                                        <div id="previewBarang" class="mb-2"></div>
                                                        <div id="previewQuantity" class="h4 text-primary"></div>
                                                        <div id="previewLocation" class="text-muted"></div>
                                                    </div>
                                                </div>
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
                                            <i class="ph-duotone ph-check me-1"></i>Simpan Stock
                                        </button>
                                        <button type="button" class="btn btn-outline-success" onclick="saveAndAddNew()">
                                            <i class="ph-duotone ph-plus-circle me-1"></i>Simpan & Tambah Lagi
                                        </button>
                                        <button type="button" class="btn btn-outline-info" onclick="quickStock()">
                                            <i class="ph-duotone ph-lightning me-1"></i>Quick Add
                                        </button>
                                        <a href="{{ route('logistik.stock.index') }}" class="btn btn-outline-secondary">
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

<!-- Quick Stock Modal -->
<div class="modal fade" id="quickStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quick Add Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickStockForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="ph-duotone ph-info me-2"></i>
                        Quick add menggunakan setting default untuk lokasi dan minimum stock
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Scan/Input Kode Barang</label>
                        <input type="text" class="form-control" id="quickKodeBarang" placeholder="Scan atau ketik kode barang">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quickQuantity" value="1" min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-duotone ph-check me-1"></i>Quick Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-fill barang information when selected
document.getElementById('barangSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        document.getElementById('kodeBarang').value = selectedOption.dataset.kode || '';
        document.getElementById('namaBarang').value = selectedOption.dataset.nama || '';
        document.getElementById('unitBarang').value = 'pcs'; // Default unit
        
        updateStockPreview();
    } else {
        clearBarangInfo();
    }
});

function clearBarangInfo() {
    document.getElementById('kodeBarang').value = '';
    document.getElementById('namaBarang').value = '';
    document.getElementById('unitBarang').value = '';
    document.getElementById('stockPreview').style.display = 'none';
}

function updateStockPreview() {
    const barang = document.getElementById('namaBarang').value;
    const quantity = document.getElementById('quantityInput').value;
    const location = document.querySelector('[name="location"]').value;
    
    if (barang && quantity) {
        document.getElementById('previewBarang').textContent = barang;
        document.getElementById('previewQuantity').textContent = quantity + ' pcs';
        document.getElementById('previewLocation').textContent = location || 'Lokasi belum dipilih';
        document.getElementById('stockPreview').style.display = 'block';
    } else {
        document.getElementById('stockPreview').style.display = 'none';
    }
}

// Quantity adjustment
function adjustQuantity(delta) {
    const input = document.getElementById('quantityInput');
    let currentValue = parseInt(input.value) || 0;
    let newValue = currentValue + delta;
    
    if (newValue >= 1) {
        input.value = newValue;
        updateStockPreview();
    }
}

// Real-time preview updates
document.getElementById('quantityInput').addEventListener('input', updateStockPreview);
document.querySelector('[name="location"]').addEventListener('change', updateStockPreview);

// Barcode scanning simulation
function scanBarcode() {
    // Simulate barcode scan
    const simulatedBarcode = 'BRG001';
    const selectElement = document.getElementById('barangSelect');
    
    // Find option by barcode
    for (let option of selectElement.options) {
        if (option.dataset.kode === simulatedBarcode) {
            selectElement.value = option.value;
            selectElement.dispatchEvent(new Event('change'));
            showNotification('Barcode berhasil di-scan!', 'success');
            break;
        }
    }
}

// Save and add new
function saveAndAddNew() {
    const form = document.getElementById('stockForm');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'save_and_new';
    input.value = '1';
    form.appendChild(input);
    form.submit();
}

// Quick stock modal
function quickStock() {
    const modal = new bootstrap.Modal(document.getElementById('quickStockModal'));
    modal.show();
}

// Quick stock form submission
document.getElementById('quickStockForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const kode = document.getElementById('quickKodeBarang').value;
    const quantity = document.getElementById('quickQuantity').value;
    
    if (!kode || !quantity) {
        alert('Mohon lengkapi semua field');
        return;
    }
    
    // Here you would typically send AJAX request
    fetch('/logistik/stock/quick-add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            kode_barang: kode,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Stock berhasil ditambahkan via Quick Add!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('quickStockModal')).hide();
            // Optionally refresh or redirect
        } else {
            showNotification('Gagal menambahkan stock: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showNotification('Terjadi kesalahan sistem', 'danger');
    });
});

// Form validation
document.getElementById('stockForm').addEventListener('submit', function(e) {
    const barangId = document.querySelector('[name="barang_id"]').value;
    const quantity = document.querySelector('[name="quantity"]').value;
    
    if (!barangId) {
        e.preventDefault();
        alert('Mohon pilih barang terlebih dahulu');
        return false;
    }
    
    if (!quantity || quantity < 1) {
        e.preventDefault();
        alert('Quantity harus diisi dan minimal 1');
        return false;
    }
    
    // Validate min/max stock
    const minStock = parseInt(document.querySelector('[name="minimum_stock"]').value) || 0;
    const maxStock = parseInt(document.querySelector('[name="maximum_stock"]').value) || 0;
    
    if (maxStock > 0 && maxStock < minStock) {
        e.preventDefault();
        alert('Maximum stock tidak boleh lebih kecil dari minimum stock');
        return false;
    }
});

// Notification function
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

// Auto-focus on barcode input for quick scanning
document.addEventListener('keydown', function(e) {
    // If user presses Ctrl+B, focus on barcode scanner
    if (e.ctrlKey && e.key === 'b') {
        e.preventDefault();
        scanBarcode();
    }
});
</script>
@endpush