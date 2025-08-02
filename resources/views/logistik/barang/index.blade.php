@extends('layouts.app')

@section('title', 'Manajemen Barang')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Manajemen Barang</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('logistik.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Barang</li>
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
                                <h4 class="text-white">{{ $stats['total_items'] }}</h4>
                                <h6 class="text-white m-b-0">Total Barang</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-package f-28 text-white"></i>
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
                                <h4 class="text-white">{{ $stats['active_items'] }}</h4>
                                <h6 class="text-white m-b-0">Aktif</h6>
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
                                <h4 class="text-white">{{ $stats['out_of_stock'] }}</h4>
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

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Daftar Barang</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('logistik.stock.index') }}" class="btn btn-outline-info">
                                <i class="ph-duotone ph-list-dashes me-1"></i>Kelola Stock
                            </a>
                            <a href="{{ route('logistik.barang.create') }}" class="btn btn-primary">
                                <i class="ph-duotone ph-plus me-1"></i>Tambah Barang
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Cari Barang</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama, kode, atau deskripsi..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="">Semua</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Filter Stock</label>
                                <select name="low_stock" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="true" {{ request('low_stock') == 'true' ? 'selected' : '' }}>Stock Rendah</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-duotone ph-magnifying-glass me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('logistik.barang.index') }}" class="btn btn-outline-secondary">
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
                                        <th>Barang</th>
                                        <th>Kategori</th>
                                        <th>Stock</th>
                                        <th>Harga Satuan</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($barangs as $barang)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    @if($barang->foto)
                                                        <img src="{{ $barang->photo_url }}" alt="{{ $barang->nama_barang }}" 
                                                             class="avtar avtar-s" style="object-fit: cover;">
                                                    @else
                                                        <div class="avtar avtar-s bg-light-secondary">
                                                            <i class="ph-duotone ph-package"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $barang->nama_barang }}</h6>
                                                    <p class="text-muted f-12 mb-0">
                                                        <span class="badge bg-light-secondary">{{ $barang->kode_barang }}</span>
                                                        {{ $barang->unit }}
                                                    </p>
                                                    @if($barang->deskripsi)
                                                        <p class="text-muted f-12 mb-0">{{ Str::limit($barang->deskripsi, 50) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-info">{{ $barang->kategori }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <h6 class="mb-0">{{ $barang->current_quantity }}</h6>
                                                    <p class="text-muted f-12 mb-0">Min: {{ $barang->minimum_stock }}</p>
                                                </div>
                                                <div>
                                                    @php $stockStatus = $barang->stock_status @endphp
                                                    <span class="badge {{ 
                                                        $stockStatus['status'] == 'out_of_stock' ? 'bg-danger' :
                                                        ($stockStatus['status'] == 'low_stock' ? 'bg-warning' : 'bg-success')
                                                    }}">
                                                        {{ $stockStatus['text'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $barang->harga_satuan_formatted }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $barang->supplier ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="{{ $barang->status_badge }}">
                                                {{ ucfirst($barang->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('logistik.barang.show', $barang->id) }}" 
                                                   class="btn btn-outline-info btn-sm" title="Detail">
                                                    <i class="ph-duotone ph-eye"></i>
                                                </a>
                                                <a href="{{ route('logistik.barang.edit', $barang->id) }}" 
                                                   class="btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="ph-duotone ph-pencil"></i>
                                                </a>
                                                @if($barang->isLowStock())
                                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                                        onclick="quickStockAdjust({{ $barang->id }})" title="Tambah Stock">
                                                    <i class="ph-duotone ph-plus-circle"></i>
                                                </button>
                                                @endif
                                                @if($barang->current_quantity == 0)
                                                <form action="{{ route('logistik.barang.destroy', $barang->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Yakin hapus barang ini?')">
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
                                        <td colspan="7" class="text-center py-4">
                                            <i class="ph-duotone ph-package f-48 text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data barang</p>
                                            <a href="{{ route('logistik.barang.create') }}" class="btn btn-primary">
                                                <i class="ph-duotone ph-plus me-1"></i>Tambah Barang Pertama
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($barangs->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $barangs->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stock Adjust Modal -->
<div class="modal fade" id="quickStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Stock Cepat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickStockForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Tambahan</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <input type="text" name="reason" class="form-control" 
                               placeholder="Restocking, penerimaan barang, dll..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="2" 
                                  placeholder="Catatan tambahan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-duotone ph-plus me-1"></i>Tambah Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function quickStockAdjust(barangId) {
        // Assuming this will create a stock record if not exists and adjust it
        const modal = new bootstrap.Modal(document.getElementById('quickStockModal'));
        const form = document.getElementById('quickStockForm');
        // This would need a route that can handle creating stock if not exists
        form.action = '{{ route("logistik.stock.quick-adjust", ":id") }}'.replace(':id', barangId);
        modal.show();
    }

    // Auto-refresh for low stock alerts
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            // Check for new low stock alerts
            fetch('{{ route("logistik.barang.index") }}?ajax=1')
                .then(response => response.json())
                .then(data => {
                    if (data.low_stock_count > {{ $stats['low_stock_items'] }}) {
                        // Show notification for new low stock items
                        showNotification('New low stock items detected!', 'warning');
                    }
                });
        }
    }, 60000); // Check every minute

    function showNotification(message, type) {
        // Simple notification system
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
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
</script>
@endpush