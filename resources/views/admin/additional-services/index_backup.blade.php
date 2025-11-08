@extends('admin.layouts.layout')

@section('title', 'Additional Services Management')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Global Font */
* {
    font-family: 'Inter', sans-serif;
}

/* Modern Admin Dashboard Styling */
.admin-dashboard {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    padding: 2rem;
}

/* Enhanced Page Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 100%;
    height: 200%;
    background: rgba(255, 255, 255, 0.1);
    transform: rotate(45deg);
    border-radius: 50px;
}

.page-header h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin: 0;
    position: relative;
    z-index: 2;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

/* Modern Statistics Cards */
.stats-card {
    background: #fff;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--card-color), var(--card-color-alt));
    background-size: 200% 100%;
    animation: shimmer 3s infinite;
}

.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.stats-card.total { --card-color: #3b82f6; --card-color-alt: #1d4ed8; }
.stats-card.pending { --card-color: #f59e0b; --card-color-alt: #d97706; }
.stats-card.completed { --card-color: #10b981; --card-color-alt: #059669; }
.stats-card.negotiation { --card-color: #8b5cf6; --card-color-alt: #7c3aed; }
.stats-card.revenue { --card-color: #06b6d4; --card-color-alt: #0891b2; }

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--card-color), var(--card-color-alt));
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.stats-number {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
    line-height: 1;
}

.stats-label {
    color: #64748b;
    font-weight: 600;
    margin: 0.5rem 0 0 0;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Notification Alert System */
.notification-alerts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.alert-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border-left: 4px solid;
    position: relative;
    overflow: hidden;
}

.alert-card.urgent {
    border-left-color: #dc2626;
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.05), rgba(248, 113, 113, 0.02));
    animation: pulse-urgent 2s infinite;
}

.alert-card.info {
    border-left-color: #3b82f6;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(147, 197, 253, 0.02));
}

.alert-card.success {
    border-left-color: #10b981;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(52, 211, 153, 0.02));
}

@keyframes pulse-urgent {
    0%, 100% { box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08); }
    50% { box-shadow: 0 8px 30px rgba(220, 38, 38, 0.3); }
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* Enhanced Table Styling */
.modern-table-wrapper {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 2rem;
}

.table-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.table-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modern-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table th {
    background: #f8fafc;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.8rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.modern-table td {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.modern-table tbody tr:hover {
    background: #f8fafc;
    transition: background 0.3s ease;
}

/* Enhanced Badge System */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.status-badge.pending {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #fff;
    animation: pulse-pending 2s infinite;
}

.status-badge.approved {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: #fff;
}

.status-badge.paid {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
}

.status-badge.completed {
    background: linear-gradient(135deg, #059669, #047857);
    color: #fff;
}

.status-badge.negotiation {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: #fff;
    animation: pulse-negotiation 2s infinite;
}

@keyframes pulse-pending {
    0%, 100% { box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3); }
    50% { box-shadow: 0 2px 8px rgba(251, 191, 36, 0.6); }
}

@keyframes pulse-negotiation {
    0%, 100% { box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3); }
    50% { box-shadow: 0 2px 8px rgba(139, 92, 246, 0.6); }
}

/* Enhanced Action Buttons */
.action-btn {
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.25rem;
}

