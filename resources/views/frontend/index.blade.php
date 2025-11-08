<!-- /header -->
@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	 <style>
        /* Hide video and show image on mobile */
        @media (max-width: 992px) {
            .header-video--media {
                display: none !important;
            }
            .mobile-video-fallback {
                display: block !important;
                width: 100%;
                height: auto;
            }
        }
        .mobile-video-fallback {
            display: none;
        }

		@media only screen and (min-width: 768px) and (max-width: 1024px) {

			.fun-facts-cards .container .card-two {
    			margin-top: 20px;
    
		}

		.fun-facts-cards .container .right .row .third-card .card-three{
			margin-top: 14px;
		}

		.fun-facts-cards .container .card {
			margin-right: 12px
		}

		}
		
    </style>
	<style>
    .header-video {
        position: relative;
        height: 430px !important; /* Adjusted to comfortable height */
        max-height: 430px !important;
        min-height: 430px !important;
        overflow: hidden;
        margin-top: 20px; /* Add space at top of banner */
        background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1920&h=1080&fit=crop') center/cover;
    }
    
    #hero_video {
        height: 100% !important;
        max-height: 430px !important;
    }
    
    .opacity-mask {
        height: 100% !important;
        max-height: 430px !important;
    }
    
    .header-video--media {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Fiverr-style Banner Styling */
    .fiverr-style-headline {
        font-size: 2.4rem !important;
        font-weight: 700;
        color: white;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .header-video h1 {
        font-size: 2.4rem !important;
    }

    .fiverr-style-subtitle {
        font-size: 1.4rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 2.5rem;
        font-weight: 300;
    }

    .fiverr-search-container {
        max-width: 700px;
        margin: 0 0 2rem 0;
    }

    .fiverr-search-box {
        display: flex;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        height: 60px;
    }

    .search-input-wrapper {
        flex: 1;
        position: relative;
    }

    .fiverr-search-input {
        width: 100%;
        height: 60px;
        border: none;
        padding: 0 25px;
        font-size: 1.1rem;
        background: transparent;
        outline: none;
        color: #333;
    }

    .fiverr-search-input::placeholder {
        color: #999;
        font-weight: 400;
    }

    .fiverr-search-btn {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        border: none;
        width: 80px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .fiverr-search-btn:hover {
        background: linear-gradient(135deg, #1a3585, #e01515, #ffa726);
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .fiverr-categories {
        margin-top: 2rem;
        width: 100%;
        overflow: visible;
    }

    .category-row {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: nowrap;
        overflow: visible;
    }

    .trending-text {
        color: rgba(255,255,255,0.8);
        font-size: 0.95rem;
        font-weight: 500;
        margin: 0;
        flex-shrink: 0;
        white-space: nowrap;
        position: sticky;
        left: 0;
        background: inherit;
        z-index: 1;
    }

    .category-buttons {
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-start;
        gap: 8px;
        align-items: center;
        overflow-x: auto;
        flex: 1;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .category-buttons::-webkit-scrollbar {
        display: none;
    }

    .category-btn {
        background: rgba(255,255,255,0.1);
        color: white;
        padding: 8px 14px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        flex-shrink: 0;
        white-space: nowrap;
    }

    .category-btn:hover {
        background: rgba(255,255,255,0.2);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .category-btn i {
        font-size: 0.8rem;
        opacity: 0.7;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .header-video {
            height: 350px !important;
            max-height: 350px !important;
            min-height: 350px !important;
			top: -17px;
        }
        
        #hero_video,
        .opacity-mask {
            max-height: 350px !important;
        }
        
        .fiverr-style-headline {
            font-size: 1.7rem !important;
        }
        
        .header-video h1 {
            font-size: 1.7rem !important;
			padding-top: 74px;
        }
        
        .fiverr-style-subtitle {
            font-size: 1.2rem;
        }
        
        .fiverr-search-container {
            max-width: 100%;
            margin: 0 0 2rem 0;
        }
        
        .fiverr-search-box {
            height: 55px;
        }
        
        .fiverr-search-input {
            height: 55px;
            font-size: 1rem;
            padding: 0 20px;
        }
        
        .fiverr-search-btn {
            width: 70px;
            height: 55px;
        }
        
        .fiverr-categories {
            margin-top: 1rem; /* Reduced from 2rem */
        }
        
        .category-row {
            gap: 8px; /* Reduced from 15px */
            flex-wrap: nowrap;
            overflow: visible; /* Keep row overflow visible */
        }
        
        .trending-text {
            font-size: 0.8rem; /* Reduced from 0.9rem */
            margin: 0;
            position: sticky;
            left: 0;
            background: inherit;
            z-index: 1;
        }
        
        .category-buttons {
            gap: 4px; /* Reduced from 8px */
            flex-wrap: nowrap;
            overflow-x: auto; /* Only buttons scroll */
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        
        .category-buttons::-webkit-scrollbar {
            display: none;
        }
        
        .category-btn {
            padding: 6px 10px; /* Reduced from 10px 16px */
            font-size: 0.8rem; /* Reduced from 0.9rem */
            border-radius: 4px; /* Slightly smaller radius */
        }
        
        .category-btn i {
            font-size: 0.7rem; /* Reduced from 0.8rem */
        }
        
        /* Popular Services Mobile */
        .popular-services-main-section {
            padding: 40px 0;
        }
        
        .popular-services-title {
            font-size: 1.8rem;
            margin-bottom: 30px;
        }
        
        .popular-service-card {
            width: 180px;
            height: 200px;
            min-width: 180px;
            min-height: 200px;
            max-width: 180px;
            max-height: 200px;
        }
        
        .service-graphic {
            height: 130px;
            padding: 12px;
        }
        
        .service-content {
            min-height: 70px;
            padding: 15px;
        }
        
        .service-title {
            font-size: 1rem;
        }
    }
    .mobile-video-fallback {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }

    /* Popular Services Section Styles */
    .popular-services-main-section {
        background-color: white;
        padding: 60px 0;
    }

    .popular-services-title {
        font-size: 2.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 40px;
        text-align: left;
    }

    .popular-services-scroll-container {
        position: relative;
        overflow: hidden;
    }

    .popular-services-wrapper {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 10px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .popular-services-wrapper::-webkit-scrollbar {
        display: none;
    }

    .popular-service-card {
        width: 200px;
        height: 275px;
        min-width: 200px;
        min-height: 275px;
        max-width: 200px;
        max-height: 275px;
        background: #0d1d53;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .service-graphic {
        height: 250px;
        overflow: hidden;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 5px;
        flex-shrink: 0;
    }

    .service-mini-card {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .service-image {
        width: 200px !important;
        height: 150px !important;
 		/* margin-top: -10px; */
        object-fit: cover;
        opacity: 0.9;
        border-radius: 15px;
    }

    .service-content {
        padding: 20px;
        text-align: left;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        min-height: 70px;
    }

    .service-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: white;
    }

    /* Join Now Button Style */
    .btn-join-style:hover {
        background: linear-gradient(135deg, #1a3585, #e01515, #ffa726) !important;
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* View All Events Button Style */
    .btn-view-all-events:hover {
        background: linear-gradient(135deg, #1a3585, #e01515, #ffa726) !important;
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        text-decoration: none !important;
    }

    /* Event Card Column Layout */
    .fiverr-meta-column {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .fiverr-meta-item {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .fiverr-btn-container {
        justify-content: flex-end;
        margin-top: 4px;
    }

    /* Scroll Arrow */
    .scroll-arrow-right {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
    }


    .scroll-arrow-right i {
        color: #2c5530;
        font-size: 1.2rem;
    }

    /* Mini Card Styles - White Background */
    .coding-card, .webdev-card, .video-card, .software-card, .seo-card, .architecture-card {
        background: #FFFFFF;
        border: 2px solid #000000;
    }

    /* New Card Content Styles */
    
    /* Common Elements */
    .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(44, 85, 48, 0.6);
        margin: 0 1px;
    }

    /* Coding Card */
    .code-screen {
        width: 100%;
        height: 100%;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .terminal-window {
        width: 90%;
        height: 80%;
        background: #1a1a1a;
        border-radius: 4px;
        padding: 6px;
        color: #00ff00;
    }

    .terminal-header {
        display: flex;
        align-items: center;
        margin-bottom: 4px;
    }

    .terminal-dots {
        display: flex;
        gap: 3px;
    }

    .terminal-content {
        font-size: 0.6rem;
        font-family: monospace;
    }

    .code-line {
        color: #87CEEB;
        margin-bottom: 2px;
    }

    .cursor-blink {
        color: #00ff00;
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0; }
    }

    /* Website Dev Card */
    .website-preview {
        width: 100%;
        height: 100%;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .browser-window {
        width: 90%;
        height: 80%;
        background: white;
        border-radius: 4px;
        overflow: hidden;
    }

    .browser-header {
        background: #f0f0f0;
        padding: 4px 6px;
        display: flex;
        align-items: center;
    }

    .browser-dots {
        display: flex;
        gap: 3px;
    }

    .website-content {
        padding: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .web-logo {
        width: 16px;
        height: 16px;
        background: #2c5530;
        border-radius: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.6rem;
        font-weight: bold;
    }

    .web-nav {
        display: flex;
        gap: 4px;
    }

    .nav-item {
        width: 12px;
        height: 2px;
        background: #ddd;
        border-radius: 1px;
    }

    /* Video Card */
    .video-editor {
        width: 100%;
        height: 100%;
        padding: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .video-player {
        width: 70%;
        height: 60%;
    }

    .video-screen {
        width: 100%;
        height: 100%;
        background: #333;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .video-content {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .play-icon {
        color: white;
        font-size: 0.8rem;
    }

    .video-timeline {
        width: 80%;
    }

    .timeline-track {
        height: 4px;
        background: #ddd;
        border-radius: 2px;
        position: relative;
    }

    .timeline-progress {
        height: 100%;
        width: 60%;
        background: #2c5530;
        border-radius: 2px;
    }

    /* Software Card */
    .app-development {
        width: 100%;
        height: 100%;
        padding: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .app-window {
        width: 80%;
        height: 60%;
        background: white;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .app-header {
        background: #2c5530;
        padding: 4px 6px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .app-title {
        color: white;
        font-size: 0.6rem;
        font-weight: bold;
    }

    .app-content {
        padding: 6px;
    }

    .code-lines {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .code-line-small {
        height: 2px;
        background: #ddd;
        border-radius: 1px;
    }

    .code-line-small:nth-child(1) { width: 80%; }
    .code-line-small:nth-child(2) { width: 60%; }
    .code-line-small:nth-child(3) { width: 90%; }

    .app-icons {
        display: flex;
        gap: 4px;
    }

    .app-icon {
        width: 8px;
        height: 8px;
        background: #2c5530;
        border-radius: 2px;
    }

    /* SEO Card */
    .seo-dashboard {
        width: 100%;
        height: 100%;
        padding: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .search-engine {
        width: 90%;
        height: 40%;
    }

    .search-bar {
        width: 100%;
        height: 16px;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
    }

    .search-icon {
        font-size: 0.6rem;
        color: #666;
    }

    .ranking-chart {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .rank-bars {
        display: flex;
        align-items: end;
        gap: 2px;
        height: 20px;
    }

    .rank-bar {
        width: 4px;
        border-radius: 1px;
        background: #2c5530;
    }

    .rank-1 { height: 16px; }
    .rank-2 { height: 12px; }
    .rank-3 { height: 8px; }

    .ranking-text {
        font-size: 0.5rem;
        font-weight: bold;
        color: #2c5530;
    }

    /* Architecture Card */
    .design-studio {
        width: 100%;
        height: 100%;
        padding: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .blueprint {
        width: 90%;
        height: 70%;
        background: rgba(255,255,255,0.8);
        border-radius: 4px;
        position: relative;
        border: 1px solid #ddd;
    }

    .floor-plan {
        width: 100%;
        height: 100%;
        position: relative;
        padding: 6px;
    }

    .room-outline {
        width: 100%;
        height: 100%;
        border: 1px solid #4A90E2;
        border-radius: 2px;
        position: relative;
    }

    .room-furniture {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .furniture-chair {
        width: 8px;
        height: 6px;
        background: #4A90E2;
        border-radius: 1px;
    }

    .furniture-table {
        width: 12px;
        height: 8px;
        background: #87CEEB;
        border-radius: 1px;
    }

    .design-tools {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .ruler {
        width: 12px;
        height: 2px;
        background: #4A90E2;
        border-radius: 1px;
    }

    .pencil {
        width: 8px;
        height: 2px;
        background: #87CEEB;
        border-radius: 1px;
    }
    @media (max-width: 992px) {
        .header-video--media {
            display: none;
        }
        .mobile-video-fallback {
            display: block;
        }
    }

	.btn-custom{
		    background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
			border: none;
			color: white;
	}
	.text{
		color: white;
	}
	/* Updated Search Results Styling */
#searchResults {
    max-height: 250px;
    overflow-y: auto;
    border-radius: 0.25rem;
    left: 0; /* Align to the left */
    right: auto; /* Override any right alignment */
    width: 100%; /* Full width of parent */
}

.search-container {
    position: relative; /* Ensure proper positioning context */
    width: 100%;
}

#searchResults .list-group-item {
    border-left: none;
    border-right: none;
    text-align: left; /* Left-align text */
    padding-left: 15px;
}

#searchResults .list-group-item:first-child {
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

#searchResults .list-group-item:last-child {
    border-bottom-left-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}

#searchResults .list-group-item:hover {
    background-color: #f8f9fa;
}
.login-popup-title {
        font-size: 1.5rem !important;
        color: white !important;
    }

    .login-popup-title .wave-icon {
        font-size: 1.8rem !important;
    }

    .login-popup-custom {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12) !important;
        color: white !important;
        border-radius: 15px !important;
        padding: 25px 20px !important;
    }

    .login-popup-btn {
        background-color: #1e0d60 !important;
        color: white !important;
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        padding: 12px 30px !important;
        border-radius: 50px !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }

    .login-popup-btn:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
    }
    
    .login-popup-close {
        color: white !important;
        opacity: 0.8 !important;
        font-size: 1.5rem !important;
    }
    
    .login-popup-close:hover {
        opacity: 1 !important;
    }

    /* Tazen Pro Section - Compact & Stylish */
    .tazen-pro-section-compact {
        position: relative;
        overflow: hidden;
    }

    .pro-compact-card {
        background: white;
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 30px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .pro-branding {
        text-align: left;
    }

    .pro-logo-compact {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-name-compact {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a2e;
        letter-spacing: -1px;
    }

    .pro-badge {
        background: linear-gradient(135deg, #f39c12, #c51010);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .pro-subtitle {
        color: #555;
        font-size: 1rem;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .btn-pro-cta {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(245, 156, 18, 0.3);
    }

    .btn-pro-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 156, 18, 0.4);
        color: white;
    }

    .pro-features-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .pro-feature-card {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .pro-feature-card:hover {
        background: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: #c51010;
    }

    .feature-icon-box {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #f39c12, #c51010);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-icon-box i {
        font-size: 1.2rem;
        color: white;
    }

    .feature-text h5 {
        color: #1a1a2e;
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 5px 0;
    }

    .feature-text p {
        color: #666;
        font-size: 0.85rem;
        margin: 0;
        line-height: 1.4;
    }

    /* Project Status Widget */
    .pro-visual {
        position: relative;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .project-status-widget {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10;
    }

    .status-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        text-align: center;
        min-width: 250px;
    }

    .status-title {
        color: #2c5530;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .progress-info {
        margin-bottom: 20px;
    }

    .progress-percentage {
        font-size: 1.8rem;
        font-weight: 700;
        color: #4CAF50;
        margin-bottom: 5px;
    }

    .progress-steps {
        font-size: 0.9rem;
        color: #666;
    }

    .circular-progress {
        margin-bottom: 20px;
    }

    .progress-circle {
        position: relative;
        display: inline-block;
    }

    .progress-ring {
        transform: rotate(-90deg);
    }

    .progress-ring-circle {
        transition: stroke-dashoffset 0.5s ease-in-out;
    }

    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.2rem;
        font-weight: 700;
        color: #4CAF50;
    }

    .profile-section {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .profile-avatar img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 2px solid #4CAF50;
    }

    .profile-name {
        font-weight: 600;
        color: #2c5530;
        font-size: 0.9rem;
    }

    .profile-status {
        font-size: 0.8rem;
        color: #4CAF50;
        font-weight: 500;
    }

    /* Progress Chart */
    .progress-chart {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        min-width: 200px;
        z-index: 10;
    }

    .chart-container {
        text-align: center;
    }

    .chart-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2c5530;
        margin-bottom: 15px;
    }

    .chart-bars {
        display: flex;
        align-items: end;
        justify-content: center;
        gap: 8px;
        height: 100px;
        margin-bottom: 10px;
    }

    .chart-bar {
        width: 20px;
        background: linear-gradient(to top, #4CAF50, #8BC34A);
        border-radius: 3px 3px 0 0;
        position: relative;
        transition: all 0.3s ease;
    }

    .chart-bar:hover {
        transform: scaleY(1.1);
    }

    .bar-label {
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.7rem;
        color: #666;
        font-weight: 500;
    }

    .chart-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #4CAF50;
    }

    /* Pro Illustration */
    .pro-illustration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .people-illustration {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .person {
        position: absolute;
        z-index: 2;
    }

    .person-1 {
        left: 30%;
        top: 40%;
    }

    .person-2 {
        right: 30%;
        top: 35%;
    }

    .person-head {
        width: 40px;
        height: 40px;
        background: #ffdbac;
        border-radius: 50%;
        margin-bottom: 5px;
        position: relative;
    }

    .person-head::after {
        content: '';
        position: absolute;
        top: 10px;
        left: 8px;
        width: 8px;
        height: 8px;
        background: #333;
        border-radius: 50%;
    }

    .person-head::before {
        content: '';
        position: absolute;
        top: 10px;
        right: 8px;
        width: 8px;
        height: 8px;
        background: #333;
        border-radius: 50%;
    }

    .person-body {
        width: 30px;
        height: 50px;
        background: #4CAF50;
        border-radius: 15px 15px 5px 5px;
        margin: 0 auto;
    }

    .laptop {
        position: absolute;
        left: 50%;
        top: 60%;
        transform: translateX(-50%);
        width: 60px;
        height: 40px;
        background: #333;
        border-radius: 5px;
        z-index: 3;
    }

    .laptop::before {
        content: '';
        position: absolute;
        top: -5px;
        left: 5px;
        width: 50px;
        height: 8px;
        background: #666;
        border-radius: 3px;
    }

    /* Responsive Design for Compact Pro Section */
    @media (max-width: 992px) {
        .pro-features-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .pro-feature-card {
            padding: 15px;
        }
        
        .feature-text h5 {
            font-size: 0.9rem;
        }
        
        .feature-text p {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 768px) {
        .pro-compact-card {
            padding: 25px 20px;
        }
        
        .brand-name-compact {
            font-size: 2rem;
        }
        
        .pro-subtitle {
            font-size: 0.9rem;
        }
        
        .btn-pro-cta {
            padding: 10px 24px;
            font-size: 0.95rem;
        }
        
        .pro-features-grid {
            grid-template-columns: 1fr;
            gap: 10px;
            margin-top: 20px;
        }
        
        .feature-icon-box {
            width: 40px;
            height: 40px;
        }
        
        .feature-icon-box i {
            font-size: 1rem;
        }
        
        .pro-visual {
            height: 300px;
        }
        
        .project-status-widget {
            top: 10px;
            right: 10px;
        }
        
        .status-card {
            min-width: 200px;
            padding: 20px;
        }
        
        .progress-chart {
            bottom: 10px;
            left: 10px;
            min-width: 180px;
            padding: 15px;
        }
        
        .person-1 {
            left: 25%;
            top: 45%;
        }

        .person-2 {
            right: 25%;
            top: 40%;
        }
    }

    @media (max-width: 576px) {
        .pro-compact-card {
            padding: 20px 15px;
        }
        
        .brand-name-compact {
            font-size: 1.75rem;
        }
        
        .pro-badge {
            font-size: 0.65rem;
            padding: 3px 10px;
        }
        
        .btn-pro-cta {
            padding: 8px 20px;
            font-size: 0.9rem;
        }
        
        .pro-feature-card {
            padding: 12px;
        }
        
        .feature-text h5 {
            font-size: 0.85rem;
        }
        
        .feature-text p {
            font-size: 0.75rem;
        }
        
        .pro-visual {
            height: 250px;
        }
        
        .project-status-widget {
            top: 5px;
            right: 5px;
        }
        
        .status-card {
            min-width: 180px;
            padding: 15px;
        }
        
        .progress-chart {
            bottom: 5px;
            left: 5px;
            min-width: 160px;
            padding: 12px;
        }
        
        .person-head {
            width: 30px;
            height: 30px;
        }
        
        .person-body {
            width: 25px;
            height: 40px;
        }
        
        .laptop {
            width: 50px;
            height: 30px;
        }
    }

    /* Service Sections */
    .categories-section {
        margin-bottom: 40px;
    }

    .popular-services-section {
        margin-top: 20px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 30px;
        text-align: left;
    }

    /* Service Category Boxes Styling */
    .service-category-box {
        background: white;
        border-radius: 8px;
        padding: 10px;
        margin-top: 10px;
        margin-left: 5px;
        margin-right: 5px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15), 0 -2px 8px rgba(0,0,0,0.1), 2px 0 8px rgba(0,0,0,0.1), -2px 0 8px rgba(0,0,0,0.1);
        cursor: pointer;
        width: 120px;
        height: 90px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
    }

    .category-icon {
        font-size: 1.5rem;
        color: #000000;
        margin-bottom: 6px;
    }

    .category-text {
        font-size: 0.7rem;
        font-weight: 500;
        color: #333;
        margin: 0;
        line-height: 1.1;
        text-align: center;
    }

    .scroll-container {
        position: relative;
        overflow: hidden;
    }

    .scroll-wrapper {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 10px;
    }

    .scroll-wrapper::-webkit-scrollbar {
        display: none;
    }

    .scroll-wrapper {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    .popular-service-card {
        min-width: 200px;
        /* background: linear-gradient(135deg, #f39c12, #c51010, #152a70); */
        background-color: #152a70
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        flex-shrink: 0;
    }


    .service-image {
        height: 120px;
        overflow: hidden;
    }

    .service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .service-content {
        padding: 15px;
        color: white;
    }

    .service-name {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: white;
    }

    .scroll-arrow {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .scroll-arrow:hover {
        background: #f0f0f0;
        transform: translateY(-50%) scale(1.1);
    }

    .scroll-arrow i {
        color: #4CAF50;
        font-size: 1.2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .service-category-box {
            padding: 8px;
            width: 100px;
            height: 80px;
        }
        
        .category-icon {
            font-size: 1.3rem;
            margin-bottom: 4px;
        }
        
        .category-text {
            font-size: 0.65rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .popular-service-card {
            min-width: 180px;
        }
        
        .service-image {
            height: 100px;
        }
        
        .service-content {
            padding: 12px;
        }
        
        .service-name {
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
    }

    @media (max-width: 576px) {
        .service-category-box {
            padding: 6px;
            width: 85px;
            height: 70px;
        }
        
        .category-icon {
            font-size: 1.1rem;
            margin-bottom: 3px;
        }
        
        .category-text {
            font-size: 0.6rem;
        }
        
        .popular-service-card {
            min-width: 160px;
        }
        
        .service-image {
            height: 90px;
        }
        
        .service-content {
            padding: 10px;
        }
        
        .service-name {
            font-size: 0.8rem;
            margin-bottom: 6px;
        }
    }

    /* Expert Matching Section Styling */
    .expert-matching-section {
        background-color: #f8f9fa !important;
        padding: 80px 0 !important;
    }

    .expert-matching-card {
        background: linear-gradient(135deg, #15265c, #142351, #031958);
        border-radius: 20px;
        padding: 60px 50px;
        box-shadow: 0 20px 40px rgba(16, 32, 84, 0.3);
        position: relative;
        overflow: hidden;
        min-height: 400px;
    }

    .expert-matching-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        pointer-events: none;
    }

    .expert-content {
        position: relative;
        z-index: 2;
    }

    .expert-title {
        font-size: 3.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 25px;
        line-height: 1.1;
    }

    .expert-title-line1 {
        display: block;
        font-size: 2.8rem;
    }

    .expert-title-line2 {
        display: block;
        font-size: 3.2rem;
        font-weight: 800;
    }

    .expert-description {
        font-size: 1.3rem;
        color: white;
        margin-bottom: 35px;
        line-height: 1.5;
        opacity: 0.95;
    }

    .expert-btn {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        border: none;
        padding: 12px 28px;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 4px;
        transition: all 0.2s;
        line-height: 1.4;
        box-shadow: 0 4px 15px rgba(245, 156, 18, 0.3);
    }

    .expert-btn:hover {
        background: linear-gradient(135deg, #1a3585, #e01515, #ffa726);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(245, 156, 18, 0.4);
    }

    /* Right Side - Abstract Graphic */
    .expert-graphic {
        position: relative;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .graphic-container {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .graphic-layer {
        position: absolute;
        border-radius: 15px;
        opacity: 0.7;
    }

    .layer-1 {
        width: 280px;
        height: 200px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-5deg);
        z-index: 1;
    }

    .layer-2 {
        width: 320px;
        height: 240px;
        background: linear-gradient(135deg, #f093fb, #f5576c);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(3deg);
        z-index: 2;
    }

    .layer-3 {
        width: 360px;
        height: 280px;
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-2deg);
        z-index: 3;
    }

    .interface-element {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 200px;
        height: 120px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 4;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .interface-content {
        position: relative;
        width: 100%;
        height: 100%;
        padding: 20px;
    }

    .interface-dots {
        position: absolute;
        top: 15px;
        left: 20px;
        display: flex;
        gap: 5px;
    }

    .dot {
        width: 6px;
        height: 6px;
        background: #666;
        border-radius: 50%;
    }

    .interface-add-btn {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 30px;
        height: 30px;
        background: #333;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .expert-matching-card {
            padding: 40px 30px;
            margin: 20px 0;
            border-radius: 15px;
            min-height: 350px;
        }
        
        .expert-title {
            font-size: 2.5rem;
        }
        
        .expert-title-line1 {
            font-size: 2rem;
        }
        
        .expert-title-line2 {
            font-size: 2.3rem;
        }
        
        .expert-description {
            font-size: 1.1rem;
        }
        
        .expert-graphic {
            height: 300px;
        }
        
        .layer-1 {
            width: 220px;
            height: 160px;
        }
        
        .layer-2 {
            width: 250px;
            height: 190px;
        }
        
        .layer-3 {
            width: 280px;
            height: 220px;
        }
        
        .interface-element {
            width: 160px;
            height: 100px;
        }
    }

    @media (max-width: 576px) {
        .expert-matching-card {
            padding: 30px 20px;
            margin: 15px 0;
            border-radius: 12px;
            min-height: 300px;
        }
        
        .expert-title {
            font-size: 2rem;
        }
        
        .expert-title-line1 {
            font-size: 1.6rem;
        }
        
        .expert-title-line2 {
            font-size: 1.8rem;
        }
        
        .expert-description {
            font-size: 1rem;
            margin-bottom: 25px;
        }
        
        .expert-btn {
            padding: 10px 24px;
            font-size: 0.95rem;
        }
        
        .expert-graphic {
            height: 250px;
        }
        
        .layer-1 {
            width: 180px;
            height: 130px;
        }
        
        .layer-2 {
            width: 200px;
            height: 150px;
        }
        
        .layer-3 {
            width: 220px;
            height: 170px;
        }
        
        .interface-element {
            width: 140px;
            height: 85px;
        }
        
        .interface-content {
            padding: 15px;
        }
        
        .interface-add-btn {
            width: 25px;
            height: 25px;
            font-size: 12px;
        }
    }

    /* Explore Categories Section Styling */
    .explore-categories-section {
        background-color: white !important;
        padding: 80px 0 !important;
    }

    .section-header .section-title {
        font-size: 1.8rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 0;
    }

    /* Section title with horizontal line */
    .section-title-with-line {
        font-size: 1.5rem;
        font-weight: 600;
        color: #5d4037;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        position: relative;
    }

    .section-title-with-line i {
        color: #5d4037;
    }

    .title-content {
        background: white;
        padding-right: 20px;
        position: relative;
        z-index: 2;
    }

    .title-line {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(to right, #5d4037, transparent);
        z-index: 1;
    }

    .category-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        cursor: pointer;
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .category-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-image img {
        transform: scale(1.05);
    }

    .category-content {
        padding: 25px 20px;
        text-align: center;
    }

    .category-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .category-description {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }

    /* Custom 5-column layout for categories */
    @media (min-width: 992px) {
        .col-lg-custom-5 {
            flex: 0 0 auto;
            width: 20%;
            max-width: 20%;
        }
    }

    /* Square Category Cards */
    .category-wrapper {
        text-align: center;
        padding: 0 5px;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .category-wrapper:hover {
        transform: translateY(-3px);
    }

    .category-card-square {
        background: linear-gradient(135deg, #152a70, #1a3585);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        margin-bottom: 10px;
        width: 75%;
        margin-left: auto;
        margin-right: auto;
        transition: all 0.3s ease;
    }
    
    .category-card-square:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(21, 42, 112, 0.3);
    }

    .category-image-square {
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
        position: relative;
    }

    .category-image-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-title-outside {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        line-height: 1.2;
        text-align: center;
    }

    /* Launch Cards - Same size as Category Cards */
    .launch-wrapper {
        text-align: center;
        padding: 0 5px;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .launch-wrapper:hover {
        transform: translateY(-3px);
    }

    .launch-card-square {
        background: linear-gradient(135deg, #c51010, #e01515);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        margin-bottom: 10px;
        width: 75%;
        margin-left: auto;
        margin-right: auto;
        transition: all 0.3s ease;
    }
    
    .launch-card-square:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(197, 16, 16, 0.3);
    }

    .launch-image-square {
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
        position: relative;
    }

    .launch-image-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .launch-title-outside {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        line-height: 1.2;
        text-align: center;
    }

    /* Discover More Section Styling - Same size as Category Cards */
    .discover-more-section {
        background-color: white !important;
        padding: 80px 0 !important;
    }

    .discover-wrapper {
        text-align: center;
        padding: 0 5px;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .discover-wrapper:hover {
        transform: translateY(-3px);
    }

    .discover-card-square {
        background: linear-gradient(135deg, #f39c12, #ffa726);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        margin-bottom: 10px;
        width: 75%;
        margin-left: auto;
        margin-right: auto;
        transition: all 0.3s ease;
    }
    
    .discover-card-square:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(243, 156, 18, 0.3);
    }

    .discover-image-square {
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
        position: relative;
    }

    .discover-image-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .discover-title-outside {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        line-height: 1.2;
        text-align: center;
    }

    /* Top Services Section Styling - Same size as other cards */
    .top-services-wrapper {
        text-align: center;
        padding: 0 5px;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .top-services-wrapper:hover {
        transform: translateY(-3px);
    }

    .top-services-card-square {
        background: linear-gradient(135deg, #152a70, #c51010);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        margin-bottom: 10px;
        width: 75%;
        margin-left: auto;
        margin-right: auto;
        transition: all 0.3s ease;
    }
    
    .top-services-card-square:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(21, 42, 112, 0.3);
    }

    .top-services-image-square {
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
        position: relative;
    }

    .top-services-image-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .top-services-title-outside {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        line-height: 1.2;
        text-align: center;
    }

    /* Popular Picks Section Styling - Same size as other cards */
    .popular-picks-wrapper {
        text-align: center;
        padding: 0 5px;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .popular-picks-wrapper:hover {
        transform: translateY(-3px);
    }

    .popular-picks-card-square {
        background: linear-gradient(135deg, #c51010, #f39c12);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        margin-bottom: 10px;
        width: 75%;
        margin-left: auto;
        margin-right: auto;
        transition: all 0.3s ease;
    }
    
    .popular-picks-card-square:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(197, 16, 16, 0.3);
    }

    .popular-picks-image-square {
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
        position: relative;
    }

    .popular-picks-image-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .popular-picks-title-outside {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        line-height: 1.2;
        text-align: center;
    }

    /* Events Section - Exact Fiverr Style */
    .events-section {
        background-color: transparent !important;
        padding: 80px 0 !important;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: #666;
        margin-top: 10px;
        margin-bottom: 30px;
    }

    .fiverr-grid {
        gap: 20px;
    }
    
    /* Ensure events don't wrap on desktop */
    @media (min-width: 992px) {
        .events-section .fiverr-grid {
            flex-wrap: nowrap;
        }
        
        .events-section .col-lg-4 {
            flex: 0 0 auto;
            width: 33.333333%;
            max-width: 33.333333%;
        }
    }

    .fiverr-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        width: 100%;
        margin: 0 auto;
    }

    .fiverr-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .fiverr-image {
        position: relative;
        height: 240px;
        overflow: hidden;
        border-radius: 15px;
    }

    .fiverr-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .fiverr-card:hover .fiverr-image img {
        transform: scale(1.02);
    }

    .fiverr-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.7));
        display: flex;
        align-items: flex-end;
        opacity: 1;
        transition: all 0.3s ease;
        padding: 20px;
    }

    .fiverr-card:hover .fiverr-overlay {
        background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.85));
        opacity: 1;
    }

    .fiverr-content {
        color: white;
        width: 100%;
    }

    .fiverr-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .fiverr-description {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .fiverr-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .fiverr-date {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.8);
        font-weight: 500;
    }

    .fiverr-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: white;
    }

    .fiverr-btn {
        display: inline-block;
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        padding: 10px 18px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
        border: none;
        line-height: 1.4;
    }

    .fiverr-btn:hover {
        background: linear-gradient(135deg, #1a3585, #e01515, #ffa726);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        text-decoration: none;
    }

    /* FAQ Section Styles */
    .faq-section {
        background-color: white !important;
        padding: 80px 0 !important;
    }

    .faq-title {
        font-size: 2.5rem;
        font-weight: 400;
        color: #333;
        margin-bottom: 0;
        text-align: left;
    }

    .faq-container {
        max-width: 100%;
        margin: 0;
    }

    .accordion-item {
        border: none;
        margin-bottom: 0;
        border-radius: 0;
        overflow: visible;
        box-shadow: none;
        background: transparent;
        border-bottom: 1px solid #e0e0e0;
    }

    .accordion-button {
        background: transparent;
        border: none;
        padding: 20px 0;
        font-size: 1.1rem;
        font-weight: 400;
        color: #333;
        text-align: left;
        box-shadow: none;
        position: relative;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .accordion-button:not(.collapsed) {
        background: transparent;
        color: #333;
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: transparent;
    }

    .accordion-button::after {
        content: '+';
        font-family: Arial, sans-serif;
        font-weight: bold;
        font-size: 1.2rem;
        color: #000000;
        background-image: none;
        transition: all 0.3s ease;
        border: none;
        width: 20px;
        height: 20px;
        margin-left: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .accordion-button.collapsed::after {
        content: '+';
    }

    .accordion-button:not(.collapsed)::after {
        content: '−';
        transform: none;
    }

    .accordion-button[aria-expanded="true"]::after {
        content: '−';
        transform: none;
    }

    .accordion-button[aria-expanded="false"]::after {
        content: '+';
    }

    .accordion-body {
        padding: 20px 0 25px 0;
        background: transparent;
        color: #666;
        font-size: 1rem;
        line-height: 1.6;
        border-top: none;
    }

    /* Responsive Design for FAQ */
    @media (max-width: 768px) {
        .faq-section {
            padding: 60px 0 !important;
        }
        
        .faq-title {
            font-size: 2rem;
        }
        
        .accordion-button {
            padding: 15px 0;
            font-size: 1rem;
        }
        
        .accordion-body {
            padding: 15px 0 20px 0;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 576px) {
        .faq-section {
            padding: 40px 0 !important;
        }
        
        .faq-title {
            font-size: 1.8rem;
        }
        
        .accordion-button {
            padding: 12px 0;
            font-size: 0.95rem;
        }
        
        .accordion-body {
            padding: 12px 0 15px 0;
            font-size: 0.9rem;
        }
    }

    /* Why Choose Us Section - New Design */
    .why-choose-section {
        background: linear-gradient(135deg, rgba(21, 42, 112, 0.03), rgba(243, 156, 18, 0.03)) !important;
        padding: 50px 0 !important;
    }

    .why-choose-container {
        display: flex;
        align-items: center;
        gap: 40px;
        background: linear-gradient(to right, rgba(21, 42, 112, 0.08) 0%, rgba(21, 42, 112, 0.08) 55%, white 55%, white 100%);
        border-radius: 16px;
        padding: 40px 30px;
        box-shadow: 0 8px 30px rgba(21, 42, 112, 0.12);
        border: 1px solid rgba(21, 42, 112, 0.1);
    }

    .why-choose-left {
        flex: 1;
        padding-right: 20px;
    }

    .why-choose-title {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #152a70, #c51010);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 15px;
        text-align: left;
    }

    .why-choose-description {
        font-size: 1rem;
        color: #555;
        margin-bottom: 25px;
        line-height: 1.5;
        text-align: left;
    }

    .image-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        max-width: 350px;
    }

    .image-item {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(21, 42, 112, 0.15);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .image-item:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 5px 20px rgba(197, 16, 16, 0.2);
        border-color: rgba(243, 156, 18, 0.5);
    }

    .image-item img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        display: block;
    }

    .why-choose-right {
        flex: 1;
        padding-left: 20px;
    }

    .reason-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(21, 42, 112, 0.08);
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .reason-item:hover {
        transform: translateX(8px);
        box-shadow: 0 4px 15px rgba(197, 16, 16, 0.15);
        border-left-color: #c51010;
    }

    .reason-number {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
        box-shadow: 0 3px 12px rgba(197, 16, 16, 0.3);
    }

    .reason-content {
        flex: 1;
    }

    .reason-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: #152a70;
        margin-bottom: 8px;
    }

    .reason-description {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.5;
        margin: 0;
    }

    /* Responsive Design for Why Choose Us */
    @media (max-width: 992px) {
        .why-choose-container {
            flex-direction: column;
            gap: 30px;
            padding: 35px 25px;
            background: linear-gradient(to bottom, rgba(21, 42, 112, 0.08) 0%, rgba(21, 42, 112, 0.08) 50%, white 50%, white 100%);
        }
        
        .why-choose-left,
        .why-choose-right {
            padding: 0;
        }
        
        .why-choose-title {
            text-align: center;
            font-size: 1.8rem;
        }
        
        .why-choose-description {
            text-align: center;
        }
        
        .image-grid {
            max-width: 100%;
            margin: 0 auto;
        }
    }

    @media (max-width: 768px) {
        .why-choose-section {
            padding: 40px 0 !important;
        }
        
        .why-choose-container {
            padding: 25px 20px;
            background: linear-gradient(to bottom, rgba(21, 42, 112, 0.08) 0%, rgba(21, 42, 112, 0.08) 50%, white 50%, white 100%);
        }
        
        .why-choose-title {
            font-size: 1.6rem;
        }
        
        .image-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .image-item img {
            height: 140px;
        }
        
        .reason-item {
            padding: 12px;
            margin-bottom: 15px;
        }
        
        .reason-number {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        
        .reason-title {
            font-size: 1.05rem;
        }
        
        .reason-description {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .why-choose-section {
            padding: 30px 0 !important;
        }
        
        .why-choose-container {
            padding: 20px 15px;
        }
        
        .why-choose-title {
            font-size: 1.4rem;
        }
        
        .why-choose-description {
            font-size: 0.95rem;
        }
        
        .image-grid {
            gap: 10px;
        }
        
        .image-item img {
            height: 120px;
        }
        
        .reason-item {
            flex-direction: column;
            text-align: center;
            gap: 12px;
            padding: 15px;
        }
        
        .reason-number {
            align-self: center;
        }
    }

    /* Legacy styles for old structure (can be removed later) */
    .category-content-square {
        padding: 15px 10px;
        text-align: center;
    }

    .category-title-square {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        line-height: 1.3;
    }

    /* New Launches Section Styling */
    .new-launches-section {
        background-color: #f8f9fa !important;
        padding: 80px 0 !important;
    }

    .launch-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        cursor: pointer;
        position: relative;
    }

    .launch-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }

    .launch-image {
        height: 180px;
        overflow: hidden;
        position: relative;
    }

    .launch-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .launch-card:hover .launch-image img {
        transform: scale(1.08);
    }

    .launch-content {
        padding: 20px 18px;
        text-align: center;
    }

    .launch-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .launch-description {
        font-size: 0.9rem;
        color: #666;
        margin: 0;
        line-height: 1.4;
    }

    /* Interactive hover effect for launch cards */
    .launch-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,152,0,0.1), rgba(255,87,34,0.1));
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .launch-card:hover::after {
        opacity: 1;
    }

    /* Responsive Design for Categories and Launches */
    @media (max-width: 768px) {
        .explore-categories-section,
        .new-launches-section {
            padding: 60px 0 !important;
        }
        
        .section-header .section-title {
            font-size: 1.5rem;
        }
        
        .section-title-with-line {
            font-size: 1.5rem;
        }
        
        .category-card,
        .category-card-square,
        .launch-card {
            margin-bottom: 20px;
        }
        
        .category-image {
            height: 160px;
        }
        
        .category-title-square {
            font-size: 1rem;
        }
        
        .category-title-outside {
            font-size: 1rem;
        }
        
        .category-card-square {
            width: 65%;
        }
        
        .launch-card-square {
            width: 65%;
        }
        
        .launch-title-outside {
            font-size: 1rem;
        }
        
        .discover-more-section {
            padding: 60px 0 !important;
        }
        
        .discover-card-square {
            width: 65%;
        }
        
        .discover-title-outside {
            font-size: 1rem;
        }
        
        .events-section {
            padding: 60px 0 !important;
        }
        
        .fiverr-image {
            height: 250px;
        }
        
        .fiverr-overlay {
            padding: 15px;
        }
        
        .fiverr-title {
            font-size: 1.2rem;
        }
        
        .fiverr-description {
            font-size: 0.85rem;
        }
        
        .fiverr-price {
            font-size: 1.1rem;
        }
        
        .launch-image {
            height: 150px;
        }
        
        .category-content {
            padding: 20px 15px;
        }
        
        .launch-content {
            padding: 18px 15px;
        }
        
        .category-title {
            font-size: 1.2rem;
        }
        
        .launch-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .explore-categories-section,
        .new-launches-section {
            padding: 40px 0 !important;
        }
        
        .section-header .section-title {
            font-size: 1.3rem;
        }
        
        .section-title-with-line {
            font-size: 1.3rem;
        }
        
        .title-content {
            padding-right: 15px;
        }
        
        .category-image {
            height: 140px;
        }
        
        .launch-image {
            height: 130px;
        }
        
        .category-content {
            padding: 18px 12px;
        }
        
        .launch-content {
            padding: 15px 12px;
        }
        
        .category-title {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        
        .category-title-square {
            font-size: 0.9rem;
        }
        
        .category-title-outside {
            font-size: 0.9rem;
        }
        
        .category-card-square {
            width: 70%;
        }
        
        .launch-card-square {
            width: 70%;
        }
        
        .launch-title-outside {
            font-size: 0.9rem;
        }
        
        .discover-more-section {
            padding: 40px 0 !important;
        }
        
        .discover-card-square {
            width: 70%;
        }
        
        .discover-title-outside {
            font-size: 0.9rem;
        }
        
        .events-section {
            padding: 40px 0 !important;
        }
        
        .fiverr-image {
            height: 200px;
        }
        
        .fiverr-overlay {
            padding: 12px;
        }
        
        .fiverr-title {
            font-size: 1.1rem;
        }
        
        .fiverr-description {
            font-size: 0.8rem;
        }
        
        .fiverr-price {
            font-size: 1rem;
        }
        
        .fiverr-btn {
            padding: 8px 14px;
            font-size: 13px;
        }
        
        .launch-title {
            font-size: 1rem;
            margin-bottom: 6px;
        }
        
        .category-description,
        .launch-description {
            font-size: 0.85rem;
        }
    }

    /* Fiverr-Style Main Section Styles */
    .fiverr-style-main-section {
        padding: 80px 0;
        background-color: white;
    }

    .main-headline {
        font-size: 2.5rem;
        font-weight: 400;
        color: #333;
        margin-bottom: 0;
        line-height: 1.2;
    }

    .feature-block {
        padding: 20px 15px;
    }

    /* Fiverr Icon Container - Transparent background */
    .fiverr-icon-container {
        width: 100px;
        height: 100px;
        margin: 0;
        background: transparent;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Grid Plus Icon - Exact Fiverr Design */
    .grid-plus-icon-exact {
        display: grid;
        grid-template-rows: repeat(3, 1fr);
        gap: 2px;
        width: 40px;
        height: 40px;
    }

    .grid-row-exact {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2px;
    }

    .grid-square-exact {
        width: 12px;
        height: 12px;
        background-color: #333;
        border-radius: 0;
    }

    .plus-square-exact {
        background-color: #1DBF73;
        position: relative;
    }

    .plus-icon-exact {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 14px;
        font-weight: 600;
    }

    /* Circular Check Icon - Exact Fiverr Design */
    .circular-check-icon-exact {
        position: relative;
        width: 40px;
        height: 40px;
    }

    .arrow-circle-exact {
        width: 40px;
        height: 40px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .arrow-path-exact {
        position: absolute;
        width: 40px;
        height: 40px;
        border: 3px solid #333;
        border-radius: 50%;
        border-top-color: transparent;
        border-right-color: transparent;
        transform: rotate(-45deg);
    }

    .checkmark-exact {
        position: absolute;
        color: #333;
        font-size: 18px;
        font-weight: 600;
        z-index: 1;
    }

    /* Lightning Square Icon - Exact Fiverr Design */
    .lightning-square-icon-exact {
        width: 40px;
        height: 40px;
        border: 2px solid #333;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .lightning-bolt-exact {
        position: relative;
        width: 16px;
        height: 20px;
    }

    .bolt-top {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-bottom: 8px solid #333;
    }

    .bolt-middle {
        position: absolute;
        top: 8px;
        left: 50%;
        transform: translateX(-50%);
        width: 8px;
        height: 5px;
        background-color: #333;
    }

    .bolt-bottom {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 3px solid transparent;
        border-right: 5px solid transparent;
        border-top: 8px solid #333;
    }

    /* Speech Bubble Icon - Exact Fiverr Design */
    .speech-bubble-icon-exact {
        position: relative;
        width: 70px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 10px;
    }

    .bubble-left {
        position: relative;
        width: 28px;
        height: 28px;
        border: 2px solid #333;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4px;
    }

    .smiley-dot {
        width: 4px;
        height: 4px;
        background-color: #333;
        border-radius: 50%;
        margin: 1px 0;
    }

    .smiley-mouth {
        width: 10px;
        height: 4px;
        border-bottom: 2px solid #333;
        border-radius: 0 0 5px 5px;
        margin-top: 2px;
    }

    .bubble-right {
        position: relative;
        width: 28px;
        height: 28px;
        border: 2px solid #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dollar-sign-exact {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .feature-title {
        font-size: 1.1rem;
        font-weight: 400;
        color: #333;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main-headline {
            font-size: 2rem;
        }
        
        .feature-title {
            font-size: 1rem;
        }
        
        .fiverr-icon-container {
            width: 80px;
            height: 80px;
        }
        
        .grid-plus-icon-exact {
            width: 32px;
            height: 32px;
        }
        
        .circular-check-icon-exact {
            width: 32px;
            height: 32px;
        }
        
        .arrow-path-exact {
            width: 32px;
            height: 32px;
        }
        
        .lightning-square-icon-exact {
            width: 32px;
            height: 32px;
        }
        
        .speech-bubble-icon-exact {
            width: 56px;
            height: 32px;
        }
        
        .bubble-left,
        .bubble-right {
            width: 22px;
            height: 22px;
        }
    }

    @media (max-width: 576px) {
        .main-headline {
            font-size: 1.8rem;
        }
        
        .fiverr-style-main-section {
            padding: 60px 0;
        }
        
        .fiverr-icon-container {
            width: 70px;
            height: 70px;
        }
        
        .grid-plus-icon-exact {
            width: 28px;
            height: 28px;
        }
        
        .circular-check-icon-exact {
            width: 28px;
            height: 28px;
        }
        
        .arrow-path-exact {
            width: 28px;
            height: 28px;
        }
        
        .lightning-square-icon-exact {
            width: 28px;
            height: 28px;
        }
        
        .speech-bubble-icon-exact {
            width: 50px;
            height: 28px;
        }
        
        .bubble-left,
        .bubble-right {
            width: 20px;
            height: 20px;
        }
        
        .dollar-sign-exact {
            font-size: 12px;
        }
    }

    /* More FAQs Button Styles */
    .btn-outline-primary:hover {
        background-color: #1DBF73 !important;
        border-color: #1DBF73 !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(29, 191, 115, 0.3);
    }

    .btn-outline-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(29, 191, 115, 0.25);
    }
</style>
@endsection
@section('content')
	<main>
		<!-- Notification Section -->
		@if(session('warning'))
			<div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin: 0; border-radius: 0;">
				<div class="container">
					<strong>Notice:</strong> {{ session('warning') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			</div>
		@endif
		
		<div class="header-video">
			<div id="hero_video">
				<div class="opacity-mask d-flex align-items-center justify-content-start" data-opacity-mask="rgba(0, 0, 0, 0.3)">
					<div class="container">
						@foreach($banners as $banner)
						<div class="row justify-content-start text-start">
							<div class="col-xl-8 col-lg-10 col-md-10">
								<h1 class="fiverr-style-headline">{{ $banner->heading }}</h1>
								<p class="fiverr-style-subtitle">{{ $banner->sub_heading }}</p>
								
								<!-- Fiverr-style Search Bar -->
								<div class="fiverr-search-container">
									<div class="fiverr-search-box">
										<div class="search-input-wrapper">
											<input class="fiverr-search-input" type="text" id="serviceSearch" placeholder="Search for any service..." autocomplete="off">
											<div id="searchResults" class="position-absolute w-100 mt-1 d-none" style="z-index: 1050;">
												<!-- Search results will appear here -->
											</div>
										</div>
										<button type="submit" id="searchButton" class="fiverr-search-btn">
											<i class="fas fa-search"></i>
										</button>
									</div>
								</div>
								
								<!-- Fiverr-style Category Buttons -->
								<div class="fiverr-categories">
									<div class="category-row">
										<h5 class="trending-text">Popular:</h5>
										<div class="category-buttons">
											@foreach($services->take(5) as $service)
											<a href="{{ url('/service/' . $service->slug) }}" class="category-btn">
												{{ $service->name }}
												<i class="fas fa-arrow-right"></i>
											</a>
											@endforeach
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<!-- Video Tag to Add the Video -->
				@foreach($banners as $banner)
    <video class="header-video--media" autoplay loop muted>
        <source src="{{ asset('frontend/assets/video/hero-video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <!-- Fallback image for mobile -->
    <img src="{{ asset('frontend/assets/img/slides/slide_home_2.jpg') }}" class="mobile-video-fallback" >
@endforeach
		</div>
		<!-- /header-video -->
		
		<!-- Popular Services Section -->
		<section class="popular-services-main-section py-5" style="background-color: white;">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h2 class="popular-services-title">Popular services</h2>
						<div class="popular-services-scroll-container">
							<div class="popular-services-wrapper" id="popularServicesScroll">
								@foreach($services as $service)
								<!-- Service Card: {{ $service->name }} -->
								<a href="{{ route('service.show', $service->slug) }}" class="popular-service-card">
									<div class="service-content">
										<h3 class="service-title">{{ $service->name }}</h3>
									</div>
									<div class="service-graphic">
										<div class="service-mini-card">
											<img src="{{ $service->image ? asset('storage/' . $service->image) : asset('frontend/assets/img/new-icons/header-menu-icon/designer.png') }}" alt="{{ $service->name }}" class="service-image">
										</div>
									</div>
								</a>
								@endforeach
							</div>
							
							<button class="scroll-arrow-right" onclick="scrollPopularServices('right')">
								<i class="fas fa-chevron-right"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</section>
		
        
		<!-- Tazen Pro Section - Compact & Stylish -->
		<section class="tazen-pro-section-compact py-4" style="background: white;">
			<div class="container" style="max-width: 1200px;">
				<div class="pro-compact-card">
					<div class="row align-items-center g-4">
						
						<div class="col-lg-4">
							<div class="pro-branding">
								<div class="pro-logo-compact mb-3">
									<span class="brand-name-compact">tazen</span>
									<span class="pro-badge">PRO</span>
								</div>
								<p class="pro-subtitle">Enterprise solutions for modern businesses</p>
								<button class="btn-pro-cta">
									<span>Explore Pro</span>
									<i class="fas fa-arrow-right ms-2"></i>
								</button>
							</div>
						</div>
						
						<!-- Right Side - Feature Grid -->
						<div class="col-lg-8">
							<div class="pro-features-grid">
								<div class="pro-feature-card">
									<div class="feature-icon-box">
										<i class="fas fa-user-tie"></i>
									</div>
									<div class="feature-text">
										<h5>Dedicated Experts</h5>
										<p>Account managers for all your needs</p>
									</div>
								</div>
								
								<div class="pro-feature-card">
									<div class="feature-icon-box">
										<i class="fas fa-shield-alt"></i>
									</div>
									<div class="feature-text">
										<h5>100% Guarantee</h5>
										<p>Satisfaction or money back</p>
									</div>
								</div>
								
								<div class="pro-feature-card">
									<div class="feature-icon-box">
										<i class="fas fa-tools"></i>
									</div>
									<div class="feature-text">
										<h5>Advanced Tools</h5>
										<p>Seamless team integration</p>
									</div>
								</div>
								
								<div class="pro-feature-card">
									<div class="feature-icon-box">
										<i class="fas fa-wallet"></i>
									</div>
									<div class="feature-text">
										<h5>Flexible Payment</h5>
										<p>Project or hourly rates</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>


	<!-- Dynamic Category Sections - Loop through all CategoryBoxes -->
	@if(isset($categoryBoxes) && $categoryBoxes->count() > 0)
		@foreach($categoryBoxes as $index => $categoryBox)
			@if($categoryBox->subCategories->count() > 0)
				@php
					// Determine wrapper class based on index
					$wrapperClasses = ['category-wrapper', 'launch-wrapper', 'discover-wrapper', 'top-services-wrapper', 'popular-picks-wrapper'];
					$cardClasses = ['category-card-square', 'launch-card-square', 'discover-card-square', 'top-services-card-square', 'popular-picks-card-square'];
					$imageClasses = ['category-image-square', 'launch-image-square', 'discover-image-square', 'top-services-image-square', 'popular-picks-image-square'];
					$titleClasses = ['category-title-outside', 'launch-title-outside', 'discover-title-outside', 'top-services-title-outside', 'popular-picks-title-outside'];
					
					$wrapperClass = $wrapperClasses[$index % count($wrapperClasses)];
					$cardClass = $cardClasses[$index % count($cardClasses)];
					$imageClass = $imageClasses[$index % count($imageClasses)];
					$titleClass = $titleClasses[$index % count($titleClasses)];
				@endphp
				<section class="top-services-section py-3" style="background-color: white;">
					<div class="container" style="width: 90%; max-width: 1400px; margin: 0 auto;">
						<div class="section-header text-start mb-3">
							<h2 class="section-title-with-line">
								<span class="title-content">
									@if($categoryBox->icon_name)
										<i class="{{ $categoryBox->icon_name }} me-2"></i>
									@else
										<i class="fas fa-star me-2"></i>
									@endif
									{{ $categoryBox->name }}
								</span>
								<span class="title-line"></span>
							</h2>
						</div>
						
						<div class="row justify-content-center g-3">
							@foreach($categoryBox->subCategories as $subCategory)
								@php
									// Find matching SubService by name for filtering with flexible matching
									$subService = null;
									if ($subCategory->service_id) {
										// Try exact match first
										$subService = \App\Models\SubService::where('service_id', $subCategory->service_id)
											->where('name', $subCategory->name)
											->first();
										
										// If no exact match, try LIKE match
										if (!$subService) {
											$subService = \App\Models\SubService::where('service_id', $subCategory->service_id)
												->where('name', 'LIKE', '%' . $subCategory->name . '%')
												->first();
										}
										
										// If still no match, try reverse matching (subservice name contains category name)
										if (!$subService) {
											$subService = \App\Models\SubService::where('service_id', $subCategory->service_id)
												->whereRaw('? LIKE CONCAT("%", name, "%")', [$subCategory->name])
												->first();
										}
									}
									
									// Build URL with filters
									$urlParams = [];
									if ($subCategory->service_id) {
										$urlParams['service_id'] = $subCategory->service_id;
									}
									if ($subService) {
										$urlParams['sub_service_id'] = $subService->id;
									}
								@endphp
								<div class="col-lg-custom-5 col-md-4 col-sm-6 mb-3">
									<a href="{{ count($urlParams) > 0 ? route('gridlisting', $urlParams) : route('gridlisting') }}" style="text-decoration: none; color: inherit;" class="{{ $wrapperClass }}">
										<div class="{{ $cardClass }}">
											<div class="{{ $imageClass }}">
												@if($subCategory->image)
													<img src="{{ asset('storage/' . $subCategory->image) }}" alt="{{ $subCategory->name }}" class="img-fluid">
												@else
													<img src="{{ asset('frontend/assets/img/6.png') }}" alt="{{ $subCategory->name }}" class="img-fluid">
												@endif
											</div>
										</div>
										<h3 class="{{ $titleClass }}">{{ $subCategory->name }}</h3>
									</a>
								</div>
							@endforeach
						</div>
					</div>
				</section>
			@endif
		@endforeach
	@endif

	<!-- Fallback Static Section (Only shown if no CategoryBoxes exist) -->
	@if(!isset($categoryBoxes) || $categoryBoxes->count() == 0)
	<section class="top-services-section py-3" style="background-color: white;">
		<div class="container" style="width: 90%; max-width: 1400px; margin: 0 auto;">
			<div class="section-header text-start mb-3">
				<h2 class="section-title-with-line">
					<span class="title-content">
						<i class="fas fa-star me-2"></i>
						Astrology
					</span>
					<span class="title-line"></span>
				</h2>
			</div>
			
			<div class="row justify-content-center g-3">
			<div class="col-lg-custom-5 col-md-4 col-sm-6 mb-3">
				<a href="{{ route('gridlisting') }}" style="text-decoration: none; color: inherit;" class="discover-wrapper">
					<div class="discover-card-square">
						<div class="discover-image-square">
							<img src="{{ asset('frontend/assets/img/1.png') }}" alt="Tarot Reading" class="img-fluid">
						</div>
					</div>
					<h3 class="discover-title-outside">Tarot Reading</h3>
				</a>
			</div>
			
			<div class="col-lg-custom-5 col-md-4 col-sm-6 mb-3">
				<a href="{{ route('gridlisting') }}" style="text-decoration: none; color: inherit;" class="discover-wrapper">
					<div class="discover-card-square">
						<div class="discover-image-square">
							<img src="{{ asset('frontend/assets/img/13.png') }}" alt="Vedic Astrology" class="img-fluid">
						</div>
					</div>
					<h3 class="discover-title-outside">Vedic Astrology</h3>
				</a>
			</div>
			
			<div class="col-lg-custom-5 col-md-4 col-sm-6 mb-3">
				<a href="{{ route('gridlisting') }}" style="text-decoration: none; color: inherit;" class="discover-wrapper">
					<div class="discover-card-square">
						<div class="discover-image-square">
							<img src="{{ asset('frontend/assets/img/14.png') }}" alt="Numerology" class="img-fluid">
						</div>
					</div>
					<h3 class="discover-title-outside">Numerology</h3>
				</a>
			</div>
			
			<div class="col-lg-custom-5 col-md-4 col-sm-6 mb-3">
				<a href="{{ route('gridlisting') }}" style="text-decoration: none; color: inherit;" class="discover-wrapper">
					<div class="discover-card-square">
						<div class="discover-image-square">
							<img src="{{ asset('frontend/assets/img/15.png') }}" alt="Palmistry" class="img-fluid">
						</div>
					</div>
					<h3 class="discover-title-outside">Palmistry</h3>
				</a>
			</div>
			
			<div class="col-lg-custom-5 col-md-4 col-sm-6 mb-3">
				<a href="{{ route('gridlisting') }}" style="text-decoration: none; color: inherit;" class="discover-wrapper">
					<div class="discover-card-square">
						<div class="discover-image-square">
							<img src="{{ asset('frontend/assets/img/16.png') }}" alt="Crystal Ball Reading" class="img-fluid">
						</div>
					</div>
					<h3 class="discover-title-outside">Crystal Ball Reading</h3>
				</a>
			</div>
			</div>
		</div>
	</section>
@endif
		<!-- second popups  -->

		


		<!-- Why Choose Us Section - New Design -->
		<section class="why-choose-section py-4">
			<div class="container" style="width: 85%; max-width: 1200px; margin: 0 auto;">
				@foreach ($whychooses as $whychoose)
				<div class="why-choose-container">
					<div class="why-choose-left">
						<h2 class="why-choose-title">{{ $whychoose->section_heading }}</h2>
						<p class="why-choose-description">{{ $whychoose->section_sub_heading }}</p>
						
						<div class="image-grid">
							<div class="image-item">
								<img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=300&h=300&fit=crop&crop=center" alt="Professional Service 1" class="img-fluid">
							</div>
							<div class="image-item">
								<img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=center" alt="Professional Service 2" class="img-fluid">
							</div>
							<div class="image-item">
								<img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=center" alt="Professional Service 3" class="img-fluid">
							</div>
							<div class="image-item">
								<img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=300&h=300&fit=crop&crop=center" alt="Professional Service 4" class="img-fluid">
							</div>
						</div>
					</div>
					
					<div class="why-choose-right">
						<div class="reason-item">
							<div class="reason-number">01</div>
							<div class="reason-content">
								<h3 class="reason-title">{{ $whychoose->card1_heading }}</h3>
								<p class="reason-description">{{ $whychoose->card1_description }}</p>
							</div>
						</div>
						
						<div class="reason-item">
							<div class="reason-number">02</div>
							<div class="reason-content">
								<h3 class="reason-title">{{ $whychoose->card2_heading }}</h3>
								<p class="reason-description">{{ $whychoose->card2_description }}</p>
							</div>
						</div>
						
						<div class="reason-item">
							<div class="reason-number">03</div>
							<div class="reason-content">
								<h3 class="reason-title">{{ $whychoose->card3_heading }}</h3>
								<p class="reason-description">{{ $whychoose->card3_description }}</p>
							</div>
						</div>
						
						<div class="reason-item">
							<div class="reason-number">04</div>
							<div class="reason-content">
								<h3 class="reason-title">{{ $whychoose->card4_heading }}</h3>
								<p class="reason-description">{{ $whychoose->card4_description }}</p>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</section>
		<!-- end Why Choose Us Section -->


		<!-- /bg_gray -->

		<!-- Events Section - Fiverr Style -->
		<section class="events-section py-5" style="background-color: transparent;">
			<div class="container" style="width: 95%; max-width: 1600px; margin: 0 auto;">
				<div class="section-header text-start mb-5">
					<h2 class="section-title-with-line">
						<span class="title-content">
							<i class="fas fa-calendar-alt text-primary me-2"></i>
							Events
						</span>
						<span class="title-line"></span>
					</h2>
					<p class="section-subtitle">Stay Updated with the Latest Workshops, Webinars, and Expert-Led Sessions</p>
				</div>
				
			<div class="row fiverr-grid justify-content-center g-3">
				@php
					$displayedEvents = 0;
					$maxEventsToShow = 6;
				@endphp
				
				@foreach($eventDetails as $eventDetail)
					@if($displayedEvents < $maxEventsToShow)
					<div class="col-lg-4 col-md-6 col-sm-6 mb-4">
						<div class="fiverr-card">
							<div class="fiverr-image">
								@php
									// Determine image path based on creator type
									if ($eventDetail->creator_type === 'admin') {
										$imagePath = is_array($eventDetail->banner_image) && count($eventDetail->banner_image) > 0 
											? $eventDetail->banner_image[0] 
											: ($eventDetail->event->card_image ?? 'default-event.jpg');
									} else {
										$imagePath = $eventDetail->event->card_image ?? 'default-event.jpg';
									}
								@endphp
								<img src="{{ asset('storage/' . $imagePath) }}" 
									 data-src="{{ asset('storage/' . $imagePath) }}"
									 class="img-fluid" alt="{{ $eventDetail->event->heading }}">
									<div class="fiverr-overlay">
										<div class="fiverr-content">
											<h3 class="fiverr-title">{{ $eventDetail->event->heading }}</h3>
											<p class="fiverr-description">{{ $eventDetail->event->mini_heading }}</p>
											<div class="fiverr-meta-column">
												<div class="fiverr-meta-item">
													<span class="fiverr-price">₹{{ number_format($eventDetail->starting_fees, 2) }}</span>
												</div>
												<div class="fiverr-meta-item">
													@php
														$eventDate = $eventDetail->creator_type === 'admin' 
															? $eventDetail->event->date 
															: $eventDetail->starting_date;
													@endphp
													<span class="fiverr-date">{{ $eventDate ? \Carbon\Carbon::parse($eventDate)->format('d M, Y') : '-' }}</span>
												</div>
												@if($eventDetail->creator_type === 'professional')
													<div class="fiverr-meta-item">
														<span class="badge bg-info text-white">By {{ $eventDetail->professional->name ?? 'Professional' }}</span>
													</div>
												@else
													<div class="fiverr-meta-item">
														<span class="badge bg-primary text-white">By Admin</span>
													</div>
												@endif
												<div class="fiverr-meta-item fiverr-btn-container">
													<a href="{{ url('/allevent/' . $eventDetail->event_id) }}" class="fiverr-btn">View Event</a>
												</div>
											</div>
										</div>
									</div>
							</div>
						</div>
					</div>
					@php $displayedEvents++; @endphp
					@endif
				@endforeach
				
				
				@if($displayedEvents === 0)
					{{-- Show message when no events available --}}
					<div class="col-12 text-center py-5">
						<p class="text-muted">No events available at the moment. Check back soon!</p>
					</div>
				@endif
			</div>

				<div class="text-center mt-5">
					<a href="{{ route('event.list') }}" class="btn btn-view-all-events btn-lg" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12); color: white; border: none; border-radius: 4px; font-weight: 500; font-size: 1rem; transition: all 0.3s ease; text-decoration: none; padding: 12px 24px;">View All Events</a>
				</div>
			</div>
		</section>
		<!-- /container -->

        <!-- Fiverr-Style Expert Matching Section -->
		<section class="expert-matching-section py-5" style="background-color: #f8f9fa;">
			<div class="container" style="width: 80%; max-width: 1200px; margin: 0 auto;">
				<div class="expert-matching-card">
					<div class="row align-items-center">
						<!-- Left Side - Text Content -->
						<div class="col-lg-7">
							<div class="expert-content">
								<h1 class="expert-title">
									<span class="expert-title-line1">Need help with</span>
									<span class="expert-title-line2">Vibe coding?</span>
								</h1>
								<p class="expert-description">
									Get matched with the right expert to keep building and marketing your project
								</p>
								<div class="expert-button">
									<button class="btn expert-btn">Find an expert</button>
								</div>
							</div>
						</div>
						
						<!-- Right Side - Abstract Graphic -->
						<div class="col-lg-5">
							<div class="expert-graphic">
								<div class="graphic-container">
									<!-- Background gradient layers -->
									<div class="graphic-layer layer-1"></div>
									<div class="graphic-layer layer-2"></div>
									<div class="graphic-layer layer-3"></div>
									
									<!-- Main white interface element -->
									<div class="interface-element">
										<div class="interface-content">
											<div class="interface-dots">
												<span class="dot"></span>
												<span class="dot"></span>
												<span class="dot"></span>
											</div>
											<div class="interface-add-btn">
												<i class="fas fa-plus"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="bg_gray">
			<div class="container margin_60_40 how">
				@foreach($howworks as $howwork)
				<div class="main_title center">
					<span><em></em></span>
					<h2>How does it work?</h2>
					<p>{{ $howwork->section_sub_heading }}</p>
				</div>
				<div class="row justify-content-center align-items-center add_bottom_45">
					<div class="col-lg-5">
						<div class="box_about">
							<strong>1</strong>
							<h3>{{ $howwork->heading1 }}</h3>
							<p>{{ $howwork->description1 }}</p>
							<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="

								data-src="url('{{ asset('frontend/assets/img/services-pic/arrow_about.png') }}')" alt="" class="arrow_1 lazy">
						</div>
					</div>
					<div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
						<figure><img
							src="{{ asset('storage/'.$howwork->image1) }}" 
							data-src="{{ asset('storage/'.$howwork->image1) }}"  
							alt="How it works"
							class="img-fluid lazy"
							width="180"
							height="180">
						</figure>
					</div>
				</div>
				<!-- /row -->
				<div class="row justify-content-center align-items-center add_bottom_45">
					<div class="col-lg-5 pr-lg-5 text-center d-none d-lg-block">
						<figure><img
							src="{{ asset('storage/'.$howwork->image2) }}" 
							data-src="{{ asset('storage/'.$howwork->image2) }}"  
							alt="How it works"
							class="img-fluid lazy"
							width="180"
							height="180"></figure>
					</div>
					<div class="col-lg-5">
						<div class="box_about">
							<strong>2</strong>
							<h3>{{ $howwork->heading2 }}</h3>
							<p>{{ $howwork->description2 }}</p>
							<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
								data-src="img/services-pic/arrow_about.png" alt="" class="arrow_2 lazy">
						</div>
					</div>
				</div>
				<!-- /row -->
				<div class="row justify-content-center align-items-center add_bottom_25">
					<div class="col-lg-5">
						<div class="box_about">
							<strong>3</strong>
							<h3>{{ $howwork->heading3 }}</h3>
							<p>{{ $howwork->description3 }}</p>
						</div>
					</div>
					<div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
						<figure><img
							src="{{ asset('storage/'.$howwork->image3) }}" 
							data-src="{{ asset('storage/'.$howwork->image3) }}"  
							alt="How it works"
							class="img-fluid lazy"
							width="180"
							height="180"></figure>
					</div>
				</div>
				<!-- /row -->
				@endforeach
			</div>
			<!-- /container -->
		</div>
		<!-- /bg_gray -->

		<!-- Testimonial Section -->
		 <section class="ttm-row padding_top_zero-section ttm-bgcolor-white clearfix testimonial-new">
        <div class="container-fluid">
            <!-- Static heading and subheading -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 ttm-box-col-wrapper m-auto">
                    <div class="main_title center">
                        <span><em></em></span>
                        <h2>TESTIMONIALS</h2>
                        <p>What our clients say about us</p>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="owl-carousel services-carousal" id="testimonial-carousel">
                    @php
                        $totalSlides = 6; // Total slides to display
                        $testimonialCount = count($testimonials);
                    @endphp
    
                    @for($i = 0; $i < $totalSlides; $i++)
                        <div class="item">
                            <div class="testimonial-box">
                                @php
                                    $isEven = $i % 2 === 0;
                                @endphp
    
                                @if($i < $testimonialCount)
                                    {{-- Real testimonial --}}
                                    @php $t = $testimonials[$i]; @endphp
                                    @if($isEven)
                                        <div class="testimonial-content bg-lavender mb-15">
                                            <p class="text">{{ $t->description }}</p>
                                        </div>
                                        <div class="testimonial-img bg-blue">
                                            <img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image" style="width: 70%; height: 100%;">
                                        </div>
                                    @else
                                        <div class="testimonial-img bg-pink mb-15">
                                            <img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image" style="width: 70%; height: 100%;">
                                        </div>
                                        <div class="testimonial-content bg-green">
                                            <p class="text">{{ $t->description }}</p>
                                        </div>
                                    @endif
                                @else
                                    {{-- Dummy testimonial --}}
                                    @if($isEven)
                                        <div class="testimonial-content bg-lavender mb-15">
                                            This is a sample testimonial. Excellent service and support!
                                        </div>
                                        <div class="testimonial-img bg-blue">
                                            <img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image" style="width: 100%; height: auto;">
                                        </div>
                                    @else
                                        <div class="testimonial-img bg-pink mb-15">
                                            <img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image" style="width: 100%; height: auto;">
                                        </div>
                                        <div class="testimonial-content bg-green">
                                            <p class="text">This is a sample testimonial. Highly recommended!</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>


		<script>
			$(document).ready(function(){
				$("#testimonial-carousel").owlCarousel({
					loop: true,
					margin: 20,
					nav: true,
					dots: true,
					autoplay: true,
					autoplayTimeout: 3000,
					autoplayHoverPause: true,
					items: 4,
					responsive: {
						0: {
							items: 1
						},
						576: {
							items: 2
						},
						992: {
							items: 3
						},
						1200: {
							items: 4
						}
					}
				});
			});
		</script>


		<!-- Fiverr-Style Main Section -->
		<section class="fiverr-style-main-section py-5" style="background-color: white;">
			<div class="container" style="width: 80%; max-width: 1200px; margin: 0 auto;">
				<!-- Main Headline -->
				<div class="text-left mb-5">
					<h1 class="main-headline" style="font-size: 2.5rem; font-weight: 400; color: #333; margin-bottom: 0;">
						Make it all happen with freelancers
					</h1>
				</div>
				
				<!-- Feature Blocks -->
				<div class="row justify-content-center">
					<!-- Feature 1: Access to talent pool -->
					<div class="col-lg-3 col-md-6 col-sm-6 mb-4">
						<div class="feature-block text-left">
							<div class="feature-icon mb-2">
								<div class="fiverr-icon-container">
									<!-- Grid with plus icon - exact Fiverr design -->
									<div class="grid-plus-icon-exact">
										<div class="grid-row-exact">
											<div class="grid-square-exact"></div>
											<div class="grid-square-exact"></div>
											<div class="grid-square-exact"></div>
										</div>
										<div class="grid-row-exact">
											<div class="grid-square-exact"></div>
											<div class="grid-square-exact"></div>
											<div class="grid-square-exact"></div>
										</div>
										<div class="grid-row-exact">
											<div class="grid-square-exact"></div>
											<div class="grid-square-exact"></div>
											<div class="grid-square-exact plus-square-exact">
												<div class="plus-icon-exact">+</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<h4 class="feature-title" style="font-size: 1.1rem; font-weight: 400; color: #333; margin-bottom: 10px;">
								Access a pool of top talent across 700 categories
							</h4>
						</div>
					</div>
					
					<!-- Feature 2: Simple matching -->
					<div class="col-lg-3 col-md-6 col-sm-6 mb-4">
						<div class="feature-block text-left">
							<div class="feature-icon mb-2">
								<div class="fiverr-icon-container">
									<!-- Circular arrow with checkmark - exact Fiverr design -->
									<div class="circular-check-icon-exact">
										<div class="arrow-circle-exact">
											<div class="arrow-path-exact"></div>
											<div class="checkmark-exact">✓</div>
										</div>
									</div>
								</div>
							</div>
							<h4 class="feature-title" style="font-size: 1.1rem; font-weight: 400; color: #333; margin-bottom: 10px;">
								Enjoy a simple, easy-to-use matching experience
							</h4>
						</div>
					</div>
					
					<!-- Feature 3: Quality work quickly -->
					<div class="col-lg-3 col-md-6 col-sm-6 mb-4">
						<div class="feature-block text-left">
							<div class="feature-icon mb-2">
								<div class="fiverr-icon-container">
									<!-- Lightning bolt in square - exact Fiverr design -->
									<div class="lightning-square-icon-exact">
										<div class="lightning-bolt-exact">
											<div class="bolt-top"></div>
											<div class="bolt-middle"></div>
											<div class="bolt-bottom"></div>
										</div>
									</div>
								</div>
							</div>
							<h4 class="feature-title" style="font-size: 1.1rem; font-weight: 400; color: #333; margin-bottom: 10px;">
								Get quality work done quickly and within budget
							</h4>
						</div>
					</div>
					
					<!-- Feature 4: Pay when happy -->
					<div class="col-lg-3 col-md-6 col-sm-6 mb-4">
						<div class="feature-block text-left">
							<div class="feature-icon mb-2">
								<div class="fiverr-icon-container">
									<!-- Speech bubble with smiley and dollar - exact Fiverr design -->
									<div class="speech-bubble-icon-exact">
										<div class="bubble-left">
											<div class="smiley-dot"></div>
											<div class="smiley-dot"></div>
											<div class="smiley-mouth"></div>
										</div>
										<div class="bubble-right">
											<div class="dollar-sign-exact">$</div>
										</div>
									</div>
								</div>
							</div>
							<h4 class="feature-title" style="font-size: 1.1rem; font-weight: 400; color: #333; margin-bottom: 10px;">
								Only pay when you're happy
							</h4>
						</div>
					</div>
				</div>
				
				<!-- Join Now Button -->
				<div class="text-center mt-4">
					<button class="btn btn-join-style px-4 py-2" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12); color: white; border: none; border-radius: 4px; font-weight: 500; font-size: 1rem; transition: all 0.3s ease; text-decoration: none;">
						Join now
					</button>
				</div>
			</div>
		</section>

		<!-- blog -->
		<div class="full-row bg-light py-5 home-blog-section">
			<div class="container">
				<div class="row heading">
					<div class="col ">
						<div class="main_title center ">
							<span><em></em></span>
							<h2>Our Recent Blogs</h2>
							<p>Explore our blogs</p>
						</div>
					</div>
				</div>
				<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
					@foreach ($blogPosts as $blogPost)
						<div class="col-sm-12">
							<div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
								<a href="{{ route('blog.show', \Illuminate\Support\Str::slug($blogPost->blog->title)) }}">
									<div class="post-image position-relative overlay-secondary" style="height: 200px; overflow: hidden;">
										<img src="{{ asset('storage/' . $blogPost->image) }}" alt="Blog Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
									</div>
								</a>
								<div class="post-content p-35">
									<h5 class="d-block font-400 mb-3">
											<a href="{{ route('blog.show', \Illuminate\Support\Str::slug($blogPost->blog->title)) }}" class="transation text-dark hover-text-primary">
											{{ $blogPost->blog->title }}
										</a>
									</h5>
									<p>{{ $blogPost->blog->description_short }}</p>
									<div class="post-meta text-uppercase">
										<a href="#"><span>{{ $blogPost->blog->created_by }}</span></a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				

				<div class="button-div">
					<a href="{{ route('blog.index') }}" class="btn_1 medium" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12);">Discover More</a>
				</div>

			</div>
		</div>
		<!-- end blog  -->

		

		<!-- FAQ Section -->
		<section class="faq-section py-5" style="background-color: white;">
			<div class="container" style="width: 80%; max-width: 1200px; margin: 0 auto;">
				<div class="section-header text-start mb-5">
					<h2 class="faq-title">FAQ</h2>
				</div>
				
				<div class="faq-container">
					<div class="accordion" id="faqAccordion">
						@if($faqs->count() > 0)
							@foreach($faqs as $faq)
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading{{ $faq->id }}">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
									{{ $faq->question }}
								</button>
							</h2>
							<div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
								<div class="accordion-body">
									{{ $faq->answer }}
								</div>
							</div>
						</div>
							@endforeach
						@else
							<!-- Default FAQs if none exist in database -->
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading1">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
									What are the benefits of outsourcing financial services?
								</button>
							</h2>
							<div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
								<div class="accordion-body">
									Outsourcing financial services provides cost savings, access to specialized expertise, improved efficiency, and allows you to focus on core business activities while ensuring compliance and accuracy in financial management.
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="heading2">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
									How do I choose the right financial consultant for my business?
								</button>
							</h2>
							<div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
								<div class="accordion-body">
									Look for consultants with relevant experience in your industry, proper certifications, positive client reviews, clear communication skills, and a proven track record of helping businesses achieve their financial goals.
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="heading3">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
									Do I need to prepare something for my financial consultant?
								</button>
							</h2>
							<div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
								<div class="accordion-body">
									Yes, prepare your financial statements, tax returns, business plans, bank statements, and any specific questions or goals you want to discuss. The more organized your information, the better advice you'll receive.
								</div>
							</div>
						</div>
						@endif
					</div>
				</div>
				
				<!-- More FAQs Button -->
				<div class="text-center mt-5">
					<a href="{{ url('/help') }}" class="btn_1 medium" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12);">
						More FAQs
					</a>
				</div>
			</div>
		</section>
		<!-- end FAQ Section -->

		<section style="background-color: #ffd41473;">
			<div class="call_section version_2 lazy">
				<div class="container clearfix">
					<div class="row">
						<div class=" col-md-6  wow">
							<img src="{{ asset('frontend/assets/img/are-you-pro.png')}}" alt="">
						</div>
						<div class=" col-md-6  wow">
							<div class="box_1">
								<div class="ribbon_promo"></div>
								<h4>Are you a Professional?</h4>
								<p>Join Us to increase your online visibility. You'll have access to even more customers
									who are looking to professional service or consultation.</p>
								<a href="submit-professional.html" class="new-unique-btn">Read more</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

	</main>

    @endsection
	@section('script')
	<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script>
$(document).ready(function(){
  $('.testimonial_slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    autoplay: true,
    autoplaySpeed: 3000,
  });
});
</script>
	<script>
// Simple service selection function for index page
function selectServiceAndRedirect(serviceId, serviceName) {
    // Save service ID and name in session for later use
    fetch('/set-service-session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            service_id: serviceId,
            service_name: serviceName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Redirect to professionals listing page
            window.location.href = '/professionals';
        } else {
            console.error('Failed to save service session');
            // Even if session save fails, still redirect
            window.location.href = '/professionals';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Even if session save fails, still redirect
        window.location.href = '/professionals';
    });
}
</script>
		
	<script>
		// Combined Live Search and Find Button functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('serviceSearch');
    const searchResults = document.getElementById('searchResults');
    const searchButton = document.getElementById('searchButton');
    const searchForm = searchInput.closest('form');
    let searchTimeout;
    let currentResults = [];

    // Prevent form submission
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleSearchButtonClick();
        });
    }

    // Find button click event
    searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        handleSearchButtonClick();
    });

    // Function to handle Find button click
    function handleSearchButtonClick() {
        const query = searchInput.value.trim();
        
        // Changed from query.length < 2 to query.length < 1
        if (query.length < 1) {
            toastr.warning('Please enter at least 1 character to search');
            return;
        }
        
        // If we already have results from typing, use the first result
        if (currentResults.length > 0) {
            window.location.href = `/service/${currentResults[0].slug}`;
            return;
        }
        
        // Otherwise, perform a search and navigate to first result
        searchButton.disabled = true;
        searchButton.value = 'Searching...';
        
        fetch(`/search-services?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                searchButton.disabled = false;
                searchButton.value = 'Find';
                
                if (data.services && data.services.length > 0) {
                    // If there's an exact match, go to that
                    const exactMatch = data.services.find(service => 
                        service.name.toLowerCase() === query.toLowerCase());
                    
                    if (exactMatch) {
                        window.location.href = `/service/${exactMatch.slug}`;
                    } else {
                        // Otherwise go to first result
                       window.location.href = `/service/${data.services[0].slug}`;
                    }
                } else {
                    toastr.error('No matching services found. Please try a different search term.');
                }
            })
            .catch(error => {
                console.error('Error searching:', error);
                searchButton.disabled = false;
                searchButton.value = 'Find';
                toastr.error('An error occurred while searching. Please try again.');
            });
    }

    // Function to fetch search results for the dropdown
    function fetchSearchResults(query) {
        // Changed from query.length < 2 to query.length < 1
        if (query.length < 1) {
            searchResults.classList.add('d-none');
            searchResults.innerHTML = '';
            currentResults = [];
            return;
        }

        fetch(`/search-services?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                // Store results for later use by the Find button
                currentResults = data.services || [];
                
                if (currentResults.length > 0) {
                    // Display search results
                    searchResults.classList.remove('d-none');
                    searchResults.innerHTML = `
                        <div class="list-group shadow">
                            ${currentResults.map(service => `
                                <a href="/service/${service.slug}" class="list-group-item list-group-item-action">
                                    ${service.name}
                                </a>
                            `).join('')}
                        </div>
                    `;
                } else {
                    // No results found
                    searchResults.classList.remove('d-none');
                    searchResults.innerHTML = `
                        <div class="list-group shadow">
                            <div class="list-group-item text-muted">No result found</div>
                        </div>
                    `;
                }
                
                // Ensure proper positioning
                searchResults.style.left = '0';
                searchResults.style.right = 'auto';
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                currentResults = [];
                searchResults.classList.add('d-none');
            });
    }

    // Search input event for live results
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Set new timeout for debounce
        searchTimeout = setTimeout(() => {
            fetchSearchResults(query);
        }, 300);
    });

    // Handle keyboard navigation in search results
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !searchResults.classList.contains('d-none')) {
            e.preventDefault();
            
            // Find the first result link and navigate to it
            const firstResult = searchResults.querySelector('.list-group-item');
            if (firstResult && firstResult.href) {
                window.location.href = firstResult.href;
            } else {
                // If no results are visible, trigger the Find button
                handleSearchButtonClick();
            }
        }
    });

    // Hide results when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.classList.add('d-none');
        }
    });

    // Show results when input is focused
    searchInput.addEventListener('focus', function() {
        // Changed from this.value.trim().length >= 2 to this.value.trim().length >= 1
        if (this.value.trim().length >= 1) {
            fetchSearchResults(this.value.trim());
        }
    });
});

	</script>

	<!-- FAQ Accordion JavaScript -->
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Get all accordion buttons
		const accordionButtons = document.querySelectorAll('.accordion-button');
		
		// Add click event listeners to each button
		accordionButtons.forEach(function(button) {
			button.addEventListener('click', function() {
				// Toggle the collapsed class
				this.classList.toggle('collapsed');
				
				// Update aria-expanded attribute
				const isExpanded = this.getAttribute('aria-expanded') === 'true';
				this.setAttribute('aria-expanded', !isExpanded);
				
				// Force icon update by triggering a reflow
				const afterElement = window.getComputedStyle(this, '::after');
				this.style.setProperty('--icon-content', afterElement.content);
			});
		});
	});
	</script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
	<script>
		// Categories scroll functionality
		function scrollCategories(direction) {
			const scrollContainer = document.querySelector('#categoriesScroll');
			const scrollAmount = 300;
			
			if (direction === 'right') {
				scrollContainer.scrollBy({
					left: scrollAmount,
					behavior: 'smooth'
				});
			} else if (direction === 'left') {
				scrollContainer.scrollBy({
					left: -scrollAmount,
					behavior: 'smooth'
				});
			}
		}

		// Popular Services scroll functionality
		function scrollPopularServices(direction) {
			const scrollContainer = document.querySelector('#popularServicesScroll');
			const scrollAmount = 300;
			
			if (direction === 'right') {
				scrollContainer.scrollBy({
					left: scrollAmount,
					behavior: 'smooth'
				});
			} else if (direction === 'left') {
				scrollContainer.scrollBy({
					left: -scrollAmount,
					behavior: 'smooth'
				});
			}
		}

		// Services scroll functionality
		function scrollServices(direction) {
			const scrollContainer = document.querySelector('#servicesScroll');
			const scrollAmount = 300;
			
			if (direction === 'right') {
				scrollContainer.scrollBy({
					left: scrollAmount,
					behavior: 'smooth'
				});
			} else if (direction === 'left') {
				scrollContainer.scrollBy({
					left: -scrollAmount,
					behavior: 'smooth'
				});
			}
		}

		// Auto scroll functionality for services with infinite loop
		function autoScrollServices() {
			const scrollContainer = document.querySelector('#servicesScroll');
			if (!scrollContainer) return;
			
			const scrollAmount = 220; // Width of one service card + gap
			const halfWidth = scrollContainer.scrollWidth / 2; // Half of total width (since we duplicated)
			
			// If we've scrolled past the first set, reset to beginning seamlessly
			if (scrollContainer.scrollLeft >= halfWidth - 10) {
				scrollContainer.scrollTo({
					left: 0,
					behavior: 'auto' // Instant reset for seamless loop
				});
			} else {
				scrollContainer.scrollBy({
					left: scrollAmount,
					behavior: 'smooth'
				});
			}
		}

		// Start auto scroll when page loads
		document.addEventListener('DOMContentLoaded', function() {
			// Auto scroll every 3 seconds
			setInterval(autoScrollServices, 3000);
		});
	</script>
 @endsection


<style>
.carousel-arrow {
    transition: background 0.2s;
}
.carousel-arrow:hover {
    background: #f0f0f0;
}
@media (max-width: 991px) {
    .carousel-arrow.left-arrow { left: 0; }
    .carousel-arrow.right-arrow { right: 0; }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var $carousel = $('.services-carousal');
    $('.left-arrow').on('click', function() {
        $carousel.trigger('prev.owl.carousel');
    });
    $('.right-arrow').on('click', function() {
        $carousel.trigger('next.owl.carousel');
    });
});
</script>
