<li class="pc-item pc-caption">
    <label data-i18n="Navigasi">Navigasi</label>
    <i class="ph-duotone ph-gauge"></i>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.dashboard') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-gauge"></i>
        </span>
        <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
    </a>
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
    <a href="{{ route('hrd.kpi-penilaian.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-line"></i>
        </span>
        <span class="pc-mtext" data-i18n="Penilaian KPI">Penilaian KPI</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Administrasi HR">Administrasi HR</label>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.surat-peringatans.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-warning-circle"></i>
        </span>
        <span class="pc-mtext" data-i18n="Surat Peringatan">Surat Peringatan</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.mutasis.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-arrows-left-right"></i>
        </span>
        <span class="pc-mtext" data-i18n="Mutasi Karyawan">Mutasi Karyawan</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.resigns.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-door-open"></i>
        </span>
        <span class="pc-mtext" data-i18n="Data Resign">Data Resign</span>
    </a>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Rekrutmen">Rekrutmen</label>
</li>
<li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-user-plus"></i>
        </span>
        <span class="pc-mtext" data-i18n="Administrasi Pelamar">Administrasi Pelamar</span>
        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="pc-submenu">
        <li class="pc-item"><a class="pc-link" href="{{ route('hrd.administrasi-pelamar') }}">Daftar Pelamar</a></li>
        <li class="pc-item"><a class="pc-link" href="{{ route('hrd.interview-attendance.index') }}">Kehadiran Interview</a></li>
    </ul>
</li>

<li class="pc-item pc-caption">
    <label data-i18n="Dokumen & Template">Dokumen & Template</label>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.forms.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-files"></i>
        </span>
        <span class="pc-mtext" data-i18n="Form Templates">Form Templates</span>
    </a>
</li>
<li class="pc-item">
    <a href="{{ route('hrd.laporan.index') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-chart-bar"></i>
        </span>
        <span class="pc-mtext" data-i18n="Laporan HR">Laporan HR</span>
    </a>
</li>