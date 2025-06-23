@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <style>
    /* Filter Container */
    .filter-container {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
        <!-- Keep any existing filters -->
        @if(request()->has('service_id'))
            <input type="hidden" name="service_id" value="{{ request('service_id') }}">
        @endif
        
        <div class="filter-row">
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
                <a href="{{ route('professionals', request()->has('service_id') ? ['service_id' => request('service_id')] : []) }}" class="filter-btn clear-btn">Clear</a>
            </div>
        </div>
    </form>
</div>

<!-- Active Filters Display -->
@if(request('experience') || request('price_range'))
<div class="active-filters-container">
    <span class="active-filters-label">Active Filters:</span>
    @if(request('experience'))
        <span class="active-filter-badge">
            Experience: {{ request('experience') }} years
            <a href="{{ route('professionals', array_merge(request()->except('experience'), request()->has('service_id') ? ['service_id' => request('service_id')] : [])) }}" class="filter-remove">×</a>
        </span>
    @endif
    @if(request('price_range'))
        <span class="active-filter-badge">
            Price: {{ request('price_range') }}
            <a href="{{ route('professionals', array_merge(request()->except('price_range'), request()->has('service_id') ? ['service_id' => request('service_id')] : [])) }}" class="filter-remove">×</a>
        </span>
    @endif
</div>
@endif

        <div class="row">
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
    <a href="{{ route('professionals.details', ['id' => $professional->id]) }}" class="strip_info">
        <div class="item_title">
            <h3>{{ $professional->name }}</h3>
            <p class="about">{{ $professional->bio }}</p>
            <small>From ₹{{ number_format($professional->profile->starting_price ?? 0, 2) }}</small>
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
                    </a>
                    </div>
                
                </div>
            @endforeach
        </div>
        
        
    <!-- /row -->
    <div class="pagination_fg">
        <a href="#">&laquo;</a>
        <a href="#" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">&raquo;</a>
    </div>
</div>
@endsection
