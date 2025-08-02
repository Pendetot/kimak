<li class="pc-item pc-caption">
    <label data-i18n="Navigasi">Navigasi</label>
    <i class="ph-duotone ph-gauge"></i>
</li>
<li class="pc-item">
    <a href="{{ route('karyawan.dashboard') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-gauge"></i>
        </span>
        <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Absensi & Kinerja">Absensi & Kinerja</label>
</li>
<li class="pc-item">
    <a href="{{ route('karyawan.absensi.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-clock"></i>
        </span>
        <span class="pc-mtext" data-i18n="Absensi">Absensi</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('karyawan.kpi.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-line"></i>
        </span>
        <span class="pc-mtext" data-i18n="Penilaian KPI">Penilaian KPI</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Pengajuan & Permintaan">Pengajuan & Permintaan</label>
</li>
<li class="pc-item">
    <a href="{{ route('karyawan.cuti.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-calendar-blank"></i>
        </span>
        <span class="pc-mtext" data-i18n="Cuti">Pengajuan Cuti</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('karyawan.pengajuan-barang.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-shopping-cart"></i>
        </span>
        <span class="pc-mtext" data-i18n="Permintaan Barang">Permintaan Barang</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Personal">Personal</label>
</li>
<li class="pc-item">
    <a href="{{ route('karyawan.profile.show') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-user-circle"></i>
        </span>
        <span class="pc-mtext" data-i18n="Profil">Profil Saya</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('karyawan.dokumen.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-file-text"></i>
        </span>
        <span class="pc-mtext" data-i18n="Dokumen">Dokumen Saya</span>
    </a>
</li>