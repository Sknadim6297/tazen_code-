@extends('professional.layout.layout')

@section('title', 'Additional Service Details')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --danger: #ef4444;
        --warning: #f59e0b;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .additional-service-show {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .show-shell {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .show-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.4rem;
        padding: 2rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.14));
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
        position: relative;
        overflow: hidden;
    }

    .show-hero::before,
    .show-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .show-hero::before {
        width: 340px;
        height: 340px;
        top: -48%;
        right: -14%;
        background: rgba(79, 70, 229, 0.2);
    }

    .show-hero::after {
        width: 220px;
        height: 220px;
        bottom: -45%;
        left: -12%;
        background: rgba(14, 165, 233, 0.16);
    }

    .show-hero > * {
        position: relative;
        z-index: 1;
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        color: var(--muted);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.38rem 1.05rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        background: rgba(255, 255, 255, 0.42);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
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

    .status-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 1.1rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #0f172a;
        background: rgba(79, 70, 229, 0.16);
        border: 1px solid rgba(79, 70, 229, 0.24);
    }

    .status-pill.pending { background: rgba(245, 158, 11, 0.16); border-color: rgba(245, 158, 11, 0.28); color: #b45309; }
    .status-pill.approved { background: rgba(34, 197, 94, 0.16); border-color: rgba(34, 197, 94, 0.28); color: #047857; }
    .status-pill.rejected { background: rgba(248, 113, 113, 0.16); border-color: rgba(248, 113, 113, 0.28); color: #b91c1c; }
    .status-pill.paid { background: rgba(14, 165, 233, 0.16); border-color: rgba(14, 165, 233, 0.28); color: #0c4a6e; }

    .show-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.6rem;
    }

    .show-card {
        background: var(--card-bg);
        border-radius: 22px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        overflow: hidden;
    }

    .show-card__head {
        padding: 1.7rem 2.1rem 1.1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.22);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .show-card__head h2 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
    }

    .show-card__body {
        padding: 2.1rem 2.1rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.4rem;
    }

    .info-block {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .info-block label {
        font-size: 0.86rem;
        font-weight: 600;
        color: var(--muted);
    }

    .info-block p {
        margin: 0;
        font-size: 0.98rem;
        font-weight: 600;
        color: #0f172a;
    }

    .description-card {
        background: rgba(79, 70, 229, 0.08);
        border-radius: 18px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        padding: 1.45rem 1.6rem;
        color: #312e81;
    }

    .price-breakdown {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.16), rgba(79, 70, 229, 0.16));
        border-radius: 20px;
        border: 1px solid rgba(79, 70, 229, 0.22);
        padding: 1.5rem 1.6rem;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.12);
    }

    .price-breakdown h3 {
        margin: 0 0 1.1rem 0;
        font-size: 1rem;
        font-weight: 700;
        color: #312e81;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.55rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.24);
    }

    .price-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .price-label { font-size: 0.85rem; color: var(--muted); font-weight: 600; }
    .price-value { font-size: 0.95rem; font-weight: 700; color: #0f172a; }
    .price-value.total { font-size: 1.15rem; color: #1d4ed8; }

    .alert-card {
        border-radius: 18px;
        border: 1px solid rgba(14, 165, 233, 0.22);
        background: rgba(14, 165, 233, 0.12);
        padding: 1.25rem 1.4rem;
        color: #0c4a6e;
    }

    .alert-card.danger { border-color: rgba(248, 113, 113, 0.28); background: rgba(248, 113, 113, 0.12); color: #991b1b; }
    .alert-card.success { border-color: rgba(34, 197, 94, 0.28); background: rgba(34, 197, 94, 0.12); color: #166534; }
    .alert-card.warning { border-color: rgba(245, 158, 11, 0.28); background: rgba(245, 158, 11, 0.14); color: #854d0e; }

    .form-card {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.24);
        padding: 1.6rem 1.7rem;
        background: rgba(249, 250, 251, 0.86);
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .form-card h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.3rem; }

    .form-group label { font-weight: 600; font-size: 0.88rem; color: var(--muted); }

    .form-control {
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.65rem 0.85rem;
        font-size: 0.92rem;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    textarea.form-control { min-height: 140px; resize: vertical; }

    .form-text { font-size: 0.78rem; color: var(--muted); }

    .actions-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        border-radius: 14px;
        border: none;
        padding: 0.85rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        text-decoration: none;
    }

    .action-btn.primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; box-shadow: 0 18px 36px rgba(79, 70, 229, 0.2); }
    .action-btn.success { background: linear-gradient(135deg, var(--accent), #16a34a); color: #fff; box-shadow: 0 18px 36px rgba(34, 197, 94, 0.2); }
    .action-btn.info { background: linear-gradient(135deg, var(--secondary), #0284c7); color: #fff; box-shadow: 0 18px 36px rgba(14, 165, 233, 0.2); }
    .action-btn.warning { background: linear-gradient(135deg, #fb923c, #f97316); color: #fff; box-shadow: 0 18px 36px rgba(249, 115, 22, 0.2); }
    .action-btn.outline { background: transparent; color: var(--muted); border: 1px solid rgba(148, 163, 184, 0.4); }

    .action-btn:hover { transform: translateY(-1px); }

    .quick-actions-card {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .invoice-actions {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .info-aside-card {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        padding: 1.8rem 1.9rem;
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .commission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .commission-card {
        border-radius: 16px;
        padding: 1rem 1.1rem;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        background: rgba(79, 70, 229, 0.08);
        border: 1px solid rgba(79, 70, 229, 0.16);
    }

    .commission-card.success { background: rgba(34, 197, 94, 0.12); border-color: rgba(34, 197, 94, 0.22); }
    .commission-card.danger { background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.22); }
    .commission-card.info { background: rgba(14, 165, 233, 0.12); border-color: rgba(14, 165, 233, 0.22); }

    .commission-card span { font-size: 0.78rem; color: var(--muted); font-weight: 600; }
    .commission-card strong { font-size: 1rem; color: #0f172a; }

    .custom-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1050;
        background: rgba(15, 23, 42, 0.55);
        align-items: center;
        justify-content: center;
        padding: 1.6rem;
    }

    .custom-modal.show { display: flex; }

    .modal-content {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 30px 70px rgba(15, 23, 42, 0.22);
        width: 100%;
        max-width: 520px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.35rem 1.6rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: rgba(241, 245, 249, 0.8);
    }

    .modal-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .modal-close {
        border: none;
        background: transparent;
        font-size: 1.2rem;
        color: var(--muted);
        cursor: pointer;
    }

    .modal-body {
        padding: 1.6rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .modal-footer {
        padding: 1.2rem 1.6rem;
        border-top: 1px solid rgba(148, 163, 184, 0.18);
        display: flex;
        gap: 0.8rem;
        justify-content: flex-end;
    }

    .modal-footer .btn {
        border-radius: 12px;
        padding: 0.75rem 1.3rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    textarea.is-invalid,
    input.is-invalid { border-color: var(--danger) !important; box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12) !important; }
    .price-error { font-size: 0.78rem; color: var(--danger); }

    @media (max-width: 1024px) {
        .show-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .additional-service-show { padding: 2.2rem 1rem 3.2rem; }
        .show-hero { padding: 1.75rem 1.6rem; }
        .show-card__body { padding: 1.7rem 1.6rem; }
        .info-grid { grid-template-columns: 1fr; }
        .actions-list .action-btn { width: 100%; }
        .modal-footer { flex-direction: column; }
        .modal-footer .btn { width: 100%; }
    }
</style>
@endsection

@section('content')
<div class="additional-service-show">
    <div class="show-shell">
        <section class="show-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-layer-group"></i>Details</span>
                <h1>Additional Service Details</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('professional.additional-services.index') }}">Additional Services</a></li>
                    <li class="active" aria-current="page">Details</li>
                </ul>
            </div>
            <div class="status-pills">
                @if($additionalService->admin_status === 'pending')
                    <span class="status-pill pending"><i class="fas fa-hourglass-half"></i>Pending Review</span>
                @elseif($additionalService->admin_status === 'approved')
                    <span class="status-pill approved"><i class="fas fa-badge-check"></i>Approved</span>
                @elseif($additionalService->admin_status === 'rejected')
                    <span class="status-pill rejected"><i class="fas fa-times-circle"></i>Rejected</span>
                @endif
                @if($additionalService->payment_status === 'paid')
                    <span class="status-pill paid"><i class="fas fa-wallet"></i>Paid</span>
                @endif
            </div>
        </section>

        <div class="show-grid">
            <article class="show-card">
                <header class="show-card__head">
                    <h2><i class="fas fa-clipboard-list"></i> Service Overview</h2>
                </header>
                <div class="show-card__body">
                    <div class="info-grid">
                        <div class="info-block">
                            <label>Service Name</label>
                            <p>{{ $additionalService->service_name }}</p>
                        </div>
                        <div class="info-block">
                            <label>Consultation Status</label>
                            <p>
                                @if($additionalService->consulting_status === 'pending')
                                    <span class="status-pill pending">Pending</span>
                                @elseif($additionalService->consulting_status === 'in_progress')
                                    <span class="status-pill info">In Progress</span>
                                @elseif($additionalService->consulting_status === 'done')
                                    <span class="status-pill approved">Completed</span>
                                @endif
                            </p>
                        </div>
                        @if($additionalService->delivery_date)
                            <div class="info-block">
                                <label>Delivery Date</label>
                                <p><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}</p>
                            </div>
                        @endif
                        <div class="info-block">
                            <label>Created</label>
                            <p>{{ $additionalService->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="description-card">
                        <strong><i class="fas fa-align-left"></i> Reason for Additional Service</strong>
                        <p style="margin: 0.6rem 0 0; font-size: 0.95rem; line-height: 1.6;">{{ $additionalService->reason }}</p>
                    </div>

                    <div class="price-breakdown">
                        <h3><i class="fas fa-coins"></i> Price Breakdown</h3>
                        @php
                            $effectiveBasePrice = $additionalService->getEffectiveBasePrice();
                            $cgst = $additionalService->cgst ?? ($effectiveBasePrice * 0.09);
                            $sgst = $additionalService->sgst ?? ($effectiveBasePrice * 0.09);
                            $totalGst = $cgst + $sgst;
                            $effectiveTotalPrice = $additionalService->getEffectiveTotalPrice();
                        @endphp
                        <div class="price-row">
                            <span class="price-label">Base Price</span>
                            <span class="price-value">₹{{ number_format($effectiveBasePrice, 2) }}</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">GST (18%)</span>
                            <span class="price-value">₹{{ number_format($totalGst, 2) }} <small style="display:block; font-size:0.75rem; color:var(--muted);">(CGST {{ number_format($cgst, 2) }}, SGST {{ number_format($sgst, 2) }})</small></span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Negotiation Status</span>
                            <span class="price-value">
                                @if($additionalService->negotiation_status === 'none')
                                    No Negotiation
                                @elseif($additionalService->negotiation_status === 'user_negotiated')
                                    Awaiting Response
                                @else
                                    Completed
                                @endif
                            </span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Negotiated Values</span>
                            <span class="price-value">
                                @if($additionalService->user_negotiated_price)
                                    Customer: ₹{{ number_format($additionalService->user_negotiated_price, 2) }}<br>
                                @endif
                                @if($additionalService->admin_final_negotiated_price)
                                    Final: ₹{{ number_format($additionalService->admin_final_negotiated_price, 2) }}
                                @else
                                    <small style="color:var(--muted);">No admin update yet</small>
                                @endif
                            </span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Final Price</span>
                            <span class="price-value total">₹{{ number_format($effectiveTotalPrice, 2) }}</span>
                        </div>
                    </div>

                    @if($additionalService->negotiation_status === 'admin_responded')
                        <div class="alert-card success">
                            <strong><i class="fas fa-handshake"></i> Negotiation Completed</strong>
                            <p style="margin:0.6rem 0 0;">
                                Original Price: ₹{{ number_format($additionalService->total_price, 2) }} → New Price: ₹{{ number_format($additionalService->final_price, 2) }}
                                <br>
                                <span style="font-size:0.85rem;">{{ $additionalService->admin_negotiation_response }}</span>
                            </p>
                        </div>
                    @elseif($additionalService->negotiation_status === 'user_negotiated')
                        <div class="alert-card warning">
                            <strong><i class="fas fa-comments"></i> Customer Price Negotiation Pending</strong>
                            <p style="margin:0.6rem 0 0;">Requested Price: ₹{{ number_format($additionalService->user_negotiated_price, 2) }}</p>
                            <p style="margin:0.2rem 0 0; font-size:0.85rem;">{{ $additionalService->user_negotiation_reason }}</p>

                            <form id="negotiationResponseForm" class="form-card" style="margin-top:1rem;">
                                @csrf
                                <h4><i class="fas fa-reply"></i> Respond to Negotiation</h4>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="professional_final_price">Your Final Price (₹)</label>
                                        <input type="number" id="professional_final_price" name="professional_final_price" class="form-control" step="0.01" min="{{ $additionalService->base_price * 0.5 }}" value="{{ $additionalService->user_negotiated_price }}" required>
                                        <div class="price-error" style="display:none;"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="professional_response">Your Response</label>
                                        <textarea id="professional_response" name="professional_response" class="form-control" rows="4" maxlength="1000" placeholder="Explain your final decision..." required></textarea>
                                        <small class="form-text">Max 1000 characters</small>
                                    </div>
                                </div>
                                <button type="submit" class="action-btn success" style="align-self:flex-start;">
                                    <i class="fas fa-paper-plane"></i> Send Response
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($additionalService->admin_status === 'approved' && $additionalService->negotiation_status !== 'user_negotiated')
                        <form id="priceUpdateForm" class="form-card">
                            @csrf
                            <h4><i class="fas fa-edit"></i> Update Service Price</h4>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="new_price">New Price (₹)</label>
                                    <input type="number" id="new_price" name="new_price" class="form-control" step="0.01" min="{{ $additionalService->base_price * 0.5 }}" value="{{ $additionalService->final_price }}" required>
                                    <div class="price-error" style="display:none;"></div>
                                    <small class="form-text">Minimum price enforced automatically.</small>
                                </div>
                                <div class="form-group">
                                    <label for="price_reason">Reason for Update</label>
                                    <textarea id="price_reason" name="reason" class="form-control" rows="4" maxlength="1000" placeholder="Explain why you're updating the price..." required></textarea>
                                    <small class="form-text">Customers will be notified of your reasoning.</small>
                                </div>
                            </div>
                            <button type="submit" class="action-btn primary" style="align-self:flex-start;">
                                <i class="fas fa-save"></i> Update Price
                            </button>
                        </form>
                    @endif

                    @if($additionalService->admin_status === 'rejected' && $additionalService->admin_reason)
                        <div class="alert-card danger">
                            <strong><i class="fas fa-times-circle"></i> Rejection Reason</strong>
                            <p style="margin:0.6rem 0 0;">{{ $additionalService->admin_reason }}</p>
                        </div>
                    @endif
                </div>
            </article>

            <div class="show-sidebar" style="display:flex; flex-direction:column; gap:1.6rem;">
                <section class="info-aside-card">
                    <h3 style="margin:0; font-size:1.05rem; font-weight:700; color:#0f172a;"><i class="fas fa-user-circle"></i> Customer Information</h3>
                    <div class="info-grid" style="grid-template-columns:1fr;">
                        <div class="info-block">
                            <label>Customer Name</label>
                            <p>{{ $additionalService->user->name }}</p>
                        </div>
                        <div class="info-block">
                            <label>Email</label>
                            <p>{{ $additionalService->user->email }}</p>
                        </div>
                        <div class="info-block">
                            <label>Phone</label>
                            <p>{{ $additionalService->user->phone }}</p>
                        </div>
                    </div>
                </section>

                <section class="info-aside-card">
                    <h3 style="margin:0; font-size:1.05rem; font-weight:700; color:#0f172a;"><i class="fas fa-calculator"></i> Payment & Commission</h3>
                    <div class="info-grid" style="grid-template-columns:1fr;">
                        <div class="info-block">
                            <label>Payment Status</label>
                            <p>
                                @if($additionalService->payment_status === 'pending')
                                    <span class="status-pill pending">Pending</span>
                                @elseif($additionalService->payment_status === 'paid')
                                    <span class="status-pill paid">Paid</span>
                                @elseif($additionalService->payment_status === 'failed')
                                    <span class="status-pill rejected">Failed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @php
                        $professional = $additionalService->professional;
                        $finalPrice = $additionalService->final_price;
                        $serviceRequestMargin = $professional->service_request_margin ?? 0;
                        $serviceRequestOffset = $professional->service_request_offset ?? 0;
                        $platformCommission = ($finalPrice * $serviceRequestMargin) / 100;
                        $professionalEarning = $finalPrice - $platformCommission;
                    @endphp
                    <div class="commission-grid">
                        <div class="commission-card">
                            <span>Platform Margin</span>
                            <strong>{{ number_format($serviceRequestMargin, 2) }}%</strong>
                            <small style="color:var(--muted);">Applied on service price</small>
                        </div>
                        <div class="commission-card danger">
                            <span>Commission Amount</span>
                            <strong>₹{{ number_format($platformCommission, 2) }}</strong>
                            <small style="color:var(--muted);">Deducted by platform</small>
                        </div>
                        <div class="commission-card success">
                            <span>Your Earnings</span>
                            <strong>₹{{ number_format($professionalEarning, 2) }}</strong>
                            <small style="color:var(--muted);">After commission</small>
                        </div>
                    </div>
                    @if($additionalService->payment_status === 'paid')
                        <div class="alert-card success">
                            <strong><i class="fas fa-check-circle"></i> Payment Received</strong>
                            <p style="margin:0.6rem 0 0; font-size:0.88rem;">You will receive ₹{{ number_format($professionalEarning, 2) }} ({{ number_format(100 - $serviceRequestMargin, 2) }}% of ₹{{ number_format($finalPrice, 2) }})</p>
                        </div>
                    @endif
                    @if($additionalService->professional_payment_status === 'processed')
                        <div class="alert-card">
                            <strong><i class="fas fa-money-bill-wave"></i> Payment Released</strong>
                            <p style="margin:0.6rem 0 0; font-size:0.88rem;">Processed on {{ $additionalService->professional_payment_processed_at->format('M d, Y h:i A') }}</p>
                            @if($additionalService->payment_transaction_id)
                                <p style="margin:0; font-size:0.82rem;">Transaction ID: {{ $additionalService->payment_transaction_id }}</p>
                            @endif
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="custom-modal" id="startConsultationModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">🚀 Start Consultation</h5>
            <button type="button" class="modal-close" onclick="closeModal('startConsultationModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="startConsultationForm">
            <div class="modal-body">
                <div class="alert-card">
                    <strong><i class="fas fa-info-circle"></i> Heads up!</strong>
                    <p style="margin:0.6rem 0 0; font-size:0.88rem;">This will mark the consultation as "In Progress" and notify the customer.</p>
                </div>
                <div class="form-group">
                    <label for="consultation_notes">Consultation Notes (Optional)</label>
                    <textarea class="form-control" id="consultation_notes" name="consultation_notes" rows="4" placeholder="Add any initial notes or instructions..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="action-btn outline" onclick="closeModal('startConsultationModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="action-btn success">
                    <i class="fas fa-play"></i> Start Consultation
                </button>
            </div>
        </form>
    </div>
</div>

<div class="custom-modal" id="markCompletedModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">✅ Mark Consultation Completed</h5>
            <button type="button" class="modal-close" onclick="closeModal('markCompletedModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="markCompletedForm">
            <div class="modal-body">
                <div class="alert-card success">
                    <strong><i class="fas fa-check-circle"></i> Confirmation</strong>
                    <p style="margin:0.6rem 0 0; font-size:0.88rem;">This action notifies the customer to confirm the consultation completion.</p>
                </div>
                <div class="form-group">
                    <label for="completion_notes">Completion Summary *</label>
                    <textarea class="form-control" id="completion_notes" name="completion_notes" rows="4" placeholder="Provide a summary of the work completed..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="action-btn outline" onclick="closeModal('markCompletedModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="action-btn success">
                    <i class="fas fa-check-circle"></i> Mark Completed
                </button>
            </div>
        </form>
    </div>
</div>

<div class="custom-modal" id="updateDeliveryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">📅 Update Delivery Date</h5>
            <button type="button" class="modal-close" onclick="closeModal('updateDeliveryModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="updateDeliveryForm">
            <div class="modal-body">
                @if($additionalService->delivery_date)
                    <div class="alert-card">
                        <strong>Current Delivery Date:</strong>
                        <p style="margin:0.6rem 0 0;">{{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}</p>
                    </div>
                @endif
                <div class="form-group">
                    <label for="new_delivery_date">New Delivery Date *</label>
                    <input type="date" class="form-control" id="new_delivery_date" name="delivery_date" min="{{ date('Y-m-d') }}" value="{{ $additionalService->delivery_date }}" required>
                </div>
                <div class="form-group">
                    <label for="delivery_notes">Reason for Date Change *</label>
                    <textarea class="form-control" id="delivery_notes" name="delivery_notes" rows="3" placeholder="Explain why the delivery date is being changed..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="action-btn outline" onclick="closeModal('updateDeliveryModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="action-btn warning">
                    <i class="fas fa-calendar"></i> Update Date
                </button>
            </div>
        </form>
    </div>
</div>

<div class="custom-modal" id="setDeliveryDateModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">📅 Set Delivery Date</h5>
            <button type="button" class="modal-close" onclick="closeModal('setDeliveryDateModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="setDeliveryDateForm">
            <div class="modal-body">
                <div class="alert-card">
                    <strong><i class="fas fa-info-circle"></i> Note</strong>
                    <p style="margin:0.6rem 0 0; font-size:0.88rem;">Customers and admin will be notified once you set a delivery date.</p>
                </div>
                <div class="form-group">
                    <label for="delivery_date">Delivery Date *</label>
                    <input type="date" class="form-control" id="delivery_date" name="delivery_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
                <div class="form-group">
                    <label for="delivery_reason">Reason/Notes *</label>
                    <textarea class="form-control" id="delivery_reason" name="delivery_reason" rows="3" placeholder="Explain the delivery plan..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="action-btn outline" onclick="closeModal('setDeliveryDateModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="action-btn info">
                    <i class="fas fa-calendar-plus"></i> Set Date
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const currentServiceId = {{ $additionalService->id }};

    function openModal(modalId) {
        const $modal = $('#' + modalId);
        $modal.addClass('show');
        $('body').css('overflow', 'hidden');
        setTimeout(() => {
            const $firstInput = $modal.find('input:not([type="hidden"]), textarea').first();
            if ($firstInput.length) $firstInput.focus();
        }, 120);
    }

    function closeModal(modalId) {
        $('#' + modalId).removeClass('show');
        $('body').css('overflow', 'auto');
    }

    window.closeModal = closeModal;

    $('.custom-modal').on('click', function(e) {
        if ($(e.target).hasClass('custom-modal')) {
            closeModal(this.id);
        }
    });

    function showButtonLoading($btn, loadingText) {
        const originalText = $btn.html();
        $btn.data('original-text', originalText);
        $btn.prop('disabled', true).html(`<i class="fas fa-spinner fa-spin"></i> ${loadingText}`);
        return originalText;
    }

    function hideButtonLoading($btn) {
        const originalText = $btn.data('original-text');
        $btn.prop('disabled', false).html(originalText);
    }

    $(document).on('click', '.start-consultation', function(e) {
        e.preventDefault();
        openModal('startConsultationModal');
    });

    $('#startConsultationForm').submit(function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Starting...');

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/start-consultation`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                consultation_notes: $('#consultation_notes').val()
            },
            success: function(response) {
                if (response.success) {
                    closeModal('startConsultationModal');
                    toastr?.success(response.message || 'Consultation started successfully!');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    toastr?.error(response.message || 'Failed to start consultation');
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                toastr?.error(message);
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    $(document).on('click', '.mark-completed', function(e) {
        e.preventDefault();
        openModal('markCompletedModal');
    });

    $('#markCompletedForm').submit(function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Completing...');

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/mark-completed`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                completion_notes: $('#completion_notes').val()
            },
            success: function(response) {
                if (response.success) {
                    closeModal('markCompletedModal');
                    toastr?.success(response.message || 'Consultation marked as completed!');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    toastr?.error(response.message || 'Failed to mark consultation as completed');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        toastr?.error(message);
                    });
                } else {
                    toastr?.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    $(document).on('click', '.set-delivery-date', function(e) {
        e.preventDefault();
        openModal('setDeliveryDateModal');
    });

    $('#setDeliveryDateForm').submit(function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Setting...');

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/set-delivery-date`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                delivery_date: $('#delivery_date').val(),
                delivery_reason: $('#delivery_reason').val()
            },
            success: function(response) {
                if (response.success) {
                    closeModal('setDeliveryDateModal');
                    toastr?.success(response.message || 'Delivery date set successfully!');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    toastr?.error(response.message || 'Failed to set delivery date');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        toastr?.error(message);
                    });
                } else {
                    toastr?.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    $(document).on('click', '.update-delivery', function(e) {
        e.preventDefault();
        openModal('updateDeliveryModal');
    });

    $('#updateDeliveryForm').submit(function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Updating...');

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/update-delivery-date`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                delivery_date: $('#new_delivery_date').val(),
                delivery_notes: $('#delivery_notes').val()
            },
            success: function(response) {
                if (response.success) {
                    closeModal('updateDeliveryModal');
                    toastr?.success(response.message || 'Delivery date updated successfully!');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    toastr?.error(response.message || 'Failed to update delivery date');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        toastr?.error(message);
                    });
                } else {
                    toastr?.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    $(document).on('click', '.complete-consultation', function(e) {
        e.preventDefault();
        const $btn = $(this);
        if (confirm('Confirm marking this consultation as completed? The customer will be notified.')) {
            showButtonLoading($btn, 'Completing...');
            $.ajax({
                url: `/professional/additional-services/${currentServiceId}/complete-consultation`,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        toastr?.success(response.message || 'Consultation completed successfully!');
                        setTimeout(() => location.reload(), 1200);
                    } else {
                        toastr?.error(response.message || 'Failed to complete consultation');
                    }
                },
                error: function(xhr) {
                    toastr?.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                },
                complete: function() {
                    hideButtonLoading($btn);
                }
            });
        }
    });

    function validatePrice(priceInput, minPrice) {
        const price = parseFloat(priceInput.val());
        const minimum = parseFloat(minPrice);
        const errorDiv = priceInput.siblings('.price-error');
        if (price < minimum) {
            errorDiv.text('Price cannot be below the allowed minimum').show();
            priceInput.addClass('is-invalid');
            return false;
        }
        errorDiv.hide();
        priceInput.removeClass('is-invalid');
        return true;
    }

    $('#professional_final_price, #new_price').on('input change', function() {
        const minPrice = $(this).attr('min');
        validatePrice($(this), minPrice);
    });

    $('#negotiationResponseForm').submit(function(e) {
        e.preventDefault();
        const priceInput = $('#professional_final_price');
        const minPrice = priceInput.attr('min');
        if (!validatePrice(priceInput, minPrice)) { return false; }
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Sending...');

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/respond-negotiation`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                professional_final_price: priceInput.val(),
                professional_response: $('#professional_response').val(),
                min_price: minPrice
            },
            success: function(response) {
                if (response.success) {
                    toastr?.success(response.message || 'Negotiation response sent!');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    toastr?.error(response.message || 'Failed to send negotiation response');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        toastr?.error(message);
                    });
                } else {
                    toastr?.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    $('#priceUpdateForm').submit(function(e) {
        e.preventDefault();
        const priceInput = $('#new_price');
        const minPrice = priceInput.attr('min');
        if (!validatePrice(priceInput, minPrice)) { return false; }
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Updating...');

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/update-price`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                new_price: priceInput.val(),
                reason: $('#price_reason').val(),
                min_price: minPrice
            },
            success: function(response) {
                if (response.success) {
                    toastr?.success(response.message || 'Service price updated successfully!');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    toastr?.error(response.message || 'Failed to update service price');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        toastr?.error(message);
                    });
                } else {
                    toastr?.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });
});
</script>
@endsection