@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
      <style>
    /* Page Background Animation */
    body {
        background: linear-gradient(135deg, #1741cabc, #d379038c, #ece00586);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        min-height: 100vh;
    }

    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    /* Content Container Adjustments */
    .container.margin_30_40 {
        background: rgba(255, 255, 255, 0.952);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        margin-top: 150px !important;
        margin-bottom: 50px;
    }

    /* Page Header Adjustments */
    .page_header {
        padding: 20px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }

    .page_header h1 {
        color: #152a70;
        margin-bottom: 10px;
    }

    .breadcrumbs ul li a {
        color: #c51010;
        font-weight: 500;
    }

    .breadcrumbs ul li:after {
        color: #f39c12;
    }

    /* Filter Container */
    .filter-container {
        background-color: rgba(248, 249, 250, 0.95);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Strip Card Adjustments */
    .strip {
        background: rgba(255, 255, 255, 0.95);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
    }

    .strip:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }
    
    /* Filter Row */
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-end;
        gap: 15px;
    }
    
    /* Filter Group */
    .filter-group {
        flex: 1;
        min-width: 200px;
        margin-bottom: 10px;
    }
    
    /* Filter Labels */
    .filter-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 1.5em;
    }
    
    /* Select Wrapper */
    .select-wrapper {
        position: relative;
        width: 100%;
    }
    
    /* Select Styling */
    .select-wrapper select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        font-size: 14px;
    }
    
    /* Select Arrow */
    .select-wrapper::after {
        content: '▼';
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 12px;
        color: #666;
    }
    
    /* Filter Buttons */
    .filter-buttons {
        display: flex;
        gap: 10px;
        margin-left: auto;
        margin-bottom: 11px;
    }
    
    /* Button Styling */
    .filter-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    /* Apply Button */
    .apply-btn {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
    }
    
    .apply-btn:hover {
        opacity: 0.9;
    }
    
    /* Clear Button */
    .clear-btn {
        background-color: #f1f1f1;
        color: #333;
    }
    
    .clear-btn:hover {
        background-color: #e1e1e1;
    }
    
    /* Active Filters Display */
    .active-filters-container {
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }
    
    .active-filters-label {
        font-weight: 600;
        color: #333;
    }
    
    .active-filter-badge {
        background-color: #007bff;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
    }
    
    .filter-remove {
        margin-left: 8px;
        color: white;
        font-weight: bold;
        text-decoration: none;
        font-size: 16px;
    }
    
    .filter-remove:hover {
        color: #f8f9fa;
    }
    
    /* Responsive Layout */
    @media (max-width: 768px) {
        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            width: 100%;
        }
        
        .filter-buttons {
            margin-left: 0;
            width: 100%;
            justify-content: space-between;
        }
        
        .filter-btn {
            flex: 1;
        }
    }
    
    /* Experience Badge on Professional Cards */
    .experience-badge {
        position: absolute; 
        top: 10px; 
        right: 10px; 
        background: #ff6f61; 
        color: white; 
        padding: 5px 10px; 
        border-radius: 20px; 
        font-size: 14px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        z-index: 5;
    }
    
    .experience-icon {
        margin-right: 5px;
    }
</style>
@endsection
@section('content')
    <div class="container margin_30_40" style="margin-top: 100px;">
      <div class="page_header">
    <div class="breadcrumbs">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Professionals</a></li>
        </ul>
    </div>
    <h1>{{ session('selected_service_name', 'Professionals') }}</h1>
    <span>: {{ count($professionals) }} found</span>
</div>

        <!-- /page_header -->
        <!-- Filter Section with Custom CSS -->
