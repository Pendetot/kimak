@extends('layouts.app')

@section('title', 'Manajemen Distribusi')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Manajemen Distribusi</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('logistik.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Distribusi</li>
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
                                <h4 class="text-white">{{ $stats['total_distributions'] }}</h4>
                                <h6 class="text-white m-b-0">Total Distribusi</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-truck f-28 text-white"></i>
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
                                <h4 class="text-white">{{ $stats['pending_distributions'] }}</h4>
                                <h6 class="text-white m-b-0">Menunggu</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-clock f-28 text-white"></i>
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
                                <h4 class="text-white">{{ $stats['in_transit'] }}</h4>
                                <h6 class="text-white m-b-0">Dalam Perjalanan</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-map-pin f-28 text-white"></i>
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
                                <h4 class="text-white">{{ $stats['completed_today'] }}</h4>
                                <h6 class="text-white m-b-0">Selesai Hari Ini</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ph-duotone ph-check-circle f-28 text-white"></i>
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
                                <h6 class="mb-1">Aksi Cepat Distribusi</h6>
                                <p class="text-muted mb-0">Kelola distribusi barang dengan mudah</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('logistik.distribusi.create') }}" class="btn btn-primary">
                                    <i class="ph-duotone ph-plus me-1"></i>Buat Distribusi
                                </a>
                                <button type="button" class="btn btn-outline-info" onclick="trackMultiple()">
                                    <i class="ph-duotone ph-map-pin me-1"></i>Track Multiple
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="bulkStatusUpdate()">
                                    <i class="ph-duotone ph-arrows-clockwise me-1"></i>Bulk Update
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
                        <h5>Daftar Distribusi</h5>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Cari</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nomor, penerima, atau tujuan..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="in_transit" {{ request('status') == 'in_transit' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Terkirim</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Prioritas</label>
                                <select name="priority" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                    <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
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
                                    <a href="{{ route('logistik.distribusi.index') }}" class="btn btn-outline-secondary">
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
                                        <th>Nomor Distribusi</th>
                                        <th>Penerima</th>
                                        <th>Barang</th>
                                        <th>Tujuan</th>
                                        <th>Status</th>
                                        <th>Prioritas</th>
                                        <th>Estimasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($distributions as $distribution)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input dist-checkbox" value="{{ $distribution->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-secondary me-2">
                                                    <i class="ph-duotone ph-truck"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $distribution->nomor_distribusi }}</h6>
                                                    <p class="text-muted f-12 mb-0">{{ $distribution->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-0">{{ $distribution->penerima_nama }}</h6>
                                                <p class="text-muted f-12 mb-0">{{ $distribution->penerima_kontak }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($distribution->foto_barang)
                                                    <img src="{{ $distribution->foto_barang }}" alt="Item" 
                                                         class="avtar avtar-s me-2" style="object-fit: cover;">
                                                @else
                                                    <div class="avtar avtar-s bg-light-info me-2">
                                                        <i class="ph-duotone ph-package"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $distribution->barang_nama }}</h6>
                                                    <p class="text-muted f-12 mb-0">{{ $distribution->quantity }} {{ $distribution->unit }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-0">{{ $distribution->alamat_tujuan }}</h6>
                                                <p class="text-muted f-12 mb-0">
                                                    @if($distribution->jarak)
                                                        <i class="ph-duotone ph-map-pin me-1"></i>{{ $distribution->jarak }} km
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="{{ $distribution->status_badge }}">
                                                {{ $distribution->status_text }}
                                            </span>
                                            @if($distribution->status == 'in_transit' && $distribution->tracking_url)
                                                <div class="mt-1">
                                                    <a href="{{ $distribution->tracking_url }}" target="_blank" 
                                                       class="btn btn-xs btn-outline-info">
                                                        <i class="ph-duotone ph-map-pin"></i> Track
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ 
                                                $distribution->priority == 'urgent' ? 'bg-danger' :
                                                ($distribution->priority == 'high' ? 'bg-warning' :
                                                ($distribution->priority == 'normal' ? 'bg-info' : 'bg-secondary'))
                                            }}">
                                                {{ ucfirst($distribution->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($distribution->estimated_delivery)
                                                <div class="text-{{ $distribution->isOverdue() ? 'danger' : 'muted' }}">
                                                    {{ $distribution->estimated_delivery->format('d/m/Y') }}
                                                    @if($distribution->isOverdue())
                                                        <br><small class="text-danger">Terlambat</small>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('logistik.distribusi.show', $distribution->id) }}" 
                                                   class="btn btn-outline-info btn-sm" title="Detail">
                                                    <i class="ph-duotone ph-eye"></i>
                                                </a>
                                                @if($distribution->canBeEdited())
                                                <a href="{{ route('logistik.distribusi.edit', $distribution->id) }}" 
                                                   class="btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="ph-duotone ph-pencil"></i>
                                                </a>
                                                @endif
                                                @if($distribution->status == 'pending')
                                                <button type="button" class="btn btn-outline-success btn-sm" 
                                                        onclick="updateStatus({{ $distribution->id }}, 'processing')" title="Proses">
                                                    <i class="ph-duotone ph-play"></i>
                                                </button>
                                                @endif
                                                @if($distribution->status == 'processing')
                                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                                        onclick="updateStatus({{ $distribution->id }}, 'in_transit')" title="Kirim">
                                                    <i class="ph-duotone ph-truck"></i>
                                                </button>
                                                @endif
                                                @if($distribution->status == 'in_transit')
                                                <button type="button" class="btn btn-outline-success btn-sm" 
                                                        onclick="updateStatus({{ $distribution->id }}, 'delivered')" title="Selesai">
                                                    <i class="ph-duotone ph-check"></i>
                                                </button>
                                                @endif
                                                @if(in_array($distribution->status, ['pending', 'processing']))
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        onclick="cancelDistribution({{ $distribution->id }})" title="Batal">
                                                    <i class="ph-duotone ph-x"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="ph-duotone ph-truck f-48 text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data distribusi</p>
                                            <a href="{{ route('logistik.distribusi.create') }}" class="btn btn-primary">
                                                <i class="ph-duotone ph-plus me-1"></i>Buat Distribusi Pertama
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($distributions->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $distributions->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Distribusi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusUpdateForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div id="statusInfo" class="mb-3 p-3 bg-light rounded">
                        <!-- Status info will be loaded here -->
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Baru</label>
                        <select name="status" class="form-select" required id="newStatus">
                            <option value="">Pilih Status</option>
                            <option value="processing">Diproses</option>
                            <option value="in_transit">Dalam Perjalanan</option>
                            <option value="delivered">Terkirim</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3" id="trackingField" style="display: none;">
                        <label class="form-label">Tracking URL</label>
                        <input type="url" name="tracking_url" class="form-control" 
                               placeholder="https://tracking.example.com/123456">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="3" 
                                  placeholder="Catatan perubahan status"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-duotone ph-check me-1"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Update Modal -->
<div class="modal fade" id="bulkUpdateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Status Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkUpdateForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="ph-duotone ph-info me-2"></i>
                        Pilih distribusi dari tabel terlebih dahulu
                    </div>
                    <div id="selectedDistributions" class="mb-3">
                        <!-- Selected distributions will be shown here -->
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Baru</label>
                        <select name="bulk_status" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="processing">Diproses</option>
                            <option value="in_transit">Dalam Perjalanan</option>
                            <option value="delivered">Terkirim</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="bulk_notes" class="form-control" rows="3" 
                                  placeholder="Catatan untuk semua distribusi"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ph-duotone ph-arrows-clockwise me-1"></i>Bulk Update
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
        const checkboxes = document.querySelectorAll('.dist-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Status update
    function updateStatus(distributionId, newStatus) {
        const modal = new bootstrap.Modal(document.getElementById('statusUpdateModal'));
        const form = document.getElementById('statusUpdateForm');
        form.action = '{{ route("logistik.distribusi.update-status", ":id") }}'.replace(':id', distributionId);
        
        document.getElementById('newStatus').value = newStatus;
        
        // Show tracking field for in_transit status
        if (newStatus === 'in_transit') {
            document.getElementById('trackingField').style.display = 'block';
        } else {
            document.getElementById('trackingField').style.display = 'none';
        }
        
        modal.show();
    }

    // Cancel distribution
    function cancelDistribution(distributionId) {
        if (confirm('Yakin ingin membatalkan distribusi ini?')) {
            updateStatus(distributionId, 'cancelled');
        }
    }

    // Bulk status update
    function bulkStatusUpdate() {
        const selectedCheckboxes = document.querySelectorAll('.dist-checkbox:checked');
        if (selectedCheckboxes.length === 0) {
            alert('Pilih minimal satu distribusi terlebih dahulu');
            return;
        }

        const modal = new bootstrap.Modal(document.getElementById('bulkUpdateModal'));
        const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
        
        document.getElementById('selectedDistributions').innerHTML = `
            <div class="alert alert-light">
                <strong>${selectedIds.length}</strong> distribusi dipilih untuk bulk update
                <input type="hidden" name="distribution_ids" value="${selectedIds.join(',')}">
            </div>
        `;
        
        modal.show();
    }

    // Track multiple
    function trackMultiple() {
        const selectedCheckboxes = document.querySelectorAll('.dist-checkbox:checked');
        if (selectedCheckboxes.length === 0) {
            alert('Pilih distribusi yang ingin di-track terlebih dahulu');
            return;
        }

        const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
        window.open(`{{ route('logistik.distribusi.track-multiple') }}?ids=${selectedIds.join(',')}`, '_blank');
    }

    // Auto-refresh every 30 seconds for real-time updates
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            fetch('{{ route("logistik.distribusi.index") }}?ajax=1')
                .then(response => response.json())
                .then(data => {
                    if (data.in_transit_count > {{ $stats['in_transit'] }}) {
                        showNotification('New distributions are in transit!', 'info');
                    }
                    if (data.completed_today > {{ $stats['completed_today'] }}) {
                        showNotification('New distributions completed!', 'success');
                    }
                });
        }
    }, 30000);

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