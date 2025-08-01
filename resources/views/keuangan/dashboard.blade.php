@extends('layouts.app')

@section('title', 'Keuangan Dashboard')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ Row 1 ] start -->
        <div class="col-md-12 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-2.svg') }}" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-1 text-white me-3">
                            <i class="ph-duotone ph-currency-dollar f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Total Hutang Karyawan</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">Rp {{ number_format($totalHutangKaryawan, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-1.svg') }}" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-2 text-white me-3">
                            <i class="ph-duotone ph-currency-dollar f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Total Hutang Belum Lunas</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">Rp {{ number_format($totalHutangBelumLunas, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-3.svg') }}" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-3 text-white me-3">
                            <i class="ph-duotone ph-warning-circle f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Total Penalti SP</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">Rp {{ number_format($totalPenaltiSP, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-4.svg') }}" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-1 text-white me-3">
                            <i class="ph-duotone ph-users f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Jumlah Karyawan Berhutang</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $jumlahKaryawanBerhutang }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-4">
            <div class="card statistics-card-1">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-5.svg') }}" alt="img" class="img-fluid img-bg" />
                    <div class="d-flex align-items-center">
                        <div class="avtar bg-brand-color-2 text-white me-3">
                            <i class="ph-duotone ph-user-minus f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Jumlah Karyawan Terkena SP</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $jumlahKaryawanTerkenaSP }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Row 1 ] end -->
    </div>
@endsection
