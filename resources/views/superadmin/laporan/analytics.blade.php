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
                            <li class="breadcrumb-item active">Analytics</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Controls -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Periode Analisis</label>
                                <select class="form-select" id="periodFilter">
                                    <option value="7d">7 Hari Terakhir</option>
                                    <option value="30d" selected>30 Hari Terakhir</option>
                                    <option value="90d">3 Bulan Terakhir</option>
                                    <option value="1y">1 Tahun Terakhir</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Departemen</label>
                                <select class="form-select" id="departmentFilter">
                                    <option value="all">Semua Departemen</option>
                                    <option value="HRD">HRD</option>
                                    <option value="Keuangan">Keuangan</option>
                                    <option value="Logistik">Logistik</option>
                                    <option value="Operasional">Operasional</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Metrik</label>
                                <select class="form-select" id="metricFilter">
                                    <option value="all">Semua Metrik</option>
                                    <option value="performance">Performance</option>
                                    <option value="financial">Financial</option>
                                    <option value="operational">Operational</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100" onclick="updateAnalytics()">
                                    <i class="ph-duotone ph-chart-line me-1"></i>Update Analytics
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Overview -->
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="card bg-gradient-primary">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white mb-1">8.7</h4>
                                <h6 class="text-white m-b-0">Overall Performance</h6>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-white" style="width: 87%"></div>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <i class="ph-duotone ph-chart-line f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-gradient-success">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white mb-1">94.2%</h4>
                                <h6 class="text-white m-b-0">Employee Satisfaction</h6>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-white" style="width: 94%"></div>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <i class="ph-duotone ph-smiley f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-gradient-warning">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white mb-1">12.5%</h4>
                                <h6 class="text-white m-b-0">Cost Efficiency</h6>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-white" style="width: 75%"></div>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <i class="ph-duotone ph-currency-circle-dollar f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card bg-gradient-info">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-white mb-1">89.1%</h4>
                                <h6 class="text-white m-b-0">Process Automation</h6>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-white" style="width: 89%"></div>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <i class="ph-duotone ph-robot f-28 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Analytics Charts -->
        <div class="row">
            <!-- Revenue & Cost Trends -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Revenue & Cost Trends</h5>
                        <div class="card-header-right">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="revenueView" id="monthly" checked>
                                <label class="btn btn-outline-primary btn-sm" for="monthly">Monthly</label>
                                <input type="radio" class="btn-check" name="revenueView" id="quarterly">
                                <label class="btn btn-outline-primary btn-sm" for="quarterly">Quarterly</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Department Performance -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Department Performance</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="departmentChart"></canvas>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small>HRD</small>
                                <small>92%</small>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: 92%"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small>Keuangan</small>
                                <small>88%</small>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 88%"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small>Logistik</small>
                                <small>85%</small>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: 85%"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small>Operasional</small>
                                <small>90%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Analytics -->
        <div class="row">
            <!-- Employee Analytics -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Employee Analytics</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="employeeChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Resource Utilization -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Resource Utilization</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="resourceChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Analytics Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Detailed Performance Metrics</h5>
                        <div class="card-header-right">
                            <button class="btn btn-outline-success btn-sm" onclick="exportAnalytics()">
                                <i class="ph-duotone ph-export me-1"></i>Export Report
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="analyticsTable">
                                <thead>
                                    <tr>
                                        <th>Metric</th>
                                        <th>Current Period</th>
                                        <th>Previous Period</th>
                                        <th>Change</th>
                                        <th>Trend</th>
                                        <th>Target</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-primary me-2">
                                                    <i class="ph-duotone ph-users"></i>
                                                </div>
                                                Employee Productivity
                                            </div>
                                        </td>
                                        <td>87.5%</td>
                                        <td>84.2%</td>
                                        <td><span class="badge bg-success">+3.3%</span></td>
                                        <td><i class="ph-duotone ph-trend-up text-success"></i></td>
                                        <td>85%</td>
                                        <td><span class="badge bg-success">Above Target</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-success me-2">
                                                    <i class="ph-duotone ph-currency-circle-dollar"></i>
                                                </div>
                                                Cost per Employee
                                            </div>
                                        </td>
                                        <td>$2,450</td>
                                        <td>$2,580</td>
                                        <td><span class="badge bg-success">-5.0%</span></td>
                                        <td><i class="ph-duotone ph-trend-down text-success"></i></td>
                                        <td>$2,500</td>
                                        <td><span class="badge bg-success">Below Target</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-warning me-2">
                                                    <i class="ph-duotone ph-clock"></i>
                                                </div>
                                                Attendance Rate
                                            </div>
                                        </td>
                                        <td>94.8%</td>
                                        <td>93.2%</td>
                                        <td><span class="badge bg-success">+1.6%</span></td>
                                        <td><i class="ph-duotone ph-trend-up text-success"></i></td>
                                        <td>95%</td>
                                        <td><span class="badge bg-warning">Near Target</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-info me-2">
                                                    <i class="ph-duotone ph-chart-bar"></i>
                                                </div>
                                                Process Efficiency
                                            </div>
                                        </td>
                                        <td>78.9%</td>
                                        <td>81.5%</td>
                                        <td><span class="badge bg-danger">-2.6%</span></td>
                                        <td><i class="ph-duotone ph-trend-down text-danger"></i></td>
                                        <td>80%</td>
                                        <td><span class="badge bg-danger">Below Target</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-danger me-2">
                                                    <i class="ph-duotone ph-heart"></i>
                                                </div>
                                                Employee Satisfaction
                                            </div>
                                        </td>
                                        <td>8.7/10</td>
                                        <td>8.4/10</td>
                                        <td><span class="badge bg-success">+0.3</span></td>
                                        <td><i class="ph-duotone ph-trend-up text-success"></i></td>
                                        <td>8.5/10</td>
                                        <td><span class="badge bg-success">Above Target</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Items & Insights -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>AI-Powered Insights</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary">
                            <h6><i class="ph-duotone ph-lightbulb me-2"></i>Key Recommendations</h6>
                            <ul class="mb-0">
                                <li>Employee productivity has increased by 3.3% - consider implementing similar practices across all departments</li>
                                <li>Process efficiency is below target - recommend workflow automation review</li>
                                <li>Cost per employee decreased significantly - good cost management practices</li>
                                <li>Attendance rate is near target - minor improvements needed</li>
                            </ul>
                        </div>
                        
                        <div class="alert alert-warning">
                            <h6><i class="ph-duotone ph-warning me-2"></i>Action Required</h6>
                            <ul class="mb-0">
                                <li><strong>Process Efficiency:</strong> Schedule process review meeting with department heads</li>
                                <li><strong>Attendance:</strong> Implement attendance improvement incentives</li>
                                <li><strong>Training:</strong> 15% of employees need skill development programs</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" onclick="generateReport()">
                                <i class="ph-duotone ph-file-text me-1"></i>Generate Executive Report
                            </button>
                            <button class="btn btn-outline-success" onclick="scheduleReview()">
                                <i class="ph-duotone ph-calendar me-1"></i>Schedule Performance Review
                            </button>
                            <button class="btn btn-outline-warning" onclick="sendAlert()">
                                <i class="ph-duotone ph-bell me-1"></i>Send Alert to Managers
                            </button>
                            <button class="btn btn-outline-info" onclick="exportData()">
                                <i class="ph-duotone ph-export me-1"></i>Export Raw Data
                            </button>
                        </div>
                        
                        <hr>
                        
                        <h6>Recent Activity</h6>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <small class="text-muted">2 hours ago</small>
                                    <p class="mb-0">Performance metrics updated</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <small class="text-muted">5 hours ago</small>
                                    <p class="mb-0">Cost analysis completed</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <small class="text-muted">1 day ago</small>
                                    <p class="mb-0">Efficiency alert triggered</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Revenue',
            data: [85000, 89000, 78000, 95000, 102000, 98000, 105000, 110000, 108000, 115000, 118000, 125000],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Costs',
            data: [45000, 47000, 44000, 52000, 55000, 53000, 58000, 60000, 57000, 62000, 64000, 67000],
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Department Performance Chart
const departmentCtx = document.getElementById('departmentChart').getContext('2d');
const departmentChart = new Chart(departmentCtx, {
    type: 'doughnut',
    data: {
        labels: ['HRD', 'Keuangan', 'Logistik', 'Operasional'],
        datasets: [{
            data: [92, 88, 85, 90],
            backgroundColor: [
                'rgb(54, 162, 235)',
                'rgb(75, 192, 192)',
                'rgb(255, 205, 86)',
                'rgb(255, 99, 132)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Employee Analytics Chart
const employeeCtx = document.getElementById('employeeChart').getContext('2d');
const employeeChart = new Chart(employeeCtx, {
    type: 'bar',
    data: {
        labels: ['Active', 'On Leave', 'Remote', 'Training'],
        datasets: [{
            label: 'Employees',
            data: [45, 3, 8, 2],
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Resource Utilization Chart
const resourceCtx = document.getElementById('resourceChart').getContext('2d');
const resourceChart = new Chart(resourceCtx, {
    type: 'radar',
    data: {
        labels: ['Equipment', 'Software', 'Training', 'Infrastructure', 'Support'],
        datasets: [{
            label: 'Current',
            data: [85, 92, 78, 88, 90],
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)'
        }, {
            label: 'Target',
            data: [90, 95, 85, 90, 95],
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});

// Update Analytics Function
function updateAnalytics() {
    const period = document.getElementById('periodFilter').value;
    const department = document.getElementById('departmentFilter').value;
    const metric = document.getElementById('metricFilter').value;
    
    // Show loading indicator
    showNotification('Updating analytics data...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        // Update charts with new data based on filters
        showNotification('Analytics updated successfully!', 'success');
    }, 1500);
}

// Export Functions
function exportAnalytics() {
    showNotification('Exporting analytics report...', 'info');
    // Simulate export
    setTimeout(() => {
        showNotification('Analytics report exported successfully!', 'success');
    }, 2000);
}

function generateReport() {
    showNotification('Generating executive report...', 'info');
    setTimeout(() => {
        showNotification('Executive report generated!', 'success');
    }, 3000);
}

function scheduleReview() {
    showNotification('Performance review scheduled!', 'success');
}

function sendAlert() {
    showNotification('Alert sent to department managers!', 'warning');
}

function exportData() {
    showNotification('Raw data export initiated...', 'info');
    setTimeout(() => {
        showNotification('Data exported successfully!', 'success');
    }, 2000);
}

// Notification function
function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alert.style.top = '20px';
    alert.style.right = '20px';
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => alert.remove(), 5000);
}

// Auto-refresh analytics every 5 minutes
setInterval(() => {
    if (document.visibilityState === 'visible') {
        // Auto-update data without user notification
        console.log('Auto-refreshing analytics data...');
    }
}, 300000);

// Real-time data simulation
setInterval(() => {
    // Simulate small random changes to KPI values
    const kpiElements = document.querySelectorAll('.card.bg-gradient-primary h4, .card.bg-gradient-success h4, .card.bg-gradient-warning h4, .card.bg-gradient-info h4');
    kpiElements.forEach(element => {
        // Small random variations
        const currentValue = parseFloat(element.textContent);
        const variation = (Math.random() - 0.5) * 0.2; // ±0.1 variation
        const newValue = (currentValue + variation).toFixed(1);
        element.textContent = newValue + (element.textContent.includes('%') ? '%' : '');
    });
}, 30000); // Update every 30 seconds
</script>

<style>
.timeline {
    position: relative;
}

.timeline-item {
    position: relative;
    padding-left: 25px;
    margin-bottom: 15px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 3px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 4px;
    top: 13px;
    bottom: -15px;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item:last-child::before {
    display: none;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #4680ff, #66a3ff);
}

.bg-gradient-success {
    background: linear-gradient(45deg, #2ed8b6, #59e0c5);
}

.bg-gradient-warning {
    background: linear-gradient(45deg, #ffb64d, #ffcb80);
}

.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #3cb4cc);
}
</style>
@endpush