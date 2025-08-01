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
  <label data-i18n="Manajemen Pengguna">Manajemen Pengguna</label>
</li>
<li class="pc-item">
  <a href="{{ route('superadmin.users.index', ['role' => \App\Enums\RoleEnum::SuperAdmin->value]) }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-user-shield"></i>
    </span>
    <span class="pc-mtext" data-i18n="Super Admin">Super Admin</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('superadmin.users.index', ['role' => \App\Enums\RoleEnum::HRD->value]) }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-user-plus"></i>
    </span>
    <span class="pc-mtext" data-i18n="HRD">HRD</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('superadmin.users.index', ['role' => \App\Enums\RoleEnum::Keuangan->value]) }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-currency-dollar"></i>
    </span>
    <span class="pc-mtext" data-i18n="Keuangan">Keuangan</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('superadmin.users.index', ['role' => \App\Enums\RoleEnum::Karyawan->value]) }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-settings"></i>
    </span>
    <span class="pc-mtext" data-i18n="Operasional">Operasional</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('superadmin.users.index', ['role' => \App\Enums\RoleEnum::Logistik->value]) }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-shield"></i>
    </span>
    <span class="pc-mtext" data-i18n="Guard">Guard</span>
  </a>
</li>