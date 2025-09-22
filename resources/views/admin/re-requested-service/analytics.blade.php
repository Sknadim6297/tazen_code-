@extends('admin.layouts.layout')

@section('title', 'Re-requested Services Analytics')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Re-requested Services Analytics</h5>
                    <a href="{{ route('admin.re-requested-service.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $totalRequests }}</h3>
                                    <p class="mb-0">Total Requests</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $pendingRequests }}</h3>
                                    <p class="mb-0">Pending</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $approvedRequests }}</h3>
                                    <p class="mb-0">Approved</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $paidRequests }}</h3>
                                    <p class="mb-0">Paid</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-dark text-white">
                                <div class="card-body text-center">
                                    <h3>₹{{ number_format($totalRevenue, 2) }}</h3>
                                    <p class="mb-0">Total Revenue</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Monthly Requests ({{ date('Y') }})</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlyRequestsChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Status Distribution</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="statusChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Revenue Chart -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Monthly Revenue ({{ date('Y') }})</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlyRevenueChart" width="400" height="100"></canvas>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Requests Chart
    const monthlyData = @json($monthlyData);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    // Prepare data for monthly requests
    const requestCounts = new Array(12).fill(0);
    const revenues = new Array(12).fill(0);
    
    monthlyData.forEach(item => {
        requestCounts[item.month - 1] = item.count;
        revenues[item.month - 1] = item.revenue || 0;
    });

    // Monthly Requests Chart
    new Chart(document.getElementById('monthlyRequestsChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Requests',
                data: requestCounts,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Status Distribution Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Paid', 'Rejected'],
            datasets: [{
                data: [
                    {{ $pendingRequests }},
                    {{ $approvedRequests }},
                    {{ $paidRequests }},
                    {{ $totalRequests - $pendingRequests - $approvedRequests - $paidRequests }}
                ],
                backgroundColor: [
                    '#ffc107',
                    '#17a2b8',
                    '#28a745',
                    '#dc3545'
                ]
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

    // Monthly Revenue Chart
    new Chart(document.getElementById('monthlyRevenueChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue (₹)',
                data: revenues,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: ₹' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
