@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Analytics Dashboard</h2>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.laporan.index') }}">Laporan</a></li>
                            <li class="breadcrumb-item active">Analytics</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Performance Indicators -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Key Performance Indicators</h5>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="ph-duotone ph-calendar me-1"></i>{{ request('period', 'This Month') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?period=today">Today</a></li>
                                <li><a class="dropdown-item" href="?period=this_week">This Week</a></li>
                                <li><a class="dropdown-item" href="?period=this_month">This Month</a></li>
                                <li><a class="dropdown-item" href="?period=this_quarter">This Quarter</a></li>
                                <li><a class="dropdown-item" href="?period=this_year">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- HR KPIs -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-gradient-primary text-white">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="text-white">{{ $kpis['total_employees'] }}</h3>
                                                <h6 class="text-white mb-0">Total Karyawan</h6>
                                                <p class="text-white-50 mb-0 f-12">
                                                    @if($kpis['employee_growth'] > 0)
                                                        <i class="ph-duotone ph-trend-up"></i> +{{ $kpis['employee_growth'] }}%
                                                    @else
                                                        <i class="ph-duotone ph-trend-down"></i> {{ $kpis['employee_growth'] }}%
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-4 text-end">
                                                <i class="ph-duotone ph-users f-28"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial KPIs -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-gradient-success text-white">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="text-white">Rp {{ number_format($kpis['total_revenue'], 0, ',', '.') }}</h3>
                                                <h6 class="text-white mb-0">Total Revenue</h6>
                                                <p class="text-white-50 mb-0 f-12">
                                                    @if($kpis['revenue_growth'] > 0)
                                                        <i class="ph-duotone ph-trend-up"></i> +{{ $kpis['revenue_growth'] }}%
                                                    @else
                                                        <i class="ph-duotone ph-trend-down"></i> {{ $kpis['revenue_growth'] }}%
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-4 text-end">
                                                <i class="ph-duotone ph-currency-circle-dollar f-28"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operational KPIs -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-gradient-warning text-white">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="text-white">{{ $kpis['operational_efficiency'] }}%</h3>
                                                <h6 class="text-white mb-0">Operational Efficiency</h6>
                                                <p class="text-white-50 mb-0 f-12">
                                                    @if($kpis['efficiency_change'] > 0)
                                                        <i class="ph-duotone ph-trend-up"></i> +{{ $kpis['efficiency_change'] }}%
                                                    @else
                                                        <i class="ph-duotone ph-trend-down"></i> {{ $kpis['efficiency_change'] }}%
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-4 text-end">
                                                <i class="ph-duotone ph-gear f-28"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Satisfaction -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-gradient-info text-white">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="text-white">{{ $kpis['satisfaction_score'] }}%</h3>
                                                <h6 class="text-white mb-0">Satisfaction Score</h6>
                                                <p class="text-white-50 mb-0 f-12">
                                                    @if($kpis['satisfaction_change'] > 0)
                                                        <i class="ph-duotone ph-trend-up"></i> +{{ $kpis['satisfaction_change'] }}%
                                                    @else
                                                        <i class="ph-duotone ph-trend-down"></i> {{ $kpis['satisfaction_change'] }}%
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-4 text-end">
                                                <i class="ph-duotone ph-heart f-28"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Employee Performance -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Employee Performance Trends</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="employeePerformanceChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Financial Overview -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Financial Overview</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="financialChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Analytics -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Department Performance</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Total Karyawan</th>
                                        <th>Avg Performance</th>
                                        <th>Productivity</th>
                                        <th>Budget Utilization</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departmentStats as $dept)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-{{ $dept['color'] }} me-2">
                                                    <i class="ph-duotone {{ $dept['icon'] }}"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $dept['name'] }}</h6>
                                                    <p class="text-muted f-12 mb-0">{{ $dept['manager'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-secondary">{{ $dept['total_employees'] }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="height: 6px; width: 60px;">
                                                    <div class="progress-bar bg-{{ $dept['performance'] >= 80 ? 'success' : ($dept['performance'] >= 60 ? 'warning' : 'danger') }}" 
                                                         style="width: {{ $dept['performance'] }}%"></div>
                                                </div>
                                                <span class="f-12">{{ $dept['performance'] }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $dept['productivity'] >= 85 ? 'success' : ($dept['productivity'] >= 70 ? 'warning' : 'danger') }}">
                                                {{ $dept['productivity'] }}%
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="height: 6px; width: 60px;">
                                                    <div class="progress-bar bg-info" style="width: {{ $dept['budget_utilization'] }}%"></div>
                                                </div>
                                                <span class="f-12">{{ $dept['budget_utilization'] }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($dept['performance'] >= 80 && $dept['productivity'] >= 85)
                                                <span class="badge bg-success">Excellent</span>
                                            @elseif($dept['performance'] >= 60 && $dept['productivity'] >= 70)
                                                <span class="badge bg-warning">Good</span>
                                            @else
                                                <span class="badge bg-danger">Needs Improvement</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resource Utilization -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Resource Utilization</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="resourceChart" height="200"></canvas>
                        
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="f-14">Human Resources</span>
                                <span class="f-14 text-success">{{ $resources['hr_utilization'] }}%</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: {{ $resources['hr_utilization'] }}%"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="f-14">Financial Resources</span>
                                <span class="f-14 text-warning">{{ $resources['financial_utilization'] }}%</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {{ $resources['financial_utilization'] }}%"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="f-14">Technology</span>
                                <span class="f-14 text-info">{{ $resources['tech_utilization'] }}%</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: {{ $resources['tech_utilization'] }}%"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="f-14">Infrastructure</span>
                                <span class="f-14 text-primary">{{ $resources['infrastructure_utilization'] }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: {{ $resources['infrastructure_utilization'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts and Insights -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>System Alerts</h5>
                    </div>
                    <div class="card-body">
                        @forelse($alerts as $alert)
                        <div class="d-flex align-items-start mb-3">
                            <div class="avtar avtar-s bg-light-{{ $alert['type'] }} me-3">
                                <i class="ph-duotone {{ $alert['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $alert['title'] }}</h6>
                                <p class="text-muted f-12 mb-1">{{ $alert['message'] }}</p>
                                <small class="text-muted">{{ $alert['time'] }}</small>
                            </div>
                            @if($alert['action_url'])
                            <div>
                                <a href="{{ $alert['action_url'] }}" class="btn btn-sm btn-outline-{{ $alert['type'] }}">
                                    Action
                                </a>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-3">
                            <i class="ph-duotone ph-check-circle f-32 text-success mb-2"></i>
                            <p class="text-muted">No active alerts</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Business Insights</h5>
                    </div>
                    <div class="card-body">
                        @foreach($insights as $insight)
                        <div class="d-flex align-items-start mb-3">
                            <div class="avtar avtar-s bg-light-info me-3">
                                <i class="ph-duotone ph-lightbulb"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $insight['title'] }}</h6>
                                <p class="text-muted f-12 mb-0">{{ $insight['description'] }}</p>
                                @if($insight['impact'])
                                <div class="mt-2">
                                    <span class="badge bg-light-{{ $insight['impact']['type'] }}">
                                        {{ $insight['impact']['text'] }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Options -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Export Analytics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" onclick="exportReport('pdf')">
                                    <i class="ph-duotone ph-file-pdf me-1"></i>Export to PDF
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-outline-success w-100 mb-2" onclick="exportReport('excel')">
                                    <i class="ph-duotone ph-microsoft-excel-logo me-1"></i>Export to Excel
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-outline-info w-100 mb-2" onclick="exportReport('csv')">
                                    <i class="ph-duotone ph-file-csv me-1"></i>Export to CSV
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-outline-secondary w-100 mb-2" onclick="scheduleReport()">
                                    <i class="ph-duotone ph-calendar-plus me-1"></i>Schedule Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
<script>
    // Employee Performance Chart
    const employeeCtx = document.getElementById('employeePerformanceChart').getContext('2d');
    new Chart(employeeCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['employee_labels']) !!},
            datasets: [{
                label: 'Average Performance',
                data: {!! json_encode($chartData['employee_performance']) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1
            }, {
                label: 'Attendance Rate',
                data: {!! json_encode($chartData['attendance_rate']) !!},
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Financial Chart
    const financialCtx = document.getElementById('financialChart').getContext('2d');
    new Chart(financialCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['financial_labels']) !!},
            datasets: [{
                label: 'Revenue (Million)',
                data: {!! json_encode($chartData['revenue_data']) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.8)'
            }, {
                label: 'Expenses (Million)',
                data: {!! json_encode($chartData['expense_data']) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.8)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Resource Utilization Chart
    const resourceCtx = document.getElementById('resourceChart').getContext('2d');
    new Chart(resourceCtx, {
        type: 'doughnut',
        data: {
            labels: ['HR', 'Financial', 'Technology', 'Infrastructure'],
            datasets: [{
                data: [
                    {{ $resources['hr_utilization'] }},
                    {{ $resources['financial_utilization'] }},
                    {{ $resources['tech_utilization'] }},
                    {{ $resources['infrastructure_utilization'] }}
                ],
                backgroundColor: [
                    '#28a745',
                    '#ffc107',
                    '#17a2b8',
                    '#007bff'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Export Functions
    function exportReport(format) {
        const period = '{{ request("period", "this_month") }}';
        window.open(`{{ route('superadmin.laporan.analytics') }}/export?format=${format}&period=${period}`, '_blank');
    }

    function scheduleReport() {
        // Open schedule modal or redirect to schedule page
        alert('Schedule report feature will be implemented');
    }

    // Auto-refresh every 5 minutes
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            location.reload();
        }
    }, 300000);
</script>
@endpush