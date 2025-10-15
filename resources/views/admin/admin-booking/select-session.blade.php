@extends('admin.layouts.layout')

@section('styles')
<style>
    .session-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fafbfc;
        position: relative;
        height: 100%;
    }

    .session-card:hover {
        border-color: #667eea;
        background: #f0f2ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
    }

    .session-card.selected {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.25);
    }

    .session-card .selection-indicator {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #ddd;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .session-card.selected .selection-indicator {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    .session-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .session-duration {
        color: #667eea;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .session-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #27ae60;
        margin-bottom: 0.25rem;
    }

    .session-period {
        color: #7f8c8d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .session-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .session-features li {
        padding: 0.25rem 0;
        color: #34495e;
        display: flex;
        align-items: center;
    }

    .session-features li i {
        color: #27ae60;
        margin-right: 0.5rem;
        width: 16px;
    }

    .popular-badge {
        position: absolute;
        top: -10px;
        left: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .progress-steps {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Select Session</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.admin-booking.index') }}">Admin Bookings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Select Session</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="card custom-card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">1</span>
                        <span class="text-success fw-semibold">Customer Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">2</span>
                        <span class="text-success fw-semibold">Service Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">3</span>
                        <span class="text-success fw-semibold">Professional Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-pill me-2">4</span>
                        <span class="text-primary fw-semibold">Select Session</span>
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

        <!-- Selected Professional Info -->
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="card-title">
                    <i class="ri-user-star-line me-2"></i>Selected Professional
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <span class="avatar avatar-lg avatar-rounded me-3">
                        <img src="{{ asset('admin/assets/images/faces/1.jpg') }}" alt="">
                    </span>
                    <div>
                        <h6 class="mb-1">{{ $professional->name ?? 'Professional' }}</h6>
                        <p class="mb-0 text-muted">{{ $professional->email ?? '' }}</p>
                        @if($professional->specialization)
                            <p class="mb-0 text-muted">{{ $professional->specialization }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Selection -->
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="ri-calendar-line me-2"></i>Step 4: Choose Session Package
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

                <form method="POST" action="{{ route('admin.admin-booking.store-session-selection') }}" id="session_form">
                    @csrf
                    
                    @if($sessions->isEmpty())
                        <!-- Default session options when no predefined sessions exist -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="session-card" data-session-id="onetime">
                                    <input type="radio" name="session_id" value="onetime" class="d-none session-radio">
                                    <div class="selection-indicator">
                                        <i class="ri-check-line"></i>
                                    </div>
                                    
                                    <div class="session-title">One Time</div>
                                    <div class="session-duration">1 session • 60 min per session</div>
                                    <div class="session-price">Rs. 1,500.00</div>
                                    <div class="session-period">one time payment</div>
                                    
                                    <ul class="session-features">
                                        <li><i class="ri-check-line"></i> Single consultation</li>
                                        <li><i class="ri-check-line"></i> 60 minutes duration</li>
                                        <li><i class="ri-check-line"></i> Instant booking</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="session-card" data-session-id="monthly">
                                    <input type="radio" name="session_id" value="monthly" class="d-none session-radio">
                                    <div class="selection-indicator">
                                        <i class="ri-check-line"></i>
                                    </div>
                                    
                                    <div class="session-title">Monthly</div>
                                    <div class="session-duration">4 sessions • 60 min per session</div>
                                    <div class="session-price">Rs. 5,000.00</div>
                                    <div class="session-period">per month</div>
                                    
                                    <ul class="session-features">
                                        <li><i class="ri-check-line"></i> 4 sessions included</li>
                                        <li><i class="ri-check-line"></i> 60 minutes each</li>
                                        <li><i class="ri-check-line"></i> Flexible scheduling</li>
                                        <li><i class="ri-check-line"></i> Progress tracking</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="session-card" data-session-id="quarterly">
                                    <div class="popular-badge">Most Popular</div>
                                    <input type="radio" name="session_id" value="quarterly" class="d-none session-radio">
                                    <div class="selection-indicator">
                                        <i class="ri-check-line"></i>
                                    </div>
                                    
                                    <div class="session-title">Quarterly</div>
                                    <div class="session-duration">12 sessions • 60 min per session</div>
                                    <div class="session-price">Rs. 12,000.00</div>
                                    <div class="session-period">per 3 months</div>
                                    
                                    <ul class="session-features">
                                        <li><i class="ri-check-line"></i> 12 sessions included</li>
                                        <li><i class="ri-check-line"></i> 60 minutes each</li>
                                        <li><i class="ri-check-line"></i> Priority scheduling</li>
                                        <li><i class="ri-check-line"></i> Progress reports</li>
                                        <li><i class="ri-check-line"></i> 20% savings</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="session-card" data-session-id="consultation">
                                    <input type="radio" name="session_id" value="consultation" class="d-none session-radio">
                                    <div class="selection-indicator">
                                        <i class="ri-check-line"></i>
                                    </div>
                                    
                                    <div class="session-title">Quarterly Consultation</div>
                                    <div class="session-duration">3 sessions • 90 min per session</div>
                                    <div class="session-price">Rs. 8,000.00</div>
                                    <div class="session-period">per 3 months</div>
                                    
                                    <ul class="session-features">
                                        <li><i class="ri-check-line"></i> 3 deep consultations</li>
                                        <li><i class="ri-check-line"></i> 90 minutes each</li>
                                        <li><i class="ri-check-line"></i> Comprehensive analysis</li>
                                        <li><i class="ri-check-line"></i> Detailed reports</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="session-card" data-session-id="package5">
                                    <input type="radio" name="session_id" value="package5" class="d-none session-radio">
                                    <div class="selection-indicator">
                                        <i class="ri-check-line"></i>
                                    </div>
                                    
                                    <div class="session-title">5 Sessions Package</div>
                                    <div class="session-duration">5 sessions • 60 min per session</div>
                                    <div class="session-price">Rs. 6,500.00</div>
                                    <div class="session-period">flexible schedule</div>
                                    
                                    <ul class="session-features">
                                        <li><i class="ri-check-line"></i> 5 sessions included</li>
                                        <li><i class="ri-check-line"></i> 60 minutes each</li>
                                        <li><i class="ri-check-line"></i> Valid for 6 months</li>
                                        <li><i class="ri-check-line"></i> No scheduling pressure</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Dynamic sessions from database -->
                        <div class="row">
                            @foreach($sessions as $session)
                                <div class="col-md-4 mb-4">
                                    <div class="session-card" data-session-id="{{ $session->id }}">
                                        <input type="radio" name="session_id" value="{{ $session->id }}" class="d-none session-radio">
                                        <div class="selection-indicator">
                                            <i class="ri-check-line"></i>
                                        </div>

                                        <div class="session-title">{{ $session->session_type ?? ($session->service_name ?? 'Session') }}</div>
                                        <div class="session-duration">{{ ($session->num_sessions ?? 1) }} session{{ ($session->num_sessions ?? 1) > 1 ? 's' : '' }} • {{ $session->duration ?? 'Duration not specified' }}</div>
                                        <div class="session-price">Rs. {{ number_format($session->final_rate ?? ($session->rate_per_session ?? 0), 2) }}</div>
                                        <div class="session-period">{{ $session->session_type ? strtolower($session->session_type) : 'one time' }}</div>

                                        @php
                                            $features = [];
                                            if (!empty($session->features)) {
                                                if (is_array($session->features)) {
                                                    $features = $session->features;
                                                } elseif (is_string($session->features)) {
                                                    $decoded = json_decode($session->features, true);
                                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                        $features = $decoded;
                                                    } else {
                                                        $features = preg_split('/\r?\n|,/', $session->features);
                                                        $features = array_map('trim', $features);
                                                        $features = array_filter($features);
                                                    }
                                                } elseif (is_object($session->features)) {
                                                    $features = (array) $session->features;
                                                }
                                            }
                                        @endphp

                                        @if(!empty($features))
                                            <ul class="session-features">
                                                @foreach($features as $feature)
                                                    <li><i class="ri-check-line"></i> {{ $feature }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="next_btn" disabled>
                                <i class="ri-arrow-right-line me-1"></i>Next: Select Date & Time
                            </button>
                            <a href="{{ route('admin.admin-booking.select-professional') }}" class="btn btn-secondary ms-2">
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
    const sessionCards = document.querySelectorAll('.session-card');
    const nextBtn = document.getElementById('next_btn');
    const sessionForm = document.getElementById('session_form');

    // Session card selection
    sessionCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            sessionCards.forEach(c => c.classList.remove('selected'));
            
            // Add selected class to clicked card
            this.classList.add('selected');
            
            // Check the radio button
            const radio = this.querySelector('.session-radio');
            if (radio) {
                radio.checked = true;
                nextBtn.disabled = false;
            }
        });
    });

    // Form validation
    sessionForm.addEventListener('submit', function(e) {
        const selectedSession = document.querySelector('input[name="session_id"]:checked');
        if (!selectedSession) {
            e.preventDefault();
            alert('Please select a session package before proceeding.');
        }
    });
});
</script>
@endsection