<div class="filter-container">
    <form id="filterForm" action="{{ route('professionals') }}" method="GET">
        <div class="filter-row">
            <!-- Sub-Service Filter -->
            <div class="filter-group">
                <label for="sub_service">Sub-Service</label>
                <div class="select-wrapper">
                    <select id="sub_service" name="sub_service_id">
                        <option value="">All Sub-Services</option>
                        @foreach($subServices as $subService)
                            <option value="{{ $subService->id }}" {{ request('sub_service_id') == $subService->id ? 'selected' : '' }}>
                                {{ $subService->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Experience Filter -->
            <div class="filter-group">
                <label for="experience">Experience</label>
                <div class="select-wrapper">
                    <select id="experience" name="experience">
                        <option value="">All Experience Levels</option>
                        <option value="0-2" {{ request('experience') == '0-2' ? 'selected' : '' }}>0-2 years</option>
                        <option value="2-4" {{ request('experience') == '2-4' ? 'selected' : '' }}>2-4 years</option>
                        <option value="4-6" {{ request('experience') == '4-6' ? 'selected' : '' }}>4-6 years</option>
                        <option value="6-8" {{ request('experience') == '6-8' ? 'selected' : '' }}>6-8 years</option>
                        <option value="8-10" {{ request('experience') == '8-10' ? 'selected' : '' }}>8-10 years</option>
                        <option value="10+" {{ request('experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                    </select>
                </div>
            </div>
            
            <!-- Price Range Filter -->
            <div class="filter-group">
                <label for="price">Price Range</label>
                <div class="select-wrapper">
                    <select id="price" name="price_range">
                        <option value="">All Prices</option>
                        <option value="0-1000" {{ request('price_range') == '0-1000' ? 'selected' : '' }}>Under ₹1,000</option>
                        <option value="1000-3000" {{ request('price_range') == '1000-3000' ? 'selected' : '' }}>₹1,000 - ₹3,000</option>
                        <option value="3000-5000" {{ request('price_range') == '3000-5000' ? 'selected' : '' }}>₹3,000 - ₹5,000</option>
                        <option value="5000+" {{ request('price_range') == '5000+' ? 'selected' : '' }}>₹5,000+</option>
                    </select>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="filter-buttons">
                <button type="submit" class="filter-btn apply-btn">Apply Filters</button>
                <a href="{{ route('professionals') }}" class="filter-btn clear-btn">Clear All</a>
            </div>
        </div>
    </form>
</div>

<!-- Active Filters Display -->
@if(request('sub_service_id') || request('experience') || request('price_range'))
<div class="active-filters-container">
    <span class="active-filters-label">Active Filters:</span>
    @if(request('sub_service_id'))
    @php $selectedSubService = collect($subServices)->firstWhere('id', request('sub_service_id')) @endphp
        @if($selectedSubService)
            <span class="active-filter-badge">
                Sub-Service: {{ $selectedSubService->name }}
                <a href="{{ route('professionals', array_merge(request()->except('sub_service_id'), request()->only(['experience', 'price_range']))) }}" class="filter-remove">×</a>
            </span>
        @endif
    @endif
    @if(request('experience'))
        <span class="active-filter-badge">
            Experience: {{ request('experience') }} years
            <a href="{{ route('professionals', array_merge(request()->except('experience'), request()->only(['service_id', 'sub_service_id', 'price_range']))) }}" class="filter-remove">×</a>
        </span>
    @endif
    @if(request('price_range'))
        <span class="active-filter-badge">
            Price: {{ request('price_range') }}
            <a href="{{ route('professionals', array_merge(request()->except('price_range'), request()->only(['service_id', 'sub_service_id', 'experience']))) }}" class="filter-remove">×</a>
        </span>
    @endif
</div>
@endif

        <div class="row">
            @if($professionals->isEmpty())
                <div class="col-12">
                    <div class="alert alert-info text-center py-4">
                        <i class="fas fa-info-circle me-2"></i>
                        No professionals found for the selected filters.
                    </div>
                </div>
            @else
                @foreach($professionals as $professional)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="strip">
                           <figure style="position: relative;">
    {{-- Wishlist Heart Icon --}}
    <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>

    {{-- Experience Badge --}}
    @if(!empty($professional->profile->experience))
        <div class="experience-badge">
            <i class="icon_briefcase experience-icon"></i> {{ $professional->profile->experience }} yrs
        </div>
    @endif

    {{-- Professional Image --}}
    <img src="{{ $professional->profile && $professional->profile->photo ? asset('storage/' . $professional->profile->photo) : asset('img/lazy-placeholder.png') }}" class="img-fluid lazy" alt="{{ $professional->first_name }}" style="z-index: 1;">

    {{-- Professional Details Link --}}
    @php
        $professionalName = $professional->name ?? 'Professional';
        $seoFriendlyName = Str::slug($professionalName);
        
        // Build route parameters
        $routeParams = ['id' => $professional->id, 'professional_name' => $seoFriendlyName];
        
        // Add sub-service slug if selected
        if(request('sub_service_id')) {
            $selectedSubService = collect($subServices)->firstWhere('id', request('sub_service_id'));
            if($selectedSubService) {
                $routeParams['sub_service_slug'] = Str::slug($selectedSubService->name);
            }
        }
        
        $detailsUrl = route('professionals.details', $routeParams);
    @endphp
    <a href="{{ $detailsUrl }}" class="strip_info">
        <div class="item_title">
            <h3>{{ $professional->name }}</h3>
            <p class="about">{{ $professional->bio }}</p>
            <small>From ₹{{ $professional->profile->starting_price ?? 'Contact for pricing' }}</small>
            <br>
         <small>
    {{ $professional->professionalServices->pluck('tags')->filter()->implode(', ') ?: 'No tags available' }}
</small>


        </div>
    </a>
</figure>


                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Appointment"><i class="icon-users"></i></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Video Call"><i class="icon-videocam"></i></a></li>
                            <li>
                                <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                            </li>
                        </ul>
                    </div>
                
            </div>
        @endforeach
        </div>
    @endif
        
        
    <!-- /row -->
    
    <!-- Pagination -->
    @if($professionals->hasPages())
        <div class="pagination_fg">
            {{-- Previous Page Link --}}
            @if ($professionals->onFirstPage())
                <span class="disabled">&laquo;</span>
            @else
                <a href="{{ $professionals->previousPageUrl() }}">&laquo;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($professionals->getUrlRange(1, $professionals->lastPage()) as $page => $url)
                @if ($page == $professionals->currentPage())
                    <a href="#" class="active">{{ $page }}</a>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($professionals->hasMorePages())
                <a href="{{ $professionals->nextPageUrl() }}">&raquo;</a>
            @else
                <span class="disabled">&raquo;</span>
            @endif
        </div>
        
        <div class="pagination-info text-center mt-3">
            <p>Showing {{ $professionals->firstItem() }} to {{ $professionals->lastItem() }} of {{ $professionals->total() }} professionals</p>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
// Auto-submit form when filters change (optional)
document.querySelectorAll('#filterForm select').forEach(select => {
    select.addEventListener('change', function() {
        // Uncomment the line below to auto-submit on filter change
        // document.getElementById('filterForm').submit();
    });
});
</script>
@endsection
 