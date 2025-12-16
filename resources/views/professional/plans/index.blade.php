@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
        --text-dark: #0f172a;
        --text-muted: #64748b;
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .plans-page {
        width: 100%;
        padding: 2.6rem 1.35rem 3.5rem;
    }

    .plans-shell {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .plans-header {
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

    .plans-header::before {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--text-muted);
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
        color: var(--primary);
        background: rgba(79, 70, 229, 0.1);
        width: fit-content;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .hero-desc {
        font-size: 0.95rem;
        color: var(--text-muted);
        margin: 0;
    }

    .current-plan-banner {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.95), rgba(99, 102, 241, 0.95));
        border: 2px solid rgba(79, 70, 229, 0.3);
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(79, 70, 229, 0.25);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .current-plan-banner::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .current-plan-banner::after {
        content: "";
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .current-plan-banner:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 48px rgba(79, 70, 229, 0.35);
    }

    .current-plan-banner .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .plan-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .plan-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(79, 70, 229, 0.12);
        border-color: var(--primary);
    }

    .plan-card.featured {
        border: 2px solid #fbbf24;
        box-shadow: 0 8px 20px rgba(251, 191, 36, 0.15);
    }

    .plan-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .plan-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }

    .plan-price {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }

    .plan-validity {
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-bottom: 1.25rem;
    }

    .plan-features {
        flex: 1;
        margin-bottom: 1.25rem;
    }

    .plan-features ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .plan-features li {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.4rem 0;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .plan-features li i {
        color: var(--accent);
        font-size: 0.9rem;
        margin-top: 0.15rem;
        flex-shrink: 0;
    }

    .plan-features li.not-included i {
        color: #94a3b8;
    }

    .plan-features li.not-included span {
        text-decoration: line-through;
        color: var(--text-muted);
    }

    .btn-plan {
        width: 100%;
        padding: 0.75rem;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-plan:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
        color: white;
    }

    @media (max-width: 768px) {
        .plans-page {
            padding: 1.5rem 1rem;
        }

        .plans-header {
            padding: 1.5rem;
        }

        .hero-title {
            font-size: 1.5rem;
        }

        .plan-price {
            font-size: 1.5rem;
        }

        .plan-name {
            font-size: 1.3rem;
        }

        .plan-features li {
            font-size: 0.8rem;
        }

        .current-plan-banner .row {
            padding: 1.5rem !important;
        }

        .current-plan-banner .col-md-4 {
            margin-top: 1rem;
            text-align: center !important;
        }

        .current-plan-banner h4 {
            font-size: 1.2rem !important;
        }

        .current-plan-banner .btn {
            width: 100%;
            padding: 0.6rem 1.5rem !important;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper plans-page">
    <div class="plans-shell">
        <!-- Page Header -->
        <div class="plans-header">
            <div class="hero-meta">
                <span class="hero-eyebrow">
                    <i class="fas fa-crown"></i>
                    Subscription Plans
                </span>
                <h1 class="hero-title">Choose Your Perfect Plan</h1>
                <p class="hero-desc">Unlock premium features and get more leads to grow your business</p>
            </div>
        </div>

        <!-- Current Plan Banner -->
        @if($currentPlan)
        <div class="current-plan-banner">
            <div class="row align-items-center" style="padding: 2rem;">
                <div class="col-md-8">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-crown" style="font-size: 1.5rem; color: #fbbf24;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Your Current Plan</p>
                            <h4 class="mb-0" style="color: white; font-weight: 700; font-size: 1.5rem;">{{ $currentPlan->plan_name }}</h4>
                        </div>
                    </div>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1rem;">
                        <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 10px; padding: 0.6rem 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-users" style="color: #22c55e; font-size: 1.1rem;"></i>
                            <span style="color: white; font-weight: 600; font-size: 0.95rem;">
                                {{ $currentPlan->remaining_leads }}/{{ $currentPlan->lead_limit }} Leads Remaining
                            </span>
                        </div>
                        @if($currentPlan->end_date)
                        <div style="background: rgba(251, 191, 36, 0.25); backdrop-filter: blur(10px); border-radius: 10px; padding: 0.6rem 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-calendar-alt" style="color: #fbbf24; font-size: 1.1rem;"></i>
                            <span style="color: white; font-weight: 600; font-size: 0.95rem;">
                                Expires: {{ $currentPlan->end_date->format('d M, Y') }}
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <p class="mb-0" style="color: rgba(255, 255, 255, 0.9); font-size: 0.95rem; line-height: 1.5;">
                        <i class="fas fa-rocket" style="color: #fbbf24;"></i>
                        <strong>Ready to upgrade?</strong> Choose a higher plan below to unlock more features!
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('professional.plans.my-plan') }}" 
                       class="btn" 
                       style="background: white; color: #4f46e5; border-radius: 12px; padding: 0.75rem 2rem; font-weight: 600; font-size: 1rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); transition: all 0.3s ease; display: inline-block; text-decoration: none;">
                        <i class="fas fa-eye"></i> View My Plan
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="current-plan-banner" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(220, 38, 38, 0.9));">
            <div class="row align-items-center" style="padding: 2rem;">
                <div class="col-md-8">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; color: #fbbf24;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0" style="color: white; font-weight: 700; font-size: 1.5rem;">No Active Plan</h4>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem;">Purchase a plan to start receiving leads</p>
                        </div>
                    </div>
                    
                    <p class="mb-0" style="color: rgba(255, 255, 255, 0.95); font-size: 0.95rem; line-height: 1.5;">
                        <i class="fas fa-info-circle" style="color: #fbbf24;"></i>
                        <strong>Get Started!</strong> Choose a plan below to unlock premium features and grow your business.
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="btn" 
                          style="background: white; color: #dc2626; border-radius: 12px; padding: 0.75rem 2rem; font-weight: 600; font-size: 1rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); display: inline-block; cursor: default;">
                        <i class="fas fa-shopping-cart"></i> Choose Plan Below
                    </span>
                </div>
            </div>
        </div>
        @endif

        <!-- Plans Grid -->
        <div class="row g-4">
            @forelse($plans as $plan)
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="plan-card {{ $plan->name === 'Gold' ? 'featured' : '' }}">
                        @if($plan->name === 'Gold')
                            <div class="plan-badge">
                                ⭐ MOST POPULAR
                            </div>
                        @endif
                        
                        <h3 class="plan-name">{{ $plan->name }}</h3>
                        <div class="plan-price">{{ $plan->formatted_price }}</div>
                        @if($plan->validity_days)
                            <div class="plan-validity">Valid for {{ $plan->validity_days }} days</div>
                        @else
                            <div class="plan-validity">No expiry</div>
                        @endif

                        <div class="plan-features">
                            <ul>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <strong>{{ $plan->lead_limit }} Leads per month</strong>
                                </li>
                                @if($plan->features && is_array($plan->features))
                                    @foreach($plan->features as $feature)
                                        <li>
                                            <i class="fas fa-check-circle"></i>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                @endif
                                
                                @php
                                    // Define features not included based on plan
                                    $notIncluded = [];
                                    if($plan->name === 'Bronze' || $plan->name === 'Silver') {
                                        $notIncluded = [
                                            'Get featured on our social media platform',
                                            'One free webinar marketing',
                                            'Promoted leads',
                                            'Be a part of our B2B workshops and earn more'
                                        ];
                                    } elseif($plan->name === 'Gold') {
                                        $notIncluded = ['Promoted leads'];
                                    }
                                @endphp
                                
                                @foreach($notIncluded as $feature)
                                    <li class="not-included">
                                        <i class="fas fa-times-circle"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <a href="{{ route('professional.plans.purchase', $plan->id) }}" class="btn-plan">
                            @if($currentPlan)
                                <i class="fas fa-arrow-up"></i> Upgrade to {{ $plan->name }}
                            @else
                                <i class="fas fa-shopping-cart"></i> Buy Now
                            @endif
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center" style="border-radius: 16px;">
                        @if($currentPlan)
                            <i class="fas fa-crown"></i> You're already on the highest available plan! Enjoy all premium features.
                        @else
                            <i class="fas fa-info-circle"></i> No plans available at the moment. Please check back later.
                        @endif
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
