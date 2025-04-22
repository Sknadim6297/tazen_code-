@extends('admin.layout.layout')

@section('styles')
{{-- <link rel="stylesheet" href="{{ asset('admin/css/manage-stock.css') }}"> --}}

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Dashboard</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Dashboard</li>
        </ul>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!-- Summary Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Professionals</div>
                        <div class="card-value">142</div>
                        <div class="card-change positive">
                            <i class="fas fa-arrow-up"></i> 12% from last month
                        </div>
                    </div>
                    <div class="card-icon professional">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Customers</div>
                        <div class="card-value">356</div>
                        <div class="card-change positive">
                            <i class="fas fa-arrow-up"></i> 8% from last month
                        </div>
                    </div>
                    <div class="card-icon customer">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Bookings</div>
                        <div class="card-value">189</div>
                        <div class="card-change negative">
                            <i class="fas fa-arrow-down"></i> 3% from last month
                        </div>
                    </div>
                    <div class="card-icon booking">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Revenue</div>
                        <div class="card-value">₹24,580</div>
                        <div class="card-change positive">
                            <i class="fas fa-arrow-up"></i> 15% from last month
                        </div>
                    </div>
                    <div class="card-icon revenue">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
       

        <!-- Charts Section -->
        <div class="dashboard-charts">
            <!-- Revenue Chart -->
            <div class="chart-card">
                <div class="table-header">
                    <div class="table-title">Revenue Overview</div>
                    <div class="view-all">Last 6 Months</div>
                </div>
                <div class="chart-placeholder">
                    [Revenue Chart Would Appear Here]
                </div>
            </div>

            <!-- Booking Types Chart -->
            <div class="chart-card">
                <div class="table-header">
                    <div class="table-title">Booking Types</div>
                    <div class="view-all">View Details</div>
                </div>
                <div class="chart-placeholder">
                    [Pie Chart of Booking Types Would Appear Here]
                </div>
            </div>
        </div>
    </div>
</div>
@endsection