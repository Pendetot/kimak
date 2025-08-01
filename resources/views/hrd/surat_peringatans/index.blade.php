@extends('layouts.app')

@section('title', 'Manajemen Surat Peringatan')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-xl-12">
      <div class="card table-card">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
          <h5>Daftar Surat Peringatan</h5>
          <div class="dropdown">
            <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons-two-tone f-18">more_vert</i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
              <a class="dropdown-item" href="{{ route('hrd.surat-peringatan.create') }}">Tambah SP</a>
            </div>
          </div>
        </div>
        <div class="card-body py-2 px-0">
          <div class="table-responsive">
            <table class="table table-hover table-borderless table-sm mb-0">
              <tbody>
                @foreach($suratPeringatans as $sp)
                  <tr>
                    <td>
                      <div class="d-inline-block align-middle">
                        <div class="d-inline-block">
                          <h6 class="m-b-0">{{ $sp->karyawan ? $sp->karyawan->nama : 'N/A' }}</h6>
                          <p class="m-b-0">{{ $sp->tanggal_sp->format('d M Y') }}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="m-b-0">{{ ucfirst($sp->jenis_sp->value) }}</p>
                    </td>
                    <td class="text-end">
                      <div class="d-inline-flex">
                        
                        
                        <form action="{{ route('hrd.surat-peringatan.destroy', $sp->id) }}"
                              method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                                  class="btn avtar avtar-xs btn-light-danger"
                                  onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="ti ti-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
                @unless($suratPeringatans->count())
                  <tr>
                    <td colspan="3" class="text-center py-4 text-muted">
                      Belum ada surat peringatan.
                    </td>
                  </tr>
                @endunless
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('components.delete-confirmation-modal')
@endsection