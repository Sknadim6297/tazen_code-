@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />

<style>
    /* Base Mobile-First Responsive Design */
    .content-wrapper {
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
        padding: 10px;
    }

    /* Page Header */
    .page-header {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e0e0e0;
    }

    .page-title h3 {
        color: #333;
        font-weight: 600;
        margin: 0;
        font-size: 1.2rem;
    }

    .breadcrumb {
        margin: 8px 0 0 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 5px;
        font-size: 0.85rem;
    }

    .breadcrumb li {
        color: #666;
    }

    .breadcrumb li.active {
        color: #007bff;
        font-weight: 500;
    }

    .breadcrumb li:not(:last-child)::after {
        content: '/';
        margin-left: 5px;
        color: #999;
    }

    /* Search Container */
    .search-container {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e0e0e0;
    }

    .search-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .search-form .form-group {
        display: flex;
        flex-direction: column;
    }

    .search-form label {
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    .search-form input,
    .search-form select {
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ddd;
        font-size: 14px;
        background: #fff;
        width: 100%;
        box-sizing: border-box;
    }

    .search-form input:focus,
    .search-form select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }

    .search-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
    }

    .search-buttons button,
    .search-buttons a {
        padding: 12px;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    /* Mobile-First Table Design */
    .content-section {
        width: 100%;
        overflow-x: hidden;
    }

    /* Mobile Card Layout (Default) */
    .events-grid {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .event-card {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e0e0e0;
        text-align: center;
    }

    .event-card .card-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .event-card .event-title {
        font-weight: 600;
        color: #333;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .event-card .event-date {
        color: #666;
        font-size: 0.9rem;
    }

    .event-card .card-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .event-card .info-item {
        display: flex;
        flex-direction: column;
    }

    .event-card .info-label {
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .event-card .info-value {
        font-size: 0.9rem;
        color: #333;
        font-weight: 500;
    }

    .event-card .card-footer {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }

    /* Status and Type Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        gap: 5px;
    }

    .status-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        gap: 3px;
    }

    .type-online {
        background: #e3f2fd;
        color: #0d47a1;
        border: 1px solid #90caf9;
    }

    .type-offline {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }

    .join-btn {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .join-btn:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .price-text {
        font-weight: 600;
        color: #28a745;
        font-size: 1rem;
    }

    /* Hide table on mobile, show cards */
    .table-view {
        display: none;
    }

    .cards-view {
        display: block;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .empty-state i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 15px;
    }

    .empty-state h4 {
        color: #666;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #999;
        font-size: 0.9rem;
    }

    /* Tablet Styles */
    @media (min-width: 576px) {
        .content-wrapper {
            padding: 15px;
        }

        .page-header,
        .search-container {
            padding: 20px;
        }

        .search-form {
            flex-direction: row;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .search-form .form-group {
            flex: 1;
            min-width: 200px;
        }

        .search-buttons {
            flex-direction: row;
            margin-top: 0;
        }

        .event-card .card-body {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .event-card .card-footer {
            flex-direction: row;
            justify-content: space-between;
        }
    }

    /* Small Desktop */
    @media (min-width: 768px) {
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .event-card .card-body {
            grid-template-columns: 1fr 1fr;
        }
    }

    /* Large Desktop - Show Table */
    @media (min-width: 992px) {
        .content-wrapper {
            padding: 20px;
        }

        /* Show table, hide cards */
        .table-view {
            display: block;
        }

        .cards-view {
            display: none;
        }

        /* Table Styles for Desktop */
        .table-container {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
        }

        .table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .table th {
            background: #f8f9fa;
            color: #333;
            padding: 15px;
            font-weight: 600;
            text-align: center;
            border-bottom: 2px solid #dee2e6;
            font-size: 0.9rem;
        }

        .table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }
    }

    /* Extra Large Desktop */
    @media (min-width: 1200px) {
        .content-wrapper {
            margin: 0 auto;
            padding: 25px;
        }

        .table th,
        .table td {
            padding: 18px;
            font-size: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Summary of your Event booking</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">events</li>
        </ul>
    </div>
<div class="search-container">
    <form action="{{ route('user.customer-event.index') }}" method="GET" class="search-form">
        <div class="form-group">
            <label for="search_name">Search</label>
            <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Search event">
        </div>

        <div class="form-group">
            <label for="search_type">Event Type</label>
            <select name="search_type" id="search_type" style="padding: 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 14px;">
                <option value="">All Types</option>
                <option value="online" {{ request('search_type') == 'online' ? 'selected' : '' }}>Online</option>
                <option value="offline" {{ request('search_type') == 'offline' ? 'selected' : '' }}>Offline</option>
            </select>
        </div>

        <div class="form-group">
            <label for="search_date_from">From Date</label>
            <input type="date" name="search_date_from" value="{{ request('search_date_from') }}">
        </div>

        <div class="form-group">
            <label for="search_date_to">To Date</label>
            <input type="date" name="search_date_to" value="{{ request('search_date_to') }}">
        </div>

        <div class="search-buttons">
            <button type="submit" class="btn-success">Search</button>
            <a href="{{ route('user.customer-event.index') }}" class="btn-secondary">Reset</a>
        </div>
    </form>
</div>


    <!-- Events Summary -->
    <div class="content-section">
        @if($bookings->count() > 0)
            
            <!-- Mobile/Tablet Card View -->
            <div class="cards-view">
                <div class="events-grid">
                    @foreach($bookings as $index => $booking)
                        <div class="event-card">
                            <div class="card-header">
                                <div class="event-title">{{ $booking->event->heading ?? 'N/A' }}</div>
                                <div class="event-date">{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</div>
                            </div>
                            
                            <div class="card-body">
                                <div class="info-item">
                                    <div class="info-label">Address</div>
                                    <div class="info-value">{{ $booking->location ?? 'N/A' }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Type</div>
                                    <div class="info-value">
                                        @if($booking->type == 'online')
                                            <span class="type-badge type-online">
                                                <i class="fas fa-video"></i> Online
                                            </span>
                                        @elseif($booking->type == 'offline')
                                            <span class="type-badge type-offline">
                                                <i class="fas fa-map-marker-alt"></i> Offline
                                            </span>
                                        @else
                                            <span class="type-badge type-offline">{{ $booking->type ?? 'N/A' }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Persons</div>
                                    <div class="info-value">{{ $booking->persons ?? 'N/A' }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Price</div>
                                    <div class="info-value">
                                        <span class="price-text">₹{{ number_format($booking->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <div>
                                    @if($booking->payment_status == 'success')
                                        <span class="status-badge status-success">
                                            <i class="fas fa-check-circle"></i> Confirmed
                                        </span>
                                    @elseif($booking->payment_status == 'failed')
                                        <span class="status-badge status-warning">
                                            <i class="fas fa-exclamation-triangle"></i> Failed
                                        </span>
                                    @else
                                        <span class="status-badge status-danger">
                                            <i class="fas fa-times-circle"></i> Unknown
                                        </span>
                                    @endif
                                </div>
                                
                                @if($booking->event && $booking->event->meet_link)
                                    <a href="{{ $booking->event->meet_link }}" target="_blank" class="join-btn">
                                        <i class="fas fa-video"></i> Join Event
                                    </a>
                                @elseif($booking->gmeet_link)
                                    <a href="{{ $booking->gmeet_link }}" target="_blank" class="join-btn">
                                        <i class="fas fa-video"></i> Join Event
                                    </a>
                                @else
                                    <span class="text-muted">No Link Available</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="table-view">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Event Name</th>
                                <th>Event Date</th>
                                <th>Address</th>
                                <th>Type</th>
                                <th>Persons</th>
                                <th>Price</th>
                                <th>Link</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $booking->event->heading ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d-m-Y') }}</td>
                                    <td>{{ $booking->location ?? 'N/A' }}</td>
                                    <td>
                                        @if($booking->type == 'online')
                                            <span class="type-badge type-online">
                                                <i class="fas fa-video"></i> Online
                                            </span>
                                        @elseif($booking->type == 'offline')
                                            <span class="type-badge type-offline">
                                                <i class="fas fa-map-marker-alt"></i> Offline
                                            </span>
                                        @else
                                            <span class="type-badge type-offline">{{ $booking->type ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->persons ?? 'N/A' }}</td>
                                    <td>
                                        <span class="price-text">₹{{ number_format($booking->total_price, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($booking->event && $booking->event->meet_link)
                                            <a href="{{ $booking->event->meet_link }}" target="_blank" class="join-btn">
                                                <i class="fas fa-video"></i> Join
                                            </a>
                                        @elseif($booking->gmeet_link)
                                            <a href="{{ $booking->gmeet_link }}" target="_blank" class="join-btn">
                                                <i class="fas fa-video"></i> Join
                                            </a>
                                        @else
                                            <span class="text-muted">No Link</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->payment_status == 'success')
                                            <span class="status-badge status-success">
                                                <i class="fas fa-check-circle"></i> Confirmed
                                            </span>
                                        @elseif($booking->payment_status == 'failed')
                                            <span class="status-badge status-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Failed
                                            </span>
                                        @else
                                            <span class="status-badge status-danger">
                                                <i class="fas fa-times-circle"></i> Unknown
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h4>No Events Found</h4>
                <p>You haven't booked any events yet. Start exploring our events to book your first one!</p>
            </div>
        @endif
    </div>

</div>

@endsection
@section('scripts')

@endsection


