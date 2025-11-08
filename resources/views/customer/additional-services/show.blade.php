@extends('customer.layout.layout')

@section('title', 'Additional Service Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* Global Font */
    * {
        font-family: 'Inter', sans-serif;
    }

    /* Modern Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 3rem 2rem;
        border-radius: 20px;
        margin-bottom: 3rem;
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

    .page-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }
    
    .page-title h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        color: #fff;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
        letter-spacing: -0.5px;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
        margin: 1rem 0 0 0;
        list-style: none;
        display: flex;
        gap: 0.5rem;
        font-size: 0.95rem;
        position: relative;
        z-index: 2;
        font-weight: 500;
    }
    
    .breadcrumb li a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
    }
    
    .breadcrumb li a:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    
    .breadcrumb li.active {
        font-weight: 600;
        color: #fff;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
    }

    /* Content Wrapper */
    .content-wrapper {
        padding: 30px;
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    /* Enhanced Card Styling */
    .card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2.5rem;
        background: #fff;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        padding: 2rem 2.5rem;
        position: relative;
    }

    .card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 2.5rem;
        right: 2.5rem;
        height: 1px;
        background: linear-gradient(90deg, transparent, #667eea, transparent);
    }

    .card-header h4, .card-header h5 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-body {
        padding: 2.5rem;
    }

    /* Enhanced Badge Styling */
    .badge {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s;
    }

    .badge:hover::before {
        left: 100%;
    }

    .badge-pending {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #fff;
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4);
    }

    .badge-approved {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #fff;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    .badge-paid {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .badge-in-progress {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: #fff;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
    }

    .badge-completed {
        background: linear-gradient(135deg, #10b981, #3b82f6);
        color: #fff;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    /* Enhanced Button Styling */
    .btn {
        padding: 1rem 2rem;
        border-radius: 16px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .btn:active {
        transform: translateY(-1px);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        box-shadow: 0 15px 35px rgba(16, 185, 129, 0.6);
        color: #fff;
    }

    /* Special Pay Now Button */
    .pay-now-btn {
        background: linear-gradient(135deg, #10b981, #3b82f6) !important;
        color: white !important;
        border: none !important;
        padding: 1.25rem 2.5rem !important;
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        border-radius: 20px !important;
        box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4) !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        position: relative !important;
        overflow: hidden !important;
        animation: pulse-glow 3s infinite !important;
    }

    .pay-now-btn:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 15px 40px rgba(16, 185, 129, 0.6) !important;
        background: linear-gradient(135deg, #3b82f6, #10b981) !important;
    }

    .pay-now-btn:focus {
        outline: none !important;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.3) !important;
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4);
        }
        50% {
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.8);
        }
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
    }

    .btn-warning:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(245, 158, 11, 0.6);
        color: #fff;
        background: linear-gradient(135deg, #d97706, #b45309);
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #fff;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(59, 130, 246, 0.6);
        color: #fff;
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
    }

    .btn-outline-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: #64748b;
        border: 2px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
    }

    .btn-outline-secondary:hover {
        background: #64748b;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(100, 116, 139, 0.4);
        border-color: #64748b;
    }

    /* Enhanced Alert Styling */
    .alert {
        border: none;
        border-radius: 20px;
        padding: 2rem 2.5rem;
        font-weight: 500;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }

    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
    }

    .alert::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 60px;
        opacity: 0.1;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    .alert-warning {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(245, 158, 11, 0.15));
        color: #92400e;
        border: 1px solid rgba(251, 191, 36, 0.2);
    }

    .alert-warning::before {
        background: linear-gradient(180deg, #fbbf24, #f59e0b);
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.15));
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert-danger::before {
        background: linear-gradient(180deg, #ef4444, #dc2626);
    }

    .alert-info {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(29, 78, 216, 0.15));
        color: #1e40af;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .alert-info::before {
        background: linear-gradient(180deg, #3b82f6, #1d4ed8);
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.15));
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-success::before {
        background: linear-gradient(180deg, #10b981, #059669);
    }

    /* Enhanced Modal Styling */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        animation: fadeIn 0.4s ease;
    }

    .custom-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        padding: 2rem 2.5rem;
        border-radius: 24px 24px 0 0;
        position: relative;
        overflow: hidden;
    }

    .modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffffff33, #ffffff66, #ffffff33);
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }

    .modal-title {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-close {
        position: absolute;
        top: 1.5rem;
        right: 2rem;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg) scale(1.1);
    }

    .modal-body {
        padding: 2.5rem;
    }

    .modal-footer {
        padding: 2rem 2.5rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        background: #f8fafc;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    /* Enhanced Form Styling */
    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        outline: none;
        background: #fff;
    }

    .form-control:hover {
        border-color: #cbd5e1;
    }

    /* Enhanced Animations */
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

    /* Modern Price Breakdown Cards */
    .price-breakdown {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(16, 185, 129, 0.3);
        position: relative;
        margin-bottom: 2rem;
    }

    .price-breakdown::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffffff33, #ffffff66, #ffffff33);
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }

    .price-breakdown .card-header {
        background: rgba(255, 255, 255, 0.15);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .price-breakdown .card-header::after {
        display: none;
    }

    .price-breakdown h6 {
        color: #fff;
        font-weight: 700;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Negotiated Price Card */
    .negotiated-price-card {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.3);
        position: relative;
        margin-bottom: 2rem;
    }

    .negotiated-price-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffffff33, #ffffff66, #ffffff33);
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }

    .negotiated-price-card .card-header {
        background: rgba(255, 255, 255, 0.15);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    /* Enhanced Info Cards */
    .info-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -25%;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .info-card h6 {
        margin: 0 0 1rem 0;
        font-weight: 700;
        opacity: 0.95;
        font-size: 1.1rem;
    }

    .info-card p {
        margin-bottom: 0.5rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Additional Service Details</h3>
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
                        <i class="fas fa-info-circle text-primary"></i>
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
                            <h6 class="mb-0">� Professional's Initial Price Breakdown</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0" style="color: #fff;">
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
                    <div class="card mb-4 negotiated-price-card hover-scale">
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
                            <table class="table table-borderless mb-0" style="color: #fff;">
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
                <div class="card-body d-grid gap-3">
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
                    <div class="info-card" style="background: linear-gradient(135deg, #00b894, #00cec9);">
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
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="fas fa-check-circle text-primary" style="font-size: 2.5rem;"></i>
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