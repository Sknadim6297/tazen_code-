@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit Plan: {{ $plan->name }}</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.plans.index') }}">Plans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Edit Plan Details</div>
                    </div>
                <div class="card-body">
                    <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $plan->name) }}" 
                                       placeholder="e.g., Bronze, Silver, Gold, Platinum" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $plan->price) }}" 
                                       placeholder="7000" min="0" step="0.01" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lead_limit" class="form-label">Lead Limit <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('lead_limit') is-invalid @enderror" 
                                       id="lead_limit" name="lead_limit" value="{{ old('lead_limit', $plan->lead_limit) }}" 
                                       placeholder="50" min="1" required>
                                @error('lead_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validity_days" class="form-label">Validity (Days) <span class="text-muted">(Optional)</span></label>
                                <input type="number" class="form-control @error('validity_days') is-invalid @enderror" 
                                       id="validity_days" name="validity_days" value="{{ old('validity_days', $plan->validity_days) }}" 
                                       placeholder="30" min="1">
                                <small class="text-muted">Leave empty for unlimited validity</small>
                                @error('validity_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="active" {{ old('status', $plan->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $plan->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $plan->order) }}" min="0">
                                <small class="text-muted">Lower numbers appear first</small>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Enter plan description...">{{ old('description', $plan->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Features</label>
                            <div id="features-container">
                                @php
                                    $features = old('features', $plan->features ?: []);
                                @endphp
                                @if(is_array($features) && count($features) > 0)
                                    @foreach($features as $feature)
                                        <div class="input-group mb-2 feature-item">
                                            <input type="text" class="form-control" name="features[]" 
                                                   value="{{ $feature }}" placeholder="Enter feature">
                                            <button class="btn btn-danger remove-feature" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 feature-item">
                                        <input type="text" class="form-control" name="features[]" 
                                               placeholder="Enter feature">
                                        <button class="btn btn-danger remove-feature" type="button">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-success" id="add-feature">
                                <i class="fas fa-plus"></i> Add Feature
                            </button>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Plan
                            </button>
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('features-container');
        const addButton = document.getElementById('add-feature');

        addButton.addEventListener('click', function() {
            const featureItem = document.createElement('div');
            featureItem.className = 'input-group mb-2 feature-item';
            featureItem.innerHTML = `
                <input type="text" class="form-control" name="features[]" placeholder="Enter feature">
                <button class="btn btn-danger remove-feature" type="button">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(featureItem);
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-feature')) {
                const featureItem = e.target.closest('.feature-item');
                if (container.querySelectorAll('.feature-item').length > 1) {
                    featureItem.remove();
                } else {
                    featureItem.querySelector('input').value = '';
                }
            }
        });
    });
</script>
@endpush
@endsection
