@extends('professional.layout.layout')

@section('content')
@php
    $professional = Auth::guard('professional')->user();
    $professionalService = $professional ? $professional->professionalServices->first() : null;
    $isServiceRate = !$rates->sub_service_id;
    $isSubServiceRate = $rates->sub_service_id;
    $currentSubService = null;
    if ($isSubServiceRate && $professionalService && $professionalService->subServices) {
        $currentSubService = $professionalService->subServices->where('id', $rates->sub_service_id)->first();
    }
@endphp

<div class="content-wrapper rates-edit-page">
    <div class="rates-shell">
        <header class="rates-header">
            <div class="header-info">
                <span class="pretitle">Rates & Packages</span>
                <h1>Edit Rate</h1>
                <p>Fine-tune your pricing details to keep your services competitive and clear for clients.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('professional.rate.index') }}" class="header-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Rates
                </a>
            </div>
        </header>

        <section class="rates-card">
            <div class="rates-card__head">
                <h2>Update Rate Information</h2>
                <p class="subtitle">
                    @if($professionalService)
                        Editing <strong>{{ $professionalService->service_name }}</strong>
                        @if($isSubServiceRate && $currentSubService)
                            <span class="dot-divider"></span>
                            <span>Sub-service: <strong>{{ $currentSubService->name }}</strong></span>
                        @endif
                    @else
                        Configure your rate details below.
                    @endif
                </p>
            </div>

            <div class="rates-card__body">
                <form id="rateForm" action="{{ route('professional.rate.update', $rates->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="professional_service_id" value="{{ $professionalService ? $professionalService->id : '' }}">
                    @if($isSubServiceRate)
                        <input type="hidden" name="sub_service_id" value="{{ $rates->sub_service_id }}">
                    @endif

                    @if($professionalService)
                        @if($isServiceRate)
                            <div class="rate-section service-section">
                                <div class="section-heading">
                                    <div>
                                        <h3>{{ $professionalService->service_name }}</h3>
                                        @if($professionalService->service_type)
                                            <small>{{ $professionalService->service_type }}</small>
                                        @endif
                                    </div>
                                    <span class="section-badge">Service level</span>
                                </div>

                                <div class="table-shell">
                                    <div class="table-responsive">
                                        <table class="styled-table">
                                            <thead>
                                                <tr>
                                                    <th>Session Type</th>
                                                    <th>No. of Sessions</th>
                                                    <th>Rate Per Session (₹)</th>
                                                    <th>Final Rate (₹)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="Session Type">
                                                        <select class="form-control session-type" name="session_type">
                                                            <option value="One Time" {{ $rates->session_type == 'One Time' ? 'selected' : '' }}>One Time</option>
                                                            <option value="Monthly" {{ $rates->session_type == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                            <option value="Quarterly" {{ $rates->session_type == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                            <option value="Free Hand" {{ $rates->session_type == 'Free Hand' ? 'selected' : '' }}>Free Hand</option>
                                                        </select>
                                                    </td>
                                                    <td data-label="No. of Sessions">
                                                        <input type="number" class="form-control num-sessions" name="num_sessions" value="{{ $rates->num_sessions }}" min="1">
                                                    </td>
                                                    <td data-label="Rate Per Session (₹)">
                                                        <input type="number" class="form-control rate-per-session" name="rate_per_session" value="{{ $rates->rate_per_session }}" min="0" step="100">
                                                    </td>
                                                    <td data-label="Final Rate (₹)">
                                                        <input type="number" class="form-control final-rate" name="final_rate" value="{{ $rates->final_rate }}" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="rate-section sub-service-section">
                                <div class="section-heading">
                                    <div>
                                        <h3>{{ $professionalService->service_name }}</h3>
                                        @if($professionalService->service_type)
                                            <small>{{ $professionalService->service_type }}</small>
                                        @endif
                                    </div>
                                    <span class="section-badge">Sub-service level</span>
                                </div>

                                <div class="sub-service-banner">
                                    <div class="sub-service-title">
                                        <span class="label">Sub-service</span>
                                        <h4>{{ $currentSubService->name ?? 'Sub-Service' }}</h4>
                                    </div>
                                </div>

                                <div class="table-shell">
                                    <div class="table-responsive">
                                        <table class="styled-table">
                                            <thead>
                                                <tr>
                                                    <th>Session Type</th>
                                                    <th>No. of Sessions</th>
                                                    <th>Rate Per Session (₹)</th>
                                                    <th>Final Rate (₹)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="Session Type">
                                                        <select class="form-control session-type" name="session_type">
                                                            <option value="One Time" {{ $rates->session_type == 'One Time' ? 'selected' : '' }}>One Time</option>
                                                            <option value="Monthly" {{ $rates->session_type == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                            <option value="Quarterly" {{ $rates->session_type == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                            <option value="Free Hand" {{ $rates->session_type == 'Free Hand' ? 'selected' : '' }}>Free Hand</option>
                                                        </select>
                                                    </td>
                                                    <td data-label="No. of Sessions">
                                                        <input type="number" class="form-control num-sessions" name="num_sessions" value="{{ $rates->num_sessions }}" min="1">
                                                    </td>
                                                    <td data-label="Rate Per Session (₹)">
                                                        <input type="number" class="form-control rate-per-session" name="rate_per_session" value="{{ $rates->rate_per_session }}" min="0" step="100">
                                                    </td>
                                                    <td data-label="Final Rate (₹)">
                                                        <input type="number" class="form-control final-rate" name="final_rate" value="{{ $rates->final_rate }}" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="features-section">
                            <h5><i class="fas fa-list-ul"></i> Package Features</h5>
                            <p class="helper-text">Highlight what this package includes to help customers choose confidently.</p>
                            <div id="featuresContainer">
                                @if($rates->features && count($rates->features) > 0)
                                    @foreach($rates->features as $feature)
                                        @if($feature)
                                            <div class="feature-item">
                                                <input type="text" name="features[]" class="form-control feature-input" placeholder="Enter feature" value="{{ $feature }}">
                                                <button type="button" class="remove-feature" onclick="removeFeature(this)" aria-label="Remove feature">×</button>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="feature-item">
                                        <input type="text" name="features[]" class="form-control feature-input" placeholder="Enter feature">
                                        <button type="button" class="remove-feature" onclick="removeFeature(this)" aria-label="Remove feature">×</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="add-feature" onclick="addFeature()">
                                <i class="fas fa-plus"></i>
                                Add Feature
                            </button>
                        </div>

                        <div class="form-footer">
                            <a href="{{ route('professional.rate.index') }}" class="back-link">
                                <i class="fas fa-arrow-left"></i>
                                Back to Rates
                            </a>
                            <button type="submit" class="btn primary-btn">
                                <i class="fas fa-save"></i>
                                Update Rate
                            </button>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>You don't have any services set up yet.</strong>
                            <p>Please set up your services first to manage rates.</p>
                            <a href="{{ route('professional.service.create') }}" class="btn">
                                Create Service
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </section>
    </div>
</div>

<style>
    .rates-edit-page {
        background: #f4f6fb;
        padding: 2.75rem 1.5rem 3.5rem;
    }

    .rates-shell {
        max-width: 1180px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .rates-header {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 28px;
        padding: 2.35rem 2.6rem;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.25);
        box-shadow: 0 20px 38px rgba(148, 163, 184, 0.18);
    }

    .rates-header::after {
        content: "";
        position: absolute;
        inset: -40% 40% auto -10%;
        height: 180%;
        background: radial-gradient(circle at top, rgba(255, 255, 255, 0.65), transparent 60%);
        pointer-events: none;
        transform: rotate(-8deg);
    }

    .header-info,
    .header-actions {
        position: relative;
        z-index: 1;
    }

    .header-info .pretitle {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.72rem;
        font-weight: 600;
        color: #0f172a;
        background: rgba(15, 23, 42, 0.08);
        border-radius: 999px;
        padding: 0.3rem 0.85rem;
        border: 1px solid rgba(100, 116, 139, 0.3);
    }

    .header-info h1 {
        margin: 1.1rem 0 0.55rem;
        font-size: 2rem;
        font-weight: 700;
        color: #000;
        letter-spacing: -0.01em;
    }

    .header-info p {
        margin: 0;
        max-width: 520px;
        color: #000;
        font-size: 0.98rem;
        line-height: 1.55rem;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem 1.55rem;
        border-radius: 999px;
        background: #fff;
        color: #000;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid rgba(148, 163, 184, 0.45);
        transition: all 0.25s ease;
    }

    .header-btn:hover {
        background: rgba(226, 232, 240, 0.6);
        transform: translateY(-1px);
    }

    .rates-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 28px 60px rgba(15, 23, 42, 0.14);
        overflow: hidden;
    }

    .rates-card__head {
        padding: 2rem 2.35rem 1.6rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.24);
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .rates-card__head h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
    }

    .rates-card__head .subtitle {
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.6rem;
        color: #64748b;
        font-size: 0.95rem;
    }

    .dot-divider {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(99, 102, 241, 0.6);
        display: inline-block;
    }

    .rates-card__body {
        padding: 2.3rem 2.35rem 2.4rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .rate-section {
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 20px;
        padding: 1.8rem;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .service-section {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.06), rgba(59, 130, 246, 0.05));
    }

    .section-heading {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .section-heading h3 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
    }

    .section-heading small {
        display: block;
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 0.2rem;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        background: rgba(79, 70, 229, 0.14);
        color: #4338ca;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .sub-service-section {
        background: rgba(79, 70, 229, 0.05);
        border-color: rgba(79, 70, 229, 0.2);
    }

    .sub-service-banner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(129, 140, 248, 0.15));
        border-radius: 16px;
        padding: 1.1rem 1.4rem;
        border: 1px solid rgba(59, 130, 246, 0.22);
    }

    .sub-service-title .label {
        display: block;
        text-transform: uppercase;
        font-size: 0.74rem;
        letter-spacing: 0.1em;
        color: rgba(71, 85, 105, 0.8);
        margin-bottom: 0.35rem;
    }

    .sub-service-title h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
    }

    .table-shell {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
    }

    .table-responsive {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: #ffffff;
    }

    .styled-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .styled-table thead {
        background: rgba(79, 70, 229, 0.08);
    }

    .styled-table th {
        padding: 0.95rem 1.05rem;
        font-size: 0.86rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #1e293b;
        border-bottom: 1px solid rgba(148, 163, 184, 0.25);
    }

    .styled-table td {
        padding: 0.85rem 1.05rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        background: #ffffff;
    }

    .styled-table tr:last-child td {
        border-bottom: none;
    }

    .styled-table input.form-control,
    .styled-table select.form-control {
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.45);
        padding: 0.7rem 0.85rem;
        font-size: 0.92rem;
        color: #0f172a;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .styled-table input.form-control:focus,
    .styled-table select.form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.18);
    }

    .features-section {
        background: #ffffff;
        border: 1px dashed rgba(99, 102, 241, 0.5);
        border-radius: 22px;
        padding: 1.8rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .features-section h5 {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.08rem;
        color: #0f172a;
    }

    .features-section h5 i {
        color: #6366f1;
    }

    .helper-text {
        margin: 0;
        color: #64748b;
        font-size: 0.92rem;
    }

    #featuresContainer {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .feature-input {
        flex: 1;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.45);
        padding: 0.75rem 0.95rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .feature-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.18);
    }

    .remove-feature {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        border: 1px solid rgba(239, 68, 68, 0.35);
        background: #fff;
        color: #ef4444;
        font-size: 1.4rem;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .remove-feature:hover {
        background: rgba(239, 68, 68, 0.12);
        border-color: rgba(239, 68, 68, 0.5);
    }

    .add-feature {
        align-self: flex-start;
        padding: 0.75rem 1.35rem;
        border-radius: 999px;
        border: 1px solid rgba(79, 70, 229, 0.45);
        background: rgba(79, 70, 229, 0.08);
        color: #4338ca;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        transition: all 0.2s ease;
    }

    .add-feature:hover {
        background: rgba(79, 70, 229, 0.15);
        border-color: rgba(79, 70, 229, 0.6);
    }

    .form-footer {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding-top: 1.1rem;
        border-top: 1px solid rgba(148, 163, 184, 0.18);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.85rem 1.55rem;
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.55);
        background: #ffffff;
        color: #475569;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .back-link:hover {
        border-color: #6366f1;
        color: #4338ca;
    }

    .primary-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.95rem 2.1rem;
        border-radius: 999px;
        border: none;
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.98rem;
        box-shadow: 0 22px 38px rgba(79, 70, 229, 0.25);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .primary-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 26px 44px rgba(79, 70, 229, 0.3);
    }

    .primary-btn:disabled {
        opacity: 0.65;
        box-shadow: none;
        cursor: not-allowed;
    }

    .empty-state {
        padding: 2.2rem;
        border-radius: 22px;
        border: 1px solid rgba(248, 113, 113, 0.35);
        background: rgba(254, 226, 226, 0.65);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.85rem;
        text-align: center;
        color: #b91c1c;
    }

    .empty-state .btn {
        padding: 0.85rem 1.6rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        color: #ffffff;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .rates-edit-page {
            padding: 2.4rem 1.35rem 3rem;
        }

        .rates-card__body {
            padding: 2rem;
        }
    }

    @media (max-width: 768px) {
        .rates-header {
            padding: 1.9rem 1.7rem;
        }

        .rates-card__head {
            padding: 1.6rem 1.8rem;
        }

        .rates-card__body {
            padding: 1.7rem;
        }

        .header-actions {
            width: 100%;
            justify-content: flex-start;
            margin-top: 1.2rem;
        }

        .header-btn {
            width: 100%;
            justify-content: center;
        }

        .rate-section {
            padding: 1.5rem;
        }

        .styled-table,
        .styled-table thead,
        .styled-table tbody,
        .styled-table th,
        .styled-table td,
        .styled-table tr {
            display: block;
        }

        .styled-table thead {
            display: none;
        }

        .styled-table tr {
            border-radius: 18px;
            border: 1px solid rgba(203, 213, 225, 0.65);
            margin-bottom: 1.1rem;
            overflow: hidden;
            background: #ffffff;
        }

        .styled-table td {
            border: none;
            padding: 0.8rem 1.1rem;
            display: flex;
            justify-content: space-between;
            gap: 1.3rem;
            background: transparent;
        }

        .styled-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            flex: 0 0 45%;
            text-transform: capitalize;
        }

        .styled-table input.form-control,
        .styled-table select.form-control {
            width: 55%;
        }

        .feature-item {
            flex-direction: column;
            align-items: stretch;
            gap: 0.65rem;
        }

        .remove-feature {
            width: 100%;
            height: 46px;
        }

        .form-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .back-link,
        .primary-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Feature management functions
    function addFeature() {
        const container = document.getElementById('featuresContainer');
        const newFeature = document.createElement('div');
        newFeature.className = 'feature-item';
        newFeature.innerHTML = `
            <input type="text" name="features[]" class="form-control feature-input" placeholder="Enter feature">
            <button type="button" class="remove-feature" onclick="removeFeature(this)" aria-label="Remove feature">×</button>
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
        if (!row) {
            return;
        }

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
