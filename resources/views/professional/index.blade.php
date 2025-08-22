@extends('professional.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
<style>
    /* Global Layout Structure Fixes */
    * {
        box-sizing: border-box;
    }
    
    html, body {
        overflow-x: hidden !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Fix the main layout containers */
    .app-container {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
    
    .main-content {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
        margin-left: var(--sidebar-width, 250px);
    }
    
    .header {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
        position: sticky !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        margin: 0 !important;
        box-sizing: border-box !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
    }
    
    .content-wrapper {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
        margin: 0 !important;
        padding: 20px 30px !important;
        box-sizing: border-box !important;
    }
    
    .page-header {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
        margin: 0 !important;
        box-sizing: border-box !important;
    }
    
    /* Fix responsive layout issues */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }
        
        .header {
            padding: 0 15px !important;
            flex-wrap: nowrap !important;
        }
        
        .header-left {
            flex: 1 !important;
            max-width: calc(100% - 120px) !important;
            overflow: hidden !important;
        }
        
        .header-right {
            flex-shrink: 0 !important;
            max-width: 120px !important;
            overflow: hidden !important;
        }
        
        .content-wrapper {
            padding: 15px !important;
        }
        
        .sidebar {
            transform: translateX(-100%) !important;
        }
        
        .sidebar.active {
            transform: translateX(0) !important;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .main-content {
            margin-left: var(--sidebar-width, 250px) !important;
        }
        
        .content-wrapper {
            padding: 20px !important;
        }
        
        .header-left {
            flex: 1 !important;
            max-width: calc(100% - 250px) !important;
        }
        
        .header-right {
            flex-shrink: 0 !important;
            max-width: 250px !important;
        }
    }
    
    /* Prevent any element from causing horizontal scroll */
    .row, .col, [class*="col-"] {
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
    
    /* Enhanced Dashboard Cards */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(320px, 1fr));
        gap: 32px;
        margin-bottom: 40px;
        justify-content: center;
        width: max-content;
        margin-left: auto;
        margin-right: auto;
    }
    .card {
        position: relative;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 22px 18px;
        display: flex;
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
        border: none;
        height: 100%;
        min-width: 360px;
        max-width: 520px;
        background: #f5e9da;
        color: #a67c52;
    }
    .card-primary, .card-success, .card-warning, .card-danger {
        background: #f5e9da !important;
        color: #a67c52 !important;
    }
    .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #f3d6c2;
        margin-right: 16px;
        flex-shrink: 0;
    }
    .card-icon i {
        font-size: 28px;
        color: #a67c52;
    }
    .card-info h4 {
        font-size: 17px;
        margin-bottom: 7px;
       color: #a67c52;
    }
    .card-info h2 {
        font-size: 30px;
        margin-bottom: 10px;
        color: #a67c52;
    }
    .card p {
        font-size: 15px;
        color: #a67c52;
    }
    .view-btn {
        padding: 7px 18px;
        border-radius: 18px;
        background: #f3d6c2;
        color: #a67c52;
        font-size: 15px;
        margin-top: 10px;
    }
    .view-btn i {
        margin-right: 6px;
        font-size: 15px;
    }
    @media (max-width: 768px) {
        .card-grid {
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 12px;
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }
        .card {
            padding: 12px;
            min-width: 120px;
            max-width: 100%;
        }
    }
    .card:hover .card-icon {
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.10); }
        100% { transform: scale(1); }
    }
    
    /* Recent events section */
    .recent-events {
        margin-top: 40px;
    }
    
    .section-title {
        font-size: 20px;
        margin-bottom: 20px;
        font-weight: 600;
        color: #333;
        border-left: 4px solid #3498db;
        padding-left: 12px;
    }
    
    .event-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .event-card {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .event-img {
        height: 160px;
        overflow: hidden;
        position: relative;
    }
    
    .event-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .event-card:hover .event-img img {
        transform: scale(1.1);
    }
    
    .event-date {
        position: absolute;
        bottom: 0;
        left: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        font-size: 14px;
    }
    
    .event-body {
        padding: 15px;
    }
    
    .event-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    
    .event-desc {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .event-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f9f9f9;
        border-top: 1px solid #eee;
    }
    
    .event-price {
        font-weight: 600;
        color: #2980b9;
    }
    
    .book-btn {
        padding: 5px 15px;
        background: #2980b9;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .book-btn:hover {
        background: #3498db;
        transform: scale(1.05);
    }
</style>
<style>

    
    /* Alert Styles */
    .notifications-container {
        margin-bottom: 30px;
    }
    
    .alert {
        padding: 20px;
        margin-bottom: 15px;
        position: relative;
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .alert-dismissible .btn-close {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 20px;
        font-weight: 700;
        line-height: 1;
        color: inherit;
        background: transparent;
        border: 0;
        opacity: 0.5;
        cursor: pointer;
    }
    
    .alert-dismissible .btn-close:hover {
        opacity: 1;
    }
    
    .alert-success {
        background-color: #d4edda !important;
        border-left: 4px solid #28a745 !important;
        color: #155724 !important;
    }
    
    .alert-warning {
        background-color: #fff3cd !important;
        border-left: 4px solid #ffc107 !important;
        color: #856404 !important;
    }
    
    .alert h5 {
        margin-bottom: 6px;
        font-weight: 600;
    }
    
    /* Enhanced Dashboard Cards */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 30px;
    }

    .card {
        position: relative;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 24px;
        display: flex;
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
        border: none;
        height: 100%;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }
    
    .card:active {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .card:after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 6px;
        background: rgba(255, 255, 255, 0.3);
    }
    
    .card-primary {
        background: linear-gradient(135deg, #2980b9, #3498db);
        color: white;
    }
    
    .card-success {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        color: white;
    }
    
    .card-warning {
        background: linear-gradient(135deg, #f39c12, #f1c40f);
        color: white;
    }
    
    .card-danger {
        background: linear-gradient(135deg, #c0392b, #e74c3c);
        color: white;
    }
    
    .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        margin-right: 18px;
        flex-shrink: 0;
    }
    
    .card-icon i {
        font-size: 32px;
        color: white;
    }
    
    .card-info {
        flex: 1;
    }
    
    .card-info h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 8px;
        color: #a67c52;
    }
    
    .card-info h2 {
        margin: 0;
        font-size: 34px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #a67c52; !important;
    }
    
    .card p {
        margin: 0;
        font-size: 15px;
        opacity: 0.9;
    }
    
    .positive {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .negative {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .fa-arrow-up, .fa-calendar, .fa-check-circle {
        margin-right: 5px;
    }
    
    .fa-arrow-down {
        margin-right: 5px;
    }
    
    /* View Button */
    .view-btn {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 14px;
        transition: all 0.2s;
        text-decoration: none;
        margin-top: 12px;
    }
    
    .view-btn i {
        margin-right: 6px;
        font-size: 14px;
    }
    
    .card:hover .view-btn {
        background: rgba(255, 255, 255, 0.3);
    }
    
    /* Enhanced for mobile */
    @media (max-width: 768px) {
        .card-grid {
            grid-template-columns: 1fr;
        }
        
        .card {
            margin-bottom: 15px;
        }
    }
    
    /* Pulse animation for attention on hover */
    .card:hover .card-icon {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* Table styling */
    .content-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .card-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
    
    .card-action {
        display: flex;
        gap: 10px;
    }
    
    .card-action button {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        background: #f1f1f1;
        color: #333;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .card-action button:hover {
        background: #e1e1e1;
    }
    
    .card-action button a {
        color: #333;
        text-decoration: none;
    }
    
    /* Table styling */
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table th {
        padding: 15px 24px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        color: #555;
        border-bottom: 1px solid #e9ecef;
        background-color: #f8f9fa;
    }
    
    .table td {
        padding: 15px 24px;
        font-size: 14px;
        color: #333;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .warning {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .info {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .secondary {
        background-color: #e9ecef;
        color: #383d41;
    }
    
    .user-profile {
        display: flex;
        align-items: center;
    }
    
    .user-profile img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }
    
    .user-info h5 {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #f1f1f1;
        color: #333;
        margin-right: 5px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .action-btn:hover {
        background: #e1e1e1;
    }
    
    /* Table horizontal scrolling for mobile */
    .table-responsive-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    }
    
    .dashboard-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
</style>
<style>
    /* Enhanced Dashboard Cards */
    .card-grid-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        width: 100%;
        margin-top: 24px;
        margin-bottom: 28px;
    }
    .card-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(340px, 1fr));
        gap: 28px;
    }

    .card {
        position: relative;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        padding: 32px 28px;
        display: flex;
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
        border: none;
        height: 100%;
        min-width: 320px;
        max-width: 480px;
        background: #f5e9da;
        color: #a67c52;
    }
    
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .card:active {
        transform: translateY(0);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }
    
    .card:after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 6px;
        background: rgba(166, 124, 82, 0.10); /* Subtle accent */
    }
    
    /* Unique colors for each card */
    .card-primary {
        background: #f5e9da !important; /* Nude beige */
        color: #a67c52 !important;
    }
    .card-primary .card-icon {
        background: #f3d6c2;
    }
    .card-primary .card-icon i {
        color: #a67c52;
    }

    .card-success {
        background: #e9f5da !important; /* Soft green nude */
        color: #6d8a4c !important;
    }
    .card-success .card-icon {
        background: #d6eac2;
    }
    .card-success .card-icon i {
        color: #6d8a4c;
    }

    .card-warning {
        background: #f5f0da !important; /* Soft yellow nude */
        color: #b89c4e !important;
    }
    .card-warning .card-icon {
        background: #f3eac2;
    }
    .card-warning .card-icon i {
        color: #b89c4e;
    }

    .card-danger {
        background: #f5dadf !important; /* Soft pink nude */
        color: #b86a7a !important;
    }
    .card-danger .card-icon {
        background: #f3c2ce;
    }
    .card-danger .card-icon i {
        color: #b86a7a;
    }
    
    .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: rgba(166, 124, 82, 0.13);
        margin-right: 16px;
        flex-shrink: 0;
        transition: background 0.3s;
    }
    
    .card-icon i {
        font-size: 34px;
        color: #a67c52;
        transition: color 0.3s;
    }
    
    .card-info {
        flex: 1;
    }
    
    .card-info h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 500;
        opacity: 0.92;
        margin-bottom: 7px;
    }
    
    .card-info h2 {
        margin: 0;
        font-size: 38px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .card p {
        margin: 0;
        font-size: 17px;
        opacity: 0.92;
    }
    
    .positive, .negative {
        color: inherit !important;
    }
    
    .fa-arrow-up, .fa-calendar, .fa-check-circle {
        margin-right: 5px;
    }
    
    .fa-arrow-down {
        margin-right: 5px;
    }
    
    /* View Button */
    .view-btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 24px;
        border-radius: 18px;
        background: rgba(166, 124, 82, 0.13);
        color: #a67c52;
        font-size: 17px;
        transition: all 0.2s;
        text-decoration: none;
        margin-top: 10px;
    }
    
    .view-btn i {
        margin-right: 6px;
        font-size: 15px;
    }
    
    .card:hover .view-btn {
        background: rgba(166, 124, 82, 0.20);
    }
    
    /* Enhanced for mobile */
    @media (max-width: 768px) {
        .card-grid {
            grid-template-columns: 1fr;
        }
        .card {
            min-width: 90vw;
            max-width: 100vw;
            padding: 22px 10px;
        }
    }
    
    /* Additional mobile header fixes */
    @media (max-width: 767px) {
        .header-left {
            flex: 1;
            max-width: calc(100% - 100px);
        }
        
        .header-right {
            flex-shrink: 0;
            margin-left: auto;
        }
        
        .search-box input {
            width: 150px !important;
            max-width: 150px !important;
        }
        
        .user-profile {
            margin-left: 10px !important;
        }
    }
    
    /* Tablet specific fixes */
    @media (min-width: 768px) and (max-width: 1024px) {
        .header-left {
            flex: 1;
            max-width: calc(100% - 200px);
        }
        
        .search-box input {
            width: 200px !important;
            max-width: 200px !important;
        }
    }
    
    /* Pulse animation for attention on hover */
    .card:hover .card-icon {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.10);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* Table styling */
    .content-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .card-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
    
    .card-action {
        display: flex;
        gap: 10px;
    }
    
    .card-action button {
        padding: 10px 22px;
        border-radius: 24px;
        border: none;
        background: #f3d6c2;
        color: #a67c52;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s;
        margin-left: 10px;
        box-shadow: 0 2px 8px rgba(243, 214, 194, 0.18);
        outline: none;
    }
    .card-action button:first-child {
        margin-left: 0;
    }
    .card-action button:hover, .card-action button:focus {
        background: #f5e9da;
        color: #a67c52;
        box-shadow: 0 4px 16px rgba(166, 124, 82, 0.10);
    }
    .card-action button a {
        color: inherit;
        text-decoration: none;
        font-weight: 600;
    }
    
    /* Table styling */
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table th {
        padding: 18px 32px;
        text-align: left;
        font-weight: 700;
        font-size: 16px;
        color: #a67c52;
        background: #f3d6c2;
        border-bottom: 3px solid #e9cbb2;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    
    .table td {
        padding: 15px 24px;
        font-size: 14px;
        color: #333;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .warning {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .info {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .secondary {
        background-color: #e9ecef;
        color: #383d41;
    }
    
    .user-profile {
        display: flex;
        align-items: center;
    }
    
    .user-profile img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }
    
    .user-info h5 {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #f1f1f1;
        color: #333;
        margin-right: 5px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .action-btn:hover {
        background: #e1e1e1;
    }
    
    /* Table horizontal scrolling for mobile */
    .table-responsive-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    }
    
    .dashboard-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
