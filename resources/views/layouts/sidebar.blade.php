<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home') }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ URL::asset('build/images/logo-dark.svg') }}" alt="logo image" class="logo-lg">
                <span class="badge bg-brand-color-2 rounded-pill ms-1 theme-version">v1.2.0</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                @if(Auth::guard('karyawan')->check())
                    @include('karyawan.layouts.sidebar')
                @elseif(Auth::check())
                    @if(Auth::user()->hasRole(\App\Enums\RoleEnum::SuperAdmin))
                        @include('superadmin.layouts.sidebar')
                    @elseif(Auth::user()->hasRole(\App\Enums\RoleEnum::HRD))
                        @include('hrd.layouts.sidebar')
                    @elseif(Auth::user()->hasRole(\App\Enums\RoleEnum::Keuangan))
                        @include('keuangan.layouts.sidebar')
                    @elseif(Auth::user()->hasRole(\App\Enums\RoleEnum::Logistik))
                        @include('logistik.layouts.sidebar')
                    @elseif(Auth::user()->hasRole(\App\Enums\RoleEnum::Pelamar))
                        @include('pelamar.layouts.sidebar')
                    @endif
                @endif
            </ul>
            <div class="card nav-action-card bg-brand-color-4">
                <div class="card-body" style="background-image: url('/build/images/layout/nav-card-bg.svg')">
                    <h5 class="text-dark">Help Center</h5>
                    <p class="text-dark text-opacity-75">Please contact us for more questions.</p>
                    <a href="https://phoenixcoded.support-hub.io/" class="btn btn-primary" target="_blank">Go to help
                        Center</a>
                </div>
            </div>
        </div>
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ URL::asset('build/images/user/avatar-1.jpg') }}" alt="user-image"
                            class="user-avtar wid-45 rounded-circle">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="dropdown">
                            <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,20">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0">{{ Auth::user() ? Auth::user()->name : 'Guest' }}</h6>
                                        <small>{{ Auth::user() && Auth::user()->role ? Auth::user()->role->value : '' }}</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="btn btn-icon btn-link-secondary avtar">
                                            <i class="ph-duotone ph-windows-logo"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a class="pc-user-links">
                                            <i class="ph-duotone ph-user"></i>
                                            <span>My Account</span>
                                        </a></li>
                                    <li><a class="pc-user-links">
                                            <i class="ph-duotone ph-gear"></i>
                                            <span>Settings</span>
                                        </a></li>
                                    <li><a class="pc-user-links">
                                            <i class="ph-duotone ph-lock-key"></i>
                                            <span>Lock Screen</span>
                                        </a></li>
                                    <li><a class="pc-user-links" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                            <i class="ph-duotone ph-power"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->