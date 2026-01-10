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
                                    <label for="end_date" class="form-label">Plan Expiry Date
                                        @if($purchase->end_date)
                                            @if($purchase->end_date->isFuture())
                                                <span class="badge bg-success ms-2">Active until {{ $purchase->end_date->format('d M, Y') }}</span>
                                            @else
                                                <span class="badge bg-danger ms-2">Expired on {{ $purchase->end_date->format('d M, Y') }}</span>
                                            @endif
                                        @else
                                            <span class="badge bg-info ms-2">No Expiry</span>
                                        @endif
                                    </label>
                                    <input type="text" 
                                           class="form-control bg-light" 
                                           value="{{ $purchase->end_date ? $purchase->end_date->format('d M, Y') : 'No expiry set' }}" 
                                           readonly>
                                    <small class="text-muted d-block mt-1">
                                        <i class="ri-information-line"></i> 
                                        @if($purchase->end_date)
                                            @if($purchase->end_date->isFuture())
                                                <strong>{{ now()->diffInDays($purchase->end_date) }} days remaining</strong> - This date was set when the plan was created and cannot be manually changed.
                                            @else
                                                Expired {{ now()->diffInDays($purchase->end_date) }} days ago - This date was set when the plan was created and cannot be manually changed.
                                            @endif
                                        @else
                                            No expiry date set for this plan.
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="lead_limit" class="form-label">Lead Limit <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('lead_limit') is-invalid @enderror" 
                                           id="lead_limit" name="lead_limit" 
                                           value="{{ old('lead_limit', $purchase->lead_limit) }}" 
                                           min="0" required oninput="calculateRemaining()">
                                    <small class="text-muted">Total leads allowed</small>
                                    @error('lead_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="leads_used" class="form-label">Leads Used <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('leads_used') is-invalid @enderror" 
                                           id="leads_used" name="leads_used" 
                                           value="{{ old('leads_used', $purchase->leads_used) }}" 
                                           min="0" required oninput="calculateRemaining()">
                                    <small class="text-muted">Already consumed</small>
                                    @error('leads_used')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Leads Remaining</label>
                                    <input type="number" class="form-control bg-light" 
                                           id="leads_remaining" 
                                           value="{{ $purchase->remaining_leads }}" 
                                           readonly>
                                    <small class="text-success fw-bold">Auto-calculated</small>
                                </div>
                            </div>

                            <div class="alert alert-info mb-3">
                                <i class="ri-information-line me-2"></i>
                                <strong>Important:</strong> 
                                <ul class="mb-0 mt-2">
                                    <li><strong>Leads:</strong> Remaining = Lead Limit - Leads Used (currently: {{ $purchase->remaining_leads }})</li>
                                    <li><strong>End Date:</strong> Should be Start Date + Plan Validity Days
                                        @if($purchase->start_date && $purchase->plan && $purchase->plan->validity_days)
                                            <br>Example: {{ $purchase->start_date->format('Y-m-d') }} + {{ $purchase->plan->validity_days }} days = {{ $purchase->start_date->addDays($purchase->plan->validity_days)->format('Y-m-d') }}
                                        @endif
                                    </li>
                                    <li><strong>Active Plan:</strong> Payment Status = Success AND End Date is in future (or null)</li>
                                </ul>
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

                        @php
                            $activePlan = \App\Models\ProfessionalPlanPurchase::getActivePlanForProfessional($purchase->professional_id);
                            $isActive = $activePlan && $activePlan->id === $purchase->id;
                            $upgradeHistory = \App\Models\ProfessionalPlanPurchase::where('professional_id', $purchase->professional_id)
                                ->where('payment_status', 'success')
                                ->orderBy('created_at', 'desc')
                                ->get();
                        @endphp

                        @if($isActive)
                            <div class="alert alert-success">
                                <i class="ri-checkbox-circle-line me-1"></i> <strong>Active Plan</strong><br>
                                This is the currently active plan
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <i class="ri-error-warning-line me-1"></i> <strong>Inactive Plan</strong><br>
                                This is NOT the active plan
                            </div>
                        @endif

                        @if($upgradeHistory->count() > 1)
                            <div class="card">
                                <div class="card-header bg-light">
                                    <strong><i class="ri-history-line me-1"></i> Upgrade History ({{ $upgradeHistory->count() }} plans)</strong>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        @foreach($upgradeHistory as $index => $history)
                                            <div class="list-group-item {{ $history->id === $purchase->id ? 'bg-light' : '' }}">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <strong class="text-primary">{{ $history->plan_name }}</strong>
                                                        @if($history->id === $purchase->id)
                                                            <span class="badge bg-warning text-dark ms-1">Editing</span>
                                                        @endif
                                                        @if($activePlan && $activePlan->id === $history->id)
                                                            <span class="badge bg-success ms-1">Active</span>
                                                        @endif
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $history->created_at->format('d M, Y') }}
                                                        </small>
                                                    </div>
                                                    <span class="badge bg-info">{{ $history->lead_limit }} leads</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function calculateRemaining() {
    const leadLimit = parseInt(document.getElementById('lead_limit').value) || 0;
    const leadsUsed = parseInt(document.getElementById('leads_used').value) || 0;
    const remaining = leadLimit - leadsUsed;
    
    document.getElementById('leads_remaining').value = remaining;
    
    // Visual feedback
    const remainingInput = document.getElementById('leads_remaining');
    if (remaining < 0) {
        remainingInput.classList.add('border-danger');
        remainingInput.classList.remove('border-success');
    } else {
        remainingInput.classList.add('border-success');
        remainingInput.classList.remove('border-danger');
    }
}

// Calculate on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateRemaining();
});
</script>

@endsection
