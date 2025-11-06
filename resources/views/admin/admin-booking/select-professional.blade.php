@extends('admin.layouts.layout')

@section('styles')
<style>
    .prof-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fafbfc;
        position: relative;
    }

    .prof-card:hover {
        border-color: #667eea;
        background: #f0f2ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
    }

    .prof-card.selected {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.25);
    }

    .prof-card .selection-indicator {
        position: absolute;
        top: 10px;
        right: 10px;
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

    .prof-card.selected .selection-indicator {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    .filter-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .filter-input {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem;
        transition: border-color 0.3s ease;
    }

    .filter-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .rating-stars {
        color: #ffc107;
    }

    .prof-info {
        flex: 1;
    }

    .prof-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }

    .prof-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
    }

    .no-results {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .session-types {
        max-height: 40px;
        overflow: hidden;
    }

    .session-badge {
        font-size: 0.65rem;
        padding: 0.15rem 0.4rem;
        border-radius: 3px;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
        border: 1px solid #e9ecef;
        background: #f8f9fa;
        color: #495057;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Select Professional</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.admin-booking.index') }}">Admin Bookings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Select Professional</li>
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
                        <span class="badge bg-primary rounded-pill me-2">3</span>
                        <span class="text-primary fw-semibold">Select Professional</span>
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

        <!-- Professional Selection -->
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="ri-user-star-line me-2"></i>Step 3: Choose Professional
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

                @if($professionals->isEmpty())
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        No professionals found for the selected service. You can go back and choose another service.
                    </div>
                @else
                    <!-- Filter Section -->
                    <div class="filter-section">
                        <h6 class="mb-3">
                            <i class="ri-filter-line me-2"></i>Filter Professionals
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Search by Name</label>
                                <input type="text" id="name_filter" class="form-control filter-input" placeholder="Enter professional name...">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Location</label>
                                <select id="location_filter" class="form-select filter-input">
                                    <option value="">All Locations</option>
                                    <option value="online">Online</option>
                                    <option value="mumbai">Mumbai</option>
                                    <option value="delhi">Delhi</option>
                                    <option value="bangalore">Bangalore</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Minimum Rating</label>
                                <select id="rating_filter" class="form-select filter-input">
                                    <option value="">Any Rating</option>
                                    <option value="5">5 Stars</option>
                                    <option value="4">4+ Stars</option>
                                    <option value="3">3+ Stars</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price Range</label>
                                <select id="price_filter" class="form-select filter-input">
                                    <option value="">Any Price</option>
                                    <option value="0-500">₹0 - ₹500</option>
                                    <option value="500-1000">₹500 - ₹1000</option>
                                    <option value="1000-2000">₹1000 - ₹2000</option>
                                    <option value="2000-5000">₹2000 - ₹5000</option>
                                    <option value="5000+">₹5000+</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Session Package</label>
                                <select id="session_package_filter" class="form-select filter-input">
                                    <option value="">All Session Packages</option>
                                    <option value="one time">One Time</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="free hand">Free Hand</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Available Weekday</label>
                                <select id="weekday_filter" class="form-select filter-input">
                                    <option value="">Any Day</option>
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                    <option value="sunday">Sunday</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3 d-flex align-items-end">
                                <button type="button" id="clear_filters" class="btn btn-outline-secondary">
                                    <i class="ri-refresh-line me-1"></i>Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.admin-booking.store-professional-selection') }}" id="professional_form">
                        @csrf
                        <div class="row" id="professionals_container">
                            @foreach($professionals as $prof)
                                @php
                                    // Get proper rate from rates table based on selected service
                                    $serviceId = session('admin_booking_service_id');
                                    $subServiceId = session('admin_booking_sub_service_id');
                                    
                                    // First try to get rates for exact service/sub-service match
                                    $professionalRates = \App\Models\Rate::where('professional_id', $prof->id)
                                        ->where('service_id', $serviceId);
                                    
                                    if ($subServiceId) {
                                        $professionalRates->where('sub_service_id', $subServiceId);
                                    } else {
                                        $professionalRates->whereNull('sub_service_id');
                                    }
                                    
                                    $rates = $professionalRates->get();
                                    
                                    // If no exact match found, try to get rates for the main service only
                                    if ($rates->isEmpty()) {
                                        $rates = \App\Models\Rate::where('professional_id', $prof->id)
                                            ->where('service_id', $serviceId)
                                            ->get();
                                    }
                                    
                                    // If still no rates found, get ANY rates for this professional to show something
                                    if ($rates->isEmpty()) {
                                        $rates = \App\Models\Rate::where('professional_id', $prof->id)->get();
                                    }
                                    
                                    // Get the minimum rate for display
                                    $minRate = $rates->min('final_rate') ?? 1000;
                                    
                                    // Collect session packages
                                    $sessionPackages = [];
                                    if($rates->count() > 0) {
                                        foreach($rates as $rate) {
                                            $sessionPackages[] = strtolower($rate->session_type);
                                        }
                                    }
                                    $sessionPackagesStr = implode(',', array_unique($sessionPackages));
                                    
                                    // Get proper location from profile or professional table
                                    $location = '';
                                    if($prof->profile && $prof->profile->city) {
                                        $location = $prof->profile->city;
                                    } elseif($prof->city) {
                                        $location = $prof->city;
                                    } elseif($prof->location) {
                                        $location = $prof->location;
                                    } else {
                                        $location = 'online';
                                    }
                                    
                                    // Get proper rating from ratings/reviews table
                                    $rating = 4; // default
                                    if($prof->reviews && $prof->reviews->count() > 0) {
                                        $rating = round($prof->reviews->avg('rating'), 1);
                                    } elseif($prof->rating) {
                                        $rating = $prof->rating;
                                    } elseif($prof->average_rating) {
                                        $rating = $prof->average_rating;
                                    }
                                    
                                    // Collect available weekdays
                                    $availableWeekdays = $prof->available_days ?? 'monday,tuesday,wednesday,thursday,friday,saturday,sunday';
                                @endphp
                                <div class="col-md-6 mb-4 professional-item" 
                                     data-name="{{ strtolower($prof->name ?? ($prof->first_name . ' ' . $prof->last_name)) }}"
                                     data-location="{{ strtolower($location) }}"
                                     data-rating="{{ $rating }}"
                                     data-price="{{ $minRate }}"
                                     data-session-packages="{{ $sessionPackagesStr }}"
                                     data-weekdays="{{ strtolower($availableWeekdays) }}">
                                    <div class="prof-card" data-professional-id="{{ $prof->id }}">
                                        <input type="radio" name="professional_id" value="{{ $prof->id }}" class="d-none professional-radio">
                                        <div class="selection-indicator">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        
                                        <div class="d-flex">
                                            @php
                                                $profilePhoto = null;
                                                if($prof->profile && $prof->profile->photo) {
                                                    $profilePhoto = asset('storage/' . $prof->profile->photo);
                                                } else {
                                                    $profilePhoto = asset('admin/assets/images/faces/1.jpg');
                                                }
                                            @endphp
                                            <img src="{{ $profilePhoto }}" 
                                                 alt="{{ $prof->name ?? 'Professional' }}" 
                                                 class="prof-avatar"
                                                 onerror="this.src='{{ asset('admin/assets/images/faces/1.jpg') }}'">
                                            <div class="prof-info">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 fw-semibold">{{ $prof->name ?? ($prof->first_name . ' ' . $prof->last_name ?? 'Professional') }}</h6>
                                    <div class="text-end">
                                        <div class="fw-bold text-primary">₹{{ number_format($minRate) }}</div>
                                        <small class="text-muted">starting from</small>
                                    </div>
                                </div>
                                
                                <p class="text-muted mb-2">{{ $prof->email ?? '' }}</p>
                                
                                @if($prof->specialization)
                                    <p class="mb-2"><small class="text-muted">{{ $prof->specialization }}</small></p>
                                @endif

                                <!-- Session Types -->
                                @if($rates->count() > 0)
                                    <div class="mb-2">
                                        <small class="text-muted fw-semibold">Available Sessions:</small>
                                        <div class="session-types mt-1">
                                            @foreach($rates as $rate)
                                                <span class="session-badge">{{ $rate->session_type }} - ₹{{ number_format($rate->final_rate) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-2">
                                        <small class="text-warning">No rates configured</small>
                                    </div>
                                @endif                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="rating-stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $rating)
                                                                <i class="ri-star-fill"></i>
                                                            @else
                                                                <i class="ri-star-line"></i>
                                                            @endif
                                                        @endfor
                                                        <span class="ms-1 text-muted small">({{ number_format($rating, 1) }})</span>
                                                    </div>
                                                    <div class="text-muted small">
                                                        <i class="ri-map-pin-line me-1"></i>{{ ucfirst($location) }}
                                                    </div>
                                                </div>
                                                
                                                @if($prof->experience_years)
                                                    <div class="mt-2">
                                                        <span class="badge bg-primary-transparent">{{ $prof->experience_years }} years exp.</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="no-results d-none">
                            <i class="ri-search-line fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No professionals found</h5>
                            <p class="text-muted">Try adjusting your filters to see more results.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="next_btn" disabled>
                                    <i class="ri-arrow-right-line me-1"></i>Next: Select Session
                                </button>
                                <a href="{{ route('admin.admin-booking.select-service') }}" class="btn btn-secondary ms-2">
                                    <i class="ri-arrow-left-line me-1"></i>Back
                                </a>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profCards = document.querySelectorAll('.prof-card');
    const nextBtn = document.getElementById('next_btn');
    const professionalForm = document.getElementById('professional_form');
    
    // Filter elements
    const nameFilter = document.getElementById('name_filter');
    const locationFilter = document.getElementById('location_filter');
    const ratingFilter = document.getElementById('rating_filter');
    const priceFilter = document.getElementById('price_filter');
    const sessionPackageFilter = document.getElementById('session_package_filter');
    const weekdayFilter = document.getElementById('weekday_filter');
    const clearFiltersBtn = document.getElementById('clear_filters');
    const professionalsContainer = document.getElementById('professionals_container');
    const noResults = document.querySelector('.no-results');

    // Professional card selection
    profCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            profCards.forEach(c => c.classList.remove('selected'));
            
            // Add selected class to clicked card
            this.classList.add('selected');
            
            // Check the radio button
            const radio = this.querySelector('.professional-radio');
            if (radio) {
                radio.checked = true;
                nextBtn.disabled = false;
            }
        });
    });

    // Form validation
    professionalForm.addEventListener('submit', function(e) {
        const selectedProfessional = document.querySelector('input[name="professional_id"]:checked');
        if (!selectedProfessional) {
            e.preventDefault();
            alert('Please select a professional before proceeding.');
        }
    });

    // Filter functionality
    function applyFilters() {
        const nameValue = nameFilter.value.toLowerCase().trim();
        const locationValue = locationFilter.value.toLowerCase();
        const ratingValue = parseFloat(ratingFilter.value) || 0;
        const priceValue = priceFilter.value;
        const sessionPackageValue = sessionPackageFilter.value.toLowerCase();
        const weekdayValue = weekdayFilter.value.toLowerCase();
        
        let visibleCount = 0;
        
        document.querySelectorAll('.professional-item').forEach(item => {
            let show = true;
            
            // Name filter
            if (nameValue && !item.dataset.name.includes(nameValue)) {
                show = false;
            }
            
            // Location filter
            if (locationValue && item.dataset.location !== locationValue) {
                show = false;
            }
            
            // Rating filter
            if (ratingValue > 0 && parseFloat(item.dataset.rating) < ratingValue) {
                show = false;
            }
            
            // Price filter
            if (priceValue) {
                const itemPrice = parseFloat(item.dataset.price) || 0;
                let priceMatch = false;
                
                if (priceValue === '0-500' && itemPrice <= 500) {
                    priceMatch = true;
                } else if (priceValue === '500-1000' && itemPrice > 500 && itemPrice <= 1000) {
                    priceMatch = true;
                } else if (priceValue === '1000-2000' && itemPrice > 1000 && itemPrice <= 2000) {
                    priceMatch = true;
                } else if (priceValue === '2000-5000' && itemPrice > 2000 && itemPrice <= 5000) {
                    priceMatch = true;
                } else if (priceValue === '5000+' && itemPrice > 5000) {
                    priceMatch = true;
                }
                
                if (!priceMatch) {
                    show = false;
                }
            }
            
            // Session Package filter
            if (sessionPackageValue) {
                const itemSessionPackages = item.dataset.sessionPackages || '';
                if (!itemSessionPackages.includes(sessionPackageValue)) {
                    show = false;
                }
            }
            
            // Weekday filter
            if (weekdayValue) {
                const itemWeekdays = item.dataset.weekdays || '';
                if (!itemWeekdays.includes(weekdayValue)) {
                    show = false;
                }
            }
            
            if (show) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0) {
            professionalsContainer.style.display = 'none';
            noResults.classList.remove('d-none');
        } else {
            professionalsContainer.style.display = 'flex';
            noResults.classList.add('d-none');
        }
    }

    // Filter event listeners
    nameFilter.addEventListener('input', applyFilters);
    locationFilter.addEventListener('change', applyFilters);
    ratingFilter.addEventListener('change', applyFilters);
    priceFilter.addEventListener('change', applyFilters);
    sessionPackageFilter.addEventListener('change', applyFilters);
    weekdayFilter.addEventListener('change', applyFilters);

    // Clear filters
    clearFiltersBtn.addEventListener('click', function() {
        nameFilter.value = '';
        locationFilter.value = '';
        ratingFilter.value = '';
        priceFilter.value = '';
        sessionPackageFilter.value = '';
        weekdayFilter.value = '';
        applyFilters();
    });
});
</script>
@endsection