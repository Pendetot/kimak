@extends('layouts.AuthLayout') {{-- Menggunakan AuthLayout dari views-2 --}}

@section('title', 'Login - ' . ucfirst($role)) {{-- Menyesuaikan judul --}}

@section('content')
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center">
                    {{-- Pastikan path gambar benar atau hapus jika tidak ada --}}
                    <img src="{{ URL::asset('build/images/authentication/img-auth-login.png') }}" alt="images" class="img-fluid mb-3">
                    <h4 class="f-w-500 mb-1">Login with your email</h4>
                    
                </div>
                <form method="POST" action="{{ url($role . '/auth/login') }}"> {{-- Menggunakan rute login kustom --}}
                    @csrf
                    <div class="form-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="floatingInput" placeholder="Email Address">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="floatingInput1" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="d-flex mt-1 justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input input-primary" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted" for="remember">Remember me?</label>
                        </div>
                        
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
@endsection