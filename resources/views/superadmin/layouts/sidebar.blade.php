<li class="pc-item pc-caption">
    <label data-i18n="Navigasi">Navigasi</label>
    <i class="ph-duotone ph-gauge"></i>
</li>
<li class="pc-item">
    <a href="{{ route('superadmin.dashboard') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-gauge"></i>
        </span>
        <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Sistem & Pengguna">Sistem & Pengguna</label>
</li>
<li class="pc-item">
    <a href="{{ route('superadmin.users.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-users-three"></i>
        </span>
        <span class="pc-mtext" data-i18n="Manajemen Pengguna">Manajemen Pengguna</span>
    </a>
</li>
<li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-gear"></i>
        </span>
        <span class="pc-mtext">Pengaturan Sistem</span>
        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="pc-submenu">
        <li class="pc-item"><a class="pc-link" href="{{ route('superadmin.settings.index') }}">Formulir Pendaftaran</a></li>
        <li class="pc-item"><a class="pc-link" href="{{ route('superadmin.settings.website.index') }}">Website</a></li>
        <li class="pc-item"><a class="pc-link" href="{{ route('superadmin.settings.validation.index') }}">Validasi Pelamar</a></li>
        <li class="pc-item"><a class="pc-link" href="{{ route('superadmin.settings.smtp.index') }}">SMTP</a></li>
    </ul>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Manajemen Karyawan">Manajemen Karyawan</label>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.karyawans.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-users-three"></i>
        </span>
        <span class="pc-mtext" data-i18n="Data Karyawan">Data Karyawan</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.cutis.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-calendar-blank"></i>
        </span>
        <span class="pc-mtext" data-i18n="Manajemen Cuti">Manajemen Cuti</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.surat-peringatans.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-warning-circle"></i>
        </span>
        <span class="pc-mtext" data-i18n="Surat Peringatan">Surat Peringatan</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Keuangan">Keuangan</label>
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

<li class="pc-item pc-caption">
    <label data-i18n="Logistik & Pengadaan">Logistik & Pengadaan</label>
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
    <a href="{{ route('superadmin.pembelian-barang.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-shopping-cart"></i>
        </span>
        <span class="pc-mtext" data-i18n="Pembelian Barang">Pembelian Barang</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('superadmin.pengajuan-barang-approval.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-check-circle"></i>
        </span>
        <span class="pc-mtext" data-i18n="Approval Final">Approval Final</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Rekrutmen">Rekrutmen</label>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.pelamars.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-user-plus"></i>
        </span>
        <span class="pc-mtext" data-i18n="Daftar Pelamar">Daftar Pelamar</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Laporan & Analytics">Laporan & Analytics</label>
</li>
<li class="pc-item">
    <a href="{{ route('superadmin.laporan.karyawan') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-bar"></i>
        </span>
        <span class="pc-mtext" data-i18n="Laporan Karyawan">Laporan Karyawan</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('superadmin.laporan.keuangan') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-line"></i>
        </span>
        <span class="pc-mtext" data-i18n="Laporan Keuangan">Laporan Keuangan</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('superadmin.laporan.logistik') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-pie"></i>
        </span>
        <span class="pc-mtext" data-i18n="Laporan Logistik">Laporan Logistik</span>
    </a>
</li>