.action-btn.view {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: #fff;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.action-btn.negotiate {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: #fff;
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

.action-btn.approve {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-dashboard { padding: 1rem; }
    .page-header { padding: 1.5rem; }
    .page-header h1 { font-size: 1.8rem; }
    .stats-card { padding: 1.5rem; }
    .modern-table td, .modern-table th { padding: 0.75rem; }
}

/* Notification Counter */
.notification-counter {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc2626;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}
</style>
@endsection

@section('content')
<div class="admin-dashboard">
    <!-- Enhanced Page Header -->
    <div class="page-header">
        <h1>
            <i class="fas fa-cogs me-3"></i>
            Additional Services Management
        </h1>
        <p class="mb-0 opacity-90">Comprehensive tracking and management of all additional service requests</p>
    </div>

    <!-- Real-time Notification Alerts -->
    <div class="notification-alerts">
        @php
            $urgentNegotiations = $additionalServices->where('negotiation_status', 'user_negotiated')->count();
            $pendingApprovals = $additionalServices->where('status', 'pending')->count();
            $recentCompletions = $additionalServices->where('consulting_status', 'done')->where('created_at', '>=', now()->subDays(1))->count();
        @endphp

        @if($urgentNegotiations > 0)
        <div class="alert-card urgent">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-danger mb-1">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Urgent Negotiations
                    </h5>
                    <p class="mb-0 text-muted">{{ $urgentNegotiations }} customer negotiation{{ $urgentNegotiations > 1 ? 's' : '' }} pending review</p>
                </div>
                <div class="position-relative">
                    <i class="fas fa-handshake text-danger" style="font-size: 2rem;"></i>
                    <span class="notification-counter">{{ $urgentNegotiations }}</span>
                </div>
            </div>
        </div>
        @endif

        @if($pendingApprovals > 0)
        <div class="alert-card info">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-primary mb-1">
                        <i class="fas fa-clock me-2"></i>
                        Pending Approvals
                    </h5>
                    <p class="mb-0 text-muted">{{ $pendingApprovals }} new service{{ $pendingApprovals > 1 ? 's' : '' }} awaiting approval</p>
                </div>
                <div class="position-relative">
                    <i class="fas fa-hourglass-half text-primary" style="font-size: 2rem;"></i>
                    <span class="notification-counter">{{ $pendingApprovals }}</span>
                </div>
            </div>
        </div>
        @endif

        @if($recentCompletions > 0)
        <div class="alert-card success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-success mb-1">
                        <i class="fas fa-check-circle me-2"></i>
                        Recent Completions
                    </h5>
                    <p class="mb-0 text-muted">{{ $recentCompletions }} service{{ $recentCompletions > 1 ? 's' : '' }} completed in last 24h</p>
                </div>
                <div>
                    <i class="fas fa-trophy text-success" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-2 col-sm-6">
            <div class="stats-card total">
                <div class="stats-icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <h3 class="stats-number">{{ $additionalServices->count() }}</h3>
                <p class="stats-label">Total Services</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="stats-card pending">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="stats-number">{{ $additionalServices->where('status', 'pending')->count() }}</h3>
                <p class="stats-label">Pending</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="stats-card completed">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="stats-number">{{ $additionalServices->where('consulting_status', 'done')->count() }}</h3>
                <p class="stats-label">Completed</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="stats-card negotiation">
                <div class="stats-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="stats-number">{{ $additionalServices->whereIn('negotiation_status', ['user_negotiated', 'admin_responded'])->count() }}</h3>
                <p class="stats-label">Negotiations</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="stats-card revenue">
                <div class="stats-icon">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <h3 class="stats-number">{{ number_format($additionalServices->where('payment_status', 'paid')->sum('final_price'), 0) }}</h3>
                <p class="stats-label">Revenue</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, #f43f5e, #e11d48);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="stats-number">{{ number_format($additionalServices->avg('final_price'), 0) }}</h3>
                <p class="stats-label">Avg Value</p>
            </div>
        </div>
    </div>
                <span class="info-box-text">Total Services</span>
                <span class="info-box-number" id="total-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-yellow">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Pending</span>
                <span class="info-box-number" id="pending-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-green">
                <i class="fa fa-check"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Approved</span>
                <span class="info-box-number" id="approved-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-aqua">
                <i class="fa fa-credit-card"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Paid</span>
                <span class="info-box-number" id="paid-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-purple">
                <i class="fa fa-handshake-o"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Negotiations</span>
                <span class="info-box-number" id="negotiation-services">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 col-sm-6">
        <div class="info-box">
            <div class="info-box-icon bg-red">
                <i class="fa fa-money"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Pending Payouts</span>
                <span class="info-box-number" id="pending-payouts">₹0</span>
            </div>
        </div>
    </div>
</div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between d-flex align-items-center">
                        <div class="card-title">Additional Services List</div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Export</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <select class="form-control" id="status-filter">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="paid">Paid</option>
                            <option value="negotiation">Under Negotiation</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" id="professional-filter">
                            <option value="">All Professionals</option>
                            @foreach($professionals as $professional)
                                <option value="{{ $professional->id }}">{{ $professional->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" id="user-filter">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="date-from" placeholder="From Date">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="date-to" placeholder="To Date">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" id="apply-filters">Apply Filters</button>
                    </div>
    <!-- Enhanced Filters Section -->
    <div class="modern-table-wrapper">
        <div class="table-header">
            <h3>
                <i class="fas fa-filter text-primary"></i>
                Advanced Filters & Search
            </h3>
        </div>
        <div class="p-3">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status Filter</label>
                    <select class="form-select" id="status-filter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="paid">Paid</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Negotiation Status</label>
                    <select class="form-select" id="negotiation-filter">
                        <option value="">All Negotiations</option>
                        <option value="none">No Negotiation</option>
                        <option value="user_negotiated">Customer Negotiated</option>
                        <option value="admin_responded">Admin Responded</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">From Date</label>
                    <input type="date" class="form-control" id="date-from" placeholder="From Date">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">To Date</label>
                    <input type="date" class="form-control" id="date-to" placeholder="To Date">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-primary w-100" id="apply-filters">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Data Table -->
    <div class="modern-table-wrapper">
        <div class="table-header">
            <h3>
                <i class="fas fa-table text-primary"></i>
                Additional Services Overview
            </h3>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary btn-sm" id="refresh-table">
                    <i class="fas fa-sync-alt me-1"></i>Refresh
                </button>
                <button class="btn btn-outline-success btn-sm" id="export-data">
                    <i class="fas fa-download me-1"></i>Export
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="modern-table" id="additional-services-table">
                <thead>
                    <tr>
                        <th>
                            <i class="fas fa-hashtag me-1"></i>ID
                        </th>
                        <th>
                            <i class="fas fa-cog me-1"></i>Service Details
                        </th>
                        <th>
                            <i class="fas fa-user-tie me-1"></i>Professional
                        </th>
                        <th>
                            <i class="fas fa-user me-1"></i>Customer
                        </th>
                        <th>
                            <i class="fas fa-rupee-sign me-1"></i>Pricing
                        </th>
                        <th>
                            <i class="fas fa-handshake me-1"></i>Negotiations
                        </th>
                        <th>
                            <i class="fas fa-chart-line me-1"></i>Status
                        </th>
                        <th>
                            <i class="fas fa-bell me-1"></i>Notifications
                        </th>
                        <th>
                            <i class="fas fa-tools me-1"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($additionalServices as $service)
                    <tr class="service-row" data-service-id="{{ $service->id }}">
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fw-bold text-primary">#{{ $service->id }}</span>
                                @if($service->created_at->isToday())
                                    <span class="badge bg-success ms-2" style="font-size: 0.6rem;">NEW</span>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div>
                                <h6 class="mb-1 fw-semibold">{{ $service->service_name }}</h6>
                                <small class="text-muted">{{ Str::limit($service->reason, 50) }}</small>
                                @if($service->delivery_date)
                                    <div class="mt-1">
                                        <small class="text-info">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($service->delivery_date)->format('M d, Y') }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                    {{ substr($service->professional->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $service->professional->name }}</div>
                                    <small class="text-muted">{{ $service->professional->email }}</small>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-info text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                    {{ substr($service->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $service->user->name }}</div>
                                    <small class="text-muted">{{ $service->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div>
                                @php
                                    $originalPrice = $service->original_professional_price ?? $service->base_price;
                                    $finalPrice = $service->final_price;
                                    $hasDiscount = $originalPrice > $finalPrice;
                                @endphp
                                
                                @if($hasDiscount)
                                    <div class="text-decoration-line-through text-muted small">₹{{ number_format($originalPrice, 0) }}</div>
                                    <div class="fw-bold text-success">₹{{ number_format($finalPrice, 0) }}</div>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-down me-1"></i>
                                        {{ number_format((($originalPrice - $finalPrice) / $originalPrice) * 100, 1) }}% off
                                    </small>
                                @else
                                    <div class="fw-bold text-dark">₹{{ number_format($finalPrice, 0) }}</div>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            @if($service->negotiation_status === 'none')
                                <span class="status-badge" style="background: #e2e8f0; color: #64748b;">No Negotiation</span>
                            @elseif($service->negotiation_status === 'user_negotiated')
                                <span class="status-badge negotiation">
                                    <i class="fas fa-clock"></i>
                                    Pending Review
                                </span>
                                <div class="mt-1">
                                    <small class="text-primary fw-semibold">
                                        Customer Offer: ₹{{ number_format($service->user_negotiated_price, 0) }}
                                    </small>
                                </div>
                            @elseif($service->negotiation_status === 'admin_responded')
                                <span class="status-badge approved">
                                    <i class="fas fa-check"></i>
                                    Accepted
                                </span>
                                <div class="mt-1">
                                    <small class="text-success fw-semibold">
                                        Final: ₹{{ number_format($service->admin_final_negotiated_price, 0) }}
                                    </small>
                                </div>
                            @endif
                        </td>
                        
                        <td>
                            <div class="d-flex flex-column gap-1">
                                @if($service->admin_status === 'pending')
                                    <span class="status-badge pending">
                                        <i class="fas fa-hourglass-half"></i>
                                        Pending
                                    </span>
                                @elseif($service->admin_status === 'approved')
                                    <span class="status-badge approved">
                                        <i class="fas fa-check"></i>
                                        Approved
                                    </span>
                                @endif
                                
                                @if($service->payment_status === 'pending')
                                    <span class="status-badge pending">
                                        <i class="fas fa-credit-card"></i>
                                        Payment Pending
                                    </span>
                                @elseif($service->payment_status === 'paid')
                                    <span class="status-badge paid">
                                        <i class="fas fa-check-circle"></i>
                                        Paid
                                    </span>
                                @endif
                                
                                @if($service->consulting_status === 'done')
                                    @if($service->customer_confirmed_at)
                                        <span class="status-badge completed">
                                            <i class="fas fa-trophy"></i>
                                            Completed
                                        </span>
                                    @else
                                        <span class="status-badge pending">
                                            <i class="fas fa-user-check"></i>
                                            Awaiting Confirmation
                                        </span>
                                    @endif
                                @elseif($service->consulting_status === 'in_progress')
                                    <span class="status-badge" style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff;">
                                        <i class="fas fa-play"></i>
                                        In Progress
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div class="d-flex flex-column gap-1">
                                @php
                                    $notifications = [];
                                    if($service->negotiation_status === 'user_negotiated') {
                                        $notifications[] = ['type' => 'urgent', 'icon' => 'handshake', 'text' => 'New Negotiation'];
                                    }
                                    if($service->admin_status === 'pending') {
                                        $notifications[] = ['type' => 'info', 'icon' => 'clock', 'text' => 'Needs Approval'];
                                    }
                                    if($service->consulting_status === 'done' && !$service->customer_confirmed_at) {
                                        $notifications[] = ['type' => 'warning', 'icon' => 'user-check', 'text' => 'Confirm Pending'];
                                    }
                                    if($service->payment_status === 'paid' && $service->professional_payment_status === 'pending') {
                                        $notifications[] = ['type' => 'success', 'icon' => 'money-bill', 'text' => 'Payout Pending'];
                                    }
                                @endphp
                                
                                @if(count($notifications) > 0)
                                    @foreach($notifications as $notification)
                                        <span class="status-badge {{ $notification['type'] === 'urgent' ? 'negotiation' : ($notification['type'] === 'info' ? 'pending' : ($notification['type'] === 'warning' ? 'pending' : 'paid')) }}">
                                            <i class="fas fa-{{ $notification['icon'] }}"></i>
                                            {{ $notification['text'] }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">
                                        <i class="fas fa-check-circle text-success"></i>
                                        All Clear
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.additional-services.show', $service->id) }}" class="action-btn view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($service->negotiation_status === 'user_negotiated')
                                    <button class="action-btn negotiate" onclick="handleNegotiation({{ $service->id }})" title="Handle Negotiation">
                                        <i class="fas fa-handshake"></i>
                                    </button>
                                @endif
                                
                                @if($service->admin_status === 'pending')
                                    <button class="action-btn approve" onclick="approveService({{ $service->id }})" title="Approve Service">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                                
                                <div class="dropdown">
                                    <button class="action-btn" style="background: #64748b;" data-bs-toggle="dropdown" title="More Actions">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.additional-services.show', $service->id) }}">
                                            <i class="fas fa-eye me-2"></i>View Full Details
                                        </a></li>
                                        @if($service->payment_status === 'paid')
                                            <li><a class="dropdown-item" href="{{ route('admin.additional-services.invoice', $service->id) }}">
                                                <i class="fas fa-file-invoice me-2"></i>View Invoice
                                            </a></li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-primary" href="#" onclick="sendNotification({{ $service->id }})">
                                            <i class="fas fa-bell me-2"></i>Send Notification
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
                
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            {{ $additionalServices->appends(request()->query())->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Approve Service Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Additional Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="approveForm">
                <div class="modal-body">
                    <p>Are you sure you want to approve this additional service?</p>
                    <div class="form-group">
                        <label for="approve_reason">Approval Note (Optional)</label>
                        <textarea class="form-control" id="approve_reason" name="reason" rows="3" 
                                  placeholder="Add any notes about the approval..."></textarea>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve Service</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Service Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Additional Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reject_reason">Reason for Rejection *</label>
                        <textarea class="form-control" id="reject_reason" name="reason" rows="4" required
                                  placeholder="Please provide a detailed reason for rejecting this service..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modify Price Modal -->
<div class="modal fade" id="modifyPriceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modify Service Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="modifyPriceForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modified_base_price">New Base Price (₹) *</label>
                        <input type="number" class="form-control" id="modified_base_price" name="modified_base_price" 
                               min="0" step="0.01" required>
                        <small class="form-text text-muted">GST will be calculated automatically</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="modification_reason">Reason for Price Modification *</label>
                        <textarea class="form-control" id="modification_reason" name="modification_reason" 
                                  rows="4" required placeholder="Please explain why the price is being modified..."></textarea>
                    </div>
                    
                    <div class="card border-info">
                        <div class="card-body">
                            <h6>Price Calculation Preview:</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small>Base Price: ₹<span id="preview_base">0.00</span></small><br>
                                    <small>CGST (9%): ₹<span id="preview_cgst">0.00</span></small>
                                </div>
                                <div class="col-6">
                                    <small>SGST (9%): ₹<span id="preview_sgst">0.00</span></small><br>
                                    <strong>Total: ₹<span id="preview_total">0.00</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Price</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Respond to Negotiation Modal -->
<div class="modal fade" id="negotiationResponseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Respond to Price Negotiation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="negotiationResponseForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>User's Negotiated Price:</strong> ₹<span id="user_negotiated_price">0.00</span><br>
                        <strong>User's Reason:</strong> <span id="user_negotiation_reason">-</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_final_price">Your Final Price (₹) *</label>
                        <input type="number" class="form-control" id="admin_final_price" name="admin_final_price" 
                               min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_response">Your Response *</label>
                        <textarea class="form-control" id="admin_response" name="admin_response" 
                                  rows="4" required placeholder="Provide your response to the negotiation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Response</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Delivery Date Modal -->
<div class="modal fade" id="deliveryDateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Delivery Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deliveryDateForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="delivery_date">New Delivery Date *</label>
                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_change_reason">Reason for Change *</label>
                        <textarea class="form-control" id="date_change_reason" name="date_change_reason" 
                                  rows="3" required placeholder="Explain why the delivery date is being changed..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Date</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize enhanced DataTable with advanced features
    const table = $('#additional-services-table').DataTable({
        "order": [[ 0, "desc" ]],
        "pageLength": 25,
        "responsive": true,
        "processing": true,
        "language": {
            "emptyTable": "No additional services found",
            "search": "🔍 Search services:",
            "lengthMenu": "Show _MENU_ services per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ services",
            "paginate": {
                "previous": "← Previous",
                "next": "Next →"
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [8] } // Actions column
        ],
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        "initComplete": function() {
            // Add custom styling to search
            $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search by name, email, service...');
            $('.dataTables_length select').addClass('form-select');
        }
    });
    
    // Enhanced filter functionality
    $('#apply-filters').click(function() {
        const statusFilter = $('#status-filter').val();
        const negotiationFilter = $('#negotiation-filter').val();
        const dateFrom = $('#date-from').val();
        const dateTo = $('#date-to').val();
        
        // Apply filters
        table.columns().search('');
        
        if (statusFilter) {
            table.column(6).search(statusFilter);
        }
        if (negotiationFilter) {
            table.column(5).search(negotiationFilter);
        }
        
        table.draw();
        
        // Show notification
        showNotification('Filters applied successfully!', 'success');
    });
    
    // Clear filters
    $('#clear-filters').click(function() {
        $('#status-filter, #negotiation-filter, #date-from, #date-to').val('');
        table.columns().search('').draw();
        showNotification('Filters cleared!', 'info');
    });
    
    // Refresh table
    $('#refresh-table').click(function() {
        $(this).find('i').addClass('fa-spin');
        setTimeout(() => {
            location.reload();
        }, 1000);
    });
    
    // Export functionality
    $('#export-data').click(function() {
        showNotification('Preparing export...', 'info');
        // Implement export logic here
        setTimeout(() => {
            showNotification('Export ready for download!', 'success');
        }, 2000);
    });
    
    // Real-time notifications check
    setInterval(checkForNotifications, 30000); // Check every 30 seconds
    
    function checkForNotifications() {
        $.get('/admin/additional-services/notifications', function(data) {
            if (data.urgent_negotiations > 0) {
                updateNotificationBadge('negotiations', data.urgent_negotiations);
            }
            if (data.pending_approvals > 0) {
                updateNotificationBadge('approvals', data.pending_approvals);
            }
        });
    }
    
    function updateNotificationBadge(type, count) {
        const badge = $(`.notification-counter[data-type="${type}"]`);
        if (badge.length) {
            badge.text(count).show();
            badge.parent().addClass('animate__animated animate__pulse');
        }
    }
    
    // Enhanced notification system
    function showNotification(message, type = 'info') {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 'alert-info';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 
                                  type === 'error' ? 'exclamation-triangle' : 
                                  type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        setTimeout(() => {
            notification.fadeOut(() => notification.remove());
        }, 5000);
    }
    
    // Quick action functions
    window.handleNegotiation = function(serviceId) {
        showNotification('Opening negotiation panel...', 'info');
        
        // Create negotiation modal
        const modal = $(`
            <div class="modal fade" id="negotiationModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-handshake me-2"></i>
                                Handle Customer Negotiation
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading negotiation details...</span>
                                </div>
                                <p class="mt-2">Loading negotiation details...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
        
        $('body').append(modal);
        $('#negotiationModal').modal('show');
        
        // Load negotiation details
        $.get(`/admin/additional-services/${serviceId}/negotiation-details`, function(data) {
            $('#negotiationModal .modal-body').html(data);
        }).fail(function() {
            $('#negotiationModal .modal-body').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Failed to load negotiation details. Please try again.
                </div>
            `);
        });
        
        $('#negotiationModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });
    };
    
    window.approveService = function(serviceId) {
        if (confirm('Are you sure you want to approve this additional service?')) {
            $.post(`/admin/additional-services/${serviceId}/approve`, {
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                if (response.success) {
                    showNotification('Service approved successfully!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(response.message || 'Failed to approve service', 'error');
                }
            })
            .fail(function() {
                showNotification('Failed to approve service. Please try again.', 'error');
            });
        }
    };
    
    window.sendNotification = function(serviceId) {
        const modal = $(`
            <div class="modal fade" id="notificationModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-bell me-2"></i>
                                Send Notification
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="notificationForm">
                                <div class="mb-3">
                                    <label class="form-label">Notification Type</label>
                                    <select class="form-select" name="type" required>
                                        <option value="">Select type...</option>
                                        <option value="info">Information</option>
                                        <option value="reminder">Reminder</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="update">Status Update</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Recipients</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="recipients[]" value="customer" id="notifyCustomer">
                                        <label class="form-check-label" for="notifyCustomer">Customer</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="recipients[]" value="professional" id="notifyProfessional">
                                        <label class="form-check-label" for="notifyProfessional">Professional</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" rows="4" placeholder="Enter your notification message..." required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="sendNotificationMessage(${serviceId})">
                                <i class="fas fa-paper-plane me-2"></i>Send Notification
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);
        
        $('body').append(modal);
        $('#notificationModal').modal('show');
        
        $('#notificationModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });
    };
    
    window.sendNotificationMessage = function(serviceId) {
        const form = $('#notificationForm');
        const formData = new FormData(form[0]);
        formData.append('_token', '{{ csrf_token() }}');
        
        $.ajax({
            url: `/admin/additional-services/${serviceId}/send-notification`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#notificationModal').modal('hide');
                    showNotification('Notification sent successfully!', 'success');
                } else {
                    showNotification(response.message || 'Failed to send notification', 'error');
                }
            },
            error: function() {
                showNotification('Failed to send notification. Please try again.', 'error');
            }
        });
    };
    
    // Auto-refresh urgent notifications
    setInterval(function() {
        $('.status-badge.negotiation').each(function() {
            $(this).addClass('animate__animated animate__pulse');
            setTimeout(() => {
                $(this).removeClass('animate__animated animate__pulse');
            }, 1000);
        });
    }, 5000);
    
    // Initialize tooltips
    $('[title]').tooltip();
    
    // Enhanced row click functionality
    $('.service-row').click(function(e) {
        if (!$(e.target).closest('.action-btn, .dropdown').length) {
            const serviceId = $(this).data('service-id');
            window.location.href = `/admin/additional-services/${serviceId}`;
        }
    });
    
    // Load initial statistics
    loadStatistics();
    
    function loadStatistics() {
        $.get('/admin/additional-services/statistics', function(data) {
            if (data) {
                $('#total-services').text(data.total || 0);
                $('#pending-services').text(data.pending || 0);
                $('#approved-services').text(data.approved || 0);
                $('#paid-services').text(data.paid || 0);
                $('#negotiation-services').text(data.with_negotiation || 0);
                $('#pending-payouts').text('₹' + Number(data.pending_payouts || 0).toLocaleString());
                
                // Update progress bars
                const progressElements = [
                    { id: 'pending-progress', value: data.pending_percentage || 0 },
                    { id: 'approved-progress', value: data.approved_percentage || 0 },
                    { id: 'paid-progress', value: data.paid_percentage || 0 }
                ];
                
                progressElements.forEach(element => {
                    $(`#${element.id}`).css('width', `${element.value}%`);
                });
            }
        }).fail(function() {
            console.warn('Failed to load statistics');
        });
    }
    
    // Auto-refresh statistics every 60 seconds
    setInterval(loadStatistics, 60000);
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

.admin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.25rem;
}

.card-body {
    padding: 1.25rem;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.notification-alerts {
    margin-bottom: 2rem;
}

.alert {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-left: 4px solid;
}

.alert-warning {
    background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
    border-left-color: #e17055;
}

.alert-info {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    border-left-color: #2d3436;
}

.alert-success {
    background: linear-gradient(135deg, #55efc4 0%, #00b894 100%);
    border-left-color: #00826a;
}

.filters-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    padding: 1.5rem;
}

.services-table-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table {
    margin-bottom: 0;
}

.table th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    border: none;
    padding: 1rem 0.75rem;
    font-size: 0.875rem;
    letter-spacing: 0.025em;
}

.table td {
    padding: 1rem 0.75rem;
    border-color: rgba(0, 0, 0, 0.05);
    vertical-align: middle;
}

.service-row {
    transition: all 0.2s ease;
    cursor: pointer;
}

.service-row:hover {
    background-color: rgba(102, 126, 234, 0.05);
    transform: scale(1.01);
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.status-pending {
    background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
    color: #2d3436;
}

.status-approved {
    background: linear-gradient(135deg, #55efc4 0%, #00b894 100%);
    color: #2d3436;
}

.status-paid {
    background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
    color: white;
}

.status-negotiation {
    background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
    color: white;
    animation: pulse 2s infinite;
}

.action-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.25rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #55efc4 0%, #00b894 100%);
    color: #2d3436;
}

.btn-info {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.btn-warning {
    background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
    color: #2d3436;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.notification-counter {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 0.75rem;
    display: none;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .admin-header h1 {
        font-size: 1.5rem;
    }
    
    .filters-section {
        padding: 1rem;
    }
    
    .table {
        font-size: 0.875rem;
    }
    
    .action-btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection
            }
        });
        
        $('.modal').modal('hide');
    }
});
</script>
@endsection