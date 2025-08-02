<li class="pc-item pc-caption">
    <label data-i18n="Navigasi">Navigasi</label>
    <i class="ph-duotone ph-gauge"></i>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.dashboard') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-gauge"></i>
        </span>
        <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Manajemen Pengadaan">Manajemen Pengadaan</label>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.pengajuan-barang.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-clipboard-text"></i>
        </span>
        <span class="pc-mtext" data-i18n="Permintaan Barang">Permintaan Barang</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.pembelian.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-shopping-cart"></i>
        </span>
        <span class="pc-mtext" data-i18n="Pembelian">Pembelian</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.vendor.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-buildings"></i>
        </span>
        <span class="pc-mtext" data-i18n="Vendor">Vendor</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Inventory">Inventory</label>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.barang.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-package"></i>
        </span>
        <span class="pc-mtext" data-i18n="Master Barang">Master Barang</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.stock.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-stack"></i>
        </span>
        <span class="pc-mtext" data-i18n="Stock Barang">Stock Barang</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.distribusi.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-truck"></i>
        </span>
        <span class="pc-mtext" data-i18n="Distribusi">Distribusi</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Laporan">Laporan</label>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.laporan.pembelian') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-bar"></i>
        </span>
        <span class="pc-mtext" data-i18n="Laporan Pembelian">Laporan Pembelian</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('logistik.laporan.stock') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-line"></i>
        </span>
        <span class="pc-mtext" data-i18n="Laporan Stock">Laporan Stock</span>
    </a>
</li>