</style>
@endsection
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Dashboard</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Dashboard</li>
        </ul>
    </div>
    
    @php
        use App\Models\ProfessionalOtherInformation;
        
        // Check for new bookings in the last 24 hours
        $professionalId = Auth::guard('professional')->id();
        $yesterday = \Carbon\Carbon::now()->subDay();
        $newBookings = \App\Models\Booking::where('professional_id', $professionalId)
            ->where('created_at', '>=', $yesterday)
            ->count();
        
        // Check if professional has services
        $hasServices = \App\Models\ProfessionalService::where('professional_id', $professionalId)->exists();
        
        // Check if professional has rates configured
        $hasRates = \App\Models\Rate::where('professional_id', $professionalId)->exists();
        
        // Check if professional has availability defined
        $hasAvailability = \App\Models\Availability::where('professional_id', $professionalId)->exists();
        
        // Check if professional has requested services (other information)
        $hasRequestedServices = \App\Models\ProfessionalOtherInformation::where('professional_id', $professionalId)->exists();
    @endphp
    
    <!-- Notifications and Alerts Section -->
    <div class="notifications-container" style="margin-bottom: 25px;">
        @if($newBookings > 0)
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #28a745; background-color: #d4edda; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-bell" style="font-size: 20px; margin-right: 12px; color: #28a745;"></i>
                    <div>
                        <h5 style="margin: 0 0 4px 0; color: #155724; font-weight: 600;">New Booking Alert!</h5>
                        <p style="margin: 0; color: #155724;">You have {{ $newBookings }} new booking(s) in the last 24 hours. <a href="{{ route('professional.booking.index') }}" style="color: #155724; text-decoration: underline; font-weight: 600;">View details</a></p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(!$hasServices || !$hasRates || !$hasAvailability || !$hasRequestedServices)
            <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-left: 4px solid #ffc107; background-color: #fff3cd; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 20px; margin-right: 12px; color: #ffc107;"></i>
                    <div>
                        <h5 style="margin: 0 0 4px 0; color: #856404; font-weight: 600;">Complete Your Profile Setup</h5>
                        <p style="margin: 0 0 8px 0; color: #856404;">Please complete the following to start accepting bookings:</p>
                        <ul style="margin: 0; padding-left: 15px; color: #856404;">
                            @if(!$hasServices)
                                <li style="margin-bottom: 4px;">
                                    <a href="{{ route('professional.service.index') }}" style="color: #856404; text-decoration: underline; font-weight: 600;">Add your services</a>
                                </li>
                            @endif
                            @if(!$hasRates)
                                <li style="margin-bottom: 4px;">
                                    <a href="{{ route('professional.rate.index') }}" style="color: #856404; text-decoration: underline; font-weight: 600;">Configure your rates</a>
                                </li>
                            @endif
                            @if(!$hasAvailability)
                                <li style="margin-bottom: 4px;">
                                    <a href="{{ route('professional.availability.index') }}" style="color: #856404; text-decoration: underline; font-weight: 600;">Set your availability</a>
                                </li>
                            @endif
                            @if(!$hasRequestedServices)
                                <li style="margin-bottom: 4px;">
                                    <a href="{{ route('professional.requested_services.index') }}" style="color: #856404; text-decoration: underline; font-weight: 600;">Add other information</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Dashboard Cards -->
    <div class="card-grid">
        @php
            use Illuminate\Support\Facades\Auth;
            use App\Models\Booking;

            $professionalId = Auth::guard('professional')->id();
            $totalBookings = Booking::where('professional_id', $professionalId)->count();
        @endphp

        <!-- Total Bookings Card - Make it clickable -->
        <a href="{{ route('professional.booking.index') }}" class="dashboard-card-link">
            <div class="card card-primary">
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-info">
                    <h4>Total Bookings</h4>
                    <h2 style="color: #a67c52;">{{ $totalBookings }}</h2>
                </div>
            </div>
        </a>

        <a href="{{ route('professional.billing.index') }}" class="dashboard-card-link">
        <div class="card card-success">
            <div class="card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-info">
                @php
                    $professionalId = Auth::guard('professional')->id();
                    
                    // Get the total amount earned from bookings with paid_status = 'paid'
                    $totalRevenue = \App\Models\Booking::where('professional_id', $professionalId)
                        ->where('paid_status', 'paid')
                        ->sum('amount');
                        
                    // Get the professional's margin rate from the professionals table
                    $professional = \App\Models\Professional::find($professionalId);
                    $marginRate = $professional->margin ?? 20; // Default to 20% if not set
                    
                    // Calculate actual professional earnings after deducting platform commission
                    $actualEarnings = $totalRevenue * ((100 - $marginRate) / 100);
                    
                    // Calculate previous month's earnings for comparison
                    $previousMonth = now()->subMonth();
                    $prevMonthStart = $previousMonth->startOfMonth()->format('Y-m-d');
                    $prevMonthEnd = $previousMonth->endOfMonth()->format('Y-m-d');
                    
                    $previousEarnings = \App\Models\Booking::where('professional_id', $professionalId)
                        ->where('paid_status', 'paid')
                        ->whereBetween('paid_date', [$prevMonthStart, $prevMonthEnd])
                        ->sum('amount') * ((100 - $marginRate) / 100);
                        
                    // Calculate percentage change
                    $percentChange = 0;
                    if ($previousEarnings > 0) {
                        $percentChange = (($actualEarnings - $previousEarnings) / $previousEarnings) * 100;
                    }
                    $isPositive = $percentChange >= 0;
                @endphp
                <h4>Total Revenue</h4>
                <h2  style="color: #a67c52;">₹{{ number_format($actualEarnings, 2) }}</h2>
                @if($previousEarnings > 0)
                    <p class="{{ $isPositive ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $isPositive ? 'up' : 'down' }}"></i> 
                        {{ abs(round($percentChange)) }}% from last month
                    </p>
                @else
                    <p>No earnings last month</p>
                @endif
            </div>
        </div>
        </a>

        @php
            $professionalId = Auth::guard('professional')->id();
            $activeClients = Booking::where('professional_id', $professionalId)
                ->distinct('user_id')
                ->count('user_id');
        @endphp

        <div class="card card-warning">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-info">
                <h4>Active Clients</h4>
                <h2>{{ $activeClients }}</h2>
            </div>
        </div>

        <!-- Upcoming Appointments Card - Dynamic Version -->
        @php
            $professionalId = Auth::guard('professional')->id();
            
            // Get the current date
            $today = \Carbon\Carbon::today();
            
            // Get ALL pending appointments for this professional (no date limit)
            $pendingBookings = \App\Models\Booking::where('professional_id', $professionalId)
                ->whereHas('timedates', function($query) {
                    $query->where('status', 'pending');
                })
                ->with(['timedates' => function($query) {
                    $query->where('status', 'pending')
                          ->orderBy('date', 'asc');
                }])
                ->get();
            
            // Count total pending appointments
            $pendingCount = 0;
            foreach($pendingBookings as $booking) {
                $pendingCount += $booking->timedates->count();
            }
            
            // Count today's pending appointments
            $todayPendingBookings = \App\Models\Booking::where('professional_id', $professionalId)
                ->whereHas('timedates', function($query) use ($today) {
                    $query->where('status', 'pending')
                          ->where('date', $today->format('Y-m-d'));
                })
                ->with(['timedates' => function($query) use ($today) {
                    $query->where('status', 'pending')
                          ->where('date', $today->format('Y-m-d'));
                }])
                ->get();
            
            $todayPendingCount = 0;
            foreach($todayPendingBookings as $booking) {
                $todayPendingCount += $booking->timedates->count();
            }
            
            // Count future pending appointments (after today)
            $futurePendingBookings = \App\Models\Booking::where('professional_id', $professionalId)
                ->whereHas('timedates', function($query) use ($today) {
                    $query->where('status', 'pending')
                          ->where('date', '>', $today->format('Y-m-d'));
                })
                ->with(['timedates' => function($query) use ($today) {
                    $query->where('status', 'pending')
                          ->where('date', '>', $today->format('Y-m-d'));
                }])
                ->get();
            
            $futurePendingCount = 0;
            foreach($futurePendingBookings as $booking) {
                $futurePendingCount += $booking->timedates->count();
            }
        @endphp

        <a href="{{ route('professional.booking.index') }}" class="dashboard-card-link">
            <div class="card card-danger">
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-info">
                    <h4>Upcoming Appointments</h4>
                    <h2>{{ $pendingCount }}</h2>
                    @if($todayPendingCount > 0)
                        <p class="negative">
                            <i class="fas fa-exclamation-circle"></i> 
                            {{ $todayPendingCount }} pending today - Action required
                        </p>
                    @elseif($futurePendingCount > 0)
                        <p class="positive">
                            <i class="fas fa-calendar-alt"></i> 
                            {{ $futurePendingCount }} upcoming - Review appointments
                        </p>
                    @else
                        <p class="positive">
                            <i class="fas fa-check-circle"></i> 
                            No pending appointments
                        </p>
                    @endif
                </div>
            </div>
        </a>

    <!-- Platform Fee Information -->
    @php
        $professionalId = Auth::guard('professional')->id();
        $professional = \App\Models\Professional::find($professionalId);
        $marginRate = $professional->margin ?? 20; // Default to 20% if not set
    @endphp
    <div class="content-card" style="background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); margin-bottom: 30px; overflow: hidden;">
        <div style="padding: 24px;">
            <div style="display: flex; align-items: center;">
                <i class="fas fa-percentage" style="font-size: 24px; margin-right: 16px; color: #3498db;"></i>
                <div>
                    <h4 style="margin: 0 0 8px 0; color: #2c3e50; font-weight: 600; font-size: 18px;">Platform Fee Information</h4>
                    <p style="margin: 0; color: #34495e; font-size: 16px;">Platform commission rate: <strong style="color: #3498db;">{{ $marginRate }}%</strong> on all completed bookings</p>
                </div>
            </div>
        </div>
    </div>

    <style>

    .table-responsive-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; 
    }
    
    .table {
        min-width: 600px; /* Minimum width to ensure all columns are visible when scrolling */
        width: 100%;
    }

    @media only screen and (min-width: 768px) and (max-width: 1024px) {
        /* Fix header to prevent horizontal scrolling */
        .page-header {
            position: relative;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            margin: 0;
            padding: 15px 20px;
        }
        
        /* Make table container scrollable horizontally */
        .table-responsive-container {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            table-layout: auto;
            white-space: nowrap;
        }
        
        /* Fix the search container from overflowing */
        .search-container {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        .content-wrapper {
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
            padding: 15px;
            margin: 0;
        }
        
        /* Fix card width */
        .card {
            width: 100%;
            overflow-x: hidden;
            margin: 0;
        }
        .card-body {
            padding: 15px;
        }
        
        /* Add scrollbar styling */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Remove problematic negative margins */
        .user-profile-wrapper {
            margin-top: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Ensure all containers stay within bounds */
        * {
            box-sizing: border-box;
        }
        
        .main-wrapper,
        .page-wrapper,
        .content {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
    }
    
    @media screen and (max-width: 767px) {
        /* Fix header to prevent horizontal scrolling */
        .page-header {
            position: relative;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            margin: 0;
            padding: 10px 15px;
        }
        
        /* Make table container scrollable horizontally */
        .table-responsive-container {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            table-layout: auto;
            white-space: nowrap;
        }
        
        /* Fix the search container from overflowing */
        .search-container {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Ensure content wrapper doesn't cause horizontal scroll */
        .content-wrapper {
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
            padding: 15px 10px;
            margin: 0;
        }
        
        /* Fix card width */
        .card {
            width: 100%;
            overflow-x: hidden;
            margin: 0;
        }
        
        /* Ensure the card body doesn't cause overflow */
        .card-body {
            padding: 10px;
        }
        
        /* Add scrollbar styling */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Remove any problematic negative margins */
        .user-profile-wrapper {
            margin-top: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Ensure all containers stay within bounds */
        * {
            box-sizing: border-box;
        }
        
        .main-wrapper,
        .page-wrapper,
        .content {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Handle alert dismissals and store dismissed state
    document.addEventListener('DOMContentLoaded', function() {
        // Close button functionality
        document.querySelectorAll('.alert .btn-close').forEach(function(button) {
            button.addEventListener('click', function() {
                const alert = this.closest('.alert');
                const alertType = alert.classList.contains('alert-success') ? 'new-booking' : 'setup-reminder';
                
                // Fade out the alert
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 300);
                
                // Store the dismissed state in localStorage with timestamp
                localStorage.setItem(alertType + '-dismissed', Date.now());
            });
        });
        
        // Auto-hide new booking alerts after 1 day (they'll reappear if there are new bookings)
        const alertElements = document.querySelectorAll('.alert');
        alertElements.forEach(function(alert) {
            if (alert.classList.contains('alert-success')) {
                const lastDismissed = localStorage.getItem('new-booking-dismissed');
                if (lastDismissed && (Date.now() - lastDismissed < 86400000)) { // 24 hours
                    alert.style.display = 'none';
                }
            }
        });
    });
</script>
@endsection