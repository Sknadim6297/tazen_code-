@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/detail-page.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
     <style>
        /* Global Styles */
        body {
            background: linear-gradient(135deg, #1741cabc, #d379038c, #ece00586);
            background-size: 400% 400%;
            animation: gradientBG 18s ease infinite;
            min-height: 100vh;
            
            line-height: 1.6;
            color: #333;
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

        .container.margin_detail {
            background: transparent !important;
            box-shadow: none !important;
        }

        .box_general,
        .main_info_wrapper,
        .tabs_detail,
        .box_booking,
        .appointment_types {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 32px !important;
            margin-top: 20px;

            padding: 0;
            
        }


        .dropdown a {
            padding: 0;
            line-height: 1;
            color: #444;
            font-weight: 500;
            display: block;
            position: relative;
        }
        /* Header Section */
        .profile-header-flex {
            display: flex;
            align-items: flex-start;
            gap: 36px;
            margin-bottom: 32px;
            padding: 32px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            flex-wrap: wrap;
        }

        .profile-main-image {
            width: 320px;
            height: 320px;
            border-radius: 14px;
            object-fit: cover;
            object-position: center;
            box-shadow: 0 2px 16px rgba(0,0,0,0.10);
            background: #f8f8f8;
            border: 4px solid #f0f0f0;
            flex-shrink: 0;
        }

        .profile-header-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-width: 300px;
        }

        .profile-header-details h3 {
            margin-bottom: 8px;
            font-size: 2rem;
            font-weight: 700;
            color: #2a2a2a;
        }

        .profile-header-details p {
            margin-bottom: 8px;
            color: #666;
            font-size: 1.1rem;
        }

        .tags.no_margin {
            margin-left: -40px;
        }

        .tag-btn {
            display: inline-block;
            background: #f0f4ff;
            color: #2563eb;
            border-radius: 16px;
            padding: 5px 14px;
            font-size: 0.98rem;
            font-weight: 600;
            margin-right: 8px;
            margin-bottom: 8px;
            border: none;
            cursor: default;
            transition: background 0.2s;
        }

        .score_in {
            margin-top: 15px;
        }

        /* About Section */
        .main_info_wrapper {
            margin-bottom: 30px;
        }

        .user_desc h4 {
            font-size: 1.5rem;
            color: #2a2a2a;
            margin-bottom: 15px;
        }

        .user_desc p {
            color: #555;
            margin-bottom: 15px;
        }

        .show_hide {
            color: #00a6eb;
            font-weight: 600;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }

        /* Tabs Section */
        .tabs_detail {
            margin-bottom: 30px;
        }

        .nav-tabs {
            border-bottom: 2px solid #f0f0f0;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 600;
            padding: 12px 20px;
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: #00a6eb;
            background: transparent;
            border-bottom: 2px solid #00a6eb;
        }

        .tab-content {
            padding: 20px 0;
        }

        /* Appointment Types */
        .appointment_types {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .appointment_types .nav-tabs {
            padding: 0 15px;
        }

        .appointment-details {
            text-align: center;
            padding: 15px;
        }

        .appointment-details h4 {
            color: #2a2a2a;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.25rem;
        }

        .appointment-details p {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .appointment-features {
            text-align: left;
            margin: 0 auto 20px;
            padding: 0;
            max-width: 280px;
        }

        .appointment-features li {
            list-style: none;
            padding: 8px 0;
            color: #555;
            font-size: 14px;
            position: relative;
            padding-left: 25px;
        }

        .appointment-features i {
            color: #00a6eb;
            position: absolute;
            left: 0;
            top: 10px;
        }

        .price {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .price strong {
            color: #00a6eb;
            font-size: 22px;
            font-weight: 700;
            display: block;
        }

        .price small {
            color: #6c757d;
            font-size: 13px;
        }

        /* Booking Section */
        .box_booking {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 25px;
        }

        .box_booking .head {
            margin-bottom: 20px;
        }

        .box_booking .head h3 {
            font-size: 1.5rem;
            color: #2a2a2a;
        }

        #selected-plan-display {
            display: none;
            margin-bottom: 20px;
            padding: 15px;
            background: #f0f9ff;
            border-left: 4px solid #00a6eb;
            border-radius: 5px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Buttons */
        .select-plan, .btn_1 {
            background: #00a6eb;
            color: white;
            border: none;
            transition: all 0.3s ease;
            padding: 12px 15px;
            font-weight: 600;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            display: block;
            margin-top: 10px;
        }

        .select-plan:hover, .btn_1:hover {
            background: #0088c6;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 166, 235, 0.3);
            color: white;
            text-decoration: none;
        }

        .booking {
            margin-top: 20px;
        }

        /* Calendar */
        #calendarDiv {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .flatpickr-day.selected {
            border: 2px solid black !important;
            box-sizing: border-box;
        }

        .flatpickr-day:hover {
            border: 2px solid #000;
        }

        .flatpickr-day.today {
            border: 1px solid #ccc;
        }

        /* Time Slots */
        .dropdown.time {
            width: 100%;
        }

        .dropdown-menu-content {
            padding: 15px;
        }

        .radio_select.time {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .slot-box {
            flex: 0 0 calc(50% - 5px);
            display: none;
        }

        .slot-box label {
            display: block;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .slot-box input[type="radio"]:checked + label {
            background: #00a6eb;
            color: white;
        }

        /* Reviews */
        .review_card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .rating i {
            color: #ffb700;
        }

        /* Gallery */
        .gallery-container {
            margin-top: 20px;
        }

        .gallery-item img {
            transition: transform 0.3s;
            cursor: pointer;
        }

        .gallery-item img:hover {
            transform: scale(1.02);
        }


        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .profile-main-image {
                width: 280px;
                height: 280px;
            }
        }

        @media (max-width: 992px) {
            .profile-header-flex {
                gap: 24px;
                padding: 24px;
            }
            
            .profile-main-image {
                width: 220px;
                height: 220px;
            }
            
            .profile-header-details h3 {
                font-size: 1.5rem;
            }

            .container.margin_detail {
                margin-top: 80px;
            }
        }

        @media (max-width: 768px) {
            .container.margin_detail {
                padding: 8px;
            }
            .row {
                flex-direction: column;
            }
            .col-xl-8.col-lg-7, .col-xl-4.col-lg-5 {
                max-width: 100%;
                flex: 0 0 100%;
                width: 100%;
            }
            
            /* Mobile order: Move About me section after profile header */
            .profile-header-flex {
                order: 1;
            }
            .main_info_wrapper {
                order: 2;
            }
            
            /* Mobile order: Move appointment types after box_general */
            .box_general {
                order: 1;
            }
            .tabs_detail {
                order: 3;
            }
            
            /* Move appointment types out of right column to appear after box_general */
            .appointment_types {
                order: 2;
                margin-bottom: 20px;
            }
            .box_booking:not(.appointment_types) {
                order: 4;
            }
            .social-share-section {
                order: 5;
            }
            
            /* Ensure parent containers use flexbox for ordering to work */
            .row {
                display: flex;
                flex-direction: column;
            }
            
            .col-xl-8.col-lg-7 {
                display: flex;
                flex-direction: column;
            }
            
            .col-xl-4.col-lg-5 {
                display: flex;
                flex-direction: column;
            }
            
            /* Mobile layout restructuring */
            .row {
                display: flex;
                flex-direction: column;
            }
            
            .col-xl-8.col-lg-7 {
                order: 1;
                display: flex;
                flex-direction: column;
            }
            
            .col-xl-4.col-lg-5 {
                order: 2;
                display: flex;
                flex-direction: column;
            }
            
            /* Move appointment types to appear after profile section but before tabs */
            .appointment_types {
                order: 2;
                margin-bottom: 20px;
                margin-top: 20px;
                position: relative;
                z-index: 10;
            }
            
            .box_general {
                order: 1;
            }
            
            .tabs_detail {
                order: 3;
            }
            
            .box_booking:not(.appointment_types) {
                order: 4;
            }
            
            .social-share-section {
                order: 5;
            }
            
            /* Force appointment types to appear after profile section using absolute positioning */
            .col-xl-4.col-lg-5 .appointment_types {
                position: relative;
                order: 2 !important;
                margin-bottom: 20px;
                margin-top: 20px;
            }
            
            /* Ensure proper ordering within columns */
            .col-xl-8.col-lg-7 > * {
                order: 1;
            }
            
            .col-xl-8.col-lg-7 .tabs_detail {
                order: 3;
            }
            
            .col-xl-4.col-lg-5 > *:not(.appointment_types) {
                order: 3;
            }
            
            /* Mobile layout with mobile appointment types section */
            .row {
                display: flex;
                flex-direction: column;
            }
            
            .col-xl-8.col-lg-7 {
                order: 1;
            }
            
            .col-xl-4.col-lg-5 {
                order: 2;
            }
            
            /* Show mobile appointment types and hide desktop version on mobile */
            .mobile-appointment-types {
                display: block !important;
                margin-bottom: 20px;
                margin-top: 20px;
                background: #ffffff !important;
                border-radius: 12px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
            }
            
            /* Mobile appointment types header styling */
            .mobile-appointment-types h3 {
                background: linear-gradient(135deg, #6f42c1, #e83e8c) !important;
                color: white !important;
                padding: 16px 20px !important;
                margin: 0 0 20px 0 !important;
                border-radius: 12px 12px 0 0 !important;
                font-size: 18px !important;
                font-weight: 600 !important;
                text-align: center !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
                position: relative !important;
                overflow: hidden !important;
            }
            
            .mobile-appointment-types h3::before {
                content: '⏰' !important;
                margin-right: 8px !important;
                font-size: 20px !important;
            }
            
            /* Show mobile booking section and hide desktop version on mobile */
            .mobile-booking-section {
                display: block !important;
                margin-bottom: 20px;
                margin-top: 20px;
            }
            
            /* Mobile booking section header */
            .mobile-booking-section h3 {
                background: linear-gradient(135deg, #fd7e14, #dc3545) !important;
                color: white !important;
                padding: 16px 20px !important;
                margin: 0 0 20px 0 !important;
                border-radius: 12px 12px 0 0 !important;
                font-size: 18px !important;
                font-weight: 600 !important;
                text-align: center !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
            }
            
            .mobile-booking-section h3::before {
                content: '📅' !important;
                margin-right: 8px !important;
                font-size: 20px !important;
            }
            
            /* Hide original appointment types and booking on mobile */
            .col-xl-4.col-lg-5 .appointment_types {
                display: none !important;
            }
            
            .col-xl-4.col-lg-5 .box_booking:not(.appointment_types) {
                display: none !important;
            }
            
            /* Ensure other sections appear in correct order */
            .tabs_detail {
                order: 3;
            }
            
            .social-share-section {
                order: 4;
            }
            
            .profile-header-flex {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 18px;
                padding: 14px;
            }
            .profile-main-image {
                width: 160px;
                height: 160px;
                margin: 0 auto 12px auto;
            }
            .profile-header-details {
                text-align: center;
                align-items: center;
                min-width: unset;
            }
            .profile-header-details h3 {
                font-size: 1.2rem;
            }
            .tags.no_margin {
                margin-left: 0 !important;
                justify-content: center;
            }
            .profile-badges.mb-2 {
                flex-direction: column;
                gap: 8px;
                width: 100%;
            }
            .badge-square {
                width: 100% !important;
                min-width: 0;
                height: 48px !important;
                font-size: 0.85rem !important;
            }
            .main_info_wrapper {
                padding: 16px 8px 12px 8px !important;
            }
            .tabs_detail .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 5px;
            }
            .tabs_detail .nav-item {
                display: inline-block;
                float: none;
            }
            .tab-pane-container .card-body {
                padding: 10px 4px;
            }
            .appointment_types .nav-tabs {
                flex-direction: row;
                overflow-x: auto;
                gap: 2px;
            }
            .appointment_types .nav-link {
                padding: 8px 6px;
                font-size: 12px;
            }
            .appointment-details {
                padding: 8px;
            }
            .appointment-details h4 {
                font-size: 1rem;
            }
            .price strong {
                font-size: 1.1rem;
            }
            .box_booking {
                margin-top: 16px;
                padding: 10px;
            }
            .gallery-container .row {
                flex-direction: column;
            }
            .gallery-item img {
                width: 100%;
                height: auto;
            }
            .share-buttons {
                display: flex;
                flex-direction: column;
                gap: 8px;
                align-items: stretch;
                margin-top: 16px;
            }
            .share-buttons li {
                width: 100%;
            }
            .share-buttons a {
                width: 100%;
                text-align: center;
                padding: 10px 0;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .profile-main-image {
                width: 120px;
                height: 120px;
            }
            .profile-header-details h3 {
                font-size: 1rem;
            }
            .profile-header-details p {
                font-size: 0.95rem;
            }
            .tag-btn {
                font-size: 0.85rem;
                padding: 3px 8px;
                margin-right: 4px;
                margin-bottom: 4px;
            }
            .appointment_types .nav-link {
                padding: 6px 3px;
                font-size: 11px;
            }
            .appointment-features {
                max-width: 100%;
            }
            .select-plan, .btn_1 {
                padding: 12px 16px !important;
                font-size: 14px !important;
                min-height: 44px !important;
                min-width: 44px !important;
                border-radius: 8px !important;
                touch-action: manipulation !important;
                user-select: none !important;
                -webkit-touch-callout: none !important;
                -webkit-user-select: none !important;
                transition: all 0.2s ease !important;
                cursor: pointer !important;
            }
            
            .select-plan:active, .btn_1:active {
                transform: scale(0.98) !important;
                background: #0056b3 !important;
                color: white !important;
            }
            
            /* Mobile Book Now button styling */
            #mobile-bookNowBtn {
                background: linear-gradient(135deg, #28a745, #20c997) !important;
                color: white !important;
                border: none !important;
                padding: 16px 24px !important;
                font-size: 16px !important;
                font-weight: 600 !important;
                border-radius: 12px !important;
                text-align: center !important;
                text-decoration: none !important;
                display: block !important;
                margin: 20px 0 !important;
                min-height: 56px !important;
                line-height: 1.2 !important;
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
                transition: all 0.3s ease !important;
                position: relative !important;
                overflow: hidden !important;
            }
            
            #mobile-bookNowBtn:hover, #mobile-bookNowBtn:active {
                background: linear-gradient(135deg, #218838, #1e7e34) !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4) !important;
                color: white !important;
                text-decoration: none !important;
            }
            
            #mobile-bookNowBtn:active {
                transform: translateY(0) scale(0.98) !important;
            }
            
            /* Better time slot styling for mobile */
            .time-slot + label, .mobile-time-slot + label {
                min-height: 48px !important;
                min-width: 100px !important;
                padding: 12px 16px !important;
                font-size: 14px !important;
                font-weight: 500 !important;
                border-radius: 8px !important;
                border: 2px solid #e9ecef !important;
                background: #ffffff !important;
                color: #495057 !important;
                touch-action: manipulation !important;
                user-select: none !important;
                cursor: pointer !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                transition: all 0.2s ease !important;
                margin: 4px !important;
                text-align: center !important;
                white-space: nowrap !important;
                overflow: visible !important;
                position: relative !important;
                z-index: 1 !important;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
            }
            
            .time-slot + label:hover, .mobile-time-slot + label:hover {
                border-color: #007bff !important;
                background: #f8f9ff !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 4px 8px rgba(0,123,255,0.2) !important;
            }
            
            /* Mobile time slot container improvements */
            .mobile-appointment-types .slot-box {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                align-items: center !important;
                margin: 8px 0 !important;
                padding: 4px !important;
                min-height: 60px !important;
                background: #f8f9fa !important;
                border-radius: 8px !important;
                border: 1px solid #e9ecef !important;
            }
            
            /* Fix hidden/covered time slots */
            .mobile-appointment-types .tab-content {
                padding: 16px !important;
                background: #ffffff !important;
                border-radius: 0 0 12px 12px !important;
                min-height: 300px !important;
                overflow: visible !important;
            }
            
            .mobile-appointment-types .tab-pane {
                padding: 16px 8px !important;
                overflow: visible !important;
            }
            
            .time-slot:checked + label, .mobile-time-slot:checked + label {
                background: #007bff !important;
                color: white !important;
                border-color: #0056b3 !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 8px rgba(0,123,255,0.3) !important;
            }
            
            .slot-box {
                flex: 0 0 100%;
                margin-bottom: 8px !important;
            }
            .container.margin_detail {
                margin-top: 50px;
                padding: 8px;
            }
            
            .box_booking {
                padding: 16px;
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                margin-bottom: 16px;
            }
            
            /* Mobile booking section main container */
            .mobile-booking-section .main {
                padding: 20px 16px !important;
                background: #ffffff !important;
                border-radius: 0 0 12px 12px !important;
            }
            
            /* Mobile appointment types main container */
            .mobile-appointment-types {
                background: #ffffff !important;
                border-radius: 12px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
                margin-bottom: 20px !important;
            }
            .modal-dialog {
                max-width: 98vw;
                margin: 0 auto;
            }
            .modal-content {
                border-radius: 10px;
                padding: 6px;
            }
        }

        @media (max-width: 400px) {
            .profile-main-image {
                width: 90px;
                height: 90px;
            }
            .profile-header-details h3 {
                font-size: 0.9rem;
            }
            .appointment_types .nav-link {
                padding: 8px 4px;
                font-size: 12px;
                min-height: 36px;
            }
            .container.margin_detail {
                margin-top: 30px;
                padding: 4px;
            }
            
            /* Ultra mobile responsive */
            .mobile-appointment-types .nav-tabs .nav-link {
                font-size: 11px !important;
                padding: 8px 10px !important;
                min-width: 70px !important;
                min-height: 36px !important;
            }
            
            .time-slot + label, .mobile-time-slot + label {
                min-width: 80px !important;
                font-size: 12px !important;
                padding: 10px 12px !important;
                min-height: 40px !important;
            }
            
            #mobile-selected-plan-display {
                padding: 12px 16px !important;
                font-size: 14px !important;
            }
            
            #mobile-bookNowBtn {
                padding: 14px 20px !important;
                font-size: 15px !important;
                min-height: 50px !important;
            }
        }

        @media (max-width: 600px) {
            .appointment-tabs {
                flex-direction: column !important;
                gap: 0 !important;
            }
            .appointment-tabs .nav-link {
                border-radius: 8px 8px 0 0 !important;
                margin-bottom: 6px !important;
                padding: 3px 9px !important;
                font-size: 1rem !important;
            }
            .appointment-tab-content {
                padding: 18px 8px 14px 8px !important;
            }
            .appointment-details h4 {
                font-size: 1.1rem !important;
            }
            .appointment-details .price strong {
                font-size: 1.3rem !important;
            }
        }

        .tab-pane-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-top: 0;
            margin-bottom: 24px;
            padding: 0;
            border: none;
        }
        .tab-pane-container .card-body {
            padding: 28px 24px;
        }
        @media (max-width: 768px) {
            .tab-pane-container .card-body {
                padding: 16px 8px;
            }
        }

        .session-type-tabs .nav-link.active {
            background: #2563eb !important;
            color: #fff !important;
            border: 1px solid #2563eb !important;
            box-shadow: 0 2px 8px rgba(37,99,235,0.08);
            z-index: 2;
        }
        .session-type-tabs .nav-link {
            background: #f4f7fa;
            color: #2563eb;
            border: 1px solid #e0e7ef;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.2s, color 0.2s;
        }
        .session-type-tabs .nav-link:not(.active):hover {
            background: #e0e7ef;
            color: #1741a6;
        }
        @media (max-width: 600px) {
            .session-type-tabs {
                flex-direction: column !important;
                gap: 6px !important;
            }
            .session-type-tabs .nav-link {
                padding: 10px 0 !important;
                font-size: 1rem !important;
            }
        }
        .margin_detail {
            padding-top: 122px;
            padding-bottom: 15px;
        }
    </style>
    <style>
        /* Client Requirements Styles */
        .client_requirements {
            margin-bottom: 20px;
            line-height: 1.7;
            color: #444;
        }
        
        .client_requirements p {
            margin-bottom: 15px;
        }
        
        /* Global Styles */
        body {
            background-color: #f8f9fa;
            
            line-height: 1.6;
            color: #333;
        }

        .container.margin_detail {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-top: 100px;
            margin-bottom: 40px;
        }

        /* Header Section */
        .profile-header-flex {
            display: flex;
            align-items: flex-start;
            gap: 36px;
            margin-bottom: 32px;
            padding: 32px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            flex-wrap: wrap;
        }

        .profile-main-image {
            width: 320px;
            height: 320px;
            border-radius: 14px;
            object-fit: cover;
            object-position: center;
            box-shadow: 0 2px 16px rgba(0,0,0,0.10);
            background: #f8f8f8;
            border: 4px solid #f0f0f0;
            flex-shrink: 0;
        }

        .profile-header-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-width: 300px;
        }

        .profile-header-details h3 {
            margin-bottom: 8px;
            font-size: 2rem;
            font-weight: 700;
            color: #2a2a2a;
        }

        .profile-header-details p {
            margin-bottom: 8px;
            color: #666;
            font-size: 1.1rem;
        }

        .tags.no_margin {
            margin-left: -40px;
        }

        .tag-btn {
            display: inline-block;
            background: #f0f4ff;
            color: #2563eb;
            border-radius: 16px;
            padding: 5px 14px;
            font-size: 0.98rem;
            font-weight: 600;
            margin-right: 8px;
            margin-bottom: 8px;
            border: none;
            cursor: default;
            transition: background 0.2s;
        }

        .score_in {
            margin-top: 15px;
        }

        /* About Section */
        .main_info_wrapper {
            margin-bottom: 30px;
        }

        .user_desc h4 {
            font-size: 1.5rem;
            color: #2a2a2a;
            margin-bottom: 15px;
        }

        .user_desc p {
            color: #555;
            margin-bottom: 15px;
        }

        .show_hide {
            color: #00a6eb;
            font-weight: 600;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }

        /* Tabs Section */
        .tabs_detail {
            margin-bottom: 30px;
        }

        .nav-tabs {
            border-bottom: 2px solid #f0f0f0;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 600;
            padding: 12px 20px;
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: #00a6eb;
            background: transparent;
            border-bottom: 2px solid #00a6eb;
        }

        .tab-content {
            padding: 20px 0;
        }

        /* Appointment Types */
        .appointment_types {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .appointment_types .nav-tabs {
            padding: 0 15px;
        }

        .appointment-details {
            text-align: center;
            padding: 15px;
        }

        .appointment-details h4 {
            color: #2a2a2a;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.25rem;
        }

        .appointment-details p {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .appointment-features {
            text-align: left;
            margin: 0 auto 20px;
            padding: 0;
            max-width: 280px;
        }

        .appointment-features li {
            list-style: none;
            padding: 8px 0;
            color: #555;
            font-size: 14px;
            position: relative;
            padding-left: 25px;
        }

        .appointment-features i {
            color: #00a6eb;
            position: absolute;
            left: 0;
            top: 10px;
        }

        .price {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .price strong {
            color: #00a6eb;
            font-size: 22px;
            font-weight: 700;
            display: block;
        }

        .price small {
            color: #6c757d;
            font-size: 13px;
        }

        /* Booking Section */
        .box_booking {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 25px;
        }

        .box_booking .head {
            margin-bottom: 20px;
        }

        .box_booking .head h3 {
            font-size: 1.5rem;
            color: #2a2a2a;
        }

        #selected-plan-display {
            display: none;
            margin-bottom: 20px;
            padding: 15px;
            background: #f0f9ff;
            border-left: 4px solid #00a6eb;
            border-radius: 5px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Buttons */
        .select-plan, .btn_1 {
            background: #00a6eb;
            color: white;
            border: none;
            transition: all 0.3s ease;
            padding: 12px 15px;
            font-weight: 600;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            display: block;
            margin-top: 10px;
        }

        .select-plan:hover, .btn_1:hover {
            background: #0088c6;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 166, 235, 0.3);
            color: white;
            text-decoration: none;
        }

        .booking {
            margin-top: 20px;
        }

        /* Calendar */
        #calendarDiv {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .flatpickr-day.selected {
            border: 2px solid black !important;
            box-sizing: border-box;
        }

        .flatpickr-day:hover {
            border: 2px solid #000;
        }

        .flatpickr-day.today {
            border: 1px solid #ccc;
        }

        /* Time Slots */
        .dropdown.time {
            width: 100%;
        }

        .dropdown-menu-content {
            padding: 15px;
        }

        .radio_select.time {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .slot-box {
            flex: 0 0 calc(50% - 5px);
            display: none;
        }

        .slot-box label {
            display: block;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .slot-box input[type="radio"]:checked + label {
            background: #00a6eb;
            color: white;
        }

        /* Reviews */
        .review_card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .rating i {
            color: #ffb700;
        }

        /* Gallery */
        .gallery-container {
            margin-top: 20px;
        }

        .gallery-item img {
            transition: transform 0.3s;
            cursor: pointer;
        }

        .gallery-item img:hover {
            transform: scale(1.02);
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .profile-main-image {
                width: 280px;
                height: 280px;
            }
        }

        @media (max-width: 992px) {
            .profile-header-flex {
                gap: 24px;
                padding: 24px;
            }
            
            .profile-main-image {
                width: 240px;
                height: 240px;
            }
            
            .profile-header-details h3 {
                font-size: 1.8rem;
            }

            .container.margin_detail {
                margin-top: 80px;
            }
        }

        @media (max-width: 768px) {
            .profile-header-flex {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 18px;
                padding: 20px;
            }
            
            .profile-main-image {
                width: 200px;
                height: 200px;
                margin: 0 auto;
            }
            
            .profile-header-details {
                text-align: center;
                align-items: center;
            }
            
            .profile-header-details h3 {
                font-size: 1.6rem;
            }
            
            .tags.no_margin {
                margin-left: 0 !important;
                justify-content: center;
            }
            
            .appointment_types .nav-link {
                padding: 10px 8px;
                font-size: 13px;
            }
            
            .appointment-details h4 {
                font-size: 1.1rem;
            }
            
            .price strong {
                font-size: 20px;
            }
            
            .box_booking {
                margin-top: 20px;
            }
            
            .tabs_detail .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 5px;
            }
            
            .tabs_detail .nav-item {
                display: inline-block;
                float: none;
            }

            .container.margin_detail {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            .profile-main-image {
                width: 160px;
                height: 160px;
            }
            
            .profile-header-details h3 {
                font-size: 1.4rem;
            }
            
            .profile-header-details p {
                font-size: 1rem;
            }
            
            .tag-btn {
                font-size: 0.9rem;
                padding: 4px 12px;
                margin-right: 6px;
                margin-bottom: 6px;
            }
            
            .appointment_types .nav-link {
                padding: 8px 6px;
                font-size: 12px;
            }
            
            .appointment-features {
                max-width: 100%;
            }
            
            .select-plan, .btn_1 {
                padding: 10px 12px;
                font-size: 14px;
            }
            
            .slot-box {
                flex: 0 0 100%;
            }

            .container.margin_detail {
                margin-top: 70px;
            }
        }

        @media (max-width: 400px) {
            .profile-main-image {
                width: 140px;
                height: 140px;
            }
            
            .profile-header-details h3 {
                font-size: 1.3rem;
            }
            
            .appointment_types .nav-link {
                padding: 6px 4px;
                font-size: 11px;
            }

            .container.margin_detail {
                margin-top: 60px;
                padding: 10px;
            }
        }

        @media (max-width: 600px) {
            .appointment-tabs {
                flex-direction: column !important;
                gap: 0 !important;
            }
            .appointment-tabs .nav-link {
                border-radius: 8px 8px 0 0 !important;
                margin-bottom: 6px !important;
                padding: 3px 9px !important;
                font-size: 1rem !important;
            }
            .appointment-tab-content {
                padding: 18px 8px 14px 8px !important;
            }
            .appointment-details h4 {
                font-size: 1.1rem !important;
            }
            .appointment-details .price strong {
                font-size: 1.3rem !important;
            }
        }

        .tab-pane-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-top: 0;
            margin-bottom: 24px;
            padding: 0;
            border: none;
        }
        .tab-pane-container .card-body {
            padding: 28px 24px;
        }
        @media (max-width: 768px) {
            .tab-pane-container .card-body {
                padding: 16px 8px;
            }
        }

        .slot-booked::after {
            content: "BOOKED";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 3px;
            white-space: nowrap;
            z-index: 2;
        }
        
        /* Styles for selected booking items */
        #selected-time-list {
            list-style: none;
            padding: 0;
            margin-top: 15px;
        }

        .selected-booking-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #e9f5ff;
            border: 1px solid #cce5ff;
            padding: 8px 12px;
            margin-bottom: 8px;
            border-radius: 5px;
            font-size: 0.95rem;
            color: #333;
        }

        .remove-booking-item {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0 5px;
            transition: color 0.2s;
        }

        .remove-booking-item:hover {
            color: #b02a37;
        }

        /* Login Popup Styles */
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

        /* Social Share Section Styles */
        .social-share-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .social-share-section h6 {
            color: #495057 !important;
            margin-bottom: 15px !important;
        }

        .social-share-section .share-buttons {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .social-share-section .share-buttons li {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .social-share-section .share-buttons a {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
            background: white;
            color: #495057;
        }

        .social-share-section .share-buttons a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-decoration: none;
        }

        .social-share-section .share-buttons .fb-share:hover {
            background-color: #1877f2;
            border-color: #1877f2;
            color: white;
        }

        .social-share-section .share-buttons .twitter-share:hover {
            background-color: #000000;
            border-color: #000000;
            color: white;
        }

        .social-share-section .share-buttons .whatsapp-share:hover {
            background-color: #25d366;
            border-color: #25d366;
            color: white;
        }

        .social-share-section .share-buttons .instagram-share:hover {
            background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
            border-color: #bc1888;
            color: white;
        }

        .social-share-section .share-buttons .copy-link:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        /* Professional Image Optimization */
        .profile-main-image,
        .professional-image-optimized {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            image-rendering: optimizeQuality;
            object-fit: cover;
            object-position: center;
        }

        /* Ensure consistent image dimensions and cropping */
        .profile-main-image {
            width: 320px !important;
            height: 320px !important;
        }

        /* Grid listing image consistency */
        .strip figure img {
            object-fit: cover !important;
            object-position: center !important;
            width: 100% !important;
            height: 200px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container margin_detail">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="box_general">
                    <div class="profile-header-flex">
                        @php
                            $profileImage = $profile && $profile->photo ? $profile->photo : null;
                            $imageUrl = $profileImage && file_exists(public_path('storage/' . $profileImage)) 
                                ? asset('storage/' . $profileImage) 
                                : asset('frontend/assets/img/lazy-placeholder.png');
                        @endphp
                        <img src="{{ $imageUrl }}" alt="" class="profile-main-image">
                        <div class="profile-header-details">
                                                    @php
                                    $fullName = trim($profile->name ?? '');
                                    $nameParts = preg_split('/\s+/', $fullName);
                                    if (!$fullName) {
                                        $displayName = '';
                                    } elseif (count($nameParts) === 1) {
                                        $displayName = $nameParts[0];
                                    } else {
                                        $surname = end($nameParts);
                                        $displayName = $nameParts[0] . ' ' . strtoupper(substr($surname, 0, 1)) . '.';
                                    }

                                    // Safe number formatter: strips non-numeric chars and returns formatted number or escaped raw value
                                    $fmt = function($val, $decimals = 2) {
                                        $raw = (string) $val;
                                        $sanitized = preg_replace('/[^\d.\-]/', '', $raw);
                                        if (is_numeric($sanitized)) {
                                            return number_format((float) $sanitized, (int) $decimals);
                                        }
                                        // If not numeric, return the escaped raw value
                                        return e($raw);
                                    };
                                @endphp
                                  <h3 id="professional_name">{{ $displayName }}</h3>
                            <div id="professional_address" style="color:#666; font-size:1rem; margin-bottom:8px;">
                                <i class="icon_pin_alt me-1"></i>
                                {{ $profile->full_address ?? $profile->address ?? 'Address not available' }}
                            </div>
                            @if(!empty($profile->specialization))
                                @php
                                    $specializations = is_array($profile->specialization) ? $profile->specialization : explode(',', $profile->specialization);
                                @endphp
                                <div style="color:#2563eb; font-weight:500; font-size:1.05rem; margin-bottom:4px;">
                                    <i class="icon_document_alt me-1"></i>
                                    Specializations: {{ !empty($specializations) ? implode(', ', array_map('trim', $specializations)) : 'Not specified' }}
                                </div>
                            @else
                                <div style="color:#888; font-size:1.05rem; margin-bottom:4px;">
                                    <i class="icon_document_alt me-1"></i>
                                    Specializations: Not specified
                                </div>
                            @endif
                            @if(!empty($profile->education))
                                @php
                                    $educationList = is_array($profile->education) ? $profile->education : explode(',', $profile->education);
                                @endphp
                                <div style="color:#2563eb; font-size:1.05rem; margin-bottom:8px;">
                                    <i class="icon_graduation me-1"></i>
                                    Education: {{ !empty($educationList) ? implode(', ', array_map('trim', $educationList)) : 'Not specified' }}
                                </div>
                            @else
                                <div style="color:#888; font-size:1.05rem; margin-bottom:8px;">
                                    <i class="icon_graduation me-1"></i>
                                    Education: Not specified
                                </div>
                            @endif
                            <div class="profile-badges mb-2" style="display:flex; gap:12px; margin-bottom:16px;">
                                <span class="badge-square" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:139px; height:60px; background:#e0f7fa; color:#00796b; border-radius:12px; font-weight:600; font-size:0.75rem;">
                                    <i class="fas fa-thumbs-up mb-1" style="font-size:1.3rem;"></i>
                                    Most Helpful
                                </span>
                                <span class="badge-square" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:139px; height:60px; background:#fff3e0; color:#ef6c00; border-radius:12px; font-weight:600; font-size:0.75rem;">
                                    <i class="fas fa-bolt mb-1" style="font-size:1.3rem;"></i>
                                    Very Responsive
                                </span>
                                <span class="badge-square" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:139px; height:60px; background:#e8eaf6; color:#3949ab; border-radius:12px; font-weight:600; font-size:0.75rem;">
                                    <i class="fas fa-user-tie mb-1" style="font-size:1.3rem;"></i>
                                    Top Professional
                                </span>
                            </div>
                            <ul class="tags no_margin" style="margin-bottom: 8px;">
                                @if($services && $services->tags)
                                    @foreach(explode(',', $services->tags) as $tag)
                                        <li style="display:inline; list-style:none; padding:0; margin:0;">
                                            <span class="tag-btn">{{ trim($tag) }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li><span class="tag-btn" style="background:#eee; color:#888;">No tags available</span></li>
                                @endif
                            </ul>
                            
                            @if(!empty($profile->experience))
                                <div class="profile-experience" style="margin-bottom: 10px; color: #444; font-weight: 500; font-size: 1.08rem;">
                                    <i class="icon_briefcase" style="margin-right: 6px;"></i>{{ $profile->experience }} experience
                                </div>
                            @else
                                <div class="profile-experience" style="margin-bottom: 10px; color: #888; font-size: 1.08rem;">
                                    <i class="icon_briefcase" style="margin-right: 6px;"></i>Experience not specified
                                </div>
                            @endif
                            @if(!empty($profile->starting_price))
                                <div class="profile-price" style="margin-bottom: 10px; color: #1a8917; font-weight: 600; font-size: 1.08rem;">
                                    <i class="fas fa-wallet" style="margin-right: 6px;"></i>From ₹{{ $profile->starting_price }}
                                </div>
                            @else
                                <div class="profile-price" style="margin-bottom: 10px; color: #888; font-size: 1.08rem;">
                                    <i class="fas fa-wallet" style="margin-right: 6px;"></i>Price not specified
                                </div>
                            @endif
                            <div class="score_in">
                                <div class="rating">
                                    <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                                </div>
                                <a href="#0" class="wish_bt" aria-label="Add to wish list"><i class="icon_heart_alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="main_info_wrapper" style="padding: 32px 28px 24px 28px; margin-bottom: 28px; margin-top: 8px; border-radius: 12px;">
                        <div class="main_info clearfix">
                            <div class="user_desc">
                                <h4 style="margin-bottom: 18px; font-size: 1.35rem; font-weight: 700; color: #222;">Professional Statement</h4>
                                @php
                                    $bioText = strip_tags($profile->bio); 
                                    $limit = 250;
                                @endphp
                                @if(strlen($bioText) > $limit)
                                    <p id="bio-short" style="margin-bottom: 10px; color: #555;">{{ Str::limit($bioText, $limit, '...') }}</p>
                                    <div id="bio-full" style="display: none; margin-bottom: 10px; color: #555;">
                                        {!! $profile->bio !!}
                                    </div>
                                    <a href="javascript:void(0)" class="show_hide" id="toggle-bio" style="margin-top: 8px; display: inline-block;">Read More</a>
                                @else
                                    <p style="color: #555;">{!! $profile->bio !!}</p>
                                @endif
                            </div>
                        </div>
                        <hr style="margin-top: 24px; margin-bottom: 0;">
                    </div>
                    
                    <!-- Mobile Appointment Types Section (appears after profile section) -->
                    <div class="box_booking appointment_types mobile-appointment-types" style="display: none;">
                        <div class="tabs">
                            <ul class="nav nav-tabs appointment-tabs" role="tablist" style="border-bottom:none; gap: 8px;">
                                @foreach($rates as $rate)
                                    @php
                                        $safeId = strtolower(str_replace(' ', '_', $rate->session_type));
                                    @endphp
                                    <li class="nav-item" style="margin-bottom:0;">
                                        <a class="nav-link @if($loop->first) active @endif" id="mobile-{{ $safeId }}-tab" data-bs-toggle="tab" href="#mobile-{{ $safeId }}" role="tab" style="font-weight:600; border-radius: 8px 8px 0 0; padding: 3px 9px; border: 1px solid #e0e7ef; background: @if($loop->first) #2563eb @else #f7f9fc @endif; color: @if($loop->first) #fff @else #222 @endif; transition: background 0.2s, color 0.2s;">
                                            {{ ucfirst($rate->session_type) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content appointment-tab-content" style="background:#f7f9fc; border-radius:0 0 12px 12px; padding:32px 28px 24px 28px; margin-top:-2px; border:1px solid #e0e7ef;">
                                @foreach($rates as $rate)
                                    @php
                                        $safeId = strtolower(str_replace(' ', '_', $rate->session_type));
                                    @endphp
                                    <div class="tab-pane fade @if($loop->first) show active @endif" id="mobile-{{ $safeId }}" role="tabpanel" aria-labelledby="mobile-{{ $safeId }}-tab">
                                        <div class="appointment-details" style="max-width:500px; margin:auto;">
                                            <h4 style="font-weight:700; color:#222; margin-bottom:10px;">{{ ucfirst($rate->session_type) }} Consultation</h4>
                                            <p style="color:#555; margin-bottom:18px;">{{ $rate->professional->bio }}</p>
                                            <ul class="appointment-features" style="padding-left:0; list-style:none; margin-bottom:22px;">
                                                <li style="margin-bottom:7px; color:#2563eb;"><i class="icon_check_alt2"></i> <span style="color:#444;">{{ $rate->num_sessions }} sessions</span></li>
                                                @php
                                                    // compute minimum session duration from availabilities (same as desktop)
                                                    $minSessionDuration = $availabilities->min('session_duration');
                                                @endphp
                                                @if($minSessionDuration)
                                                    <li style="margin-bottom:7px; color:#2563eb;">
                                                        <i class="icon_check_alt2"></i>
                                                        <span style="color:#444;">{{ $minSessionDuration }} min per session</span>
                                                    </li>
                                                @endif
                                                @foreach($availabilities as $availability)
                                                    
                                                @endforeach
                                                <li style="color:#2563eb;"><i class="icon_check_alt2"></i> <span style="color:#444;">Curated solutions for you</span></li>
                                            </ul>
                                            <div class="price" style="margin-bottom:18px;">
                                                @php
                                                $perText = match (strtolower($rate->session_type)) {
                                                    'free hand' => 'per session',
                                                    'weekly' => 'per week',
                                                    'monthly' => 'per month',
                                                    'quarterly' => 'per 3 months',
                                                    default => 'per session',
                                                };
                                                @endphp
                                                <strong style="font-size:2rem; color:#2563eb; font-weight:700;">Rs. {{ number_format($rate->final_rate, 2) }}</strong><br>
                                                <small style="font-size:1rem; color:#666;">{{ $perText }}</small>
                                            </div>
                                            <button 
                                                class="select-plan" 
                                                data-plan="{{ $safeId }}" 
                                                data-sessions="{{ $rate->num_sessions }}" 
                                                data-rate="{{ $rate->final_rate }}"
                                                style="background:#2563eb; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-weight:600; font-size:1.08rem; transition:background 0.2s; box-shadow:none; outline:none; cursor:pointer;"
                                                onmouseover="this.style.background='#1741a6'" onmouseout="this.style.background='#2563eb'"
                                            >
                                                Select {{ ucfirst($rate->session_type) }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Booking Section (appears after appointment types) -->
                    <div class="box_booking mobile-booking-section" style="display: none;">
                        <div class="head">
                            <h3>Booking</h3>
                            <a href="#0" class="close_panel_mobile"><i class="icon_close"></i></a>
                        </div>
                        <div class="main">
                            <div id="mobile-selected-plan-display" style="display:none;">
                                <strong>Selected Plan: </strong><span id="mobile-selected-plan-text">None</span>
                                <input type="hidden" id="mobile-selected_plan" name="selected_plan" value="">
                            </div>
                            
                            <div class="radio_select type">
                                <ul>
                                    <li>
                                        <input type="radio" id="mobile-appointment" name="mobile-type" value="12.00pm">
                                        <label for="mobile-appointment"><i class="icon-users"></i> Appointment</label>
                                    </li>
                                </ul>
                            </div>
                            <div style="display: flex; justify-content: center; margin-top: 20px;">
                                <div style="padding: 10px; background: #fff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px;">
                                    <input type="text" id="mobile-rangeInput" placeholder="Select Dates" style="display: none;" />
                                    <div id="mobile-calendarDiv"></div>
                                </div>
                            </div>
                            <div class="dropdown time mt-4">
                                <a href="#" data-bs-toggle="dropdown">
                                    <div>Hour</div>
                                    <div id="mobile-selected_time"></div>
                                </a>
                                
                                <div class="dropdown-menu">
                                    <div class="dropdown-menu-content">
                                        <div class="radio_select d-flex flex-wrap gap-2">
                                            @foreach($availabilities as $availability)
                                                @php $weekdays = json_decode($availability->weekdays, true); @endphp
                                                @if(is_array($weekdays))
                                                    @foreach($availability->slots as $slot)
                                                        @foreach($weekdays as $day)
                                                            @php
                                                                $weekday = strtolower($day);
                                                                $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i A'); 
                                                                $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i A');
                                                            @endphp

                                                            <div class="slot-box" data-weekday="{{ $weekday }}" data-month="{{ $availability->month }}" style="flex: 0 0 auto; display: none;">
                                                                <input type="radio"
                                                                    id="mobile-time_{{ $slot->id }}_{{ $weekday }}_{{ $availability->month }}"
                                                                    name="mobile-time"
                                                                    class="mobile-time-slot"
                                                                    data-id="{{ $slot->id }}"
                                                                    data-month="{{ $availability->month }}"
                                                                    value="{{ $startTime }} to {{ $endTime }}"
                                                                    data-start="{{ $startTime }}"
                                                                    data-start-period="{{ strtoupper($slot->start_period) }}"
                                                                    data-end="{{ $endTime }}"
                                                                    data-end-period="{{ strtoupper($slot->end_period) }}">

                                                                <label for="mobile-time_{{ $slot->id }}_{{ $weekday }}_{{ $availability->month }}">
                                                                    {{ $startTime }} - {{ $endTime }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul id="mobile-selected-time-list">
                                <!-- Selected dates and times will be appended here -->
                            </ul>
                            
                            <a href="javascript:void(0);" class="btn_1 full-width booking" id="mobile-bookNowBtn">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="tabs_detail">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a id="tab-A" href="#pane-A" class="nav-link active" data-bs-toggle="tab" role="tab">Other info</a>
                        </li>
                        <li class="nav-item">
                            <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a id="tab-C" href="#pane-C" class="nav-link" data-bs-toggle="tab" role="tab">Gallery</a>
                        </li>
                    </ul>
                    <div class="tab-content" role="tablist">
                        <div id="pane-A" class="card tab-pane fade show active tab-pane-container" role="tabpanel" aria-labelledby="tab-A">
                            <div class="card-header" role="tab" id="heading-A">
                                <h5>
                                    <a class="collapsed" data-bs-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">
                                        Other info
                                    </a>
                                </h5>
                            </div>
                            @php
                            $requestedServices = $requestedService && $requestedService->requested_service
                                        ? json_decode($requestedService->requested_service, true)
                                        : [];
                        
                            $prices = $requestedService && $requestedService->price
                                        ? json_decode($requestedService->price, true)
                                        : [];
                        
                            $education = $requestedService && $requestedService->education
                                        ? json_decode($requestedService->education, true)
                                        : ['college_name' => [], 'degree' => []];
                                        
                            // Store the original ProfessionalService model in a different variable for access later
                            $professionalService = $services;
                        @endphp
                        
                        <div id="collapse-A" class="collapse show" role="tabpanel" aria-labelledby="heading-A">
                            <div class="card-body info_content">
                                {{-- Services --}}
                                <div class="indent_title_in">
                                    <i class="icon_document_alt"></i>
                                    <h3>Services</h3>
                                </div>
                                <div class="wrapper_indent">
                                    @if(!empty($requestedServices))
                                        <p>{{ $requestedService->sub_heading ?? '' }}</p>
                        
                                        <h6>Most Requested Services</h6>
                                        <div class="services_list clearfix">
                                            <ul>
                                                @foreach($requestedServices as $index => $service)
                                                    <li>
                                                        {{ $service }}
                                                        @if(isset($prices[$index]))
                                                        <strong><small>from</small> ₹{{ number_format($prices[$index], 2) }}</strong>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p>No services available at the moment.</p>
                                    @endif
                                </div>
                                <hr>
                          @php
                                    $requirements = '';
                                    
                                    if ($professionalService && $professionalService->requirements) {
                                        // Handle different formats of requirements
                                        if (is_array($professionalService->requirements)) {
                                            $requirements = implode("\n\n", $professionalService->requirements);
                                        } elseif (is_string($professionalService->requirements)) {
                                            // Try to parse as JSON in case it's a JSON string
                                            $decoded = json_decode($professionalService->requirements, true);
                                            if (is_array($decoded) && json_last_error() === JSON_ERROR_NONE) {
                                                $requirements = implode("\n\n", $decoded);
                                            } else {
                                                $requirements = $professionalService->requirements;
                                            }
                                        }
                                    }
                                @endphp
                                
                                @if(!empty(trim($requirements)))
                                {{-- Client Requirements --}}
                                <div class="indent_title_in">
                                    <i class="icon_document_alt"></i>
                                    <h3>Client Requirements</h3>
                                    <p>Note for clients if any</p>
                                </div>
                                <div class="wrapper_indent add_bottom_25">
                                    {!! nl2br(e($requirements)) !!}
                                </div>
                                @endif
                                <hr>
                        
                                {{-- Education --}}
                                <div class="indent_title_in">
                                    <i class="icon_document_alt"></i>
                                    <h3>Educational background</h3>
                                    <p>{{ $requestedService->education_statement ?? 'No education statement available.' }}</p>
                                </div>
                                <div class="wrapper_indent add_bottom_25">
                                    <ul class="bullets">
                                        @foreach($education['college_name'] as $i => $college)
                                            @if(!empty($college) || !empty($education['degree'][$i]))
                                                <li><strong>{{ $college }}</strong> - {{ $education['degree'][$i] ?? '' }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <hr>
                            </div>
                        </div>
                        </div>
                        
                        <div id="pane-B" class="card tab-pane fade tab-pane-container" role="tabpanel" aria-labelledby="tab-B">
                            <div class="card-header" role="tab" id="heading-B">
                                <h5>
                                    <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
                                        Reviews
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
                                <div class="card-body reviews">
                                    <div class="row add_bottom_45 d-flex align-items-center">
                                        @php
                                            $reviews = ($profile && $profile->professional) ? $profile->professional->reviews : collect([]);
                                            $reviewCount = $reviews->count();
                                            $avgRating = $reviewCount > 0 ? number_format($reviews->avg('rating'), 1) : 0;
                                            
                                            // Rating text based on average score
                                            $ratingText = 'No ratings yet';
                                            if ($reviewCount > 0) {
                                                if ($avgRating >= 4.5) $ratingText = 'Excellent';
                                                elseif ($avgRating >= 4.0) $ratingText = 'Very Good';
                                                elseif ($avgRating >= 3.5) $ratingText = 'Good';
                                                elseif ($avgRating >= 3.0) $ratingText = 'Average';
                                                else $ratingText = 'Fair';
                                            }
                                        @endphp
                                        
                                        <div class="col-md-3">
                                            <div id="review_summary">
                                                <strong>{{ $avgRating }}</strong>
                                                <em>{{ $ratingText }}</em>
                                                <small>Based on {{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }}</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-9 reviews_sum_details">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Rating</h6>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-9 col-9">
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar" style="width: {{ $avgRating * 20 }}%" aria-valuenow="{{ $avgRating * 20 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-3"><strong>{{ $avgRating }}</strong></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p class="text-end">
                                        <button type="button" class="btn_1" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                            <i class="fas fa-star me-1"></i> Leave a review
                                        </button>
                                    </p>
                                    
                                    <div id="reviews">
                                        @forelse($reviews as $review)
                                            <div class="review_card">
                                                <div class="row">
                                                    <div class="col-md-2 user_info">
                                                        @php
                                                            // Try to get profile image from customer_profiles table
                                                            $userPhoto = null;
                                                            if ($review->user && $review->user->customerProfile) {
                                                                $userPhoto = $review->user->customerProfile->photo;
                                                            }
                                                            // Fallback to default avatar
                                                            if (!$userPhoto) {
                                                                $userPhoto = 'img/avatar-placeholder.jpg';
                                                            }
                                                        @endphp
                                                        <figure class="mb-2">
                                                            <img src="{{ asset($userPhoto) }}" alt="{{ $review->user->name ?? 'Anonymous' }}" class="img-fluid rounded-circle" style="width: 70px; height: 70px; object-fit: cover;">
                                                        </figure>
                                                        <h5>{{ $review->user->name ?? 'Anonymous' }}</h5>
                                                    </div>
                                                    <div class="col-md-10 review_content">
                                                        <div class="clearfix add_bottom_15">
                                                            <span class="rating">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $review->rating)
                                                                        <i class="fas fa-star text-warning"></i>
                                                                    @else
                                                                        <i class="far fa-star text-muted"></i>
                                                                    @endif
                                                                @endfor
                                                                <small class="ms-2">({{ $review->rating }}/5)</small>
                                                            </span>
                                                            <em>Published {{ $review->created_at->diffForHumans() }}</em>
                                                        </div>
                                                        <p>{{ $review->review_text }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">
                                                <p class="mb-0 text-center">This professional doesn't have any reviews yet. Be the first to leave a review!</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="pane-C" class="card tab-pane fade tab-pane-container" role="tabpanel" aria-labelledby="tab-C">
                            <div class="card-header" role="tab" id="heading-C">
                                <h5>
                                    <a class="collapsed" data-bs-toggle="collapse" href="#collapse-C" aria-expanded="false" aria-controls="collapse-C">
                                        Gallery
                                    </a>
                                </h5>
                            </div>
                            @php
                            // Use the safe gallery accessor method from the Profile model
                            $galleryImages = $profile ? $profile->gallery_array : [];
                            @endphp
                            @if(!empty($galleryImages) && is_array($galleryImages))
                                <div id="collapse-C" class="collapse" role="tabpanel" aria-labelledby="heading-C">
                                    <div class="card-body">
                                        <div class="gallery-container">
                                            <div class="row">
                                                @foreach($galleryImages as $image)
                                                    <div class="col-md-4 col-sm-6 mb-4">
                                                        @php
                                                            $imagePath = Str::startsWith($image, 'storage/') ? $image : 'storage/' . $image;
                                                            $fullImagePath = str_replace('storage/', 'storage/', $imagePath);
                                                            $imageExists = file_exists(public_path($fullImagePath));
                                                            $finalImageUrl = $imageExists ? asset($imagePath) : asset('frontend/assets/img/lazy-placeholder.png');
                                                        @endphp
                                                        <a href="{{ $finalImageUrl }}" class="gallery-item" data-fancybox="gallery">
                                                            <img src="{{ $finalImageUrl }}" class="img-fluid rounded" alt="Clinic Photo">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="text-center mt-3">
                                                <p>Our state-of-the-art facilities and comfortable environment</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-5">
                <!-- Appointment Type Tabs -->
                <div class="box_booking appointment_types">
                    <div class="tabs">
                        <ul class="nav nav-tabs appointment-tabs" role="tablist" style="border-bottom:none; gap: 8px;">
                            @foreach($rates as $rate)
                                @php
                                    $safeId = strtolower(str_replace(' ', '_', $rate->session_type));
                                @endphp
                                <li class="nav-item" style="margin-bottom:0;">
                                    <a class="nav-link @if($loop->first) active @endif" id="{{ $safeId }}-tab" data-bs-toggle="tab" href="#{{ $safeId }}" role="tab" style="font-weight:600; border-radius: 8px 8px 0 0; padding: 3px 9px; border: 1px solid #e0e7ef; background: @if($loop->first) #2563eb @else #f7f9fc @endif; color: @if($loop->first) #fff @else #222 @endif; transition: background 0.2s, color 0.2s;">
                                        {{ ucfirst($rate->session_type) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content appointment-tab-content" style="background:#f7f9fc; border-radius:0 0 12px 12px; padding:32px 28px 24px 28px; margin-top:-2px; border:1px solid #e0e7ef;">
                            @foreach($rates as $rate)
                                @php
                                    $safeId = strtolower(str_replace(' ', '_', $rate->session_type));
                                @endphp
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $safeId }}" role="tabpanel" aria-labelledby="{{ $safeId }}-tab">
                                    <div class="appointment-details" style="max-width:500px; margin:auto;">
                                        <h4 style="font-weight:700; color:#222; margin-bottom:10px;">{{ ucfirst($rate->session_type) }} Consultation</h4>
                                        <p style="color:#555; margin-bottom:18px;">{{ $rate->professional->bio }}</p>
                                        <ul class="appointment-features" style="padding-left:0; list-style:none; margin-bottom:22px;">
                                            <li style="margin-bottom:7px; color:#2563eb;"><i class="icon_check_alt2"></i> <span style="color:#444;">{{ $rate->num_sessions }} sessions</span></li>
                                            @php
                                                $minSessionDuration = $availabilities->min('session_duration');
                                            @endphp
                                            <li style="margin-bottom:7px; color:#2563eb;">
                                                <i class="icon_check_alt2"></i>
                                                <span style="color:#444;">{{ $minSessionDuration }} min per session</span>
                                            </li>
                                            
                                            @php
                                                // Get dynamic features from the rate
                                                $dynamicFeatures = $rate->features_list ?? [];
                                                
                                                // If no dynamic features, use default
                                                if (empty($dynamicFeatures)) {
                                                    $dynamicFeatures = ['Curated solutions for you'];
                                                }
                                            @endphp
                                            
                                            @foreach($dynamicFeatures as $feature)
                                                <li style="margin-bottom:7px; color:#2563eb;">
                                                    <i class="icon_check_alt2"></i> 
                                                    <span style="color:#444;">{{ $feature }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="price" style="margin-bottom:18px;">
                                            @php
                                            $perText = match (strtolower($rate->session_type)) {
                                                'free hand' => 'per session',
                                                'weekly' => 'per week',
                                                'monthly' => 'per month',
                                                'quarterly' => 'per 3 months',
                                                default => 'per session',
                                            };
                                            @endphp
                                            <strong style="font-size:2rem; color:#2563eb; font-weight:700;">Rs. {{ number_format($rate->final_rate, 2) }}</strong><br>
                                            <small style="font-size:1rem; color:#666;">{{ $perText }}</small>
                                        </div>
                                        <button 
                                            class="select-plan" 
                                            data-plan="{{ $safeId }}" 
                                            data-sessions="{{ $rate->num_sessions }}" 
                                            data-rate="{{ $rate->final_rate }}"
                                            style="background:#2563eb; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-weight:600; font-size:1.08rem; transition:background 0.2s; box-shadow:none; outline:none; cursor:pointer;"
                                            onmouseover="this.style.background='#1741a6'" onmouseout="this.style.background='#2563eb'"
                                        >
                                            Select {{ ucfirst($rate->session_type) }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Booking Section -->
                <div class="box_booking">
                    <div class="head">
                        <h3>Booking</h3>
                        <a href="#0" class="close_panel_mobile"><i class="icon_close"></i></a>
                    </div>
                    <div class="main">
                        <div id="selected-plan-display" style="display:none;">
                            <strong>Selected Plan: </strong><span id="selected-plan-text">None</span>
                            <input type="hidden" id="selected_plan" name="selected_plan" value="">
                        </div>
                        
                        <div class="radio_select type">
                            <ul>
                                <li>
                                    <input type="radio" id="appointment" name="type" value="12.00pm">
                                    <label for="appointment"><i class="icon-users"></i> Appointment</label>
                                </li>
                            </ul>
                        </div>
                        <div style="display: flex; justify-content: center; margin-top: 20px;">
                            <div style="padding: 10px; background: #fff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px;">
                                <input type="text" id="rangeInput" placeholder="Select Dates" style="display: none;" />
                                <div id="calendarDiv"></div>
                            </div>
                        </div>
                        <div class="dropdown time mt-4">
                            <a href="#" data-bs-toggle="dropdown">
                                <div>Hour</div>
                                <div id="selected_time"></div>
                            </a>
                            
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-content">
                                    <div class="radio_select d-flex flex-wrap gap-2">
                                        @foreach($availabilities as $availability)
                                            @php $weekdays = json_decode($availability->weekdays, true); @endphp
                                            @if(is_array($weekdays))
                                                @foreach($availability->slots as $slot)
                                                    @foreach($weekdays as $day)
                                                        @php
                                                            $weekday = strtolower($day);
                                                            $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i A'); 
                                                            $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i A');
                                                        @endphp

                                                        <div class="slot-box" data-weekday="{{ $weekday }}" data-month="{{ $availability->month }}" style="flex: 0 0 auto; display: none;">
                                                            <input type="radio"
                                                                id="time_{{ $slot->id }}_{{ $weekday }}_{{ $availability->month }}"
                                                                name="time"
                                                                class="time-slot"
                                                                data-id="{{ $slot->id }}"
                                                                data-month="{{ $availability->month }}"
                                                                value="{{ $startTime }} to {{ $endTime }}"
                                                                data-start="{{ $startTime }}"
                                                                data-start-period="{{ strtoupper($slot->start_period) }}"
                                                                data-end="{{ $endTime }}"
                                                                data-end-period="{{ strtoupper($slot->end_period) }}">

                                                            <label for="time_{{ $slot->id }}_{{ $weekday }}_{{ $availability->month }}">
                                                                {{ $startTime }} - {{ $endTime }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul id="selected-time-list">
                            <!-- Selected dates and times will be appended here -->
                        </ul>
                        
                        <a href="javascript:void(0);" class="btn_1 full-width booking" id="bookNowBtn">Book Now</a>
                    </div>
                </div>
                
                <!-- Social Share Buttons -->
                <div class="social-share-section mt-3">
                    <h6 class="text-dark mb-3" style="font-weight: 600;">
                        <i class="fas fa-share-alt me-2"></i>Share this professional:
                    </h6>
                    @php
                        // Create SEO-friendly URL with professional name
                        $professionalName = $profile->name ?? 'Professional';
                        $seoFriendlyName = Str::slug($professionalName);
                        $shareUrl = route('professionals.details', ['id' => $profile->professional_id, 'professional_name' => $seoFriendlyName]);
                    @endphp
                    <ul class="share-buttons">
                        <li><a class="fb-share" href="#0" onclick="shareOnFacebookProfessional('{{ $professionalName }}', '{{ $shareUrl }}')"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                        <li><a class="twitter-share" href="#0" onclick="shareOnXProfessional('{{ $professionalName }}', '{{ $shareUrl }}')"><i class="fab fa-x-twitter"></i> Twitter</a></li>
                        <li><a class="whatsapp-share" href="#0" onclick="shareOnWhatsAppProfessional('{{ $professionalName }}', '{{ $shareUrl }}')"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                        <li><a class="instagram-share" href="#0" onclick="shareOnInstagram('{{ $professionalName }}', '{{ $shareUrl }}')"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a class="copy-link" href="#0" onclick="copyLinkProfessional('{{ $shareUrl }}')"><i class="fas fa-copy"></i> Copy Link</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">
                        <i class="fas fa-star text-warning me-2"></i>Rate Your Experience
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(Auth::guard('user')->check())
                        <form id="reviewForm">
                            @csrf
                            <input type="hidden" name="professional_id" value="{{ ($profile && $profile->professional && $profile->professional->id) ? $profile->professional->id : $id ?? '' }}">>
                            
                            <!-- Rating Stars -->
                            <div class="rating-container text-center mb-4">
                                <p class="rating-title mb-2">How would you rate this professional?</p>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                                </div>
                                <div class="rating-value mt-2">
                                    <span id="selected-rating">Select a rating</span>
                                </div>
                            </div>
                            
                            <!-- Review Text -->
                            <div class="form-group mb-3">
                                <label for="review_text" class="form-label">Your Review</label>
                                <textarea class="form-control" name="review_text" id="review_text" rows="4" 
                                    placeholder="Share your experience with this professional..."></textarea>
                                <small class="form-text text-muted">
                                    Your honest feedback helps others make better decisions.
                                </small>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                Please <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="alert-link">sign in</a> to leave a review.
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    @if(Auth::guard('user')->check())
                        <button type="button" class="btn_1" id="submitReview">
                            <i class="fas fa-paper-plane me-1"></i> Submit Review
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Mobile Detection and UI Switching
            function isMobileDevice() {
                return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
            
            function toggleMobileDesktopViews() {
                const isMobile = isMobileDevice();
                
                // Mobile appointment types
                const mobileAppointmentTypes = document.querySelector('.mobile-appointment-types');
                const desktopAppointmentTypes = document.querySelector('.appointment_types:not(.mobile-appointment-types)');
                
                // Mobile booking section
                const mobileBookingSection = document.querySelector('.mobile-booking-section');
                const desktopBookingSection = document.querySelector('.box_booking:not(.mobile-booking-section):not(.mobile-appointment-types)');
                
                if (isMobile) {
                    // Show mobile versions
                    if (mobileAppointmentTypes) {
                        mobileAppointmentTypes.style.display = 'block';
                    }
                    if (mobileBookingSection) {
                        mobileBookingSection.style.display = 'block';
                    }
                    
                    // Hide desktop versions
                    if (desktopAppointmentTypes) {
                        desktopAppointmentTypes.style.display = 'none';
                    }
                    if (desktopBookingSection) {
                        desktopBookingSection.style.display = 'none';
                    }
                } else {
                    // Show desktop versions
                    if (desktopAppointmentTypes) {
                        desktopAppointmentTypes.style.display = 'block';
                    }
                    if (desktopBookingSection) {
                        desktopBookingSection.style.display = 'block';
                    }
                    
                    // Hide mobile versions
                    if (mobileAppointmentTypes) {
                        mobileAppointmentTypes.style.display = 'none';
                    }
                    if (mobileBookingSection) {
                        mobileBookingSection.style.display = 'none';
                    }
                }
            }
            
            // Initial mobile/desktop view setup
            toggleMobileDesktopViews();
            
            // Handle window resize
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(toggleMobileDesktopViews, 100);
            });
            
            let enabledDates = @json($enabledDates);
            
            // Get existing bookings for this professional
            const existingBookings = @json($existingBookings ?? []);
            
            // Initialize booking data
            
            let selectedBookings = {};
            
            // Initialize calendars for both desktop and mobile
            function initializeCalendar(calendarId, isMobile = false) {
                if (!document.getElementById(calendarId)) return;
                
                // Helper function to format the date to local date string
                function formatLocalDate(date) {
                    const offset = date.getTimezoneOffset();
                    const localDate = new Date(date.getTime() - offset * 60000);
                    return localDate.toISOString().split('T')[0];
                }
                
                // Initialize Flatpickr
                flatpickr("#" + calendarId, {
                    inline: true,
                    mode: "multiple",
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    enable: enabledDates, 
                    disable: [
                        function (date) {
                            const dateString = formatLocalDate(date);
                            return !enabledDates.includes(dateString);
                        }
                    ],
                    onDayCreate: function (dObj, dStr, fp, dayElem) {
                        const date = dayElem.dateObj;
                        const dateString = formatLocalDate(date);
                        if (enabledDates.includes(dateString)) {
                            dayElem.style.backgroundColor = '#28a745';
                            dayElem.style.color = 'white';
                        } else {
                            dayElem.style.backgroundColor = '#ccc'; // Disabled days
                            dayElem.style.color = '#999';
                        }
                    },
                    onChange: function (selectedDates, dateStr, instance) {
                        const offset = selectedDates.length ? selectedDates[0].getTimezoneOffset() : 0;
                        const selectedDatesLocal = selectedDates.map(d => {
                            return new Date(d.getTime() - offset * 60000).toISOString().split('T')[0];
                        });

                        // Remove unselected dates from selectedBookings
                        Object.keys(selectedBookings).forEach(date => {
                            if (!selectedDatesLocal.includes(date)) {
                                delete selectedBookings[date];
                            }
                        });

                        // Hide all slot boxes first
                        const slotBoxes = isMobile ? 
                            Array.from(document.querySelectorAll('.mobile-time-slot')).map(slot => slot.closest('.slot-box')) :
                            Array.from(document.querySelectorAll('.time-slot')).map(slot => slot.closest('.slot-box'));
                            
                        slotBoxes.forEach(box => {
                            if (box) {
                                box.style.display = 'none';
                                box.removeAttribute('data-current-date');
                            }
                        });

                        // Show slots for last selected date only
                        if (selectedDates.length > 0) {
                            const selectedDateUTC = selectedDates[selectedDates.length - 1];
                            const selectedDate = new Date(selectedDateUTC.getTime() - offset * 60000);
                            const weekdayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
                            const weekday = weekdayNames[selectedDate.getDay()];
                            const dateString = selectedDate.toISOString().split('T')[0];
                            
                            // Get month from selected date
                            const monthNames = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
                            const selectedMonth = monthNames[selectedDate.getMonth()];

                            const relevantSlotBoxes = isMobile ? 
                                Array.from(document.querySelectorAll(`.slot-box[data-weekday="${weekday}"][data-month="${selectedMonth}"] .mobile-time-slot`)).map(slot => slot.closest('.slot-box')) :
                                Array.from(document.querySelectorAll(`.slot-box[data-weekday="${weekday}"][data-month="${selectedMonth}"] .time-slot`)).map(slot => slot.closest('.slot-box'));

                            relevantSlotBoxes.forEach(box => {
                                if (box) {
                                    box.style.display = 'flex';
                                    box.style.alignItems = 'center';
                                    box.setAttribute('data-current-date', dateString);
                                    
                                    // Check if the slot is already booked
                                    const timeInput = box.querySelector(isMobile ? '.mobile-time-slot' : '.time-slot');
                                    const timeValue = timeInput ? timeInput.value : '';
                                    const label = timeInput ? timeInput.nextElementSibling : null;

                                    // Reset any previous styling
                                    if (timeInput) {
                                        timeInput.disabled = false;
                                        timeInput.checked = false;
                                    }
                                    if (label) {
                                        label.style.opacity = '';
                                        label.style.textDecoration = '';
                                        // Ensure label text is present (fallback to data attributes)
                                        try {
                                            const start = timeInput ? timeInput.getAttribute('data-start') || '' : '';
                                            const end = timeInput ? timeInput.getAttribute('data-end') || '' : '';
                                            if (!label.textContent || label.textContent.trim() === '') {
                                                label.textContent = start + (start && end ? ' - ' : '') + end;
                                            }
                                            label.style.color = label.style.color || '#222';
                                            label.style.background = label.style.background || '#f8f9fa';
                                            label.style.display = 'block';
                                        } catch (e) {
                                            console.warn('label autofill failed', e);
                                        }
                                        // Remove previous BOOKED text
                                        if (label.innerHTML && label.innerHTML.includes('(BOOKED)')) {
                                            label.innerHTML = label.innerHTML.replace(/ <span[^>]*>\(BOOKED\)<\/span>/g, '');
                                        }
                                    }
                                    
                                    // Check if this slot is booked for the selected date
                                    if (timeInput && isTimeSlotBooked(dateString, timeValue)) {
                                        timeInput.disabled = true;
                                        box.classList.add('slot-booked');
                                        if (label) {
                                            label.style.opacity = '0.5';
                                            label.style.textDecoration = 'line-through';
                                            label.innerHTML = label.innerHTML + ' <span style="color: red; font-size: 10px; font-weight: bold;">(BOOKED)</span>';
                                        }
                                    }
                                }
                            });
                        }

                        updateSelectedTimeList(isMobile);
                    }
                });
            }
            
            // Initialize both calendars
            initializeCalendar('calendarDiv', false); // Desktop
            initializeCalendar('mobile-calendarDiv', true); // Mobile

            // Note: Calendar initialization is handled by initializeCalendar function above

            // Function to check if a time slot is already booked
            function isTimeSlotBooked(date, timeSlot) {
                if (!existingBookings[date]) return false;
                
                // Normalize both time slot formats for comparison
                const normalizeTimeSlot = (slot) => {
                    return slot.replace(' to ', ' - ').trim();
                };
                
                const normalizedTimeSlot = normalizeTimeSlot(timeSlot);
                
                const isBooked = existingBookings[date].some(bookedTime => {
                    const normalizedBookedTime = normalizeTimeSlot(bookedTime);
                    return normalizedTimeSlot === normalizedBookedTime;
                });
                
                return isBooked;
            }
            
            // Function to update selected time list for both desktop and mobile
            function updateSelectedTimeList(isMobile = false) {
                const listId = isMobile ? 'mobile-selected-time-list' : 'selected-time-list';
                const list = document.getElementById(listId);
                if (list) {
                    list.innerHTML = '';

                    // Sort the dates first
                    const sortedDates = Object.keys(selectedBookings).sort();

                    sortedDates.forEach(date => {
                        // Sort times within each date
                        const sortedTimes = selectedBookings[date].slice().sort((a, b) => {
                            return new Date(`1970-01-01T${a}`) - new Date(`1970-01-01T${b}`);
                        });

                        sortedTimes.forEach(time => {
                            const item = document.createElement('li');
                            item.classList.add('selected-booking-item');
                            // Convert YYYY-MM-DD to dd/mm/yy for display
                            let [year, month, day] = date.split('-');
                            let displayDate = `${day}/${month}/${year.slice(-2)}`;
                            item.innerHTML = `
                                <span>${displayDate} - ${time}</span>
                                <button type="button" class="remove-booking-item" data-date="${date}" data-time="${time}" aria-label="Remove booking">
                                    &#x2716;
                                </button>
                            `;
                            list.appendChild(item);
                        });
                    });

                    // Add event listeners for remove buttons
                    document.querySelectorAll('.remove-booking-item').forEach(button => {
                        button.addEventListener('click', function() {
                            const dateToRemove = this.getAttribute('data-date');
                            const timeToRemove = this.getAttribute('data-time');

                            if (selectedBookings[dateToRemove]) {
                                // Remove the specific time from the array for that date
                                selectedBookings[dateToRemove] = selectedBookings[dateToRemove].filter(time => time !== timeToRemove);

                                // If no more times for this date, remove the date entry
                                if (selectedBookings[dateToRemove].length === 0) {
                                    delete selectedBookings[dateToRemove];
                                }
                            }
                            updateSelectedTimeList(isMobile); // Re-render the list
                        });
                    });
                } else {
                    console.warn('Selected time list element not found!');
                }
            }

            // Function to mark booked time slots visually
            function markBookedSlots() {
                document.querySelectorAll('.time-slot').forEach(slot => {
                    const timeValue = slot.value;
                    const slotBox = slot.closest('.slot-box');
                    const label = slot.nextElementSibling;
                    
                    // Get the current selected date from calendar or use a default
                    const selectedDates = document.querySelectorAll('.flatpickr-day.selected');
                    
                    if (selectedDates.length > 0) {
                        const selectedDate = selectedDates[0].getAttribute('aria-label');
                        const dateString = formatLocalDate(new Date(selectedDate));
                        
                        if (isTimeSlotBooked(dateString, timeValue)) {
                            slot.disabled = true;
                            slotBox.classList.add('slot-booked');
                            label.style.opacity = '0.5';
                            label.style.textDecoration = 'line-through';
                            label.innerHTML = label.innerHTML + ' <span style="color: red; font-size: 10px;">(BOOKED)</span>';
                        }
                    }
                });
            }

            // Function to update booked slots when date changes
            function updateBookedSlotsForDate(dateString) {
                document.querySelectorAll('.time-slot').forEach(slot => {
                    const timeValue = slot.value;
                    const slotBox = slot.closest('.slot-box');
                    const label = slot.nextElementSibling;
                    
                    // Reset previous booked styling
                    slot.disabled = false;
                    slotBox.classList.remove('slot-booked');
                    label.style.opacity = '';
                    label.style.textDecoration = '';
                    // Remove previous BOOKED text
                    label.innerHTML = label.innerHTML.replace(/ <span[^>]*>\(BOOKED\)<\/span>/g, '');
                    
                    // Check if this slot is booked for the selected date
                    if (isTimeSlotBooked(dateString, timeValue)) {
                        slot.disabled = true;
                        slotBox.classList.add('slot-booked');
                        label.style.opacity = '0.5';
                        label.style.textDecoration = 'line-through';
                        label.innerHTML = label.innerHTML + ' <span style="color: red; font-size: 10px;">(BOOKED)</span>';
                    }
                });
            }

            // Enhanced mobile touch support for time slots
            function addMobileTouchSupport() {
                const timeSlotSelectors = ['.time-slot', '.mobile-time-slot'];
                
                timeSlotSelectors.forEach(selector => {
                    document.querySelectorAll(selector).forEach(slot => {
                        const label = slot.nextElementSibling;
                        
                        if (label) {
                            // Add touch feedback
                            label.addEventListener('touchstart', function() {
                                if (!slot.disabled) {
                                    this.style.transform = 'scale(0.95)';
                                    this.style.opacity = '0.8';
                                }
                            }, { passive: true });
                            
                            label.addEventListener('touchend', function() {
                                this.style.transform = '';
                                this.style.opacity = '';
                            }, { passive: true });
                            
                            // Ensure click works on mobile
                            label.addEventListener('click', function(e) {
                                e.preventDefault();
                                if (!slot.disabled) {
                                    slot.click();
                                }
                            });
                        }
                    });
                });
            }
            
            // Call mobile touch support initialization
            addMobileTouchSupport();

            // Handle slot selection for both desktop and mobile
            function initializeSlotHandlers(isMobile = false) {
                const selector = isMobile ? '.mobile-time-slot' : '.time-slot';
                document.querySelectorAll(selector).forEach(slot => {
                    slot.addEventListener('change', function () {
                        const box = this.closest('.slot-box');
                        const currentDate = box.getAttribute('data-current-date');
                        const selectedTime = this.value;

                        // Don't allow selection of already booked slots
                        if (isTimeSlotBooked(currentDate, selectedTime)) {
                            toastr.error('This time slot is already booked. Please choose another time.');
                            this.checked = false;
                            return;
                        }

                        if (currentDate && selectedTime) {
                            if (!selectedBookings[currentDate]) {
                                selectedBookings[currentDate] = [];
                            }
                            selectedBookings[currentDate] = [selectedTime];
                            const slotSelector = isMobile ? '.mobile-time-slot' : '.time-slot';
                            document.querySelectorAll(`.slot-box[data-current-date="${currentDate}"] ${slotSelector}`).forEach(input => {
                                input.checked = (input.value === selectedTime);
                            });

                            updateSelectedTimeList(isMobile);
                        }
                    });
                });
            }
            
            // Initialize slot handlers for both desktop and mobile
            initializeSlotHandlers(false); // Desktop
            initializeSlotHandlers(true); // Mobile
            
            // Reinitialize mobile touch support when DOM changes
            const observer = new MutationObserver(function(mutations) {
                let shouldReinitialize = false;
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && (node.classList.contains('slot-box') || node.querySelector('.time-slot, .mobile-time-slot'))) {
                                shouldReinitialize = true;
                            }
                        });
                    }
                });
                if (shouldReinitialize) {
                    setTimeout(addMobileTouchSupport, 100);
                }
            });
            
            // Observe the appointment sections for changes
            const appointmentSections = document.querySelectorAll('.appointment_types, .mobile-appointment-types');
            appointmentSections.forEach(section => {
                if (section) {
                    observer.observe(section, { childList: true, subtree: true });
                }
            });
            
            // Add event delegation for dynamically created elements
            document.addEventListener('click', function(e) {
                // Handle plan selection buttons
                if (e.target.classList.contains('select-plan') || e.target.closest('.select-plan')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const button = e.target.classList.contains('select-plan') ? e.target : e.target.closest('.select-plan');
                    checkAuthenticationBeforePlanSelection(button);
                }
                
                // Handle time slot labels
                if (e.target.tagName === 'LABEL' && (e.target.previousElementSibling?.classList.contains('time-slot') || e.target.previousElementSibling?.classList.contains('mobile-time-slot'))) {
                    e.preventDefault();
                    const input = e.target.previousElementSibling;
                    if (!input.disabled) {
                        input.checked = !input.checked;
                        input.dispatchEvent(new Event('change'));
                    }
                }
            });
            
            // Add touch event delegation for better mobile support
            document.addEventListener('touchstart', function(e) {
                if (e.target.classList.contains('select-plan') || e.target.closest('.select-plan')) {
                    const button = e.target.classList.contains('select-plan') ? e.target : e.target.closest('.select-plan');
                    button.style.transform = 'scale(0.95)';
                    button.style.opacity = '0.8';
                }
            }, { passive: true });
            
            document.addEventListener('touchend', function(e) {
                if (e.target.classList.contains('select-plan') || e.target.closest('.select-plan')) {
                    const button = e.target.classList.contains('select-plan') ? e.target : e.target.closest('.select-plan');
                    button.style.transform = '';
                    button.style.opacity = '';
                }
            }, { passive: true });
            
            // Add CSS for booked slots and mobile interactions
            const style = document.createElement('style');
            style.textContent = `
                .slot-booked {
                    opacity: 0.6;
                    position: relative;
                }
                .slot-booked::after {
                    content: "BOOKED";
                }
                
                /* Mobile touch feedback */
                @media (max-width: 768px) {
                    .select-plan, .btn_1, .time-slot + label, .mobile-time-slot + label {
                        position: relative;
                        overflow: hidden;
                    }
                    
                    /* Mobile calendar styling */
                    .flatpickr-calendar {
                        width: 100% !important;
                        max-width: 350px !important;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
                        border-radius: 12px !important;
                        border: none !important;
                    }
                    
                    .flatpickr-day {
                        width: 40px !important;
                        height: 40px !important;
                        line-height: 40px !important;
                        font-size: 14px !important;
                        border-radius: 8px !important;
                        margin: 2px !important;
                    }
                    
                    .flatpickr-day.selected {
                        background: #007bff !important;
                        border-color: #0056b3 !important;
                        box-shadow: 0 2px 8px rgba(0,123,255,0.3) !important;
                    }
                    
                    .flatpickr-day:hover {
                        background: #e3f2fd !important;
                        border-color: #007bff !important;
                    }
                    
                    .select-plan::before, .btn_1::before, .time-slot + label::before, .mobile-time-slot + label::before {
                        content: '';
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        width: 0;
                        height: 0;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.5);
                        transition: width 0.3s, height 0.3s, top 0.3s, left 0.3s;
                        transform: translate(-50%, -50%);
                        pointer-events: none;
                    }
                    
                    .select-plan:active::before, .btn_1:active::before, 
                    .time-slot:checked + label::before, .mobile-time-slot:checked + label::before {
                        width: 200px;
                        height: 200px;
                    }
                    
            /* Ensure tap targets are large enough */
            .nav-link {
                min-height: 48px !important;
                padding: 12px 16px !important;
            }
            
            /* Mobile navigation tabs styling */
            .mobile-appointment-types .nav-tabs {
                background: #f8f9fa !important;
                padding: 8px !important;
                border-radius: 12px !important;
                border: none !important;
                margin-bottom: 16px !important;
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
            }
            
            .mobile-appointment-types .nav-tabs .nav-link {
                border: 2px solid transparent !important;
                border-radius: 8px !important;
                margin: 4px !important;
                background: #ffffff !important;
                color: #495057 !important;
                font-weight: 500 !important;
                font-size: 13px !important;
                min-width: 80px !important;
                text-align: center !important;
                transition: all 0.2s ease !important;
                padding: 10px 12px !important;
                min-height: 40px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            
            .mobile-appointment-types .nav-tabs .nav-link.active {
                background: #007bff !important;
                color: white !important;
                border-color: #0056b3 !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 4px 8px rgba(0,123,255,0.3) !important;
            }
            
            .mobile-appointment-types .nav-tabs .nav-link:hover:not(.active) {
                background: #e3f2fd !important;
                border-color: #007bff !important;
                transform: translateY(-1px) !important;
            }
            
            /* Better spacing for mobile */
            .slot-box {
                margin: 4px 0 !important;
            }
            
            /* Mobile selected time list styling */
            #mobile-selected-time-list {
                background: #f8f9fa !important;
                border-radius: 12px !important;
                padding: 16px !important;
                margin: 16px 0 !important;
                border: 2px solid #e9ecef !important;
                min-height: 60px !important;
            }
            
            #mobile-selected-time-list:empty::before {
                content: '🕐 No time slots selected yet' !important;
                color: #6c757d !important;
                font-style: italic !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                height: 40px !important;
                font-size: 14px !important;
            }
            
            #mobile-selected-time-list li {
                background: linear-gradient(135deg, #28a745, #20c997) !important;
                color: white !important;
                padding: 12px 16px !important;
                margin: 8px 0 !important;
                border-radius: 8px !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                font-weight: 500 !important;
                box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3) !important;
            }
            
            #mobile-selected-time-list .remove-booking-item {
                background: rgba(255, 255, 255, 0.2) !important;
                color: white !important;
                border: none !important;
                width: 24px !important;
                height: 24px !important;
                border-radius: 50% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 14px !important;
                cursor: pointer !important;
                transition: all 0.2s ease !important;
            }
            
            #mobile-selected-time-list .remove-booking-item:hover {
                background: rgba(220, 53, 69, 0.8) !important;
                transform: scale(1.1) !important;
            }
        }
                
                /* Mobile z-index and positioning fixes */
                .mobile-appointment-types, .mobile-booking-section {
                    position: relative !important;
                    z-index: 10 !important;
                }
                
                .mobile-appointment-types .nav-tabs {
                    z-index: 11 !important;
                    position: relative !important;
                }
                
                .mobile-appointment-types .tab-content {
                    z-index: 12 !important;
                    position: relative !important;
                    background: #ffffff !important;
                }
                
                /* Mobile time slot visibility and styling fixes */
                .mobile-appointment-types .slot-box {
                    min-height: 50px !important;
                    background: #ffffff !important;
                    border: 2px solid #e9ecef !important;
                    border-radius: 8px !important;
                    padding: 12px 8px !important;
                    margin: 8px 4px !important;
                    text-align: center !important;
                    cursor: pointer !important;
                    transition: all 0.3s ease !important;
                    font-size: 14px !important;
                    font-weight: 500 !important;
                    color: #495057 !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    position: relative !important;
                    overflow: visible !important;
                    z-index: 15 !important;
                }
                
                .mobile-appointment-types .slot-box:hover {
                    background: #e3f2fd !important;
                    border-color: #007bff !important;
                    transform: translateY(-2px) !important;
                    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2) !important;
                }
                
                .mobile-appointment-types .slot-box.selected {
                    background: linear-gradient(135deg, #28a745, #20c997) !important;
                    color: white !important;
                    border-color: #28a745 !important;
                    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4) !important;
                }
                
                .mobile-appointment-types .slot-box.slot-booked {
                    background: #f8d7da !important;
                    color: #721c24 !important;
                    border-color: #f5c6cb !important;
                    cursor: not-allowed !important;
                    opacity: 0.7 !important;
                }
                
                /* Fix covered time slots issue */
                .mobile-appointment-types .tab-pane {
                    padding: 16px 8px !important;
                    overflow: visible !important;
                    min-height: 200px !important;
                }
                
                .mobile-appointment-types .row {
                    margin: 0 -4px !important;
                    overflow: visible !important;
                }
                
                .mobile-appointment-types .col-4 {
                    padding: 0 4px !important;
                    margin-bottom: 8px !important;
                    overflow: visible !important;
                }
                
                /* Mobile selected plan section styling to match desktop */
                .mobile-booking-section .selected-plan-info {
                    background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
                    border: 2px solid #007bff !important;
                    border-radius: 12px !important;
                    padding: 20px !important;
                    margin: 16px 0 !important;
                    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15) !important;
                }
                
                .mobile-booking-section .selected-plan-info h5 {
                    color: #007bff !important;
                    font-weight: 600 !important;
                    margin-bottom: 12px !important;
                    font-size: 18px !important;
                    display: flex !important;
                    align-items: center !important;
                }
                
                .mobile-booking-section .selected-plan-info h5::before {
                    content: '📋 ' !important;
                    margin-right: 8px !important;
                }
                
                .mobile-booking-section .selected-plan-info p {
                    margin: 8px 0 !important;
                    font-size: 16px !important;
                    color: #495057 !important;
                    line-height: 1.5 !important;
                }
                
                .mobile-booking-section .selected-plan-info strong {
                    color: #28a745 !important;
                    font-weight: 600 !important;
                }
                
                /* Mobile booking summary styling */
                .mobile-booking-section .booking-summary {
                    background: #ffffff !important;
                    border: 2px solid #28a745 !important;
                    border-radius: 12px !important;
                    padding: 20px !important;
                    margin: 16px 0 !important;
                    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15) !important;
                }
                
                .mobile-booking-section .booking-summary h6 {
                    color: #28a745 !important;
                    font-weight: 600 !important;
                    margin-bottom: 16px !important;
                    padding-bottom: 8px !important;
                    border-bottom: 2px solid #e9ecef !important;
                    font-size: 16px !important;
                }
                
                .slot-booked::after {
                    content: "BOOKED";
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background-color: rgba(255, 0, 0, 0.7);
                    color: white;
                    font-size: 10px;
                    padding: 2px 5px;
                    border-radius: 3px;
                    white-space: nowrap;
                    z-index: 2;
                }
                
                /* Mobile booking action buttons */
                .mobile-booking-section .btn {
                    min-height: 50px !important;
                    font-size: 16px !important;
                    font-weight: 600 !important;
                    border-radius: 8px !important;
                    transition: all 0.3s ease !important;
                    text-transform: uppercase !important;
                    letter-spacing: 0.5px !important;
                    border: none !important;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
                }
                
                .mobile-booking-section .btn-primary {
                    background: linear-gradient(135deg, #007bff, #0056b3) !important;
                    color: white !important;
                }
                
                .mobile-booking-section .btn-primary:hover {
                    background: linear-gradient(135deg, #0056b3, #004085) !important;
                    transform: translateY(-2px) !important;
                    box-shadow: 0 6px 16px rgba(0, 123, 255, 0.3) !important;
                }
                
                .mobile-booking-section .btn-success {
                    background: linear-gradient(135deg, #28a745, #20c997) !important;
                    color: white !important;
                }
                
                .mobile-booking-section .btn-success:hover {
                    background: linear-gradient(135deg, #218838, #1e7e34) !important;
                    transform: translateY(-2px) !important;
                    box-shadow: 0 6px 16px rgba(40, 167, 69, 0.3) !important;
                }
                
                /* Mobile responsive improvements */
                @media (max-width: 480px) {
                    .mobile-appointment-types .col-4 {
                        flex: 0 0 50% !important;
                        max-width: 50% !important;
                    }
                    
                    .mobile-booking-section .btn {
                        width: 100% !important;
                        margin: 8px 0 !important;
                    }
                    
                    .mobile-booking-section .selected-plan-info,
                    .mobile-booking-section .booking-summary {
                        margin: 12px 0 !important;
                        padding: 16px !important;
                    }
                }
            `;
            document.head.appendChild(style);

            function updateSelectedTimeList() {
                const list = document.getElementById('selected-time-list');
                const mobileList = document.getElementById('mobile-selected-time-list');
                
                // Clear both lists
                if (list) list.innerHTML = '';
                if (mobileList) mobileList.innerHTML = '';
                
                if (list || mobileList) {

                    // Sort the dates first
                    const sortedDates = Object.keys(selectedBookings).sort();

                    sortedDates.forEach(date => {
                        // Sort times within each date
                        const sortedTimes = selectedBookings[date].slice().sort((a, b) => {
                            return new Date(`1970-01-01T${a}`) - new Date(`1970-01-01T${b}`);
                        });

                        sortedTimes.forEach(time => {
                            // Convert YYYY-MM-DD to dd/mm/yy for display
                            let [year, month, day] = date.split('-');
                            let displayDate = `${day}/${month}/${year.slice(-2)}`;
                            
                            const itemHTML = `
                                <span>${displayDate} - ${time}</span>
                                <button type="button" class="remove-booking-item" data-date="${date}" data-time="${time}" aria-label="Remove booking">
                                    &#x2716;
                                </button>
                            `;
                            
                            // Add to desktop list
                            if (list) {
                                const item = document.createElement('li');
                                item.classList.add('selected-booking-item');
                                item.innerHTML = itemHTML;
                                list.appendChild(item);
                            }
                            
                            // Add to mobile list  
                            if (mobileList) {
                                const mobileItem = document.createElement('li');
                                mobileItem.classList.add('selected-booking-item');
                                mobileItem.innerHTML = itemHTML;
                                mobileList.appendChild(mobileItem);
                            }
                        });
                    });
                    const bookingDataInput = document.getElementById('booking_data_json');
                    if (bookingDataInput) {
                        bookingDataInput.value = JSON.stringify(selectedBookings);
                    }

                    // Add event listeners for remove buttons
                    document.querySelectorAll('.remove-booking-item').forEach(button => {
                        button.addEventListener('click', function() {
                            const dateToRemove = this.getAttribute('data-date');
                            const timeToRemove = this.getAttribute('data-time');

                            if (selectedBookings[dateToRemove]) {
                                // Remove the specific time from the array for that date
                                selectedBookings[dateToRemove] = selectedBookings[dateToRemove].filter(time => time !== timeToRemove);

                                // If no more times for this date, remove the date entry
                                if (selectedBookings[dateToRemove].length === 0) {
                                    delete selectedBookings[dateToRemove];
                                    // Also unselect the date in Flatpickr if no times remain for it
                                    const flatpickrInstance = document.querySelector('#calendarDiv')._flatpickr;
                                    if (flatpickrInstance) {
                                        const currentSelectedDates = flatpickrInstance.selectedDates.map(d => formatLocalDate(d));
                                        const newSelectedDates = currentSelectedDates.filter(d => d !== dateToRemove);
                                        flatpickrInstance.setDate(newSelectedDates, true); // Update Flatpickr without triggering onChange
                                    }
                                }
                            }
                            updateSelectedTimeList(); // Re-render the list
                        });
                    });
                } else {
                    console.warn('Selected time list element not found!');
                }
            }

            // Handle plan selection for both desktop and mobile
            const planButtons = document.querySelectorAll('.select-plan');
            const selectedPlanDisplay = document.getElementById('selected-plan-display');
            const selectedPlanText = document.getElementById('selected-plan-text');
            const selectedPlanInput = document.getElementById('selected_plan');
            
            // Mobile elements
            const mobileSelectedPlanDisplay = document.getElementById('mobile-selected-plan-display');
            const mobileSelectedPlanText = document.getElementById('mobile-selected-plan-text');
            const mobileSelectedPlanInput = document.getElementById('mobile-selected_plan');
            
            let sessionCount = 0; 
            let selectedRate = 0;

            planButtons.forEach(button => {
                // Improved mobile button handling
                const handlePlanClick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    // First check if user is logged in before allowing plan selection
                    checkAuthenticationBeforePlanSelection(this);
                };
                
                // Add both click and touch events for better mobile support
                button.addEventListener('click', handlePlanClick);
                button.addEventListener('touchstart', handlePlanClick, { passive: false });
                
                // Add visual feedback for touch
                button.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.95)';
                    this.style.opacity = '0.8';
                }, { passive: true });
                
                button.addEventListener('touchend', function() {
                    this.style.transform = '';
                    this.style.opacity = '';
                }, { passive: true });
            });

            // Function to check authentication before plan selection
            function checkAuthenticationBeforePlanSelection(planButton) {
                fetch('/check-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        check: true
                    })
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    if (data.logged_in) {
                        // User is logged in, proceed with plan selection
                        selectPlan(planButton);
                    } else {
                        // User is not logged in, show login popup
                        showLoginPopupForPlanSelection(planButton);
                    }
                })
                .catch(error => {
                    // On error, show login popup (safer fallback)
                    showLoginPopupForPlanSelection(planButton);
                });
            }

            // Function to show login popup for plan selection
            function showLoginPopupForPlanSelection(planButton) {
                const plan = planButton.getAttribute('data-plan');
                const planDisplayName = plan.split('_')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');

                // Check if Swal is available
                if (typeof Swal === 'undefined') {
                    alert('Please login to select a consultation plan and proceed with booking.');
                    window.location.href = "/login?redirect=" + encodeURIComponent(window.location.href);
                    return;
                }

                // Show the login popup with custom styling
                Swal.fire({
                    title: '<span class="login-popup-title"><span class="wave-icon">👋</span> Hey! You forgot to login</span>',
                    html: '<p style="color: white; margin: 15px 0;">Please login to select a consultation plan and proceed with booking.</p>',
                    showCloseButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Login',
                    customClass: {
                        popup: 'login-popup-custom',
                        confirmButton: 'login-popup-btn',
                        closeButton: 'login-popup-close'
                    },
                    confirmButtonColor: '#1e0d60',
                    background: 'linear-gradient(135deg, #152a70, #c51010, #f39c12)',
                    backdrop: 'rgba(0,0,0,0.8)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to login with current professional page as intended destination
                        window.location.href = "/login?redirect=" + encodeURIComponent(window.location.href);
                    }
                    // If cancelled, do nothing - user stays on current page
                });
            }

            // Function to actually select the plan (for authenticated users)
            function selectPlan(planButton) {
                const plan = planButton.getAttribute('data-plan');
                sessionCount = parseInt(planButton.getAttribute('data-sessions')); 
                selectedRate = parseFloat(planButton.getAttribute('data-rate'));
                
                // Format the plan name for display
                const displayPlan = plan.split('_')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
                
                const displayText = `${displayPlan} Consultation (Total ${sessionCount} Sessions)`;
                
                // Update desktop elements
                if (selectedPlanInput) selectedPlanInput.value = plan;
                if (selectedPlanText) selectedPlanText.textContent = displayText;
                if (selectedPlanDisplay) {
                    selectedPlanDisplay.style.display = 'block';
                    selectedPlanDisplay.scrollIntoView({ behavior: 'smooth' });
                }
                
                // Update mobile elements
                if (mobileSelectedPlanInput) mobileSelectedPlanInput.value = plan;
                if (mobileSelectedPlanText) mobileSelectedPlanText.textContent = displayText;
                if (mobileSelectedPlanDisplay) {
                    mobileSelectedPlanDisplay.style.display = 'block';
                    mobileSelectedPlanDisplay.scrollIntoView({ behavior: 'smooth' });
                }
                
            }

            // Handle booking submission for both desktop and mobile
            function initializeBookingHandlers(isMobile = false) {
                const buttonId = isMobile ? 'mobile-bookNowBtn' : 'bookNowBtn';
                const bookingButton = document.getElementById(buttonId) || document.querySelector('.booking');
                
                if (bookingButton) {
                    bookingButton.addEventListener('click', function (e) {
                        e.preventDefault();
                        
                        // Proceed directly with booking since auth check happened at plan selection
                        proceedWithBooking();
                    });
                } else {
                    console.error('Booking button not found for ' + (isMobile ? 'mobile' : 'desktop') + '!');
                }
            }
            
            // Initialize booking handlers for both desktop and mobile
            initializeBookingHandlers(false); // Desktop
            initializeBookingHandlers(true); // Mobile
            
            // Mobile booking validation helper
            function validateMobileBookingState() {
                const isMobile = window.innerWidth <= 768;
                if (!isMobile) return true;
                
                // Ensure required mobile elements exist
                const mobileList = document.getElementById('mobile-selected-time-list');
                const mobileBookBtn = document.getElementById('mobile-bookNowBtn');
                const mobilePlanInput = document.getElementById('mobile-selected_plan');
                
                return mobileList && mobileBookBtn && mobilePlanInput;
            }

            // Function to proceed with booking (for authenticated users)
            function proceedWithBooking() {
                // Check both desktop and mobile plan inputs
                const planType = (selectedPlanInput && selectedPlanInput.value) || 
                               (mobileSelectedPlanInput && mobileSelectedPlanInput.value);
                const bookingData = selectedBookings;
                
                // Get the number of dates selected by the user
                const selectedDatesCount = Object.keys(bookingData).length;


                if (!planType) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Please select a consultation plan.');
                    } else {
                        alert('Please select a consultation plan.');
                    }
                    return;
                }

                if (selectedDatesCount !== sessionCount) {
                    const message = `You need to select ${sessionCount} dates for this booking.`;
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                    return;
                }

                const professionalNameEl = document.getElementById('professional_name');
                const professionalAddressEl = document.getElementById('professional_address');
                
                if (!professionalNameEl) {
                    console.error('Professional name element not found');
                    const message = 'Professional information missing. Please refresh the page.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                    return;
                }
                
                if (!professionalAddressEl) {
                    console.error('Professional address element not found');
                    const message = 'Professional address information missing. Please refresh the page.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                    return;
                }

                const professionalName = professionalNameEl.textContent.trim();
                const professionalAddress = professionalAddressEl.textContent.trim();
                const professionalId = {{ json_encode(($profile && $profile->professional && $profile->professional->id) ? $profile->professional->id : $id ?? null) }};
                // Format the bookings data into the expected structure
                const formattedBookings = {};
                Object.keys(bookingData).forEach(date => {
                    formattedBookings[date] = bookingData[date];
                });
                // Send the booking data to the server
                fetch("{{ route('user.booking.session.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        professional_name: professionalName,
                        professional_address: professionalAddress,
                        professional_id: professionalId,
                        plan_type: planType,
                        bookings: formattedBookings,
                        total_amount: selectedRate
                    })
                })
                .then(res => {
                    // Check if response is redirected to login page
                    if (res.redirected && res.url.includes('/login')) {
                        throw new Error('Authentication required');
                    }
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.text(); // Get as text first to check if it's JSON
                })
                .then(responseText => {
                    let data;
                    try {
                        data = JSON.parse(responseText);
                    } catch (parseError) {
                        // If JSON parsing fails, it might be an HTML login page
                        if (responseText.includes('<html') || responseText.includes('login')) {
                            throw new Error('Authentication required');
                        }
                        throw new Error('Invalid response format');
                    }
                    
                    if (data.status === 'success') {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.message);
                        } else {
                            alert(data.message || 'Booking successful!');
                        }
                        setTimeout(() => {
                            window.location.href = "{{ route('user.booking') }}";
                        }, 1000);
                    } else {
                        const message = data.message || 'Something went wrong.';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    }
                })
                .catch(err => {
                    console.error('Booking error:', err);
                    let message = 'Server error. Please try again later.';
                    
                    if (err.message === 'Authentication required') {
                        message = 'Please login to complete your booking.';
                        // Show login modal or redirect to login
                        if (typeof toastr !== 'undefined') {
                            toastr.info(message);
                        } else {
                            alert(message);
                        }
                        // Redirect to login with current page as the redirect
                        setTimeout(() => {
                            window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.href);
                        }, 1500);
                        return;
                    }
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                });
            }

            // Toggle Bio functionality
            const bioShort = document.getElementById("bio-short");
            const bioFull = document.getElementById("bio-full");
            const toggleBtn = document.getElementById("toggle-bio");

            if (toggleBtn) {
                toggleBtn.addEventListener("click", function () {
                    if (bioFull.style.display === "none") {
                        bioShort.style.display = "none";
                        bioFull.style.display = "block";
                        toggleBtn.textContent = "Read Less";
                    } else {
                        bioShort.style.display = "block";
                        bioFull.style.display = "none";
                        toggleBtn.textContent = "Read More";
                    }
                });
            }

            // Star rating selection
            const starInputs = document.querySelectorAll('.star-rating input');
            const ratingValue = document.getElementById('selected-rating');
            
            starInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const value = this.value;
                    let text = '';
                    
                    switch(value) {
                        case '5': text = 'Excellent'; break;
                        case '4': text = 'Very Good'; break;
                        case '3': text = 'Good'; break;
                        case '2': text = 'Fair'; break;
                        case '1': text = 'Poor'; break;
                        default: text = 'Select a rating';
                    }
                    
                    ratingValue.textContent = `${text} (${value}/5)`;
                });
            });

            // Submit review
            const submitReviewBtn = document.getElementById('submitReview');
            if (submitReviewBtn) {
                submitReviewBtn.addEventListener('click', function() {
                    const form = document.getElementById('reviewForm');
                    const formData = new FormData(form);
                    const rating = formData.get('rating');
                    const reviewText = formData.get('review_text');
                    
                    // Validate form
                    if (!rating) {
                        toastr.error('Please select a rating');
                        return;
                    }
                    
                    if (!reviewText.trim()) {
                        toastr.error('Please write your review');
                        return;
                    }
                    
                    // Show loading state
                    submitReviewBtn.disabled = true;
                    submitReviewBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Submitting...';
                    
                    // Submit the review
                    fetch('{{ route("user.review.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            professional_id: formData.get('professional_id'),
                            rating: rating,
                            review_text: reviewText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message || 'Review submitted successfully!');
                            
                            // Close modal and reset form
                            const modal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
                            modal.hide();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            toastr.error(data.message || 'Something went wrong');
                            submitReviewBtn.disabled = false;
                            submitReviewBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Submit Review';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred. Please try again.');
                        submitReviewBtn.disabled = false;
                        submitReviewBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Submit Review';
                    });
                });
            }
        });

        // Social sharing functions for professional profiles
        window.shareOnFacebookProfessional = function(professionalName, url) {
            const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(`Check out this professional: ${professionalName}`)}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        };

        window.shareOnTwitterProfessional = function(professionalName, url) {
            const text = `Check out this professional: ${professionalName}`;
            const shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        };

        window.shareOnXProfessional = function(professionalName, url) {
            const text = `Check out this professional: ${professionalName}`;
            const shareUrl = `https://x.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        };

        window.shareOnWhatsAppProfessional = function(professionalName, url) {
            const text = `Check out this professional: ${professionalName} ${url}`;
            const shareUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(shareUrl, '_blank');
        };

        window.shareOnInstagram = function(professionalName, url) {
            // Instagram doesn't have a direct sharing URL, so we copy the link and show instructions
            navigator.clipboard.writeText(url).then(function() {
                if (typeof toastr !== 'undefined') {
                    toastr.success('Link copied! Open Instagram and paste it in your story or post.');
                } else {
                    alert('Link copied to clipboard! Open Instagram and paste it in your story or post.');
                }
            }).catch(function() {
                if (typeof toastr !== 'undefined') {
                    toastr.info('Please copy this link and share it on Instagram: ' + url);
                } else {
                    alert('Please copy this link and share it on Instagram: ' + url);
                }
            });
        };

        window.copyLinkProfessional = function(url) {
            navigator.clipboard.writeText(url).then(function() {
                if (typeof toastr !== 'undefined') {
                    toastr.success('Professional profile link copied to clipboard!');
                } else {
                    alert('Professional profile link copied to clipboard!');
                }
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                if (typeof toastr !== 'undefined') {
                    toastr.success('Professional profile link copied to clipboard!');
                } else {
                    alert('Professional profile link copied to clipboard!');
                }
            });
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection