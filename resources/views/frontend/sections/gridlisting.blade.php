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

    /* Professional Image Optimization for Grid */
    .strip figure {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 0;
        height: 250px; /* Fixed height for consistent card sizing */
        background: #f8f9fa;
    }

    .strip figure img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: center !important;
        border-radius: 8px;
        transition: transform 0.3s ease;
        display: block;
    }

    .strip figure img:hover {
        transform: scale(1.02);
    }

    /* Remove the problematic ::before pseudo-element */
    .strip figure::before {
        display: none;
    }

    /* Fix for lazy loading */
    .strip figure img.lazy {
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    /* Professional card improvements */
    .strip {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
    }

    .strip:hover {
        box-shadow: 0 5px 25px rgba(0,0,0,0.15);
    }

    /* Strip info styling */
    .strip_info {
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .strip_info:hover {
        text-decoration: none;
        color: inherit;
    }

    /* Item title improvements */
    .item_title {
        padding: 15px;
        background: white;
    }

    .item_title h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .item_title .about {
        color: #6c757d;
        font-size: 0.9rem;
        line-height: 1.4;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .item_title small {
        color: #007bff;
        font-weight: 500;
    }

    /* Experience badge improvements */
    .experience-badge {
        position: absolute; 
        top: 15px; 
        right: 15px; 
        background: linear-gradient(135deg, #ff6f61, #ff8a80); 
        color: white; 
        padding: 6px 12px; 
        border-radius: 20px; 
        font-size: 12px; 
        font-weight: 600;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        z-index: 10;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    /* Wishlist button improvements */
    .wish_bt {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255,255,255,0.9);
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .wish_bt:hover {
        background: #ff4757;
        color: white;
        transform: scale(1.1);
    }

    /* Modern Pagination Styling */
    .results-info {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .showing-results {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
        font-weight: 500;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 40px;
    }

    .pagination {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .pagination .page-item {
        margin: 0;
        border-right: 1px solid #e9ecef;
    }

    .pagination .page-item:last-child {
        border-right: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        height: 42px;
        padding: 8px 12px;
        color: #495057;
        text-decoration: none;
        border: none;
        background: transparent;
        transition: all 0.25s ease;
        font-weight: 500;
        font-size: 14px;
        position: relative;
    }

    .pagination .page-item.active .page-link {
        background: #152a70;
        color: white;
        font-weight: 600;
    }

    .pagination .page-link:hover:not(.page-item.disabled .page-link) {
        background: #f8f9fa;
        color: #152a70;
    }

    .pagination .page-item.active .page-link:hover {
        background: #1e3a8a;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .pagination .page-item.disabled .page-link:hover {
        background: transparent;
        color: #adb5bd;
    }

    /* Arrow icons styling - Clean and simple */
    .pagination .page-link span[aria-hidden="true"] {
        font-size: 16px;
        font-weight: bold;
        line-height: 1;
        display: inline-block;
    }

    /* Dots styling */
    .pagination .page-item .page-link[aria-disabled="true"] {
        font-weight: bold;
        color: #6c757d;
    }

    /* Responsive pagination */
    @media (max-width: 576px) {
        .pagination .page-link {
            min-width: 36px;
            height: 36px;
            padding: 6px 8px;
            font-size: 13px;
        }
        
        .pagination .page-item:first-child .page-link::before,
        .pagination .page-item:last-child .page-link::before {
            font-size: 14px;
        }
        
        .showing-results {
            font-size: 13px;
        }
    }

    /* Clean separation between page numbers */
    .pagination .page-item + .page-item .page-link {
        margin-left: 0;
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
    @php
        $profileImage = $professional->profile && $professional->profile->photo ? $professional->profile->photo : null;
        $imageUrl = $profileImage && file_exists(public_path('storage/' . $profileImage)) 
            ? asset('storage/' . $profileImage) 
            : asset('frontend/assets/img/lazy-placeholder.png');
    @endphp
    <img src="{{ $imageUrl }}" class="img-fluid lazy" alt="{{ $professional->first_name }}">

    {{-- Professional Details Link --}}
       @php
        $fullName = trim($professional->name ?? $professional->first_name ?? '');
        $parts = preg_split('/\s+/', $fullName);
        if (!$fullName) {
            $cardName = '';
        } elseif (count($parts) === 1) {
            $cardName = $parts[0];
        } else {
            $cardName = $parts[0] . ' ' . strtoupper(substr(end($parts), 0, 1)) . '.';
        }
    @endphp
    @php
        $detailsUrl = route('professionals.details', ['id' => $professional->id, 'professional_name' => $cardName]);
        // Add sub_service_id parameter if it's in the request
        if(request('sub_service_id')) {
            $detailsUrl .= '?sub_service_id=' . request('sub_service_id');
        }
    @endphp
    <a href="{{ $detailsUrl }}" class="strip_info">
        <div class="item_title">
              <h3>{{ $cardName }}</h3>
            <p class="about">{{ $professional->bio }}</p>
            <small>From ₹{{ $professional->profile->starting_price ?? 'Contact for pricing' }}</small>
            <br>
         <small>
    {{ $professional->professionalServices->pluck('tags')->filter()->implode(', ') ?: 'No tags available' }}
</small>
        </div>
    </a>
</figure>

                    </div>
                </div>
            @endforeach
        </div>
        
        
    <!-- /row -->
    
    <!-- Results Info and Pagination Section -->
    @if($professionals->hasPages())
        <div class="results-info">
            <p class="showing-results">
                Showing {{ $professionals->firstItem() }} to {{ $professionals->lastItem() }} of {{ $professionals->total() }} professionals
            </p>
        </div>
        
        <div class="pagination-wrapper">
            {{ $professionals->links('pagination.custom-pagination') }}
        </div>
    @endif
</div>
@endsection
