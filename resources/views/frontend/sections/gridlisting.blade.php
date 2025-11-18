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
        background: rgba(255, 255, 255, 0.98);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(10px);
        margin-top: 120px !important;
        margin-bottom: 30px;
        max-width: 1200px;
    }

    /* Page Header Adjustments - Fiverr Style */
    .page_header {
        padding: 0;
        background: transparent;
        border-radius: 0;
        margin-bottom: 30px;
        box-shadow: none;
    }

    /* Breadcrumbs - Fiverr Style */
    .breadcrumbs {
        margin-bottom: 16px;
    }

    .breadcrumbs ul {
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .breadcrumbs ul li {
        font-size: 14px;
        color: #74767e;
    }

    .breadcrumbs ul li a {
        color: #74767e;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumbs ul li a:hover {
        color: #1dbf73;
    }

    /* Category Title - Fiverr Style */
    .page_header h1 {
        color: #222325;
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .breadcrumbs ul li a {
        color: #152a70;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .breadcrumbs ul li a:hover {
        color: #c51010;
    }

    .breadcrumbs ul li:after {
        color: #f39c12;
    }

    /* Category Description - Fiverr Style */
    .category-description {
        color: #74767e;
        font-size: 16px;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    /* Sub-category Bubbles - Fiverr Style */
    .sub-categories {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .sub-category-bubble {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        border: none;
        border-radius: 20px;
        padding: 8px 16px;
        text-decoration: none;
        color: white !important;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(21, 42, 112, 0.2);
    }

    .sub-category-bubble:hover {
        background: linear-gradient(135deg, #1a3585, #e01515, #ffa726);
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .sub-category-bubble.active {
        background: linear-gradient(135deg, #0d1f4f, #a00d0d, #d68910);
        border: 2px solid #152a70;
        box-shadow: 0 4px 15px rgba(21, 42, 112, 0.4);
        color: white !important;
    }

    .sub-category-bubble span {
        color: white !important;
    }

    .sub-category-bubble i {
        font-size: 16px;
    }

    .category-count {
        color: rgba(255, 255, 255, 0.85);
        font-weight: 400;
        font-size: 12px;
        margin-left: 4px;
    }

    .sub-category-bubble:hover .category-count {
        color: rgba(255, 255, 255, 0.95);
    }

    /* Results Count - Fiverr Style */
    .page_header span {
        color: #74767e;
        font-size: 14px;
        margin-top: 0;
        background: none;
        padding: 0;
        border: none;
        border-radius: 0;
    }

    /* Filter Container */
    .filter-container {
        background-color: rgba(248, 249, 250, 0.95);
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.08);
    }
    
    /* Fiverr-Style Card Design */
    .strip {
        background: white;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 15px;
        overflow: hidden;
        position: relative;
        border: 1px solid #e4e5e7;
        height: 100%;
    }

    .strip:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(21, 42, 112, 0.2);
        border-color: #152a70;
    }

    /* Card Image Section */
    .strip figure {
        position: relative;
        margin: 0;
        overflow: hidden;
        height: 220px;
    }

    .strip figure img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Wishlist Heart */
    .wish_bt {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .wish_bt:hover {
        background: linear-gradient(135deg, #c51010, #f39c12);
        transform: scale(1.1);
    }

    .wish_bt i {
        color: #666;
        font-size: 16px;
    }

    .wish_bt:hover i {
        color: white;
    }

    /* Experience Badge */
    .experience-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(21, 42, 112, 0.3);
    }

    .experience-icon {
        margin-right: 4px;
        font-size: 10px;
    }

    /* Card Content Section */
    .strip_info {
        padding: 10px 12px;
        text-decoration: none;
        color: inherit;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .strip_info:hover {
        text-decoration: none;
        color: inherit;
    }

    /* Professional Name */
    .item_title h3 {
        font-size: 14px;
        font-weight: 600;
        color: #222;
        margin: 0 0 4px 0;
        line-height: 1.2;
    }

    /* Bio/Description */
    .item_title .about {
        font-size: 12px;
        color: #74767e;
        margin: 0 0 4px 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    /* Price */
    .item_title small {
        font-size: 15px;
        font-weight: 700;
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
        margin-bottom: 2px;
    }

    /* Tags */
    .item_title small:last-child {
        font-size: 11px;
        color: #b2b3b4;
        font-weight: 400;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 0;
    }

    /* Action Buttons */
    .strip ul {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        margin: 0;
        background: #fafafa;
        border-top: 1px solid #e4e5e7;
        flex-shrink: 0;
    }

    .strip ul li {
        list-style: none;
        margin: 0;
    }

    .strip ul li a {
        color: #74767e;
        text-decoration: none;
        padding: 6px;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .strip ul li a:hover {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        transform: translateY(-2px);
    }

    .strip ul li a i {
        font-size: 14px;
    }

    /* Icon Collage */
    .icon-collage-container {
        margin: 0;
    }

    .icon-collage {
        display: flex;
        align-items: center;
        gap: 0;
        position: relative;
    }

    .collage-icon {
        color: #74767e;
        text-decoration: none;
        padding: 6px 8px;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        border: 1px solid #e4e5e7;
    }

    .collage-icon:first-child {
        border-radius: 4px 0 0 4px;
        border-right: none;
    }

    .collage-icon:last-child {
        border-radius: 0 4px 4px 0;
    }

    .collage-icon:hover {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        transform: scale(1.05);
        z-index: 2;
        border-color: transparent;
    }

    .collage-icon i {
        font-size: 14px;
    }

    /* Rating Section */
    .score {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .score span {
        font-size: 11px;
        color: #74767e;
    }

    .score em {
        display: block;
        font-size: 9px;
        color: #b2b3b4;
        font-style: normal;
    }

    .score strong {
        font-size: 14px;
        font-weight: 700;
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
        min-width: 180px;
        margin-bottom: 8px;
    }
    
    /* Filter Labels */
    .filter-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #152a70;
        font-size: 14px;
    }
    
    /* Select Wrapper */
    .select-wrapper {
        position: relative;
        width: 100%;
    }
    
    /* Select Styling */
    .select-wrapper select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e4e5e7;
        border-radius: 4px;
        background-color: white;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        font-size: 13px;
        transition: border-color 0.3s ease;
    }

    .select-wrapper select:focus {
        border-color: #152a70;
        outline: none;
        box-shadow: 0 0 0 2px rgba(21, 42, 112, 0.1);
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
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        font-size: 13px;
        transition: all 0.2s;
    }
    
    /* Apply Button */
    .apply-btn {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
    }
    
    .apply-btn:hover {
        background: linear-gradient(135deg, #1a3585, #e01515, #ffa726);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
        color: #152a70;
    }
    
    .active-filter-badge {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
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
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .container.margin_30_40 {
            padding: 15px;
            margin-top: 100px !important;
        }
        
        .page_header {
            margin-bottom: 20px;
        }
        
        .page_header h1 {
            font-size: 28px;
        }
        
        .category-description {
            font-size: 15px;
            margin-bottom: 20px;
        }
        
        .sub-categories {
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .sub-category-bubble {
            padding: 6px 12px;
            font-size: 13px;
        }
        
        .filter-container {
            padding: 12px;
            margin-bottom: 15px;
        }
        
        .strip {
            margin-bottom: 12px;
        }
        
        .strip figure {
            height: 190px;
        }
        
        .strip_info {
            padding: 8px 10px;
        }
        
        .item_title h3 {
            font-size: 13px;
        }
        
        .item_title .about {
            font-size: 11px;
        }
        
        .item_title small {
            font-size: 14px;
        }
        
        .strip ul {
            padding: 6px 10px;
        }
        
        .strip ul li a {
            padding: 5px;
        }
        
        .strip ul li a i {
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .container.margin_30_40 {
            padding: 12px;
            margin-top: 80px !important;
        }
        
        .page_header {
            margin-bottom: 18px;
        }
        
        .page_header h1 {
            font-size: 24px;
        }
        
        .category-description {
            font-size: 14px;
            margin-bottom: 18px;
        }
        
        .sub-categories {
            gap: 8px;
            margin-bottom: 18px;
        }
        
        .sub-category-bubble {
            padding: 5px 10px;
            font-size: 12px;
        }
        
        .filter-container {
            padding: 10px;
            margin-bottom: 12px;
        }
        
        .strip figure {
            height: 170px;
        }
        
        .strip_info {
            padding: 6px 8px;
        }
        
        .item_title h3 {
            font-size: 12px;
        }
        
        .item_title .about {
            font-size: 10px;
        }
        
        .item_title small {
            font-size: 13px;
        }
        
        .strip ul {
            padding: 5px 8px;
        }
        
        .experience-badge {
            font-size: 10px;
            padding: 3px 6px;
        }
        
        .wish_bt {
            width: 26px;
            height: 26px;
        }
        
        .wish_bt i {
            font-size: 12px;
        }
    }

    /* Grid Layout Improvements */
    .row {
        margin: 0 -8px;
    }
    
    .row > [class*="col-"] {
        padding: 0 8px;
        margin-bottom: 15px;
    }

    /* Loading Animation */
    .strip {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Staggered Animation */
    .strip:nth-child(1) { animation-delay: 0.1s; }
    .strip:nth-child(2) { animation-delay: 0.2s; }
    .strip:nth-child(3) { animation-delay: 0.3s; }
    .strip:nth-child(4) { animation-delay: 0.4s; }
    .strip:nth-child(5) { animation-delay: 0.5s; }
    .strip:nth-child(6) { animation-delay: 0.6s; }
    </style>
@endsection
@section('content')
    <div class="container margin_30_40">
      <div class="page_header">
        <div class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('gridlisting') }}">Professionals</a></li>
                @if(session('selected_service_name'))
                    <li><a href="{{ route('gridlisting', ['service_id' => session('selected_service_id')]) }}">{{ session('selected_service_name') }}</a></li>
                @endif
                @if(request('sub_service_id'))
                    @php
                        $selectedSubService = collect($subServices)->firstWhere('id', request('sub_service_id'));
                    @endphp
                    @if($selectedSubService)
                        <li>{{ $selectedSubService->name }}</li>
                    @endif
                @endif
            </ul>
        </div>
        
        <h1>
            {{ session('selected_service_name', 'Professionals') }}
            @if(request('sub_service_id') && isset($selectedSubService))
                <span style="color: #74767e; font-size: 0.7em; font-weight: 400;"> • {{ $selectedSubService->name }}</span>
            @endif
        </h1>
        
        <div class="category-description">
            Find the perfect professional for your project needs. Connect with skilled experts who deliver quality results.
        </div>
        
        <div class="sub-categories">
            @if($subServices && $subServices->count() > 0)
                @foreach($subServices as $subService)
                    <a href="{{ route('gridlisting', ['service_id' => $selectedServiceId, 'sub_service_id' => $subService->id]) }}" 
                       class="sub-category-bubble {{ request('sub_service_id') == $subService->id ? 'active' : '' }}">
                        <span>{{ $subService->name }}</span>
                    </a>
                @endforeach
            @else
                <span style="color: #74767e; font-size: 14px;">No sub-categories available</span>
            @endif
        </div>
        
        <span>{{ count($professionals) }}+ results</span>
    </div>

        <!-- /page_header -->
        <!-- Filter Section with Custom CSS -->
<div class="filter-container">
    <form id="filterForm" action="{{ route('gridlisting') }}" method="GET">
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
                <a href="{{ route('gridlisting') }}" class="filter-btn clear-btn">Clear All</a>
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
            <a href="{{ route('gridlisting', array_merge(request()->except('experience'), request()->only(['price_range']))) }}" class="filter-remove">×</a>
        </span>
    @endif
    @if(request('price_range'))
        <span class="active-filter-badge">
            Price: {{ request('price_range') }}
            <a href="{{ route('gridlisting', array_merge(request()->except('price_range'), request()->only(['experience']))) }}" class="filter-remove">×</a>
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
                            {{-- Card Image Banner --}}
                            <figure>
                                {{-- Wishlist Heart Icon --}}
                                <a href="#0" class="wish_bt"><i class="icon_heart"></i></a>

                                {{-- Experience Badge --}}
                                @if(!empty($professional->profile->experience))
                                    <div class="experience-badge">
                                        <i class="icon_briefcase experience-icon"></i> {{ $professional->profile->experience }} yrs
                                    </div>
                                @endif

                                <img src="{{ $professional->profile && $professional->profile->photo ? asset('storage/' . $professional->profile->photo) : asset('img/lazy-placeholder.png') }}" class="img-fluid lazy" alt="{{ $professional->first_name }}">
                            </figure>

                        
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
                                
                                // Determine pricing based on selected service/sub-service
                                $displayPrice = 'Contact for pricing';
                                
                                if(request('sub_service_id')) {
                                    // Sub-service is selected - show sub-service rate
                                    $subServiceRate = $professional->professionalServices
                                        ->where('sub_service_id', request('sub_service_id'))
                                        ->first();
                                    if($subServiceRate && $subServiceRate->rate) {
                                        $displayPrice = number_format((float)$subServiceRate->rate, 0);
                                    }
                                } elseif(session('selected_service_id')) {
                                    // No sub-service selected but main service is selected - show main service rate
                                    $mainServiceRate = $professional->professionalServices
                                        ->where('service_id', session('selected_service_id'))
                                        ->whereNull('sub_service_id')
                                        ->first();
                                    if($mainServiceRate && $mainServiceRate->rate) {
                                        $displayPrice = number_format((float)$mainServiceRate->rate, 0);
                                    } else {
                                        // Fallback to any service rate for this professional under the selected service
                                        $anyServiceRate = $professional->professionalServices
                                            ->where('service_id', session('selected_service_id'))
                                            ->where('rate', '>', 0)
                                            ->first();
                                        if($anyServiceRate && $anyServiceRate->rate) {
                                            $displayPrice = number_format((float)$anyServiceRate->rate, 0);
                                        }
                                    }
                                }
                                
                                // Final fallback to starting price if no specific service rate found
                                if($displayPrice === 'Contact for pricing' && $professional->profile && $professional->profile->starting_price) {
                                    $displayPrice = number_format((float)$professional->profile->starting_price, 0);
                                }
                            @endphp
                            
                            <a href="{{ $detailsUrl }}" class="strip_info">
                                <div class="item_title">
                                    <h3>{{ $professional->name }}</h3>
                                    <p class="about">{{ $professional->bio ?: 'Professional service provider with expertise in your field.' }}</p>
                                    <small>From ₹{{ $displayPrice }}</small>
                                    <small>{{ $professional->professionalServices->pluck('tags')->filter()->implode(', ') ?: 'Professional Services' }}</small>
                                </div>
                            </a>

                            
                            <ul>
                                <li class="icon-collage-container">
                                    <div class="icon-collage">
                                        <a href="#0" class="tooltip-1 collage-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Chat"><i class="icon-chat"></i></a>
                                        <a href="#0" class="tooltip-1 collage-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Available Video Call"><i class="icon-videocam"></i></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="score">
                                        <span>Excellent<em>{{ rand(50, 500) }} Reviews</em></span>
                                        <strong>{{ number_format(rand(40, 50) / 10, 1) }}</strong>
                                    </div>
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
 