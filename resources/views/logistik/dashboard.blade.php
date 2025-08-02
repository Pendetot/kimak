@extends('layouts.main')

@section('title', 'Dashboard Logistik')

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
                            <i class="ph-duotone ph-package f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Total Pengajuan Barang</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $totalPengajuan }}</h2>
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
                            <i class="ph-duotone ph-clock f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Pending Approval Logistik</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $pendingLogisticApproval }}</h2>
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
                            <i class="ph-duotone ph-check-circle f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Disetujui Logistik</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $approvedByLogistic }}</h2>
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
                            <i class="ph-duotone ph-x-circle f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Pengajuan Ditolak</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $rejectedPengajuan }}</h2>
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
                            <i class="ph-duotone ph-shopping-cart f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Sudah Dibeli</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $purchasedPengajuan }}</h2>
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
                            <i class="ph-duotone ph-truck f-26"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Sudah Diterima</p>
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 f-w-500">{{ $deliveredPengajuan }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Row 1 ] end -->
    </div>
@endsection