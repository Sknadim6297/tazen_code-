@extends('admin.layouts.layout')

@section('styles')
<style>
    /* Service card styling */
    .service-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fafbfc;
        height: 100%;
    }

    .service-card:hover {
        border-color: #667eea;
        background: #f0f2ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
    }

    .service-card.selected {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .service-card .service-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .progress-steps {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .step-item {
        display: flex;
        align-items: center;
        flex: 1;
        position: relative;
    }

    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 50%;
        right: -50%;
        width: 100%;
        height: 2px;
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-50%);
    }

    .step-item.active::after {
        background: rgba(255, 255, 255, 0.8);
    }

    .step-badge {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .step-item.completed .step-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .step-item.active .step-badge {
        background: white;
        color: #667eea;
    }

    .step-item:not(.completed):not(.active) .step-badge {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Create Admin Booking</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.admin-booking.index') }}">Admin Bookings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Select Service</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

<div class="row">
    <div class="col-xl-12">
        <!-- Progress Steps -->
        <div class="card custom-card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">1</span>
                        <span class="text-success fw-semibold">Customer Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-pill me-2">2</span>
                        <span class="text-primary fw-semibold">Select Service</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-secondary rounded-pill me-2">3</span>
                        <span class="text-muted">Select Professional</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-secondary rounded-pill me-2">4</span>
                        <span class="text-muted">Select Session</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-secondary rounded-pill me-2">5</span>
                        <span class="text-muted">Select Date & Time</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-secondary rounded-pill me-2">6</span>
                        <span class="text-muted">Confirm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Customer Info -->
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="card-title">
                    <i class="ri-user-line me-2"></i>Selected Customer
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <span class="avatar avatar-lg avatar-rounded me-3">
                        <img src="{{ asset('admin/assets/images/faces/9.jpg') }}" alt="">
                    </span>
                    <div>
                        <h6 class="mb-1">{{ $customer->name }}</h6>
                        <p class="mb-0 text-muted">{{ $customer->email }}</p>
                        @if($customer->phone)
                            <p class="mb-0 text-muted">{{ $customer->phone }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Selection -->
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    Step 2: Select Service & Sub-Service
                </div>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.admin-booking.store-service-selection') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="service_id" class="form-label">Service <span class="text-danger">*</span></label>
                            <select name="service_id" id="service_id" class="form-select" required>
                                <option value="">Select a service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sub_service_id" class="form-label">Sub-Service <span class="text-danger">*</span></label>
                            <select name="sub_service_id" id="sub_service_id" class="form-select" required disabled>
                                <option value="">Select a service first</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="next_btn" disabled>
                                <i class="ri-arrow-right-line me-1"></i>Next: Select Professional
                            </button>
                            <a href="{{ route('admin.admin-booking.create') }}" class="btn btn-secondary ms-2">
                                <i class="ri-arrow-left-line me-1"></i>Back
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('service_id');
    const subServiceSelect = document.getElementById('sub_service_id');
    const nextBtn = document.getElementById('next_btn');
    const subServiceRow = subServiceSelect.closest('.col-md-6');

    serviceSelect.addEventListener('change', function() {
        const serviceId = this.value;
        
        if (serviceId) {
            subServiceSelect.disabled = false;
            subServiceSelect.innerHTML = '<option value="">Loading...</option>';
            nextBtn.disabled = true;
            
            fetch(`{{ route('admin.admin-booking.get-sub-services') }}?service_id=${serviceId}`)
                .then(response => response.json())
                .then(subServices => {
                    if (subServices.length > 0) {
                        // Sub-services exist, show dropdown
                        subServiceRow.style.display = 'block';
                        let options = '<option value="">Select a sub-service</option>';
                        subServices.forEach(subService => {
                            options += `<option value="${subService.id}">${subService.name}</option>`;
                        });
                        subServiceSelect.innerHTML = options;
                        subServiceSelect.required = true;
                        
                        // Update label to show it's required
                        const label = subServiceSelect.previousElementSibling;
                        if (label && !label.innerHTML.includes('*')) {
                            label.innerHTML = 'Sub-Service <span class="text-danger">*</span>';
                        }
                    } else {
                        // No sub-services, hide dropdown and allow proceeding
                        subServiceRow.style.display = 'none';
                        subServiceSelect.required = false;
                        subServiceSelect.value = ''; // Clear any previous value
                        nextBtn.disabled = false; // Enable next button
                    }
                })
                .catch(error => {
                    console.error('Error loading sub-services:', error);
                    // If there's an error, assume no sub-services and allow proceeding
                    subServiceRow.style.display = 'none';
                    subServiceSelect.required = false;
                    subServiceSelect.value = '';
                    nextBtn.disabled = false;
                });
        } else {
            subServiceSelect.disabled = true;
            subServiceSelect.innerHTML = '<option value="">Select a service first</option>';
            subServiceRow.style.display = 'block';
            subServiceSelect.required = true;
            nextBtn.disabled = true;
        }
    });

    subServiceSelect.addEventListener('change', function() {
        // Only check sub-service if it's required (visible)
        if (subServiceSelect.required) {
            nextBtn.disabled = !this.value;
        }
    });
});
</script>
@endsection