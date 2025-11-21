@extends('professional.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('professional/assets/css/service.css') }}" />

<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .service-edit-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .service-edit-shell {
        max-width: 920px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .service-edit-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.4rem;
        padding: 2rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.16));
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
    }

    .service-edit-hero::before,
    .service-edit-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .service-edit-hero::before {
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .service-edit-hero::after {
        width: 220px;
        height: 220px;
        bottom: -40%;
        left: -10%;
        background: rgba(59, 130, 246, 0.18);
    }

    .service-edit-hero > * {
        position: relative;
        z-index: 1;
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--muted);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.45);
        color: #0f172a;
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .hero-breadcrumb {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        font-size: 0.86rem;
        color: var(--muted);
    }

    .hero-breadcrumb li a {
        color: var(--primary);
        text-decoration: none;
    }

    .form-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        padding: 2.2rem 2.3rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .form-section {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .form-section header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .form-section header h2 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.4rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .form-group label {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.75rem 0.9rem;
        font-size: 0.92rem;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    textarea.form-control {
        min-height: 140px;
        resize: vertical;
    }

    .muted-note {
        font-size: 0.78rem;
        color: var(--muted);
    }

    .sub-service-container {
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 16px;
        padding: 1.1rem;
        background: rgba(248, 250, 252, 0.85);
        min-height: 64px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.8rem;
    }
    
    @media (max-width: 992px) {
        .sub-service-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 576px) {
        .sub-service-container {
            grid-template-columns: 1fr;
        }
    }

    .sub-service-loading {
        text-align: center;
        color: var(--muted);
        font-style: italic;
        padding: 0.6rem 0;
    }

    .sub-service-item {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.65rem 0.8rem;
        background-color: #ffffff;
        border-radius: 10px;
        border: 1px solid rgba(226, 232, 240, 0.9);
    }

    .sub-service-item input[type="checkbox"] {
        transform: scale(1.15);
    }

    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .checkbox-item {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 1rem;
        border-radius: 999px;
        background: rgba(79, 70, 229, 0.1);
        color: #312e81;
        font-weight: 600;
        font-size: 0.82rem;
    }

    .checkbox-item input[type="checkbox"] {
        transform: scale(1.1);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 999px;
        padding: 0.75rem 1.6rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 18px 38px rgba(79, 70, 229, 0.22);
    }

    .btn-outline {
        background: transparent;
        color: var(--muted);
        border: 1px solid rgba(148, 163, 184, 0.38);
    }

    .btn-primary:hover,
    .btn-outline:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .service-edit-page {
            padding: 2.2rem 1rem 3.2rem;
        }

        .service-edit-hero {
            padding: 1.75rem 1.6rem;
        }

        .form-card {
            padding: 1.8rem 1.7rem;
        }
    }
</style>

@endsection

@section('content')
<div class="service-edit-page">
    <div class="service-edit-shell">
        <section class="service-edit-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-tools"></i>Edit Service</span>
                <h1>Edit Service</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Edit Service</li>
                </ul>
            </div>
        </section>

        <section class="form-card">
            <form id="serviceForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="serviceDuration" value="{{ old('serviceDuration', $service->duration ?? 60) }}">

                <div class="form-section">
                    <header>
                        <h2>Service Details</h2>
                    </header>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="serviceCategory">Service Category * <span class="badge bg-secondary text-white" style="font-size: 11px; padding: 3px 6px;">Not editable</span></label>
                            <select name="serviceId_disabled" id="serviceCategory" class="form-control" disabled>
                                <option value="">Select Category</option>
                                @foreach($services as $serviceItem)
                                    <option value="{{ $serviceItem->id }}" {{ $service->service_id == $serviceItem->id ? 'selected' : (isset($matchingServiceId) && $matchingServiceId == $serviceItem->id ? 'selected' : '') }}>
                                        {{ $serviceItem->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="serviceId" value="{{ $service->service_id }}">
                            <span class="muted-note">Service category is read-only on this page and cannot be changed.</span>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <header>
                        <h2>Sub-Services</h2>
                    </header>
                    <div class="form-group">
                        <label for="subServices">Sub-Services (Optional)</label>
                        <div id="subServiceContainer" class="sub-service-container">
                            <div class="sub-service-loading">Loading sub-services...</div>
                        </div>
                        <span class="muted-note">Select the specific sub-services you offer within your service category.</span>
                    </div>
                </div>

                <div class="form-section">
                    <header>
                        <h2>Additional Information</h2>
                    </header>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Service Features</label>
                            <div class="checkbox-group">
                                @php
                                    $selectedFeatures = is_array($service->features) ? $service->features : json_decode($service->features ?? '[]', true);
                                    $allFeatures = ['online' => 'Online Sessions'];
                                @endphp
                                @foreach($allFeatures as $key => $label)
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="features[]" value="{{ $key }}" {{ in_array($key, old('features', $selectedFeatures)) ? 'checked' : 'checked' }}> {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="serviceTags">Tags</label>
                            <input type="text" name="serviceTags" id="serviceTags" class="form-control" value="{{ old('serviceTags', $service->tags ?? '') }}" placeholder="Add tags separated by commas">
                            <span class="muted-note">Example: coaching, business, career</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serviceRequirements">Client Requirements</label>
                        <textarea name="serviceRequirements" id="serviceRequirements" class="form-control" placeholder="List any requirements clients should know before booking" rows="3">{{ old('serviceRequirements', $service->requirements ?? '') }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('professional.service.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Service
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#serviceCategory').change(function() {
        loadSubServices($(this).val());
    });

    loadSubServices($('#serviceCategory').val(), @json($service->subServices->pluck('id')->toArray()));

    $('#serviceForm').submit(function(e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);
        formData.append('_method', 'PUT');

        $.ajax({
            url: "{{ route('professional.service.update', $service->id) }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    form.reset();
                    setTimeout(() => {
                        window.location.href = "{{ route('professional.service.index') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message || "Something went wrong");
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error(xhr.responseJSON.message || "An unexpected error occurred");
                }
            }
        });
    });
});

function loadSubServices(serviceId, selectedSubServices = []) {
    const container = $('#subServiceContainer');

    if (!serviceId) {
        container.html('<p class="text-muted">Please select a service category first to see available sub-services.</p>');
        return;
    }

    container.html('<div class="sub-service-loading">Loading sub-services...</div>');

    $.ajax({
        url: "{{ route('professional.service.getSubServices') }}",
        type: "GET",
        data: { service_id: serviceId },
        success: function(response) {
            if (response.success && response.subServices.length > 0) {
                let html = '';
                response.subServices.forEach(function(subService) {
                    const isSelected = selectedSubServices.includes(subService.id);
                    html += `
                        <div class="sub-service-item">
                            <input type="checkbox" name="subServices[]" value="${subService.id}" id="subService${subService.id}" ${isSelected ? 'checked' : ''}>
                            <label for="subService${subService.id}">${subService.name}</label>
                        </div>
                    `;
                });
                container.html(html);
                enforceSubServiceLimit(container);
            } else {
                container.html('<p class="text-muted">No sub-services available for this category.</p>');
            }
        },
        error: function() {
            container.html('<p class="text-danger">Error loading sub-services. Please try again.</p>');
        }
    });
}

function enforceSubServiceLimit(container) {
    container.find('input[type="checkbox"]').off('change').on('change', function() {
        // selection not limited
    });
}
</script>
@endsection
