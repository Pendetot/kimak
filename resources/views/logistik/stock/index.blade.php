@extends('layouts.app')

@section('title', 'Manajemen Stock')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Manajemen Stock</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('logistik.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Stock</li>
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
                                <h4 class="text-white">{{ number_format($stats['total_items']) }}</h4>
                                <h6 class="text-white m-b-0">Total Items</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-stack f-28 text-white"></i>
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
                                <h4 class="text-white">Rp {{ number_format($stats['total_value'], 0, ',', '.') }}</h4>
                                <h6 class="text-white m-b-0">Total Nilai</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-currency-circle-dollar f-28 text-white"></i>
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
                                <h4 class="text-white">{{ $stats['low_stock_items'] }}</h4>
                                <h6 class="text-white m-b-0">Stock Rendah</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-warning-circle f-28 text-white"></i>
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
                                <h4 class="text-white">{{ $stats['out_of_stock_items'] }}</h4>
                                <h6 class="text-white m-b-0">Habis</h6>
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
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">Aksi Cepat</h6>
                                <p class="text-muted mb-0">Kelola stock dengan mudah</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('logistik.stock.create') }}" class="btn btn-primary">
                                    <i class="ph-duotone ph-plus me-1"></i>Tambah Stock
                                </a>
                                <a href="{{ route('logistik.stock.movements') }}" class="btn btn-outline-info">
                                    <i class="ph-duotone ph-list-dashes me-1"></i>History Movement
                                </a>
                                <button type="button" class="btn btn-outline-warning" onclick="bulkAdjustModal()">
                                    <i class="ph-duotone ph-arrows-clockwise me-1"></i>Bulk Adjust
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
                        <h5>Daftar Stock Barang</h5>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Cari Barang</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama barang atau kode..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Barang</label>
                                <select name="barang_id" class="form-select">
                                    <option value="">Semua</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" {{ request('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Lokasi</label>
                                <select name="location" class="form-select">
                                    <option value="">Semua</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status Stock</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="normal" {{ request('status') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Stock Rendah</option>
                                    <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                                    <option value="overstock" {{ request('status') == 'overstock' ? 'selected' : '' }}>Overstock</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-duotone ph-magnifying-glass me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('logistik.stock.index') }}" class="btn btn-outline-secondary">
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
                                        <th>Barang</th>
                                        <th>Lokasi</th>
                                        <th>Stock Saat Ini</th>
                                        <th>Min/Max</th>
                                        <th>Status</th>
                                        <th>Batch/Expired</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stocks as $stock)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input stock-checkbox" value="{{ $stock->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    @if($stock->barang->foto)
                                                        <img src="{{ $stock->barang->photo_url }}" alt="{{ $stock->barang->nama_barang }}" 
                                                             class="avtar avtar-s" style="object-fit: cover;">
                                                    @else
                                                        <div class="avtar avtar-s bg-light-secondary">
                                                            <i class="ph-duotone ph-package"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $stock->barang->nama_barang }}</h6>
                                                    <p class="text-muted f-12 mb-0">
                                                        <span class="badge bg-light-secondary">{{ $stock->barang->kode_barang }}</span>
                                                        {{ $stock->barang->unit }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-info">{{ $stock->location ?: 'Default' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <h5 class="mb-0 me-2">{{ $stock->quantity }}</h5>
                                                <small class="text-muted">{{ $stock->barang->unit }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-muted f-12">
                                                <div>Min: {{ $stock->minimum_stock }}</div>
                                                @if($stock->maximum_stock > 0)
                                                    <div>Max: {{ $stock->maximum_stock }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php $stockStatus = $stock->stock_status @endphp
                                            <span class="badge {{ 
                                                $stockStatus['status'] == 'out_of_stock' ? 'bg-danger' :
                                                ($stockStatus['status'] == 'low_stock' ? 'bg-warning' : 
                                                ($stockStatus['status'] == 'overstock' ? 'bg-info' : 'bg-success'))
                                            }}">
                                                {{ $stockStatus['text'] }}
                                            </span>
                                            @if($stock->maximum_stock > 0)
                                                <div class="progress mt-1" style="height: 4px;">
                                                    <div class="progress-bar" 
                                                         style="width: {{ $stock->stock_percentage }}%"
                                                         title="{{ $stock->stock_percentage }}%"></div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($stock->batch_number)
                                                <div class="f-12">
                                                    <div>Batch: {{ $stock->batch_number }}</div>
                                                    @if($stock->expiry_date)
                                                        <div class="text-{{ $stock->isExpiringSoon() ? 'warning' : 'muted' }}">
                                                            Exp: {{ $stock->expiry_date->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('logistik.stock.show', $stock->id) }}" 
                                                   class="btn btn-outline-info btn-sm" title="Detail">
                                                    <i class="ph-duotone ph-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                                        onclick="adjustStock({{ $stock->id }})" title="Adjust Stock">
                                                    <i class="ph-duotone ph-arrows-clockwise"></i>
                                                </button>
                                                <a href="{{ route('logistik.stock.edit', $stock->id) }}" 
                                                   class="btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="ph-duotone ph-pencil"></i>
                                                </a>
                                                @if($stock->quantity == 0)
                                                <form action="{{ route('logistik.stock.destroy', $stock->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Yakin hapus stock ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                        <i class="ph-duotone ph-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="ph-duotone ph-stack f-48 text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data stock</p>
                                            <a href="{{ route('logistik.stock.create') }}" class="btn btn-primary">
                                                <i class="ph-duotone ph-plus me-1"></i>Tambah Stock Pertama
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($stocks->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $stocks->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Adjustment Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adjust Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="adjustStockForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="stockInfo" class="mb-3 p-3 bg-light rounded">
                        <!-- Stock info will be loaded here -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Adjustment</label>
                                <select name="adjustment_type" class="form-select" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="increase">Tambah Stock</option>
                                    <option value="decrease">Kurangi Stock</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <input type="text" name="reason" class="form-control" 
                               placeholder="Restock, rusak, hilang, etc..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="3" 
                                  placeholder="Catatan tambahan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-duotone ph-check me-1"></i>Adjust Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Adjustment Modal -->
<div class="modal fade" id="bulkAdjustModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Stock Adjustment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkAdjustForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="ph-duotone ph-info me-2"></i>
                        Pilih stock items dari tabel terlebih dahulu
                    </div>
                    <div id="selectedStocks" class="mb-3">
                        <!-- Selected stocks will be shown here -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Adjustment</label>
                                <select name="bulk_adjustment_type" class="form-select" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="increase">Tambah Stock</option>
                                    <option value="decrease">Kurangi Stock</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jumlah (untuk semua)</label>
                                <input type="number" name="bulk_quantity" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <input type="text" name="bulk_reason" class="form-control" 
                               placeholder="Alasan untuk semua adjustment..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ph-duotone ph-arrows-clockwise me-1"></i>Bulk Adjust
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
        const checkboxes = document.querySelectorAll('.stock-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Individual stock adjustment
    function adjustStock(stockId) {
        const modal = new bootstrap.Modal(document.getElementById('adjustStockModal'));
        const form = document.getElementById('adjustStockForm');
        form.action = '{{ route("logistik.stock.adjust", ":id") }}'.replace(':id', stockId);
        
        // Load stock info
        fetch(`/logistik/stock/${stockId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('stockInfo').innerHTML = `
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6>${data.barang.nama_barang}</h6>
                            <p class="mb-0">Current Stock: <strong>${data.quantity}</strong> ${data.barang.unit}</p>
                        </div>
                        <div class="text-end">
                            <p class="mb-0">Min: ${data.minimum_stock}</p>
                            <p class="mb-0">Max: ${data.maximum_stock || 'N/A'}</p>
                        </div>
                    </div>
                `;
            });
            
        modal.show();
    }

    // Bulk adjustment
    function bulkAdjustModal() {
        const selectedCheckboxes = document.querySelectorAll('.stock-checkbox:checked');
        if (selectedCheckboxes.length === 0) {
            alert('Pilih minimal satu stock item terlebih dahulu');
            return;
        }

        const modal = new bootstrap.Modal(document.getElementById('bulkAdjustModal'));
        const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
        
        // Show selected items
        document.getElementById('selectedStocks').innerHTML = `
            <div class="alert alert-light">
                <strong>${selectedIds.length}</strong> stock items dipilih untuk bulk adjustment
                <input type="hidden" name="stock_ids" value="${selectedIds.join(',')}">
            </div>
        `;
        
        modal.show();
    }

    // Auto-refresh for real-time stock updates
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            // Check for low stock alerts
            fetch('{{ route("logistik.stock.index") }}?ajax=1')
                .then(response => response.json())
                .then(data => {
                    if (data.low_stock_count > {{ $stats['low_stock_items'] }}) {
                        showNotification('New low stock alerts detected!', 'warning');
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