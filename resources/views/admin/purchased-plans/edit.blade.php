@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit Purchased Plan</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.purchased-plans.index') }}">Purchased Plans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Edit Purchase Details</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.purchased-plans.update', $purchase->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Professional</label>
                                <input type="text" class="form-control" value="{{ $purchase->professional->name ?? 'N/A' }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Plan Name</label>
                                <input type="text" class="form-control" value="{{ $purchase->plan_name }}" readonly>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payment_status') is-invalid @enderror" 
                                            id="payment_status" name="payment_status" required>
                                        <option value="pending" {{ old('payment_status', $purchase->payment_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="success" {{ old('payment_status', $purchase->payment_status) === 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="failed" {{ old('payment_status', $purchase->payment_status) === 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" 
                                           value="{{ old('end_date', $purchase->end_date ? $purchase->end_date->format('Y-m-d') : '') }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="lead_limit" class="form-label">Lead Limit <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('lead_limit') is-invalid @enderror" 
                                           id="lead_limit" name="lead_limit" 
                                           value="{{ old('lead_limit', $purchase->lead_limit) }}" 
                                           min="0" required>
                                    @error('lead_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="leads_used" class="form-label">Leads Used <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('leads_used') is-invalid @enderror" 
                                           id="leads_used" name="leads_used" 
                                           value="{{ old('leads_used', $purchase->leads_used) }}" 
                                           min="0" required>
                                    @error('leads_used')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Admin Notes</label>
                                <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                          id="admin_notes" name="admin_notes" rows="4" 
                                          placeholder="Add notes for the professional...">{{ old('admin_notes', $purchase->admin_notes) }}</textarea>
                                @error('admin_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i> Update Purchase
                                </button>
                                <a href="{{ route('admin.purchased-plans.show', $purchase->id) }}" class="btn btn-secondary">
                                    <i class="ri-arrow-left-line me-1"></i> Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Quick Actions</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.purchased-plans.extend', $purchase->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="extend_days" class="form-label">Extend Plan Validity</label>
                                <input type="number" class="form-control" id="extend_days" name="extend_days" 
                                       placeholder="Enter days" min="1" required>
                                <small class="text-muted">Add extra days to the plan validity</small>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="ri-time-line me-1"></i> Extend Plan
                            </button>
                        </form>

                        <hr>

                        <div class="alert alert-info">
                            <strong>Current Status:</strong><br>
                            <span class="badge bg-{{ $purchase->payment_status === 'success' ? 'success' : ($purchase->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($purchase->payment_status) }}
                            </span>
                        </div>

                        <div class="alert alert-warning">
                            <strong>Remaining Leads:</strong><br>
                            {{ $purchase->remaining_leads }} / {{ $purchase->lead_limit }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
