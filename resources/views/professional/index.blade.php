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
        /* overflow-x: hidden !important; */
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
        grid-template-columns: repeat(2, minmax(260px, 1fr));
        gap: 1.2rem;
        align-items: stretch;
    }
    
    @media (max-width: 900px) {
        .card-grid {
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }
    }
    
    .card-grid > * {
        height: 100%;
    }
    
    .dashboard-card-link {
        display: block;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }
    
    .card {
        position: relative;
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.12);
        overflow: hidden;
        background: #ffffff;
        padding: 1.6rem 1.8rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 1rem;
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.12);
        transition: transform 0.22s ease, box-shadow 0.22s ease;
        height: 100%;
    }
    
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 42px rgba(15, 23, 42, 0.16);
    }
    
    .card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(79, 70, 229, 0.1), transparent 48%);
        opacity: 0;
        transition: opacity 0.22s ease;
    }
    
    .card:hover::after {
        opacity: 1;
    }
    
    .card__top {
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    
    .card__icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
        font-size: 1.4rem;
    }
    
    .card.card-success .card__icon { background: rgba(34, 197, 94, 0.1); color: #059669; }
    .card.card-warning .card__icon { background: rgba(245, 158, 11, 0.12); color: #d97706; }
    .card.card-danger .card__icon { background: rgba(239, 68, 68, 0.12); color: #dc2626; }
    
    .card__meta {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }
    
    .card__meta span.label {
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 600;
    }
    
    .card__meta span.value {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.05;
    }
    
    .card__meta span.value small {
        font-size: 1rem;
        color: #94a3b8;
        margin-left: 0.35rem;
    }
    
    .card__footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
        font-size: 0.9rem;
        color: #475569;
    }
    
    .card__footer .trend {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-weight: 600;
    }
    
    .card__footer .trend.positive { color: #059669; }
    .card__footer .trend.negative { color: #dc2626; }
    
    .card__footer .cta {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        background: rgba(79, 70, 229, 0.1);
        color: #4338ca;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.18s ease, color 0.18s ease;
    }
    
    .card__footer .cta:hover {
        background: rgba(79, 70, 229, 0.18);
        color: #312e81;
    }
    
    .card.card-success .card__footer .cta { background: rgba(34, 197, 94, 0.12); color: #047857; }
    .card.card-success .card__footer .cta:hover { background: rgba(34, 197, 94, 0.2); color: #065f46; }
    
    .card.card-warning .card__footer .cta { background: rgba(245, 158, 11, 0.12); color: #b45309; }
    .card.card-warning .card__footer .cta:hover { background: rgba(245, 158, 11, 0.18); color: #92400e; }
    
    .card.card-danger .card__footer .cta { background: rgba(239, 68, 68, 0.12); color: #b91c1c; }
    .card.card-danger .card__footer .cta:hover { background: rgba(239, 68, 68, 0.18); color: #991b1b; }
    
    @media (max-width: 640px) {
        .card__footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.6rem;
        }
        
    .card__footer .cta {
        width: 100%;
        justify-content: center;
    }
    
    .dashboard-card-link {
        height: auto;
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
    .dashboard-enhanced {
        background: #f4f6fb;
        padding: 2.2rem 2.2rem 3rem;
    }

    .dashboard-shell {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2.2rem;
    }

    .dashboard-hero {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.6rem;
        padding: 2.2rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.16);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.16));
        box-shadow: 0 26px 54px rgba(79, 70, 229, 0.16);
    }

    .dashboard-hero__meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .dashboard-hero__meta span {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        padding: 0.4rem 1.05rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.45);
        color: #0f172a;
    }

    .dashboard-hero__meta h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .dashboard-hero__meta p {
        margin: 0;
        color: #475569;
        max-width: 520px;
        font-size: 0.96rem;
    }

    .dashboard-hero__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.9rem;
        align-items: center;
        justify-content: flex-end;
    }

    .dashboard-hero__actions a {
        display: inline-flex;
        align-items: center;
        gap: 0.48rem;
        padding: 0.85rem 1.75rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.94rem;
        text-decoration: none;
        border: 1px solid rgba(79, 70, 229, 0.28);
        color: #312e81;
        background: rgba(255, 255, 255, 0.88);
        box-shadow: 0 18px 36px rgba(79, 70, 229, 0.16);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .dashboard-hero__actions a.btn-primary {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        color: #ffffff;
        border-color: transparent;
    }

    .dashboard-hero__actions a:hover {
        transform: translateY(-2px);
        box-shadow: 0 24px 48px rgba(79, 70, 229, 0.22);
    }

    .dashboard-section-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(148, 163, 184, 0.22);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.1);
        padding: 2rem 2.4rem;
    }

    .dashboard-section-card + .dashboard-section-card {
        margin-top: 1.6rem;
    }

    .dashboard-section-card h2 {
        margin: 0 0 0.6rem;
        font-size: 1.2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .dashboard-section-card p {
        margin: 0;
        color: #64748b;
    }

    .dashboard-notices {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .dashboard-enhanced .card-grid {
        margin: 0;
    }

    .dashboard-enhanced .card {
        border-radius: 20px;
        min-width: 0;
        box-shadow: 0 20px 44px rgba(15, 23, 42, 0.14);
    }

    .dashboard-enhanced .table-responsive-container {
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.12);
        padding: 0;
        background: #ffffff;
    }

    .dashboard-enhanced .content-card {
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.1);
    }

    .dashboard-enhanced .recent-events h3 {
        font-size: 1.18rem;
        font-weight: 700;
        color: #0f172a;
    }

    .dashboard-enhanced .recent-events .event-card {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.18);
    }

    .commission-card {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    
    .commission-card__head {
        display: flex;
        align-items: flex-start;
        gap: 1.2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
    }
    
    .commission-card__head h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
    }
    
    .commission-card__head p {
        margin: 0.5rem 0 0;
        color: #64748b;
        font-size: 0.94rem;
        line-height: 1.5;
    }
    
    .commission-card__icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(79, 70, 229, 0.08));
        color: #4338ca;
        font-size: 1.5rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.12);
    }
    
    .commission-card__grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }
    
    .commission-pill {
        border-radius: 14px;
        padding: 1.1rem 1rem;
        background: #f8fafc;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
        display: flex;
        flex-direction: column;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .commission-pill:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.1);
    }
    
    .commission-pill h3 {
        margin: 0;
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        line-height: 1.3;
    }
    
    .commission-pill__value {
        font-size: 1.85rem;
        font-weight: 700;
        letter-spacing: -0.03em;
        line-height: 1.2;
        margin: 0.2rem 0;
    }
    
    .commission-pill p {
        margin: 0;
        font-size: 0.82rem;
        color: #475569;
        line-height: 1.5;
    }
    
    .commission-pill--blue {
        background: linear-gradient(145deg, rgba(59, 130, 246, 0.12), rgba(59, 130, 246, 0.04));
        border-color: rgba(59, 130, 246, 0.25);
    }
    
    .commission-pill--blue h3 {
        color: #1e40af;
    }
    
    .commission-pill--blue .commission-pill__value {
        color: #1d4ed8;
    }
    
    .commission-pill--blue p {
        color: #1e3a8a;
    }
    
    .commission-pill--red {
        background: linear-gradient(145deg, rgba(239, 68, 68, 0.12), rgba(248, 113, 113, 0.04));
        border-color: rgba(239, 68, 68, 0.25);
    }
    
    .commission-pill--red h3 {
        color: #991b1b;
    }
    
    .commission-pill--red .commission-pill__value {
        color: #dc2626;
    }
    
    .commission-pill--red p {
        color: #991b1b;
    }
    
    .commission-pill--green {
        background: linear-gradient(145deg, rgba(34, 197, 94, 0.12), rgba(34, 197, 94, 0.04));
        border-color: rgba(34, 197, 94, 0.25);
    }
    
    .commission-pill--green h3 {
        color: #14532d;
    }
    
    .commission-pill--green .commission-pill__value {
        color: #16a34a;
    }
    
    .commission-pill--green p {
        color: #14532d;
    }
    
    @media (max-width: 768px) {
        .commission-card__head {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding-bottom: 1.2rem;
        }
        
        .commission-card__icon {
            width: 48px;
            height: 48px;
            font-size: 1.3rem;
        }
        
        .commission-card__head h2 {
            font-size: 1.15rem;
        }
        
        .commission-card__head p {
            font-size: 0.88rem;
        }
        
        .commission-card__grid {
            grid-template-columns: 1fr;
            gap: 1.2rem;
        }
        
        .commission-pill {
            padding: 1.5rem 1.3rem;
        }
        
        .commission-pill__value {
            font-size: 2rem;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .commission-card__grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 1024px) {
        .dashboard-enhanced {
            padding: 2rem 1.6rem 2.6rem;
        }

        .dashboard-section-card {
            padding: 1.8rem 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 1.8rem;
        }

        .dashboard-hero__actions {
            justify-content: stretch;
        }

        .dashboard-hero__actions a {
            width: 100%;
            justify-content: center;
        }

        .dashboard-enhanced .card-grid {
            gap: 1.4rem;
        }
    }
</style>
@endsection
@section('content')

<div class="dashboard-enhanced">
    <div class="dashboard-shell">
        <section class="dashboard-hero">
            <div class="dashboard-hero__meta">
                <span><i class="fas fa-chart-line"></i> Professional Dashboard</span>
                <h1>Insights & Activity Overview</h1>
                <p>Track bookings, revenue, and upcoming appointments while keeping your profile ready for new customers.</p>
            </div>
            <div class="dashboard-hero__actions">
                <a href="{{ route('professional.profile.index') }}">
                    <i class="fas fa-user-cog"></i>
                    Manage Profile
                </a>
                <a href="{{ route('professional.booking.index') }}" class="btn-primary">
                    <i class="fas fa-calendar-check"></i>
                    View Bookings
                </a>
            </div>
        </section>
        
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
    <div class="dashboard-section-card">
        <div class="dashboard-notices">
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
        <div class="card__top">
            <div class="card__icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card__meta">
                <span class="label">Total Bookings</span>
                <span class="value">{{ $totalBookings }}</span>
            </div>
        </div>
        <div class="card__footer">
            <span class="trend positive">
                <i class="fas fa-calendar"></i> Keep track of all reservations
            </span>
            <span class="cta">
                View details <i class="fas fa-arrow-right"></i>
            </span>
        </div>
    </div>
        </a>

        @php
            $professionalId = Auth::guard('professional')->id();
            $totalRevenue = \App\Models\Booking::where('professional_id', $professionalId)
                ->where('paid_status', 'paid')
                ->sum('amount');
            $professional = \App\Models\Professional::find($professionalId);
            $marginRate = $professional->margin ?? 20;
            $actualEarnings = $totalRevenue * ((100 - $marginRate) / 100);

            $previousMonth = now()->subMonth();
            $prevMonthStart = $previousMonth->copy()->startOfMonth();
            $prevMonthEnd = $previousMonth->copy()->endOfMonth();

            $previousEarningsRaw = \App\Models\Booking::where('professional_id', $professionalId)
                ->where('paid_status', 'paid')
                ->whereBetween('paid_date', [$prevMonthStart, $prevMonthEnd])
                ->sum('amount');

            $previousEarnings = $previousEarningsRaw * ((100 - $marginRate) / 100);
            $percentChange = $previousEarnings > 0
                ? (($actualEarnings - $previousEarnings) / $previousEarnings) * 100
                : 0;
            $isPositive = $percentChange >= 0;
        @endphp

        <a href="{{ route('professional.billing.index') }}" class="dashboard-card-link">
            <div class="card card-success">
                <div class="card__top">
                    <div class="card__icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card__meta">
                        <span class="label">Total Revenue</span>
                        <span class="value">₹{{ number_format($actualEarnings, 2) }}</span>
                    </div>
                </div>
                <div class="card__footer">
                    @if($previousEarnings > 0)
                        <span class="trend {{ $isPositive ? 'positive' : 'negative' }}">
                            <i class="fas fa-arrow-{{ $isPositive ? 'up' : 'down' }}"></i>
                            {{ abs(round($percentChange)) }}% from last month
                        </span>
                    @else
                        <span class="trend positive">
                            <i class="fas fa-info-circle"></i>
                            No earnings last month
                        </span>
                    @endif
                    <span class="cta">
                        Billing center <i class="fas fa-arrow-right"></i>
                    </span>
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
        <div class="card__top">
            <div class="card__icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card__meta">
                <span class="label">Active Clients</span>
                <span class="value">{{ $activeClients }}</span>
            </div>
        </div>
        <div class="card__footer">
            <span class="trend positive">
                <i class="fas fa-user-friends"></i>
                Build client retention
            </span>
            <span class="cta">
                View clients <i class="fas fa-arrow-right"></i>
            </span>
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
        <div class="card__top">
            <div class="card__icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card__meta">
                <span class="label">Upcoming Appointments</span>
                <span class="value">{{ $pendingCount }}</span>
            </div>
        </div>
        <div class="card__footer">
            @if($todayPendingCount > 0)
                <span class="trend negative">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $todayPendingCount }} pending today
                </span>
            @elseif($futurePendingCount > 0)
                <span class="trend positive">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $futurePendingCount }} upcoming
                </span>
            @else
                <span class="trend positive">
                    <i class="fas fa-check-circle"></i>
                    No pending items
                </span>
            @endif
            <span class="cta">
                Manage schedule <i class="fas fa-arrow-right"></i>
            </span>
        </div>
    </div>
        </a>

    <!-- Platform Fee Information -->
    @php
        $professionalId = Auth::guard('professional')->id();
        $professional = \App\Models\Professional::find($professionalId);
        $marginRate = $professional->margin ?? 20; // Default to 20% if not set
        $serviceRequestMargin = $professional->service_request_margin ?? 10.00; // Dynamic service request margin
        $negotiationOffset = $professional->service_request_offset ?? 20.00; // Dynamic negotiation offset
    @endphp
    <div class="dashboard-section-card commission-card">
        <header class="commission-card__head">
            <span class="commission-card__icon">
                <i class="fas fa-percentage"></i>
            </span>
            <div>
                <h2>Commission & Fees</h2>
                <p>Understand how each booking and service request contributes to your earnings.</p>
            </div>
        </header>
        <div class="commission-card__grid">
            <div class="commission-pill commission-pill--green">
                <h3>Main Margin</h3>
                <div class="commission-pill__value">{{ number_format($marginRate, 2) }}%</div>
                <p>Platform commission on completed bookings</p>
            </div>
            <div class="commission-pill commission-pill--blue">
                <h3>Service Request Margin</h3>
                <div class="commission-pill__value">{{ number_format($serviceRequestMargin, 2) }}%</div>
                <p>Commission for additional service requests</p>
            </div>
            <div class="commission-pill commission-pill--red">
                <h3>Negotiation Offset</h3>
                <div class="commission-pill__value">{{ number_format($negotiationOffset, 2) }}%</div>
                <p>Maximum negotiation limit for customers</p>
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

    </div>
</div>

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

<!-- Include Onboarding Tutorial -->
{{-- Temporarily commented out onboarding tutorials --}}
{{-- @include('components.onboarding-tutorial') --}}
{{-- @include('components.professional-onboarding') --}}
@endsection