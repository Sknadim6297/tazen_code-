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
            
            /* Calendar date styling - Same as admin booking */
            .flatpickr-day.has-available-slots {
                background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
                border: 2px solid #28a745 !important;
                color: #155724 !important;
                font-weight: bold;
                position: relative;
            }

            .flatpickr-day.has-available-slots:hover {
                background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
                color: white !important;
                transform: scale(1.05);
                transition: all 0.2s ease;
            }

            /* Green dot indicator for dates with available slots */
            .flatpickr-day.has-available-slots::before {
                content: '●';
                position: absolute;
                top: 1px;
                right: 2px;
                color: #28a745;
                font-size: 10px;
                font-weight: bold;
                text-shadow: 0 0 2px white;
            }
    
            /* Time Slots */
            .dropdown.time {
                width: 100%;
            }
            
            .dropdown.time .dropdown-menu {
                display: block !important;
                position: relative !important;
                width: 100% !important;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                box-shadow: none;
                transform: none !important;
                margin-top: 10px;
                min-height: 200px; /* Fixed height to prevent jumping */
            }
    
            .dropdown-menu-content {
                padding: 15px;
                min-height: 100px;
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
                    padding: 8px 6px;
                    font-size: 13px;
                }
                .slot-box {
                    flex: 0 0 100%;
                }
                .container.margin_detail {
                    margin-top: 50px;
                    padding: 4px;
                }
                .box_booking {
                    padding: 6px;
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
                    padding: 4px 2px;
                    font-size: 10px;
                }
                .container.margin_detail {
                    margin-top: 30px;
                    padding: 2px;
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
                min-height: 200px; /* Fixed minimum height to prevent jumping */
                position: relative;
            }

            .radio_select.time {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                min-height: 150px; /* Maintain consistent height */
            }

            #time-slots-container {
                position: relative;
                width: 100%;
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
            
            #no-slots-message {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                text-align: center;
                padding: 20px;
                color: #6c757d;
                display: block; /* Show by default until date is selected */
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

            /* Enhanced Login Modal Styles */
            .login-modal {
                display: none;
                position: fixed;
                z-index: 10000;
                left: 0;
                top: 95px;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0,0,0,0.7);
                animation: fadeIn 0.3s ease-in-out;
            }

            .login-modal-content {
                background: linear-gradient(135deg, #1741cabc, #d379038c, #ece00586);
                /* keep some top margin so it doesn't touch header on mobile */
                margin: 6vh auto;
                padding: 0;
                border: none;
                width: 90%;
                max-width: 450px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                animation: slideIn 0.3s ease-out;
                overflow: hidden;
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes slideIn {
                from { transform: translateY(-50px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            .login-modal-header {
                /* Requested theme gradient */
                background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
                padding: 18px 20px;
                position: relative;
                display: flex;
                align-items: center;
                gap: 12px;
                justify-content: center;
            }

            .login-modal-logo {
                width: 56px;
                height: 56px;
                object-fit: contain;
                border-radius: 8px;
                background: rgba(255,255,255,0.06);
                padding: 6px;
                box-shadow: 0 3px 10px rgba(0,0,0,0.15);
                position: absolute;
                left: 18px;
                top: 50%;
                transform: translateY(-50%);
            }

            .login-modal-header h2 {
                margin: 0;
                color: #fff;
                font-size: 1.6rem;
                font-weight: 800;
                text-align: center;
                line-height: 1;
            }

            .login-modal-header .wave-icon {
                color: rgba(255,255,255,0.9);
                margin-right: 8px;
                font-size: 1.4rem;
            }

            .login-modal-close {
                position: absolute;
                right: 14px;
                top: 12px;
                color: rgba(255,255,255,0.95);
                font-size: 26px;
                font-weight: 700;
                cursor: pointer;
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: all 0.25s ease;
                background: transparent;
            }

            .login-modal-close:hover {
                background: rgba(255,255,255,0.12);
                color: #fff;
                transform: rotate(90deg);
            }

            .login-modal-body {
                background: rgba(255,255,255,0.95);
                padding: 30px;
            }

            .login-form-group {
                margin-bottom: 20px;
            }

            .login-form-group label {
                display: block;
                margin-bottom: 8px;
                color: #333;
                font-weight: 600;
                font-size: 0.95rem;
            }

            .login-form-group input {
                width: 100%;
                padding: 12px 15px;
                border: 2px solid #e1e5e9;
                border-radius: 10px;
                font-size: 1rem;
                transition: all 0.3s;
                background: #fff;
                color: #333;
            }

            .login-form-group input:focus {
                outline: none;
                border-color: #2563eb;
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
                transform: translateY(-1px);
            }

            .login-form-group input::placeholder {
                color: #999;
            }

            .login-btn {
                width: 100%;
                background: linear-gradient(135deg, #2563eb, #1741ca);
                color: white;
                border: none;
                padding: 14px 20px;
                border-radius: 10px;
                font-size: 1.1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .login-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            }

            .login-btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none;
            }

            .login-divider {
                text-align: center;
                margin: 25px 0;
                position: relative;
                color: #666;
            }

            .login-divider::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 1px;
                background: #ddd;
            }

            .login-divider span {
                background: rgba(255,255,255,0.95);
                padding: 0 15px;
                position: relative;
            }

            .login-footer {
                text-align: center;
                margin-top: 20px;
            }

            .login-footer a {
                color: #2563eb;
                text-decoration: none;
                font-weight: 600;
            }

            .login-footer a:hover {
                text-decoration: underline;
            }

            .login-loading {
                display: none;
                text-align: center;
                padding: 20px;
            }

            .login-spinner {
                border: 3px solid #f3f3f3;
                border-top: 3px solid #2563eb;
                border-radius: 50%;
                width: 30px;
                height: 30px;
                animation: spin 1s linear infinite;
                margin: 0 auto 10px;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Responsive Design */
            @media (max-width: 480px) {
                .login-modal-content {
                    width: 95%;
                    margin: 25% auto;
                }
                
                .login-modal-header {
                    padding: 20px;
                }
                
                .login-modal-body {
                    padding: 20px;
                }
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
        </style>
    @endsection

    @section('content')
        <div class="container margin_detail">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                   <div class="box_general">
                        <div class="profile-header-flex">
                            <img src="{{ $profile && $profile->photo ? asset('storage/' . $profile->photo) : asset('img/lazy-placeholder.png') }}" alt="" class="profile-main-image">
                            <div class="profile-header-details">
                                <h3 id="professional_name">{{ $profile->name }}</h3>
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
                                    <h4 style="margin-bottom: 18px; font-size: 1.35rem; font-weight: 700; color: #222;">About me</h4>
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
                                                            <a href="{{ Str::startsWith($image, 'storage/') ? asset($image) : asset('storage/' . $image) }}" class="gallery-item" data-fancybox="gallery">
                                                                <img src="{{ Str::startsWith($image, 'storage/') ? asset($image) : asset('storage/' . $image) }}" class="img-fluid rounded" alt="Clinic Photo">
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
                    <!-- Service Context Indicator -->
                    @if($requestedSubServiceId && $services && $services->subServices)
                        @php $currentSubService = $services->subServices->where('id', $requestedSubServiceId)->first(); @endphp
                        @if($currentSubService)
                            <div class="box_booking mb-3">
                                <div style="padding: 15px; background: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 8px;">
                                    <small style="color: #1976d2; font-weight: 600;">
                                        <i class="fas fa-info-circle"></i> Showing rates for: {{ $currentSubService->name }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    @else
                        @if($services && $services->subServices && count($services->subServices) > 0)
                            <div class="box_booking mb-3">
                                <div style="padding: 15px; background: #f3e5f5; border-left: 4px solid #9c27b0; border-radius: 8px;">
                                    <small style="color: #7b1fa2; font-weight: 600;">
                                        <i class="fas fa-info-circle"></i> Showing general service rates for: {{ $services->name }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    @endif

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
                                                @foreach($availabilities as $availability)
                                                    <li style="margin-bottom:7px; color:#2563eb;">
                                                        <i class="icon_check_alt2"></i>
                                                        <span style="color:#444;">{{ $availability->session_duration }} min per session</span>
                                                    </li>
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
                                            @guest('user')
                                                <div style="position: relative;">
                                                    <button 
                                                        class="select-plan-disabled" 
                                                        style="background:#ccc; color:#666; border:none; border-radius:6px; padding:10px 28px; font-weight:600; font-size:1.08rem; cursor:not-allowed; opacity:0.6; width:100%;"
                                                        disabled
                                                    >
                                                        Login to Select {{ ucfirst($rate->session_type) }}
                                                    </button>
                                                    <small style="display: block; margin-top: 8px; color: #666; text-align: center;">
                                                        <a href="javascript:void(0);" onclick="openLoginModal()" style="color: #2563eb; text-decoration: underline;">Please login</a> to select sessions and book appointments
                                                    </small>
                                                </div>
                                            @else
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
                                            @endguest
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
                            @guest('user')
                                <div class="auth-required-booking" style="text-align: center; padding: 40px 20px;">
                                    <i class="fas fa-calendar-times" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                                    <h4 style="color: #666; margin-bottom: 15px; font-weight: 600;">Login Required</h4>
                                    <p style="color: #888; margin-bottom: 20px;">You need to be logged in to select dates, times, and book appointments.</p>
                                    <a href="javascript:void(0);" onclick="openLoginModal()" 
                                       class="btn_1" 
                                       style="background: #2563eb; color: white; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block;">
                                        <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>Login to Book
                                    </a>
                                </div>
                            @else
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
                                
                                <!-- Date Selection Instructions -->
                                <div id="date-selection-info" style="display:none; text-align: center; margin: 15px 0; padding: 10px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px;">
                                    <p style="margin: 0; color: #495057; font-weight: 500;">
                                        <i class="fas fa-calendar-alt" style="margin-right: 5px; color: #2563eb;"></i>
                                        Select <span id="required-dates">0</span> date(s) for your booking 
                                        <span style="color: #2563eb;">(<span id="selected-dates-count">0</span> selected)</span>
                                    </p>
                                </div>
                                
                                <div style="display: flex; justify-content: center; margin-top: 20px;">
                                    <div style="padding: 10px; background: #fff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px;">
                                        <input type="text" id="rangeInput" placeholder="Select Dates" style="display: none;" />
                                        <div id="calendarDiv"></div>
                                    </div>
                                </div>
                                <div class="dropdown time mt-4">
                                    <a href="#" data-bs-toggle="dropdown" class="dropdown-toggle">
                                        <div>Hour <small class="text-muted">(Select a date to see available times)</small></div>
                                        <div id="selected_time"></div>
                                    </a>
                                    
                                    <div class="dropdown-menu" style="display: block; position: relative; width: 100%;">
                                        <div class="dropdown-menu-content">
                                            <div class="radio_select d-flex flex-wrap gap-2" id="time-slots-container">
                                                @foreach($availabilities as $availability)
                                                    @foreach($availability->slots as $slot)
                                                        @php
                                                            // Handle two patterns:
                                                            // Pattern 1: Slot has its own weekday field (newer system)
                                                            // Pattern 2: Weekdays in parent availability, slot weekday is null (legacy system)
                                                            
                                                            $weekdaysToProcess = [];
                                                            
                                                            if (!empty($slot->weekday)) {
                                                                // Pattern 1: Slot has direct weekday
                                                                $weekdaysToProcess = [strtolower($slot->weekday)];
                                                            } else {
                                                                // Pattern 2: Get from parent availability
                                                                $weekdaysRaw = $availability->weekdays;
                                                                
                                                                if (is_string($weekdaysRaw)) {
                                                                    $weekdaysToProcess = json_decode($weekdaysRaw, true) ?: [];
                                                                } elseif (is_array($weekdaysRaw)) {
                                                                    $weekdaysToProcess = $weekdaysRaw;
                                                                }
                                                                
                                                                // Convert to lowercase
                                                                $weekdaysToProcess = array_map('strtolower', $weekdaysToProcess);
                                                            }
                                                            
                                                            $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i A'); 
                                                            $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i A');
                                                        @endphp
                                                        
                                                        @foreach($weekdaysToProcess as $weekday)
                                                            <div class="slot-box" data-weekday="{{ $weekday }}" style="flex: 0 0 auto; display: none;">
                                                                <input type="radio"
                                                                    id="time_{{ $slot->id }}_{{ $weekday }}"
                                                                    name="time"
                                                                    class="time-slot"
                                                                    data-id="{{ $slot->id }}"
                                                                    value="{{ $startTime }} to {{ $endTime }}"
                                                                    data-start="{{ $startTime }}"
                                                                    data-end="{{ $endTime }}">

                                                                <label for="time_{{ $slot->id }}_{{ $weekday }}">
                                                                    {{ $startTime }} - {{ $endTime }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                                <!-- No slots message -->
                                                <div id="no-slots-message" style="width: 100%; text-align: center; padding: 30px 20px; color: #6c757d;">
                                                    <i class="fas fa-calendar-alt" style="font-size: 2.5rem; margin-bottom: 15px; opacity: 0.4; display: block;"></i>
                                                    <p style="margin: 0; font-size: 1rem; font-weight: 500;">
                                                        <strong>No date selected</strong><br>
                                                        <span style="font-size: 0.9rem; opacity: 0.8;">Please select a date from the calendar above to view available time slots</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    // Debug: Log all slot boxes rendered on page load
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const allSlots = document.querySelectorAll('.slot-box');
                                        console.log('Total slot boxes rendered:', allSlots.length);
                                        
                                        // Group by weekday
                                        const slotsByDay = {};
                                        allSlots.forEach(slot => {
                                            const weekday = slot.getAttribute('data-weekday');
                                            if (!slotsByDay[weekday]) slotsByDay[weekday] = 0;
                                            slotsByDay[weekday]++;
                                        });
                                        console.log('Slots by weekday:', slotsByDay);
                                    });
                                </script>
                                <ul id="selected-time-list">
                                    <!-- Selected dates and times will be appended here -->
                                </ul>
                                
                                <a href="javascript:void(0);" class="btn_1 full-width booking" id="bookNowBtn">Book Now</a>
                            @endguest
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
                            
                            // Build route parameters for share URL
                            $shareRouteParams = ['id' => $profile->professional_id, 'professional_name' => $seoFriendlyName];
                            
                            // Add sub-service slug if currently viewing a specific sub-service
                            if($requestedSubServiceId ?? null) {
                                $currentSubService = \App\Models\SubService::find($requestedSubServiceId);
                                if($currentSubService) {
                                    $shareRouteParams['sub_service_slug'] = Str::slug($currentSubService->name);
                                }
                            }
                            
                            $shareUrl = route('professionals.details', $shareRouteParams);
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
                                <input type="hidden" name="professional_id" value="{{ ($profile && $profile->professional && $profile->professional->id) ? $profile->professional->id : $id ?? '' }}">
                                
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

        <!-- Login Modal -->
        <div id="loginModal" class="login-modal">
            <div class="login-modal-content">
                <div class="login-modal-header">
                    <img class="login-modal-logo" src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="Logo">
                    <h2><i class="fas fa-sign-in-alt wave-icon"></i>Welcome Back</h2>
                    <span class="login-modal-close">&times;</span>
                </div>
                <div class="login-modal-body">
                    <form id="loginForm">
                        @csrf
                        <div class="login-form-group">
                            <label for="loginEmail">Email Address</label>
                            <input type="email" id="loginEmail" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="login-form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="login-form-group">
                            <button type="submit" class="login-btn" id="loginSubmitBtn">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </div>
                    </form>
                    
                    <div class="login-loading" id="loginLoading">
                        <div class="login-spinner"></div>
                        <p>Signing you in...</p>
                    </div>

                    <div class="login-divider">
                        <span>OR</span>
                    </div>
                    
                    <div class="login-footer">
                        @if(Route::has('register'))
                            <p>Don't have an account? <a href="{{ route('register') }}" target="_blank">Sign up here</a></p>
                        @endif
                        @if(Route::has('password.request'))
                            <p><a href="{{ route('password.request') }}" target="_blank">Forgot your password?</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            // Check if user is authenticated
            const isUserAuthenticated = @json(Auth::guard('user')->check());
            const currentPageUrl = @json(url()->current());
            const loginUrl = @json(route('login'));

            // Login Modal Functions
            function openLoginModal() {
                document.getElementById('loginModal').style.display = 'block';
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }

            function closeLoginModal() {
                document.getElementById('loginModal').style.display = 'none';
                document.body.style.overflow = 'auto'; // Restore scrolling
                // Reset form
                document.getElementById('loginForm').reset();
                document.getElementById('loginLoading').style.display = 'none';
                document.getElementById('loginForm').style.display = 'block';
            }

            // Handle login form submission
            function handleLogin(event) {
                event.preventDefault();
                
                const form = document.getElementById('loginForm');
                const formData = new FormData(form);
                const submitBtn = document.getElementById('loginSubmitBtn');
                const loadingDiv = document.getElementById('loginLoading');

                // Show loading state
                form.style.display = 'none';
                loadingDiv.style.display = 'block';
                submitBtn.disabled = true;

                // Send login request
                fetch('{{ route("login") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Success - show success message and reload page
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.message || 'Login successful! Refreshing page...');
                        } else {
                            alert(data.message || 'Login successful! Refreshing page...');
                        }
                        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else if (data.status === 'confirm_logout') {
                        // User is logged in on another device - ask for confirmation
                        if (confirm(data.message)) {
                            // User confirmed - force login
                            formData.append('force_login', '1');
                            handleForceLogin(formData, form, loadingDiv, submitBtn);
                        } else {
                            // User cancelled - reset form
                            form.style.display = 'block';
                            loadingDiv.style.display = 'none';
                            submitBtn.disabled = false;
                        }
                    } else {
                        // Error - show error message
                        const errorMessage = data.message || 'Login failed. Please check your credentials.';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(errorMessage);
                        } else {
                            alert(errorMessage);
                        }
                        
                        // Reset form display
                        form.style.display = 'block';
                        loadingDiv.style.display = 'none';
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Login error:', error);
                    const errorMessage = 'An error occurred during login. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMessage);
                    } else {
                        alert(errorMessage);
                    }
                    
                    // Reset form display
                    form.style.display = 'block';
                    loadingDiv.style.display = 'none';
                    submitBtn.disabled = false;
                });
            }

            // Handle force login after device confirmation
            function handleForceLogin(formData, form, loadingDiv, submitBtn) {
                fetch('{{ route("login") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.message || 'Login successful! Refreshing page...');
                        } else {
                            alert(data.message || 'Login successful! Refreshing page...');
                        }
                        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        const errorMessage = data.message || 'Login failed. Please try again.';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(errorMessage);
                        } else {
                            alert(errorMessage);
                        }
                        
                        // Reset form display
                        form.style.display = 'block';
                        loadingDiv.style.display = 'none';
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Force login error:', error);
                    const errorMessage = 'An error occurred during login. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMessage);
                    } else {
                        alert(errorMessage);
                    }
                    
                    // Reset form display
                    form.style.display = 'block';
                    loadingDiv.style.display = 'none';
                    submitBtn.disabled = false;
                });
            }

            // Global selectPlan function (accessible from anywhere)
            window.selectPlan = function(planButton) {
                
                const plan = planButton.getAttribute('data-plan');
                const sessionsAttr = planButton.getAttribute('data-sessions');
                let sessionCount = parseInt(sessionsAttr); 
                const selectedRate = parseFloat(planButton.getAttribute('data-rate'));
                
                // Store selectedRate globally
                window.selectedRate = selectedRate;
                
                // Get the selected plan input element
                const selectedPlanInput = document.getElementById('selected_plan');
                const selectedPlanDisplay = document.getElementById('selected-plan-display');
                const selectedPlanText = document.getElementById('selected-plan-text');
                
                if (selectedPlanInput) {
                    selectedPlanInput.value = plan;
                }
                
                // Values set for selected plan
                
                // Validate sessionCount
                if (isNaN(sessionCount) || sessionCount <= 0) {
                    console.error('Invalid sessionCount detected! Setting to 1 as fallback');
                    sessionCount = 1;
                }
                
                // Validate selectedRate
                if (isNaN(selectedRate) || selectedRate <= 0) {
                    console.error('Invalid selectedRate detected! Setting to 0 as fallback');
                    window.selectedRate = 0;
                }
                
                // Format the plan name for display
                const displayPlan = plan.split('_')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
                
                if (selectedPlanText && selectedPlanDisplay) {
                    selectedPlanText.textContent = `${displayPlan} Consultation (Total ${sessionCount} Sessions)`;
                    selectedPlanDisplay.style.display = 'block';
                    selectedPlanDisplay.scrollIntoView({ behavior: 'smooth' });
                }
                
                // Show date selection info and update required dates
                const dateSelectionInfo = document.getElementById('date-selection-info');
                const requiredDatesSpan = document.getElementById('required-dates');
                const selectedDatesCountSpan = document.getElementById('selected-dates-count');
                
                if (dateSelectionInfo && requiredDatesSpan && selectedDatesCountSpan) {
                    requiredDatesSpan.textContent = sessionCount;
                    
                    // Get current selected bookings
                    const selectedBookings = window.selectedBookings || {};
                    selectedDatesCountSpan.textContent = Object.keys(selectedBookings).length;
                    dateSelectionInfo.style.display = 'block';
                    
                    // Update the color based on current selection
                    const currentDateCount = Object.keys(selectedBookings).length;
                    const parentElement = selectedDatesCountSpan.parentElement;
                    if (currentDateCount === sessionCount) {
                        parentElement.style.color = '#28a745'; // Green when correct
                    } else if (currentDateCount > sessionCount) {
                        parentElement.style.color = '#dc3545'; // Red when too many
                    } else {
                        parentElement.style.color = '#2563eb'; // Blue when need more
                    }
                }
                
                // Store sessionCount globally to ensure it's accessible everywhere
                window.currentSessionCount = sessionCount;
                window.sessionCount = sessionCount; // Also store as window.sessionCount for consistency
                
                // All values set after selection
                
                // Reinitialize calendar with session limit after a small delay to ensure variables are set
                setTimeout(() => {
                    // Calendar reinitialize timeout
                    
                    if (window.initializeCalendar && window.enabledDates) {
                        window.initializeCalendar(window.enabledDates);
                    }
                }, 100);
            };

            // Global checkAuthenticationBeforePlanSelection function
            window.checkAuthenticationBeforePlanSelection = function(planButton) {
                if (!isUserAuthenticated) {
                    showLoginPopupForPlanSelection(planButton);
                } else {
                    window.selectPlan(planButton);
                }
            };

            // Global showLoginPopupForPlanSelection function
            window.showLoginPopupForPlanSelection = function(planButton) {
                // Show login popup for plan selection
                
                const plan = planButton.getAttribute('data-plan');
                const planDisplayName = plan.split('_')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');

                // Plan display name computed

                // Check if Swal is available
                if (typeof Swal === 'undefined') {
                    console.error('SweetAlert2 not loaded!');
                    alert('Please login to select a consultation plan and proceed with booking.');
                    window.location.href = "/login?redirect=" + encodeURIComponent(window.location.href);
                    return;
                }

                // Showing SweetAlert popup
                
                Swal.fire({
                    title: '👋 Login Required!',
                    html: `<p style="margin-bottom: 15px;">Please login to select the <strong>${planDisplayName}</strong> consultation plan and proceed with booking.</p>`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: '🔐 Login Now',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        popup: 'login-popup-custom',
                        confirmButton: 'login-popup-btn',
                        title: 'login-popup-title'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to login with current professional page as intended destination
                        window.location.href = "/login?redirect=" + encodeURIComponent(window.location.href);
                    }
                    // If cancelled, do nothing - user stays on current page
                });
            };

            // Initialize modal event listeners
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('loginModal');
                const closeBtn = document.querySelector('.login-modal-close');
                const loginForm = document.getElementById('loginForm');

                // Close modal when clicking the X
                if (closeBtn) {
                    closeBtn.addEventListener('click', closeLoginModal);
                }

                // Close modal when clicking outside of it
                window.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        closeLoginModal();
                    }
                });

                // Handle form submission
                if (loginForm) {
                    loginForm.addEventListener('submit', handleLogin);
                }

                // Replace all login links with modal triggers
                document.addEventListener('click', function(e) {
                    if (e.target.tagName === 'A' && e.target.href && e.target.href.includes('/login')) {
                        // Check if it's not a target="_blank" link
                        if (e.target.target !== '_blank') {
                            e.preventDefault();
                            openLoginModal();
                        }
                    }
                });

                // Handle ESC key to close modal
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeLoginModal();
                    }
                });
            });

            // Function to generate select button based on authentication status
            function generateSelectButton(rate, safeId) {
                if (!isUserAuthenticated) {
                    return `
                        <div style="position: relative;">
                            <button 
                                class="select-plan-disabled" 
                                style="background:#ccc; color:#666; border:none; border-radius:6px; padding:10px 28px; font-weight:600; font-size:1.08rem; cursor:not-allowed; opacity:0.6; width:100%;"
                                disabled
                            >
                                Login to Select ${rate.session_type.charAt(0).toUpperCase() + rate.session_type.slice(1)}
                            </button>
                            <small style="display: block; margin-top: 8px; color: #666; text-align: center;">
                                <a href="javascript:void(0);" onclick="openLoginModal()" style="color: #2563eb; text-decoration: underline;">Please login</a> to select sessions and book appointments
                            </small>
                        </div>
                    `;
                } else {
                    return `
                        <button 
                            class="select-plan" 
                            data-plan="${safeId}" 
                            data-sessions="${rate.num_sessions}" 
                            data-rate="${rate.final_rate}"
                            style="background:#2563eb; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-weight:600; font-size:1.08rem; transition:background 0.2s; box-shadow:none; outline:none; cursor:pointer;"
                            onmouseover="this.style.background='#1741a6'" onmouseout="this.style.background='#2563eb'"
                        >
                            Select ${rate.session_type.charAt(0).toUpperCase() + rate.session_type.slice(1)}
                        </button>
                    `;
                }
            }

            // Sub-service selection functionality
            let currentProfessionalId = {{ $profile->professional_id ?? 0 }};
            // Fallback to 0 if $services or its id is not set
            let currentProfessionalServiceId = {{ isset($services) && isset($services->id) ? $services->id : 0 }};

            // Function to update rates and availability based on sub-service selection
            function updateRatesAndAvailability(subServiceId = null) {
                const loadingOverlay = document.createElement('div');
                loadingOverlay.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
                loadingOverlay.style.cssText = 'position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 1000; display: flex; align-items: center; justify-content: center;';
                
                const appointmentContainer = document.querySelector('.appointment_types');
                if (appointmentContainer) {
                    appointmentContainer.style.position = 'relative';
                    appointmentContainer.appendChild(loadingOverlay);
                }

                const requestUrl = `{{ route('get.professional.rates.availability') }}?professional_id=${currentProfessionalId}&professional_service_id=${currentProfessionalServiceId}&sub_service_id=${subServiceId || ''}`;
                fetch(requestUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update rates tabs
                            updateRatesTabs(data.rates);
                            
                            // Update availability
                            updateAvailabilityData(data.enabled_dates);
                            
                            // Reinitialize calendar with new dates
                            initializeCalendar(data.enabled_dates);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating rates and availability:', error);
                        alert('Error loading data. Please try again.');
                    })
                    .finally(() => {
                        loadingOverlay.remove();
                    });
            }

            // Function to update rates tabs
            function updateRatesTabs(rates) {
                const tabsList = document.querySelector('.appointment-tabs');
                const tabContent = document.querySelector('.appointment-tab-content');
                
                if (!rates || rates.length === 0) {
                    tabsList.innerHTML = '<li class="nav-item"><span class="nav-link">No rates available for this selection</span></li>';
                    tabContent.innerHTML = '<div class="tab-pane fade show active"><div class="appointment-details"><p>No rates available for the selected service/sub-service combination.</p></div></div>';
                    return;
                }

                // Clear existing tabs
                tabsList.innerHTML = '';
                tabContent.innerHTML = '';

                rates.forEach((rate, index) => {
                    const safeId = rate.session_type.toLowerCase().replace(/\s+/g, '_');
                    const isActive = index === 0;
                    
                    // Create tab
                    const tabItem = document.createElement('li');
                    tabItem.className = 'nav-item';
                    tabItem.style.marginBottom = '0';
                    
                    const tabLink = document.createElement('a');
                    tabLink.className = `nav-link ${isActive ? 'active' : ''}`;
                    tabLink.id = `${safeId}-tab`;
                    tabLink.setAttribute('data-bs-toggle', 'tab');
                    tabLink.setAttribute('href', `#${safeId}`);
                    tabLink.setAttribute('role', 'tab');
                    tabLink.style.cssText = 'font-weight:600; border-radius: 8px 8px 0 0; padding: 3px 9px; border: 1px solid #e0e7ef; transition: background 0.2s, color 0.2s;';
                    tabLink.style.background = isActive ? '#2563eb' : '#f7f9fc';
                    tabLink.style.color = isActive ? '#fff' : '#222';
                    tabLink.textContent = rate.session_type.charAt(0).toUpperCase() + rate.session_type.slice(1);
                    
                    tabItem.appendChild(tabLink);
                    tabsList.appendChild(tabItem);
                    
                    // Create tab content
                    const tabPane = document.createElement('div');
                    tabPane.className = `tab-pane fade ${isActive ? 'show active' : ''}`;
                    tabPane.id = safeId;
                    tabPane.setAttribute('role', 'tabpanel');
                    tabPane.setAttribute('aria-labelledby', `${safeId}-tab`);
                    
                    const perText = {
                        'free hand': 'per session',
                        'weekly': 'per week',
                        'monthly': 'per month',
                        'quarterly': 'per 3 months'
                    }[rate.session_type.toLowerCase()] || 'per session';
                    
                    tabPane.innerHTML = `
                        <div class="appointment-details" style="max-width:500px; margin:auto;">
                            <h4 style="font-weight:700; color:#222; margin-bottom:10px;">${rate.session_type.charAt(0).toUpperCase() + rate.session_type.slice(1)} Consultation</h4>
                            <p style="color:#555; margin-bottom:18px;">Professional consultation service</p>
                            <ul class="appointment-features" style="padding-left:0; list-style:none; margin-bottom:22px;">
                                <li style="margin-bottom:7px; color:#2563eb;"><i class="icon_check_alt2"></i> <span style="color:#444;">${rate.num_sessions} sessions</span></li>
                                <li style="color:#2563eb;"><i class="icon_check_alt2"></i> <span style="color:#444;">Curated solutions for you</span></li>
                            </ul>
                            <div class="price" style="margin-bottom:18px;">
                                <strong style="font-size:2rem; color:#2563eb; font-weight:700;">Rs. ${Number(rate.final_rate).toFixed(2)}</strong><br>
                                <small style="font-size:1rem; color:#666;">${perText}</small>
                            </div>
                            ${generateSelectButton(rate, safeId)}
                        </div>
                    `;
                    
                    tabContent.appendChild(tabPane);
                });

                // Re-attach event listeners for new select buttons
                attachSelectPlanListeners();
            }

            // Function to update availability data
            function updateAvailabilityData(newEnabledDates) {
                window.enabledDates = newEnabledDates || [];
                // Keep local reference for backward compatibility
                enabledDates = window.enabledDates;
            }

            // Auto-load rates for pre-selected sub-service from URL
            document.addEventListener('DOMContentLoaded', function() {
                // Get sub-service ID from URL parameter (passed from gridlisting filter)
                const requestedSubServiceId = @json($requestedSubServiceId ?? null);
                
                // Always trigger update with the URL sub-service parameter
                // If requestedSubServiceId is null, it will show service-level rates
                // If requestedSubServiceId has a value, it will show sub-service-specific rates
                updateRatesAndAvailability(requestedSubServiceId);
            });

            // Function to attach select plan listeners
            function attachSelectPlanListeners() {
                document.querySelectorAll('.select-plan').forEach(button => {
                    button.addEventListener('click', function() {
                        
                        // Check authentication before plan selection
                        if (!isUserAuthenticated) {
                            // User not authenticated - show login modal
                            window.checkAuthenticationBeforePlanSelection(this);
                            return;
                        }
                        
                        // User is authenticated, proceed with plan selection
                        // User authenticated - proceed with plan selection
                        window.selectPlan(this);
                        
                        // Remove active class from all buttons
                        document.querySelectorAll('.select-plan').forEach(btn => {
                            btn.style.background = '#2563eb';
                            btn.textContent = btn.textContent.replace(' ✓', '');
                        });
                        
                        // Add active state to clicked button
                        this.style.background = '#1741a6';
                        this.textContent += ' ✓';
                    });
                });
            }

            document.addEventListener("DOMContentLoaded", function () {
                // Make these globally accessible
                window.enabledDates = @json($enabledDates);
                window.selectedRate = 0; // Initialize global selectedRate
                
                // Get existing bookings for this professional
                const existingBookings = @json($existingBookings ?? []);
                
                // Existing bookings and enabled dates are available for internal use
                
                window.selectedBookings = {};

                // Helper function to format the date to local date string
                function formatLocalDate(date) {
                    const offset = date.getTimezoneOffset();
                    const localDate = new Date(date.getTime() - offset * 60000);
                    return localDate.toISOString().split('T')[0];
                }

                // Function to initialize calendar
                function initializeCalendar(dates) {
                    // Initialize calendar with provided dates
                    // Destroy existing flatpickr instance if it exists
                    const calendarElement = document.getElementById('calendarDiv');
                    if (!calendarElement) {
                        console.error('Calendar element not found!');
                        return; // nothing to do without element
                    }
                    if (calendarElement._flatpickr && typeof calendarElement._flatpickr.destroy === 'function') {
                        calendarElement._flatpickr.destroy();
                    }

                    // Initialize new flatpickr with updated dates
                    if (typeof flatpickr !== 'function') {
                        console.warn('flatpickr is not available');
                        return;
                    }
                    
                    // Normalize enabled dates to YYYY-MM-DD format
                    const normalizedEnabledDates = Array.isArray(dates) ? dates.filter(date => date && typeof date === 'string') : [];
                    console.log('Initializing calendar with enabled dates:', normalizedEnabledDates);
                    
                    // Create date boundaries - today to 6 months from now
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const maxDate = new Date();
                    maxDate.setMonth(maxDate.getMonth() + 6); // 6 months from today
                    
                    flatpickr("#calendarDiv", {
                        inline: true,
                        mode: "multiple",
                        dateFormat: "Y-m-d",
                        minDate: today,
                        maxDate: maxDate,
                        onDayCreate: function(dObj, dStr, fp, dayElem) {
                            // Use local date without timezone conversion to avoid day shift
                            const dayDate = new Date(dayElem.dateObj);
                            const year = dayDate.getFullYear();
                            const month = String(dayDate.getMonth() + 1).padStart(2, '0');
                            const day = String(dayDate.getDate()).padStart(2, '0');
                            const dateStr = `${year}-${month}-${day}`;
                            
                            dayDate.setHours(0, 0, 0, 0);
                            
                            // Skip past dates
                            if (dayDate < today) {
                                return;
                            }
                            
                            // Check if this date has available slots (same as admin booking)
                            if (normalizedEnabledDates.includes(dateStr)) {
                                // Highlight dates that have availability with green background
                                dayElem.classList.add('has-available-slots');
                                dayElem.style.background = 'linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%)';
                                dayElem.style.border = '2px solid #28a745';
                                dayElem.style.color = '#155724';
                                dayElem.style.fontWeight = 'bold';
                                dayElem.title = `Available slots on ${dateStr}`;
                            } else {
                                // No availability for this date
                                dayElem.title = `No availability on ${dateStr}`;
                            }
                        },
                        onChange: function (selectedDates, dateStr, instance) {
                            // Only enforce session count limit if a plan has been selected
                            const currentSessionCount = sessionCount || window.currentSessionCount || 0;
                            if (currentSessionCount > 0 && selectedDates.length > currentSessionCount) {
                                // If too many dates selected, remove the last one
                                selectedDates.pop();
                                instance.setDate(selectedDates);
                                if (typeof toastr !== 'undefined') {
                                    toastr.warning(`You can only select ${currentSessionCount} date(s) for this session type.`);
                                } else {
                                    alert(`You can only select ${currentSessionCount} date(s) for this session type.`);
                                }
                                return;
                            }
                            
                            // If no plan selected yet, show a helpful message
                            if (currentSessionCount === 0 && selectedDates.length > 0) {
                                // Double check if plan display is visible (means plan was selected)
                                const planDisplay = document.getElementById('selected-plan-display');
                                if (!planDisplay || planDisplay.style.display === 'none') {
                                    if (typeof toastr !== 'undefined') {
                                        toastr.info('Please select a consultation plan first to determine how many dates you can choose.');
                                    } else {
                                        alert('Please select a consultation plan first to determine how many dates you can choose.');
                                    }
                                    return;
                                }
                            }
                            
                            handleDateSelection(selectedDates);
                        }
                    });
                }

                    // Expose initializer globally so other functions can call it
                    window.initializeCalendar = initializeCalendar;

                // Function to handle date selection
                function handleDateSelection(selectedDates) {
                    const offset = selectedDates.length ? selectedDates[0].getTimezoneOffset() : 0;
                    const selectedDatesLocal = selectedDates.map(d => {
                        return new Date(d.getTime() - offset * 60000).toISOString().split('T')[0];
                    });

                    // Remove unselected dates from selectedBookings
                    Object.keys(window.selectedBookings).forEach(date => {
                        if (!selectedDatesLocal.includes(date)) {
                            delete window.selectedBookings[date];
                        }
                    });

                    // Update selected dates counter
                    const selectedDatesCountSpan = document.getElementById('selected-dates-count');
                    if (selectedDatesCountSpan) {
                        selectedDatesCountSpan.textContent = selectedDates.length;
                        
                        // Only show color-coded feedback if a plan has been selected
                        const parentElement = selectedDatesCountSpan.parentElement;
                        const currentSessionCount = sessionCount || window.currentSessionCount || 0;
                        if (currentSessionCount > 0) {
                            if (selectedDates.length === currentSessionCount) {
                                parentElement.style.color = '#28a745'; // Green when correct
                            } else if (selectedDates.length > currentSessionCount) {
                                parentElement.style.color = '#dc3545'; // Red when too many
                            } else {
                                parentElement.style.color = '#2563eb'; // Blue when need more
                            }
                        } else {
                            // No plan selected yet, use neutral color
                            parentElement.style.color = '#6c757d'; // Gray/neutral
                        }
                    }

                    // Hide all slot boxes first
                    document.querySelectorAll('.slot-box').forEach(box => {
                        box.style.display = 'none';
                        box.removeAttribute('data-current-date');
                        // Reset any previous selections for unselected dates
                        const timeInput = box.querySelector('.time-slot');
                        if (timeInput && !selectedDatesLocal.includes(box.getAttribute('data-current-date'))) {
                            timeInput.checked = false;
                        }
                    });

                    // Show/hide no slots message
                    const noSlotsMessage = document.getElementById('no-slots-message');

                    // Show slots for last selected date only (if any date is selected)
                    if (selectedDates.length > 0) {
                        if (noSlotsMessage) noSlotsMessage.style.display = 'none';
                        const selectedDateUTC = selectedDates[selectedDates.length - 1];
                        const selectedDate = new Date(selectedDateUTC.getTime() - offset * 60000);
                        const weekdayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
                        const weekday = weekdayNames[selectedDate.getDay()];
                        const dateString = selectedDate.toISOString().split('T')[0];

                        console.log('Date selected:', dateString, '(', weekday, ')');

                        // Show available slots for this weekday and check if they're booked
                        const matchingBoxes = document.querySelectorAll(`.slot-box[data-weekday="${weekday}"]`);
                        console.log('Showing slots for', weekday, '- Found:', matchingBoxes.length, 'slots');
                        
                        matchingBoxes.forEach(box => {
                            box.style.display = 'flex';
                            box.style.visibility = 'visible';
                            box.setAttribute('data-current-date', dateString);
                            
                            // Check if the slot is already booked
                            const timeInput = box.querySelector('.time-slot');
                            if (timeInput) {
                                const timeValue = timeInput.value;
                                const label = timeInput.nextElementSibling;
                                
                                // Reset any previous styling
                                timeInput.disabled = false;
                                timeInput.checked = false;
                                box.classList.remove('slot-booked');
                                if (label) {
                                    label.style.opacity = '';
                                    label.style.textDecoration = '';
                                    // Remove previous BOOKED text
                                    if (label.innerHTML.includes('(BOOKED)')) {
                                        label.innerHTML = label.innerHTML.replace(/ <span[^>]*>\(BOOKED\)<\/span>/g, '');
                                    }
                                }
                                
                                // Check if this slot is booked for the selected date
                                if (typeof isTimeSlotBooked === 'function' && isTimeSlotBooked(dateString, timeValue)) {
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

                        if (typeof updateSelectedTimeDisplay === 'function') {
                            updateSelectedTimeDisplay();
                        }
                        if (typeof updateSelectedTimeList === 'function') {
                            updateSelectedTimeList();
                        }
                    } else {
                        // No dates selected, show the message
                        if (noSlotsMessage) noSlotsMessage.style.display = 'block';
                    }
                }

                // Initialize select plan listeners on page load
                attachSelectPlanListeners();

                // Initialize calendar with default enabled dates
                initializeCalendar(enabledDates);

                // Ensure no slots are shown initially - user must select a date first
                // Make sure the "no slots message" is visible on page load
                const noSlotsMessage = document.getElementById('no-slots-message');
                if (noSlotsMessage) {
                    noSlotsMessage.style.display = 'block';
                }
                
                // Hide all slot boxes on initial load
                document.querySelectorAll('.slot-box').forEach(box => {
                    box.style.display = 'none';
                });
                
                console.log('Page loaded: Time slots hidden until user selects a date from calendar');

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

                // Handle slot selection
                document.querySelectorAll('.time-slot').forEach(slot => {
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
                            document.querySelectorAll(`.slot-box[data-current-date="${currentDate}"] .time-slot`).forEach(input => {
                                input.checked = (input.value === selectedTime);
                            });

                            updateSelectedTimeList();
                            
                            // Update selected dates counter when a time slot is selected
                            const selectedDatesCountSpan = document.getElementById('selected-dates-count');
                            if (selectedDatesCountSpan) {
                                const currentDateCount = Object.keys(selectedBookings).length;
                                selectedDatesCountSpan.textContent = currentDateCount;
                                
                                // Update color based on requirement
                                const parentElement = selectedDatesCountSpan.parentElement;
                                const currentSessionCount = sessionCount || window.currentSessionCount || 0;
                                if (currentSessionCount > 0) {
                                    if (currentDateCount === currentSessionCount) {
                                        parentElement.style.color = '#28a745'; // Green when correct
                                    } else if (currentDateCount > currentSessionCount) {
                                        parentElement.style.color = '#dc3545'; // Red when too many
                                    } else {
                                        parentElement.style.color = '#2563eb'; // Blue when need more
                                    }
                                }
                            }
                        }
                    });
                });
                
                // Add CSS for booked slots
                const style = document.createElement('style');
                style.textContent = `
                    .slot-booked {
                        opacity: 0.6;
                        position: relative;
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
                `;
                document.head.appendChild(style);

                // Function to update selected time display
                function updateSelectedTimeDisplay() {
                    const selectedTimeElement = document.getElementById('selected_time');
                    const selectedTimes = Object.values(selectedBookings).flat();
                    
                    if (selectedTimeElement) {
                        if (selectedTimes.length > 0) {
                            selectedTimeElement.textContent = `${selectedTimes.length} slot(s) selected`;
                        } else {
                            selectedTimeElement.textContent = 'Select time slots';
                        }
                    }
                }

                function updateSelectedTimeList() {
                    const list = document.getElementById('selected-time-list');
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
                                
                                // Update selected dates counter
                                const selectedDatesCountSpan = document.getElementById('selected-dates-count');
                                if (selectedDatesCountSpan) {
                                    const currentDateCount = Object.keys(selectedBookings).length;
                                    selectedDatesCountSpan.textContent = currentDateCount;
                                    
                                    // Update color based on requirement
                                    const parentElement = selectedDatesCountSpan.parentElement;
                                    const currentSessionCount = sessionCount || window.currentSessionCount || 0;
                                    if (currentSessionCount > 0) {
                                        if (currentDateCount === currentSessionCount) {
                                            parentElement.style.color = '#28a745'; // Green when correct
                                        } else if (currentDateCount > currentSessionCount) {
                                            parentElement.style.color = '#dc3545'; // Red when too many
                                        } else {
                                            parentElement.style.color = '#2563eb'; // Blue when need more
                                        }
                                    }
                                }
                            });
                        });
                    } else {
                        console.warn('Selected time list element not found!');
                    }
                }

                // Handle plan selection
                const planButtons = document.querySelectorAll('.select-plan');
                const selectedPlanDisplay = document.getElementById('selected-plan-display');
                const selectedPlanText = document.getElementById('selected-plan-text');
                const selectedPlanInput = document.getElementById('selected_plan');
                let sessionCount = 0; 
                let selectedRate = 0;

                planButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        // First check if user is logged in before allowing plan selection
                        checkAuthenticationBeforePlanSelection(this);
                    });
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
                        console.error('Error checking login status:', error);
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
                        console.error('SweetAlert2 not loaded!');
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
                    const sessionsAttr = planButton.getAttribute('data-sessions');
                    sessionCount = parseInt(sessionsAttr); 
                    selectedRate = parseFloat(planButton.getAttribute('data-rate'));
                    selectedPlanInput.value = plan;
                    
                    // Debug: ensure sessionCount is valid
                    
                    // Validate sessionCount
                    if (isNaN(sessionCount) || sessionCount <= 0) {
                        console.error('Invalid sessionCount detected! Setting to 1 as fallback');
                        sessionCount = 1;
                    }
                    
                    // Format the plan name for display
                    const displayPlan = plan.split('_')
                        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                        .join(' ');
                        
                    selectedPlanText.textContent = `${displayPlan} Consultation (Total ${sessionCount} Sessions)`;
                    selectedPlanDisplay.style.display = 'block';
                    selectedPlanDisplay.scrollIntoView({ behavior: 'smooth' });
                    
                    // Show date selection info and update required dates
                    const dateSelectionInfo = document.getElementById('date-selection-info');
                    const requiredDatesSpan = document.getElementById('required-dates');
                    const selectedDatesCountSpan = document.getElementById('selected-dates-count');
                    
                    if (dateSelectionInfo && requiredDatesSpan && selectedDatesCountSpan) {
                        requiredDatesSpan.textContent = sessionCount;
                        selectedDatesCountSpan.textContent = Object.keys(selectedBookings).length;
                        dateSelectionInfo.style.display = 'block';
                        
                        // Update the color based on current selection
                        const currentDateCount = Object.keys(selectedBookings).length;
                        const parentElement = selectedDatesCountSpan.parentElement;
                        if (currentDateCount === sessionCount) {
                            parentElement.style.color = '#28a745'; // Green when correct
                        } else if (currentDateCount > sessionCount) {
                            parentElement.style.color = '#dc3545'; // Red when too many
                        } else {
                            parentElement.style.color = '#2563eb'; // Blue when need more
                        }
                    }
                    
                    // Store sessionCount globally to ensure it's accessible everywhere
                    window.currentSessionCount = sessionCount;
                    
                    
                    
                    // Reinitialize calendar with session limit after a small delay to ensure variables are set
                        setTimeout(() => {
                        if (window.initializeCalendar) {
                            initializeCalendar(enabledDates);
                        }
                    }, 100);
                }

                // Handle booking submission
                const bookingButton = document.querySelector('.booking') || document.getElementById('bookNowBtn');
                if (bookingButton) {
                    bookingButton.addEventListener('click', function (e) {
                        e.preventDefault();
                        
                        // Proceed directly with booking since auth check happened at plan selection
                        proceedWithBooking();
                    });
                } else {
                    console.error('Booking button not found!');
                }

                // Function to proceed with booking (for authenticated users)
                function proceedWithBooking() {
                    const planType = selectedPlanInput.value;
                    const bookingData = selectedBookings;

                    // Get the number of dates selected by the user
                    const selectedDatesCount = Object.keys(bookingData).length;
                    
                    // Get current session count with multiple fallbacks
                    const currentSessionCount = sessionCount || window.currentSessionCount || 0;
                    
                    // CRITICAL: Don't allow booking if no dates are selected at all
                    if (selectedDatesCount === 0) {
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Please select at least one date from the calendar before booking.');
                        } else {
                            alert('Please select at least one date from the calendar before booking.');
                        }
                        
                        // Scroll to calendar
                        const calendarDiv = document.getElementById('calendarDiv');
                        if (calendarDiv) {
                            calendarDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        return;
                    }
                    
                    // Check plan display state
                    const planDisplay = document.getElementById('selected-plan-display');
                    const planIsVisible = planDisplay && planDisplay.style.display !== 'none';

                    if (!planType || currentSessionCount === 0) {
                        // Additional check for plan display visibility
                        const planDisplay = document.getElementById('selected-plan-display');
                        const planIsVisible = planDisplay && planDisplay.style.display !== 'none';
                        
                        if (!planIsVisible && !planType) {
                            if (typeof toastr !== 'undefined') {
                                toastr.error('Please select a consultation plan first.');
                            } else {
                                alert('Please select a consultation plan first.');
                            }
                            
                            // Scroll to plan selection area
                            const planSection = document.querySelector('.appointment_types');
                            if (planSection) {
                                planSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            return;
                        }
                    }

                    if (selectedDatesCount !== currentSessionCount) {
                        let message;
                        if (selectedDatesCount === 0) {
                            message = `Please select ${currentSessionCount} date(s) from the calendar to proceed with booking.`;
                        } else if (selectedDatesCount < currentSessionCount) {
                            message = `You need to select ${currentSessionCount - selectedDatesCount} more date(s). Currently selected: ${selectedDatesCount}/${currentSessionCount}`;
                        } else {
                            message = `You have selected too many dates. Please select only ${currentSessionCount} date(s). Currently selected: ${selectedDatesCount}/${currentSessionCount}`;
                        }
                        
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                        
                        const calendarDiv = document.getElementById('calendarDiv');
                        if (calendarDiv) {
                            calendarDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        return;
                    }

                    // Check that each selected date has a time slot
                    const datesWithoutTimeSlots = [];
                    Object.keys(bookingData).forEach(date => {
                        if (!bookingData[date] || bookingData[date].length === 0) {
                            datesWithoutTimeSlots.push(date);
                        }
                    });

                    if (datesWithoutTimeSlots.length > 0) {
                        const message = `Please select a time slot for the following date(s): ${datesWithoutTimeSlots.join(', ')}`;
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                        
                        // Scroll to time selection area
                        const timeDropdown = document.querySelector('.dropdown.time');
                        if (timeDropdown) {
                            timeDropdown.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
                    
                    // Get sub-service information from URL parameter (no dropdown anymore)
                    const selectedSubServiceId = @json($requestedSubServiceId ?? null);
                    const selectedSubServiceName = selectedSubServiceId ? 
                        @json($services && $services->subServices ? $services->subServices->where('id', $requestedSubServiceId)->first()->name ?? null : null) : null;
                    
                    // Format the bookings data into the expected structure
                    const formattedBookings = {};
                    Object.keys(bookingData).forEach(date => {
                        formattedBookings[date] = bookingData[date];
                    });
                    
                    // Use global selectedRate with fallback
                    const finalRate = window.selectedRate || 0;
                    
                    // Prepare to submit booking
                    
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
                            total_amount: finalRate,
                            sub_service_id: selectedSubServiceId,
                            sub_service_name: selectedSubServiceName
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
                            if (typeof toastr !== 'undefined') {
                                toastr.info(message);
                            } else {
                                alert(message);
                            }
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