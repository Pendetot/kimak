<li class="pc-item pc-caption">
  <label data-i18n="Navigation">Navigation</label>
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
  <label data-i18n="Keuangan">Keuangan</label>
  <i class="ph-duotone ph-currency-dollar"></i>
</li>
<li class="pc-item"><a href="{{ route('hutang.index') }}" class="pc-link">
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