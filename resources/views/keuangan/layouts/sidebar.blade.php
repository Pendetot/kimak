<li class="pc-item pc-caption">
    <label data-i18n="Navigasi">Navigasi</label>
    <i class="ph-duotone ph-gauge"></i>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.dashboard') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-gauge"></i>
        </span>
        <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Manajemen Hutang">Manajemen Hutang</label>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.hutang-karyawans.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-money"></i>
        </span>
        <span class="pc-mtext" data-i18n="Hutang Karyawan">Hutang Karyawan</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.penalti-sp.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-warning-diamond"></i>
        </span>
        <span class="pc-mtext" data-i18n="Penalti SP">Penalti SP</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.pembayaran.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-credit-card"></i>
        </span>
        <span class="pc-mtext" data-i18n="Pembayaran">Pembayaran</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Data Karyawan">Data Karyawan</label>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.rekening-karyawans.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-bank"></i>
        </span>
        <span class="pc-mtext" data-i18n="Rekening Karyawan">Rekening Karyawan</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.gaji.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-currency-circle-dollar"></i>
        </span>
        <span class="pc-mtext" data-i18n="Gaji Karyawan">Gaji Karyawan</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Laporan Keuangan">Laporan Keuangan</label>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.laporan.hutang') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-bar"></i>
        </span>
        <span class="pc-mtext" data-i18n="Laporan Hutang">Laporan Hutang</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.laporan.gaji') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-line"></i>
        </span>
        <span class="pc-mtext" data-i18n="Laporan Gaji">Laporan Gaji</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('keuangan.laporan.cash-flow') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-pie"></i>
        </span>
        <span class="pc-mtext" data-i18n="Cash Flow">Cash Flow</span>
    </a>
</li>