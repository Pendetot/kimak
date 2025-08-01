@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5>Daftar Pengguna @if($role) ({{ ucfirst($role) }}) @endif</h5>
                    <div class="dropdown">
                        <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons-two-tone f-18">more_vert</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach(\App\Enums\RoleEnum::cases() as $roleEnum)
                                <a class="dropdown-item" href="{{ route('superadmin.users.create', ['role' => $roleEnum->value]) }}">Tambah Akun {{ ucfirst($roleEnum->value) }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-body py-2 px-0">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role->value ?? 'N/A') }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('superadmin.users.edit', $user->id) }}" class="btn avtar avtar-xs btn-light-warning">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn avtar avtar-xs btn-light-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @unless(count($users))
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Belum ada pengguna.
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
