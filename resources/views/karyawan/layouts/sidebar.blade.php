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
  <label data-i18n="Manajemen Karyawan">Manajemen Karyawan</label>
</li>
<li class="pc-item">
  <a href="{{ route('karyawan.absensis') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-clock"></i>
    </span>
    <span class="pc-mtext" data-i18n="Absensi">Absensi</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('karyawan.lap-dokumens') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-file-text"></i>
    </span>
    <span class="pc-mtext" data-i18n="Laporan Dokumen">Laporan Dokumen</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('karyawan.pembinaans') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-users"></i>
    </span>
    <span class="pc-mtext" data-i18n="Pembinaan">Pembinaan</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('karyawan.kpis') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-chart-line"></i>
    </span>
    <span class="pc-mtext" data-i18n="Penilaian KPI">Penilaian KPI</span>
  </a>
</li>