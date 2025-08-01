@extends('layouts.app')

@section('title', 'Form Templates')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Form Templates Management</h5>
                    <p class="text-muted">Download and manage all available form templates</p>
                </div>
                <div class="card-body">
                    @foreach($forms as $categoryKey => $category)
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">{{ $category['title'] }}</h6>
                        <div class="row">
                            @foreach($category['forms'] as $filename => $title)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                @if(str_ends_with($filename, '.xlsx'))
                                                    <i class="ph-duotone ph-file-xls text-success f-24"></i>
                                                @elseif(str_ends_with($filename, '.docx') || str_ends_with($filename, '.doc'))
                                                    <i class="ph-duotone ph-file-doc text-primary f-24"></i>
                                                @elseif(str_ends_with($filename, '.pdf'))
                                                    <i class="ph-duotone ph-file-pdf text-danger f-24"></i>
                                                @else
                                                    <i class="ph-duotone ph-file text-secondary f-24"></i>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">{{ $title }}</h6>
                                                <p class="text-muted mb-0 small">{{ $filename }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('forms.download', $filename) }}" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="ph-duotone ph-download me-1"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection