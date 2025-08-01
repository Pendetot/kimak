<li class="pc-item pc-caption">
  <label data-i18n="Navigation">Navigation</label>
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
  <label data-i18n="SuperAdmin">SuperAdmin</label>
  <i class="ph-duotone ph-user-crown"></i>
</li>
<li class="pc-item"><a href="{{ route('superadmin.users.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-users-three"></i>
    </span>
    <span class="pc-mtext" data-i18n="Manajemen Pengguna">Manajemen Pengguna</span></a></li>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-gear"></i>
    </span>
    <span class="pc-mtext">Settings</span>
    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <li class="pc-item"><a class="pc-link" href="{{ route('superadmin.settings.index') }}">Formulir Pendaftaran</a></li>
    <li class="pc-item"><a class="pc-link" href="{{ route('superadmin.settings.website.index') }}">Website</a></li>
    <li class="pc-item"><a class="pc-link" href="{{ route('superadmin.settings.validation.index') }}">Validasi Pelamar</a></li>
    <li class="pc-item"><a class="pc-link" href="{{ route('superadmin.settings.smtp.index') }}">SMTP</a></li>
  </ul>
</li>
<li class="pc-item"><a href="{{ route('superadmin.pembelian-barang.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-shopping-cart"></i>
    </span>
    <span class="pc-mtext" data-i18n="Pembelian Barang">Pembelian Barang</span></a></li>
<li class="pc-item"><a href="{{ route('superadmin.pengajuan-barang-approval.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-check-circle"></i>
    </span>
    <span class="pc-mtext" data-i18n="Approval Pengajuan Barang">Approval Pengajuan Barang</span></a></li>

<li class="pc-item pc-caption">
  <label data-i18n="HRD">HRD</label>
  <i class="ph-duotone ph-hard-hat"></i>
</li>
<li class="pc-item"><a href="{{ route('hrd.data-karyawan') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-users-three"></i>
    </span>
    <span class="pc-mtext" data-i18n="Data Karyawan">Data Karyawan</span></a></li>
<li class="pc-item"><a href="{{ route('hrd.pengajuan-cuti') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-calendar-blank"></i>
    </span>
    <span class="pc-mtext" data-i18n="Pengajuan Cuti">Pengajuan Cuti</span></a></li>
<li class="pc-item"><a href="{{ route('hrd.data-resign') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-door-open"></i>
    </span>
    <span class="pc-mtext" data-i18n="Data Resign">Data Resign</span></a></li>
<li class="pc-item"><a href="{{ route('hrd.surat-peringatan') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-warning-circle"></i>
    </span>
    <span class="pc-mtext" data-i18n="Surat Peringatan">Surat Peringatan</span></a></li>
<li class="pc-item"><a href="{{ route('hrd.mutasi-karyawan') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-arrows-left-right"></i>
    </span>
    <span class="pc-mtext" data-i18n="Mutasi Karyawan">Mutasi Karyawan</span></a></li>
<li class="pc-item"><a href="{{ route('hrd.kpi-penilaian.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-chart-line"></i>
    </span>
    <span class="pc-mtext" data-i18n="Penilaian KPI">Penilaian KPI</span></a></li>
<li class="pc-item"><a href="{{ route('superadmin.administrasi-pelamar.index') }}" class="pc-link">
    <span class="pc-micon">
        <i class="ph-duotone ph-user-plus"></i>
    </span>
    <span class="pc-mtext" data-i18n="Daftar Pelamar">Daftar Pelamar</span></a></li>

<li class="pc-item pc-caption">
  <label data-i18n="Keuangan">Keuangan</label>
  <i class="ph-duotone ph-currency-dollar"></i>
</li>
<li class="pc-item"><a href="{{ route('keuangan.hutang-karyawans.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-money"></i>
    </span>
    <span class="pc-mtext" data-i18n="Hutang Karyawan">Hutang Karyawan</span></a></li>
<li class="pc-item"><a href="{{ route('keuangan.rekening-karyawans.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-bank"></i>
    </span>
    <span class="pc-mtext" data-i18n="Rekening Karyawan">Rekening Karyawan</span></a></li>
<li class="pc-item"><a href="{{ route('keuangan.penalti-sp.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-currency-dollar"></i>
    </span>
    <span class="pc-mtext" data-i18n="Penalti SP">Penalti SP</span></a></li>

<li class="pc-item pc-caption">
  <label data-i18n="Karyawan">Karyawan</label>
  <i class="ph-duotone ph-tools"></i>
</li>
<li class="pc-item">
  <a href="{{ route('karyawan.dashboard') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-gauge"></i>
    </span>
    <span class="pc-mtext" data-i18n="Dashboard Karyawan">Dashboard Karyawan</span>
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
<li class="pc-item"><a href="{{ route('karyawan.lap-dokumens') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-file-text"></i>
    </span>
    <span class="pc-mtext" data-i18n="Lapsem">Lapsem</span></a></li>
<li class="pc-item"><a href="{{ route('karyawan.pembinaans') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-users"></i>
    </span>
    <span class="pc-mtext" data-i18n="Pembinaan">Pembinaan</span></a></li>

<li class="pc-item pc-caption">
  <label data-i18n="Logistik">Logistik</label>
  <i class="ph-duotone ph-truck"></i>
</li>
<li class="pc-item">
  <a href="{{ route('logistik.dashboard') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-gauge"></i>
    </span>
    <span class="pc-mtext" data-i18n="Dashboard Logistik">Dashboard Logistik</span>
  </a>
</li>
<li class="pc-item"><a href="{{ route('logistik.pengajuan-barang.index') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-package"></i>
    </span>
    <span class="pc-mtext" data-i18n="Pengajuan Barang">Pengajuan Barang</span></a></li>

<li class="pc-item pc-caption">
  <label data-i18n="Pelamar">Pelamar</label>
  <i class="ph-duotone ph-user"></i>
</li>
<li class="pc-item"><a href="{{ route('pelamar.dashboard') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-user"></i>
    </span>
    <span class="pc-mtext" data-i18n="Dashboard Pelamar">Dashboard Pelamar</span></a></li>
