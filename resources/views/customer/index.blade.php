<!-- /header -->
@extends('customer.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/styles.css') }}" />
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

    <!-- Dashboard Cards -->
    <div class="card-grid">
        <div class="card card-primary">
            <div class="card-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-info">
                <h4>Upcoming Appointments</h4>
                <h2>2</h2>
                <p class="positive"><i class="fas fa-arrow-up"></i> 1 New Today</p>
            </div>
        </div>

        <div class="card card-success">
            <div class="card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-info">
                <h4>Pending Payments</h4>
                <h2>₹4,500</h2>
                <p class="negative"><i class="fas fa-arrow-down"></i> 2 Pending</p> 
            </div>
        </div>

        <div class="card card-warning">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-info">
                <h4>Active Subscriptions</h4>
                <h2>1</h2>
                <p class=""><i class=""></i> Monthy Package</p>
            </div>
        </div>

        <div class="card card-danger">
            <div class="card-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="card-info">
                <h4>Recent Documents</h4>
                <h2>3</h2>
                <p class="positive"><i class="fas fa-eye"></i> View</p>
            </div>
        </div>
    </div>


</div>
@endsection