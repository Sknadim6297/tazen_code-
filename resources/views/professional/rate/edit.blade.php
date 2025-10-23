@extends('professional.layout.layout')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3>Edit Rate</h3>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Update Rate Information</h4>
        </div>
        <div class="card-body">
            @php
                $professional = Auth::guard('professional')->user();
                $professionalService = $professional->professionalServices->first();
                $hasSubServices = $professionalService && $professionalService->subServices->count() > 0;
                $isServiceRate = !$rates->sub_service_id;
                $isSubServiceRate = $rates->sub_service_id;
            @endphp

            <form id="rateForm" action="{{ route('professional.rate.update', $rates->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Hidden fields for auto-detected service -->
                <input type="hidden" name="professional_service_id" value="{{ $professionalService->id }}">
                @if($isSubServiceRate)
                    <input type="hidden" name="sub_service_id" value="{{ $rates->sub_service_id }}">
                @endif

                @if($professionalService)
                    @if($isServiceRate)
                        <!-- Service Rate Section -->
                        <div class="service-section mb-4">
                            <div class="service-header mb-3 p-3" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px;">
                                <h5 class="mb-1">{{ $professionalService->service_name }}</h5>
                                @if($professionalService->service_type)
                                    <small class="text-muted">({{ $professionalService->service_type }})</small>
                                @endif
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Session Type</th>
                                            <th>No. of Sessions</th>
                                            <th>Rate Per Session (₹)</th>
                                            <th>Final Rate (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control session-type" name="session_type">
                                                    <option value="One Time" {{ $rates->session_type == 'One Time' ? 'selected' : '' }}>One Time</option>
                                                    <option value="Monthly" {{ $rates->session_type == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                    <option value="Quarterly" {{ $rates->session_type == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                    <option value="Free Hand" {{ $rates->session_type == 'Free Hand' ? 'selected' : '' }}>Free Hand</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control num-sessions" name="num_sessions" value="{{ $rates->num_sessions }}" min="1">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control rate-per-session" name="rate_per_session" value="{{ $rates->rate_per_session }}" min="0" step="100">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control final-rate" name="final_rate" value="{{ $rates->final_rate }}" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <!-- Sub-Service Rate Section -->
                        @php
                            $subService = $professionalService->subServices->where('id', $rates->sub_service_id)->first();
                        @endphp
                        <div class="sub-service-section mb-4">
                            <div class="service-header mb-3 p-3" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px;">
                                <h5 class="mb-1">{{ $professionalService->service_name }}</h5>
                                @if($professionalService->service_type)
                                    <small class="text-muted">({{ $professionalService->service_type }})</small>
                                @endif
                            </div>

                            <div class="sub-service-header mb-3 p-2" style="background: #e3f2fd; border: 1px solid #bbdefb; border-radius: 6px;">
                                <h6 class="mb-0">{{ $subService->name ?? 'Sub-Service' }}</h6>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Session Type</th>
                                            <th>No. of Sessions</th>
                                            <th>Rate Per Session (₹)</th>
                                            <th>Final Rate (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control session-type" name="session_type">
                                                    <option value="One Time" {{ $rates->session_type == 'One Time' ? 'selected' : '' }}>One Time</option>
                                                    <option value="Monthly" {{ $rates->session_type == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                    <option value="Quarterly" {{ $rates->session_type == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                    <option value="Free Hand" {{ $rates->session_type == 'Free Hand' ? 'selected' : '' }}>Free Hand</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control num-sessions" name="num_sessions" value="{{ $rates->num_sessions }}" min="1">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control rate-per-session" name="rate_per_session" value="{{ $rates->rate_per_session }}" min="0" step="100">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control final-rate" name="final_rate" value="{{ $rates->final_rate }}" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Features Section -->
                    <div class="features-section mb-4">
                        <h5 class="mb-3">Package Features</h5>
                        <div id="featuresContainer">
                            @if($rates->features && count($rates->features) > 0)
                                @foreach($rates->features as $feature)
                                    @if($feature)
                                        <div class="feature-item d-flex align-items-center mb-2">
                                            <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" value="{{ $feature }}" style="margin-right: 8px;">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="feature-item d-flex align-items-center mb-2">
                                    <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary add-feature" onclick="addFeature()">
                            <i class="fas fa-plus"></i> Add Feature
                        </button>
                    </div>

                    <div class="form-actions mt-4 d-flex justify-content-between">
                        <a href="{{ route('professional.rate.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Rates
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Rate
                        </button>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        You don't have any services set up yet. Please set up your services first.
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<style>
    @media screen and (max-width: 767px) {
    /* Fix header to prevent horizontal scrolling */
    .page-header {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
        padding-top: 10px;
        padding-bottom: 10px;
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
    }
    
    /* Make table container scrollable horizontally */
    .table-wrapper {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
    }
    
    /* Ensure the table takes full width of container */
    .data-table {
        width: 100%;
        table-layout: auto;
    }
    
    /* Fix the search container from overflowing */
    .search-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure content wrapper doesn't cause horizontal scroll */
    .content-wrapper {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
        padding: 20px 10px;
    }
    
    /* Fix card width */
    .card {
        width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure the card body doesn't cause overflow */
    .card-body {
        padding: 10px 5px;
    }
    
    /* Optional: Make some table columns width-responsive */
    .data-table th,
    .data-table td {
        white-space: nowrap;
    }
}
@media only screen and (min-width: 768px) and (max-width: 1024px) {
    .user-profile-wrapper {
        margin-top: -57px;
    }
    
}

/* Features styling */
.features-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.feature-item {
    margin-bottom: 0.75rem;
}

.feature-input {
    flex: 1;
}

.remove-feature {
    min-width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.add-feature {
    margin-top: 0.5rem;
}
</style>
@endsection

@section('scripts')
<script>
    // Feature management functions
    function addFeature() {
        const container = document.getElementById('featuresContainer');
        const newFeature = document.createElement('div');
        newFeature.className = 'feature-item d-flex align-items-center mb-2';
        newFeature.innerHTML = `
            <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
            <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
        `;
        container.appendChild(newFeature);
    }

    function removeFeature(button) {
        const featureItem = button.closest('.feature-item');
        const container = featureItem.closest('#featuresContainer');
        const featureItems = container.querySelectorAll('.feature-item');
        
        // Don't allow removing the last feature input
        if (featureItems.length > 1) {
            featureItem.remove();
        } else {
            // Just clear the input instead of removing it
            featureItem.querySelector('.feature-input').value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const row = document.querySelector('tbody tr');

        const calculateFinalRate = () => {
            const numSessions = parseInt(row.querySelector('.num-sessions').value || 0);
            const ratePerSession = parseInt(row.querySelector('.rate-per-session').value || 0);
            const finalRateInput = row.querySelector('.final-rate');
            finalRateInput.value = numSessions * ratePerSession;
        };

        row.querySelector('.num-sessions').addEventListener('input', calculateFinalRate);
        row.querySelector('.rate-per-session').addEventListener('input', calculateFinalRate);

        calculateFinalRate();
    });
</script>

<script>
    $(document).ready(function () {
        $('#rateForm').submit(function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const submitBtn = $(form).find('button[type="submit"]');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (response) {
                    toastr.success("Rate updated successfully.");
                    setTimeout(() => {
                        window.location.href = "{{ route('professional.rate.index') }}";
                    }, 1500);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error("An unexpected error occurred.");
                    }
                },
                complete: function () {
                    submitBtn.prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
