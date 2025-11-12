@extends('customer.layout.layout')

@section('title', 'Additional Service Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #f7a86c;
        --primary-dark: #eb8640;
        --primary-soft: #fde5cd;
        --accent: #7dd3fc;
        --success: #16a34a;
        --warning: #f59e0b;
        --danger: #ef4444;
        --neutral-900: #1f2937;
        --neutral-700: #374151;
        --neutral-500: #6b7280;
        --surface: #ffffff;
        --surface-muted: rgba(255, 255, 255, 0.92);
        --border-soft: rgba(247, 168, 108, 0.28);
        --shadow-lg: 0 24px 48px rgba(122, 63, 20, 0.14);
        --shadow-md: 0 14px 30px rgba(122, 63, 20, 0.12);
        --shadow-sm: 0 10px 22px rgba(15, 23, 42, 0.1);
        --radius-lg: 26px;
        --radius-md: 20px;
    }

    body,
    .app-content {
        background: linear-gradient(180deg, #fff8f1 0%, #fdf2e9 100%);
        font-family: 'Inter', sans-serif;
    }

    .content-wrapper {
        padding: 2.8rem 1.6rem 3.2rem;
        max-width: 1180px;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(251, 209, 173, 0.95), rgba(255, 244, 232, 0.95));
        border-radius: var(--radius-lg);
        padding: 2.6rem 2.4rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.6rem 2rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .page-header::before,
    .page-header::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        pointer-events: none;
    }

    .page-header::before {
        width: 320px;
        height: 320px;
        top: -200px;
        right: -120px;
        background: rgba(247, 168, 108, 0.26);
    }

    .page-header::after {
        width: 240px;
        height: 240px;
        bottom: -160px;
        left: -120px;
        background: rgba(255, 236, 214, 0.36);
    }

    .page-title h3 {
        margin: 0 0 0.8rem;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--neutral-900);
    }

    .page-title p {
        margin: 0;
        color: rgba(47, 47, 47, 0.68);
        max-width: 520px;
        line-height: 1.6;
    }

    .breadcrumb {
        display: flex;
        gap: 0.6rem;
        padding: 0;
        margin: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .breadcrumb li {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.88rem;
        color: var(--neutral-500);
    }

    .breadcrumb li a {
        text-decoration: none;
        color: var(--neutral-500);
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.65);
        border: 1px solid rgba(247, 168, 108, 0.2);
        transition: background 0.18s ease, color 0.18s ease;
    }

    .breadcrumb li a:hover {
        background: rgba(247, 168, 108, 0.18);
        color: var(--neutral-900);
    }

    .breadcrumb li.active {
        padding: 0.35rem 0.95rem;
        border-radius: 999px;
        background: rgba(247, 168, 108, 0.26);
        color: var(--neutral-900);
        font-weight: 600;
    }

    .card {
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        background: var(--surface);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        margin-bottom: 1.8rem;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .card-header {
        background: rgba(255, 255, 255, 0.9);
        border-bottom: 1px solid rgba(247, 168, 108, 0.16);
        padding: 1.8rem 2rem;
    }

    .card-header h4,
    .card-header h5 {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        font-size: 1.28rem;
        font-weight: 700;
        color: var(--neutral-900);
    }

    .card-body {
        padding: 1.9rem 2rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background: rgba(247, 168, 108, 0.2);
        color: #b36b31;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.2);
        color: #b45309;
    }

    .badge-paid,
    .badge-approved {
        background: rgba(125, 211, 252, 0.2);
        color: #0f4a6e;
    }

    .info-card {
        border-radius: var(--radius-md);
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(148, 163, 184, 0.22);
        padding: 1.6rem;
        box-shadow: var(--shadow-sm);
    }

    .info-card h6 {
        margin: 0 0 1rem;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--neutral-900);
    }

    .info-card p {
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.45rem;
        color: var(--neutral-500);
    }

    .price-breakdown,
    .negotiated-price-card {
        border-radius: var(--radius-md);
        border: 1px solid rgba(247, 168, 108, 0.22);
        background: rgba(255, 255, 255, 0.94);
        box-shadow: var(--shadow-sm);
    }

    .price-breakdown .card-header,
    .negotiated-price-card .card-header {
        background: rgba(255, 244, 232, 0.88);
        border-bottom-color: rgba(247, 168, 108, 0.2);
    }

    .price-breakdown .card-body,
    .negotiated-price-card .card-body {
        color: var(--neutral-700);
    }

    .price-table tr:first-child td {
        font-size: 0.86rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--neutral-500);
    }

    .price-table td {
        padding: 0.55rem 0;
        color: var(--neutral-700) !important;
    }

    .price-table td strong,
    .price-table td h5 {
        color: var(--neutral-900) !important;
    }

    .price-table tr:not(:first-child) td {
        border-top: 1px solid rgba(247, 168, 108, 0.16);
    }

    .price-table tr:first-child td {
        border-top: none;
    }

    .section-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: rgba(247, 168, 108, 0.18);
        color: var(--primary-dark);
        font-size: 1.1rem;
    }

    .quick-actions .btn {
        border-radius: 16px;
        padding: 0.9rem 1.1rem;
        justify-content: center;
    }

    .quick-actions small {
        color: var(--neutral-500);
    }

    .payment-card {
        background: linear-gradient(135deg, rgba(125, 211, 252, 0.18), rgba(250, 232, 214, 0.3));
        border: 1px solid rgba(125, 211, 252, 0.3);
        color: var(--neutral-700);
    }

    .payment-card h4 {
        color: #0369a1;
        font-weight: 700;
    }

    .payment-card code {
        background: rgba(255, 255, 255, 0.7);
        border-radius: 12px;
        padding: 0.35rem 0.6rem;
        display: inline-block;
        font-size: 0.82rem;
        color: #17496d;
    }

    .info-card {
        border-radius: var(--radius-md);
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(148, 163, 184, 0.22);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
    }

    .modal-illustration {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(247, 168, 108, 0.18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem;
    }

    .modal-illustration-icon {
        font-size: 2.4rem;
        color: var(--primary-dark);
    }

    .text-success {
        color: #0f766e !important;
    }

    .text-warning {
        color: #b45309 !important;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        padding: 0.85rem 1.6rem;
        border-radius: 999px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        text-decoration: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .btn-success,
    .pay-now-btn {
        background: linear-gradient(135deg, rgba(251, 209, 173, 1), rgba(247, 168, 108, 0.9));
        color: #7a4416;
        box-shadow: 0 16px 32px rgba(247, 168, 108, 0.28);
    }

    .btn-warning {
        background: rgba(250, 204, 21, 0.2);
        color: #b45309;
        border: 1px solid rgba(250, 204, 21, 0.28);
    }

    .btn-outline-secondary {
        background: rgba(255, 255, 255, 0.92);
        color: var(--neutral-700);
        border: 1px solid rgba(148, 163, 184, 0.28);
    }

    .alert {
        border-radius: var(--radius-md);
        border: 1px solid rgba(247, 168, 108, 0.22);
        background: rgba(255, 255, 255, 0.94);
        padding: 1.6rem 1.9rem;
        box-shadow: var(--shadow-sm);
        color: var(--neutral-700);
    }

    .alert-warning {
        border-color: rgba(245, 158, 11, 0.25);
        background: rgba(251, 213, 141, 0.18);
        color: #b45309;
    }

    .alert-info {
        border-color: rgba(125, 211, 252, 0.25);
        background: rgba(125, 211, 252, 0.15);
        color: #0f4a6e;
    }

    .alert-success {
        border-color: rgba(34, 197, 94, 0.24);
        background: rgba(187, 247, 208, 0.2);
        color: #166534;
    }

    .custom-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1050;
        background-color: rgba(17, 24, 39, 0.55);
        backdrop-filter: blur(6px);
        padding: 1.5rem;
    }

    .custom-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-soft);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18);
        width: min(640px, 100%);
        max-height: 90vh;
        overflow-y: auto;
        animation: fadeIn 0.24s ease;
    }

    .modal-header {
        padding: 1.8rem 2rem;
        border-bottom: 1px solid rgba(247, 168, 108, 0.22);
        background: rgba(255, 255, 255, 0.9);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .modal-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--neutral-900);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .modal-close {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: rgba(247, 168, 108, 0.18);
        color: var(--neutral-900);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.18s ease;
    }

    .modal-close:hover {
        background: rgba(247, 168, 108, 0.32);
    }

    .modal-body {
        padding: 1.9rem 2rem;
        display: grid;
        gap: 1.4rem;
    }

    .modal-footer {
        padding: 1.6rem 2rem;
        border-top: 1px solid rgba(247, 168, 108, 0.18);
        display: flex;
        justify-content: flex-end;
        gap: 0.8rem;
        background: rgba(255, 255, 255, 0.94);
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.92rem;
        color: var(--neutral-700);
    }

    .form-control,
    textarea,
    input[type="number"] {
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        padding: 0.85rem 1rem;
        background: rgba(247, 249, 252, 0.9);
    }

    .form-control:focus,
    textarea:focus,
    input[type="number"]:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(247, 168, 108, 0.25);
        outline: none;
    }

    .form-control:hover {
        border-color: var(--neutral-500);
    }

    .form-text {
        font-size: 0.85rem;
        color: var(--neutral-500);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideInUp {
        from {
            transform: translateY(60px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    /* Enhanced Responsive Design */
    @media (max-width: 768px) {
        .page-title h3 {
            font-size: 2rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .modal-content {
            margin: 1rem;
            width: calc(100% - 2rem);
        }
        
        .btn {
            padding: 0.8rem 1.5rem;
            font-size: 0.85rem;
        }

        .pay-now-btn {
            padding: 1rem 2rem !important;
            font-size: 1rem !important;
        }

        .content-wrapper {
            padding: 20px;
        }

        .page-header {
            padding: 2rem 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .card-header h4, .card-header h5 {
            font-size: 1.2rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
        }
    }

    /* Additional Utility Classes */
    .text-gradient {
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .hover-scale:hover {
        transform: scale(1.02);
        transition: transform 0.3s ease;
    }

    @keyframes slideInUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-title h3 {
            font-size: 1.8rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .modal-content {
            margin: 1rem;
            width: calc(100% - 2rem);
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Additional Service Details</h3>
            <p>Review your add-on request, track negotiation updates, and complete payment when you are satisfied with the offer.</p>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('user.additional-services.index') }}">Additional Services</a></li>
            <li class="active">Details</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-info-circle section-icon"></i>
                        Service Information
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="d-block"><strong>Service Name:</strong></label>
                            <p class="mb-0">{{ $additionalService->service_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="d-block"><strong>Status:</strong></label>
                            <p class="mb-0">{{ $additionalService->status_text }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="d-block"><strong>Reason:</strong></label>
                        <p class="mb-0">{{ $additionalService->reason }}</p>
                    </div>

                    @php
                        // Get the original professional price using the model method
                        $originalProfessionalBasePrice = $additionalService->original_professional_price;
                        
                        // For Professional's Price Breakdown - always use original
                        $originalCGST = $originalProfessionalBasePrice * 0.09;
                        $originalSGST = $originalProfessionalBasePrice * 0.09;
                        $originalTotalGST = $originalCGST + $originalSGST;
                        $originalFinalPrice = $originalProfessionalBasePrice + $originalTotalGST;
                        
                        // Check if customer has negotiated
                        $hasNegotiation = in_array($additionalService->negotiation_status, ['user_negotiated', 'admin_responded']);
                        
                        if ($hasNegotiation) {
                            // For Negotiated Price Breakdown - show the negotiated amount
                            if ($additionalService->negotiation_status === 'admin_responded') {
                                // Professional accepted - show final negotiated price
                                $negotiatedBasePrice = $additionalService->admin_final_negotiated_price;
                            } else {
                                // Still pending - show customer's offer
                                $negotiatedBasePrice = $additionalService->user_negotiated_price;
                            }
                            
                            // Calculate discount and new price based on ORIGINAL price
                            $discountAmount = $originalProfessionalBasePrice - $negotiatedBasePrice;
                            $discountPercent = ($originalProfessionalBasePrice > 0) ? (($discountAmount / $originalProfessionalBasePrice) * 100) : 0;
                            
                            $negotiatedCGST = $negotiatedBasePrice * 0.09;
                            $negotiatedSGST = $negotiatedBasePrice * 0.09;
                            $negotiatedTotalGST = $negotiatedCGST + $negotiatedSGST;
                            $negotiatedFinalPrice = $negotiatedBasePrice + $negotiatedTotalGST;
                        }
                    @endphp

                    <!-- Professional's Price Breakdown -->
                    <div class="card mb-3 price-breakdown">
                        <div class="card-header">
                            <h6 class="mb-0">₹ Professional's Initial Price Breakdown</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0 price-table">
                                <tbody>
                                    <tr>
                                        <td><strong>Description</strong></td>
                                        <td class="text-end"><strong>Amount</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Base Price</strong></td>
                                        <td class="text-end"><strong>₹{{ number_format($originalProfessionalBasePrice, 2) }}</strong></td>
                                    </tr>
                                    <tr style="border-top: 1px solid rgba(255,255,255,0.2);">
                                        <td colspan="2"><strong>Tax Breakdown</strong></td>
                                    </tr>
                                    <tr>
                                        <td>CGST 9%</td>
                                        <td class="text-end">₹{{ number_format($originalCGST, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>SGST 9%</td>
                                        <td class="text-end">₹{{ number_format($originalSGST, 2) }}</td>
                                    </tr>
                                    <tr style="border-top: 1px solid rgba(255,255,255,0.2);">
                                        <td><strong>Total GST (18%)</strong></td>
                                        <td class="text-end"><strong>₹{{ number_format($originalTotalGST, 2) }}</strong></td>
                                    </tr>
                                    <tr style="border-top: 2px solid rgba(255,255,255,0.3);">
                                        <td><strong>Final Amount</strong></td>
                                        <td class="text-end"><h5 class="mb-0"><strong>₹{{ number_format($originalFinalPrice, 2) }}</strong></h5></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($hasNegotiation)
                    <!-- Negotiated Price Breakdown -->
                    <div class="card mb-4 negotiated-price-card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-handshake"></i>
                                Negotiated Price Breakdown
                                @if($additionalService->negotiation_status === 'admin_responded')
                                    <span class="badge badge-paid ms-2">✅ Accepted</span>
                                @else
                                    <span class="badge badge-pending ms-2">⏳ Pending</span>
                                @endif
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0 price-table">
                                <tbody>
                                    <tr>
                                        <td><strong>Description</strong></td>
                                        <td class="text-end"><strong>Amount</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Base Price</td>
                                        <td class="text-end">₹{{ number_format($originalProfessionalBasePrice, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Negotiation Discount ({{ number_format($discountPercent, 1) }}%)</td>
                                        <td class="text-end text-warning">− ₹{{ number_format($discountAmount, 2) }}</td>
                                    </tr>
                                    <tr style="border-top: 1px solid rgba(255,255,255,0.2);">
                                        <td><strong>New Price After Discount</strong></td>
                                        <td class="text-end"><strong>₹{{ number_format($negotiatedBasePrice, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>GST 18% (9%+9%)</td>
                                        <td class="text-end">₹{{ number_format($negotiatedTotalGST, 2) }}</td>
                                    </tr>
                                    <tr style="border-top: 2px solid rgba(255,255,255,0.3);">
                                        <td><strong>Final Price Customer Pays</strong></td>
                                        <td class="text-end"><h5 class="mb-0 text-warning"><strong>₹{{ number_format($negotiatedFinalPrice, 2) }}</strong></h5></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="mt-3 text-center">
                                @if($additionalService->negotiation_status === 'admin_responded')
                                    @php
                                        $totalSavings = $originalFinalPrice - $negotiatedFinalPrice;
                                    @endphp
                                    <small class="text-success d-block">✅ Negotiated price accepted - Ready for payment</small>
                                    <small class="text-success"><i class="fas fa-piggy-bank"></i> You save: <strong>₹{{ number_format($totalSavings, 2) }}</strong> total</small>
                                @else
                                    <small class="text-warning d-block">⏳ Your negotiated offer is pending professional review</small>
                                    <small class="d-block mt-1">Once accepted, you'll pay ₹{{ number_format($negotiatedFinalPrice, 2) }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($additionalService->delivery_date)
                    <div class="mb-3">
                        <label class="d-block"><strong>Delivery Date:</strong></label>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}</p>
                    </div>
                    @endif

                    @if($additionalService->negotiation_status !== 'none')
                    <div class="alert {{ $additionalService->negotiation_status === 'user_negotiated' ? 'alert-warning' : 'alert-info' }}">
                        <h5 class="mb-3">
                            @if($additionalService->negotiation_status === 'user_negotiated')
                                ⏳ Negotiation Pending Review
                            @else
                                ✅ Negotiation Accepted
                            @endif
                        </h5>
                        @if($additionalService->negotiation_status === 'user_negotiated')
                            @php
                                $negotiationHandler = $additionalService->professional_id ? 'professional' : 'admin';
                                $handlerLabel = $negotiationHandler === 'professional' ? 'Professional' : 'Admin';
                            @endphp
                            
                            <div class="mb-2">
                                <strong>Your Negotiated Offer:</strong> 
                                <span class="text-success">₹{{ number_format($additionalService->user_negotiated_price, 2) }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Your Reason:</strong> 
                                <p class="mb-0 text-muted">{{ $additionalService->user_negotiation_reason }}</p>
                            </div>
                            <p class="text-info mb-0">
                                <i class="fas fa-clock"></i> 
                                <strong>Status:</strong> Waiting for {{ strtolower($handlerLabel) }} response... We'll notify you once {{ strtolower($handlerLabel) }} reviews your negotiation.
                            </p>
                        @elseif($additionalService->negotiation_status === 'admin_responded')
                            @php
                                $modifierLabel = $additionalService->professional_id ? 'Professional' : 'Admin';
                                $originalBasePriceForSavings = $additionalService->base_price; // Use the same original price
                                $finalNegotiatedPrice = $additionalService->admin_final_negotiated_price;
                                $totalSavings = ($originalBasePriceForSavings - $finalNegotiatedPrice) * 1.18;
                                $savingsPercent = ($originalBasePriceForSavings > 0) ? (($originalBasePriceForSavings - $finalNegotiatedPrice) / $originalBasePriceForSavings * 100) : 0;
                            @endphp
                            
                            <div class="mb-2">
                                <strong>Your Base Price Offer:</strong> ₹{{ number_format($additionalService->user_negotiated_price, 2) }}
                            </div>
                            <div class="mb-2">
                                <strong>{{ $modifierLabel }}'s Base Price Final Offer:</strong> 
                                <span class="text-success">₹{{ number_format($finalNegotiatedPrice, 2) }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>{{ $modifierLabel }}'s Response:</strong> 
                                <p class="mb-0 text-muted">{{ $additionalService->admin_negotiation_response }}</p>
                            </div>
                            <div class="mt-2">
                                <small class="text-success">✅ <strong>Good news!</strong> {{ $modifierLabel }} has responded to your negotiation. You can now proceed with payment at the updated price.</small>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">👨‍💼 Professional Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-card">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h6>👤 {{ $additionalService->professional->name }}</h6>
                                <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $additionalService->professional->email }}</p>
                                <p class="mb-1"><i class="fas fa-phone me-2"></i>{{ $additionalService->professional->phone }}</p>
                                <p class="mb-0"><i class="fas fa-bookmark me-2"></i>Booking: #{{ $additionalService->booking_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">⚡ Quick Actions</h5>
                </div>
                <div class="card-body d-grid gap-3 quick-actions">
                    @if($additionalService->payment_status === 'pending')
                        @if($additionalService->negotiation_status === 'user_negotiated')
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-clock"></i> 
                                Payment Pending Admin Review
                            </button>
                            <small class="text-muted text-center">
                                <i class="fas fa-info-circle"></i> 
                                Payment will be enabled once admin responds to your negotiation
                            </small>
                        @else
                            <button class="btn btn-success pay-now-btn" data-id="{{ $additionalService->id }}">
                                <i class="fas fa-credit-card"></i> 
                                Pay Now - ₹{{ number_format($additionalService->final_price, 2) }}
                            </button>
                        @endif
                    @endif
                    
                    @if($additionalService->canBeNegotiated())
                    <button class="btn btn-warning negotiate-btn" data-id="{{ $additionalService->id }}">
                        <i class="fas fa-handshake"></i> 
                        Negotiate Price
                    </button>
                    @endif
                    
                    @if($additionalService->consulting_status === 'done' && !$additionalService->customer_confirmed_at)
                    <button class="btn btn-primary confirm-completion-btn" data-id="{{ $additionalService->id }}">
                        <i class="fas fa-check-circle"></i> 
                        Confirm Completion
                    </button>
                    @endif

                    @if($additionalService->consulting_status === 'done' && $additionalService->payment_status === 'paid')
                    <hr class="my-2">
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.additional-services.invoice', $additionalService->id) }}" class="btn btn-success">
                            <i class="fas fa-file-text"></i> View Invoice
                        </a>
                        <a href="{{ route('user.additional-services.invoice.pdf', $additionalService->id) }}" class="btn btn-outline-success" target="_blank">
                            <i class="fas fa-download"></i> Download PDF Invoice
                        </a>
                    </div>
                    @endif

                    <a href="{{ route('user.additional-services.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> 
                        Back to List
                    </a>
                </div>
            </div>

            @if($additionalService->isPaid())
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">💳 Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-card payment-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge badge-paid">✅ Payment Completed</span>
                            <h4 class="mb-0">₹{{ number_format($additionalService->final_price, 2) }}</h4>
                        </div>
                        @if($additionalService->payment_id)
                        <p class="mb-0">
                            <small class="opacity-75">Transaction ID</small><br>
                            <code>{{ $additionalService->payment_id }}</code>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Negotiation Modal -->
<div class="custom-modal" id="negotiationModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">💰 Negotiate Service Price</h5>
            <button type="button" class="modal-close" onclick="closeModal('negotiationModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="negotiationForm">
            <div class="modal-body">
                @php
                    $professional = $additionalService->professional;
                    // Use professional->service_request_offset (percentage) for negotiation limit; default to 10%
                    $maxDiscountPercent = $professional->service_request_offset ?? 10;
                    // Effective base price (before GST)
                    $basePrice = $additionalService->getEffectiveBasePrice();
                    // Minimum allowed base price (e.g., 10% discount)
                    $minBasePrice = $minPrice ?? round($basePrice * (1 - ($maxDiscountPercent / 100)), 2);
                    // Final amounts including GST (18%) for display
                    $minFinal = round($minBasePrice * 1.18, 2);
                    $currentFinal = round($basePrice * 1.18, 2);
                @endphp
                
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-6">
                            <small class="d-block opacity-75">Current Base Price</small>
                            <strong>₹{{ number_format($basePrice, 2) }}</strong>
                            <small class="d-block text-muted">+ GST (18%): ₹{{ number_format($basePrice * 0.18, 2) }}</small>
                            <small class="d-block"><strong>Total: ₹{{ number_format($currentFinal, 2) }}</strong></small>
                        </div>
                        <div class="col-6">
                            <small class="d-block opacity-75">You can negotiate this service</small>
                            <strong class="text-success">💬 Make an offer</strong>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="negotiated_price" class="form-label">
                        <i class="fas fa-tag me-2"></i>Your Proposed Base Price (₹) *
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-info-circle"></i> 
                            You are negotiating the <strong>base price</strong> (currently ₹{{ number_format($basePrice, 2) }}). 
                            GST (18%) will be calculated on your negotiated price.
                        </small>
                    </label>
                    <input type="number" class="form-control form-control-lg" id="negotiated_price" name="negotiated_price" 
                           data-min-price="{{ $minBasePrice }}" 
                           data-max-price="{{ $basePrice }}"
                           min="{{ $minBasePrice }}"
                           max="{{ $basePrice }}" 
                           step="0.01" 
                           required
                           placeholder="Enter amount between ₹{{ number_format($minBasePrice, 2) }} - ₹{{ number_format($basePrice, 2) }}">
                    
                </div>
                
                <div class="mb-3">
                    <label for="negotiation_reason" class="form-label">
                        <i class="fas fa-comment me-2"></i>Reason for Negotiation *
                    </label>
                    <textarea class="form-control" id="negotiation_reason" name="negotiation_reason" 
                              rows="4" maxlength="1000" required 
                              placeholder="Please explain why you're requesting a price reduction..."></textarea>
                    <div class="form-text">
                        <span id="char-count">0</span>/1000 characters
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal('negotiationModal')">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-paper-plane me-2"></i>Submit Negotiation
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Confirm Completion Modal -->
<div class="custom-modal" id="confirmCompletionModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">✅ Confirm Service Completion</h5>
            <button type="button" class="modal-close" onclick="closeModal('confirmCompletionModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="text-center mb-4">
                <div class="modal-illustration">
                    <i class="fas fa-check-circle modal-illustration-icon"></i>
                </div>
            </div>
            <h6 class="text-center mb-3">Service Completion Confirmation</h6>
            <p class="text-center">The professional has marked this consultation as completed. Do you confirm that the service has been delivered satisfactorily?</p>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Important:</strong> Once confirmed, this action cannot be undone and the service will be marked as fully completed.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" onclick="closeModal('confirmCompletionModal')">
                <i class="fas fa-clock me-2"></i>Not Yet
            </button>
            <button type="button" class="btn btn-success" id="confirmCompletionBtn">
                <i class="fas fa-check-circle me-2"></i>Yes, Confirm Completion
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(document).ready(function() {
    let currentServiceId = {{ $additionalService->id }};

    // Custom Modal Functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Make closeModal available globally
    window.closeModal = closeModal;

    // Close modal when clicking outside
    $('.custom-modal').click(function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });

    // Close modal with Escape key
    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            $('.custom-modal.show').each(function() {
                closeModal(this.id);
            });
        }
    });

    // Character count for negotiation reason
    $('#negotiation_reason').on('input', function() {
        const length = $(this).val().length;
        $('#char-count').text(length);
        
        if (length > 1000) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Pay Now functionality with enhanced UI feedback
    $('.pay-now-btn').click(function() {
        const serviceId = $(this).data('id');
        const $btn = $(this);
        const originalText = $btn.html();
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: `/user/additional-services/${serviceId}/create-payment-order`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    const rkey = response.key || response.razorpay_key || '{{ config('services.razorpay.key') }}';
                    const ramount = response.amount || response.order_amount || 0; // amount in paise
                    const rcurrency = response.currency || 'INR';
                    const rorderId = response.order_id || response.orderId || response.order?.id || null;

                    if (!rorderId || !ramount) {
                        toastr.error('Invalid payment order returned from server. Please try again.');
                        $btn.prop('disabled', false).html(originalText);
                        return;
                    }

                    const options = {
                        key: rkey,
                        amount: ramount,
                        currency: rcurrency,
                        name: '{{ config('app.name') }}',
                        description: response.service_name || response.description || 'Additional Service Payment',
                        order_id: rorderId,
                        handler: function (razorpayResponse) {
                            handlePaymentSuccess(serviceId, razorpayResponse);
                        },
                        prefill: {
                            name: '{{ Auth::guard('user')->user()->name }}',
                            email: '{{ Auth::guard('user')->user()->email }}',
                            contact: '{{ Auth::guard('user')->user()->phone }}'
                        },
                        theme: {
                            color: '#667eea'
                        },
                        modal: {
                            ondismiss: function() {
                                toastr.info('Payment cancelled by user');
                                $btn.prop('disabled', false).html(originalText);
                            }
                        }
                    };
                    
                    const rzp = new Razorpay(options);
                    rzp.open();
                    
                    rzp.on('payment.failed', function (response) {
                        toastr.error('Payment failed: ' + response.error.description);
                    });
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('Failed to initiate payment. Please try again.');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

    function handlePaymentSuccess(serviceId, paymentResponse) {
        // Show success animation
        toastr.success('Payment initiated successfully! Verifying...');
        
        $.ajax({
            url: `/user/additional-services/${serviceId}/payment-success`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                razorpay_order_id: paymentResponse.razorpay_order_id,
                razorpay_signature: paymentResponse.razorpay_signature
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('Payment verification failed. Please contact support.');
            }
        });
    }

    // Negotiate functionality with custom modal
    $('.negotiate-btn').click(function() {
        openModal('negotiationModal');
        // Reset form
        $('#negotiationForm')[0].reset();
        $('#char-count').text('0');
    });

    // Submit negotiation with enhanced feedback
    $('#negotiationForm').submit(function(e) {
        e.preventDefault();
        
        const $submitBtn = $(this).find('button[type="submit"]');
        const originalText = $submitBtn.html();
        
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
        
        $.ajax({
            url: `/user/additional-services/${currentServiceId}/negotiate`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                negotiated_price: $('#negotiated_price').val(),
                negotiation_reason: $('#negotiation_reason').val()
            },
            success: function(response) {
                if (response.success) {
                    closeModal('negotiationModal');
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                // Handle validation errors
                const serverMessage = xhr.responseJSON?.message;
                const errors = xhr.responseJSON?.errors;
                
                if (serverMessage) {
                    toastr.error(serverMessage);
                } else if (errors) {
                    Object.values(errors).forEach(function(error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Confirm completion with custom modal
    $('.confirm-completion-btn').click(function() {
        // ensure currentServiceId is set (show page has it prefilled, but set from button for consistency)
        currentServiceId = $(this).data('id') || currentServiceId;
        console.log('Opening confirm modal for service:', currentServiceId);
        openModal('confirmCompletionModal');
    });

    $('#confirmCompletionBtn').click(function() {
        const $btn = $(this);
        const originalText = $btn.html();
        
        // Debug log
        console.log('Confirm completion clicked for serviceId:', currentServiceId);

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Confirming...');
        
        $.ajax({
            url: `/user/additional-services/${currentServiceId}/confirm-consultation`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('confirm-consultation success response:', response);
                if (response.success) {
                    closeModal('confirmCompletionModal');
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                console.error('confirm-consultation error:', xhr);
                const serverMessage = xhr.responseJSON?.message;
                if (serverMessage) {
                    toastr.error(serverMessage);
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Add smooth animations to cards
    $('.card').each(function(index) {
        $(this).css({
            'animation-delay': (index * 0.1) + 's'
        });
    });

    // Price input validation with real-time feedback
    $('#negotiated_price').on('input', function() {
        const value = parseFloat($(this).val());
        const minPrice = parseFloat($(this).data('min-price'));
        const max = parseFloat($(this).attr('max'));
        const $errorDiv = $('#price-error');
        
        // Real-time GST calculation display
        if (value && !isNaN(value)) {
            const finalAmount = value * 1.18; // Add 18% GST
            const savings = max - value; // Savings from current base
            const savingsPercent = ((savings / max) * 100).toFixed(2);
            
            // Update or create a real-time display
            let $display = $('#real-time-calc');
            if ($display.length === 0) {
                $display = $('<div id="real-time-calc" class="alert alert-success mt-2" style="border-left: 4px solid #198754;"></div>');
                $(this).after($display);
            }
            
            if (value >= minPrice && value <= max) {
                $display.html(`
                    <div class="text-center">
                        <small class="text-muted d-block">Your proposed base price</small>
                        <strong style="font-size: 1.1em;">₹${value.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>
                        <hr class="my-2">
                        <small class="text-success d-block"><strong>Final amount you'll pay (with GST):</strong></small>
                        <strong class="text-success" style="font-size: 1.2em;">₹${finalAmount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>
                        <small class="d-block text-success mt-1"><i class="fas fa-piggy-bank"></i> You save: <strong>₹${savings.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})} (${savingsPercent}%)</strong></small>
                    </div>
                `).show();
            } else {
                $display.hide();
            }
        }
    });
});
</script>
@endsection