<li class="pc-item pc-caption">
  <label data-i18n="Navigation">Navigation</label>
  <i class="ph-duotone ph-gauge"></i>
</li>
<li class="pc-item">
  <a href="{{ route('pelamar.dashboard') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-gauge"></i>
    </span>
    <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
  </a>
</li>
@if(Auth::user()->pelamar)
<li class="pc-item">
  <a href="{{ route('pelamar.edit', Auth::user()->pelamar->id) }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-user-circle"></i>
    </span>
    <span class="pc-mtext" data-i18n="Edit Profil">Edit Profil</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('pelamar.upload-documents', Auth::user()->pelamar->id) }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-upload"></i>
    </span>
    <span class="pc-mtext" data-i18n="Upload Dokumen">Upload Dokumen</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('hrd.administrasi-pelamar.show-confirm-interview', Auth::user()->pelamar->id) }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-calendar-check"></i>
    </span>
    <span class="pc-mtext" data-i18n="Konfirmasi Interview">Konfirmasi Interview</span>
  </a>
</li>
@endif
<li class="pc-item">
  <a href="{{ route('pelamar.dashboard') }}#pat-results" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-file-text"></i>
    </span>
    <span class="pc-mtext" data-i18n="Hasil PAT">Hasil PAT</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('pelamar.dashboard') }}#psikotest-results" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-file-text"></i>
    </span>
    <span class="pc-mtext" data-i18n="Hasil Psikotest">Hasil Psikotest</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('pelamar.dashboard') }}#health-test-results" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-file-text"></i>
    </span>
    <span class="pc-mtext" data-i18n="Hasil Tes Kesehatan">Hasil Tes Kesehatan</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('pelamar.dashboard') }}#interview-results" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-file-text"></i>
    </span>
    <span class="pc-mtext" data-i18n="Hasil Interview">Hasil Interview</span>
  </a>
</li>
<li class="pc-item">
  <a href="{{ route('pelamar.dashboard') }}#final-decision" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-check-circle"></i>
    </span>
    <span class="pc-mtext" data-i18n="Keputusan Akhir">Keputusan Akhir</span>
  </a>
</li>
