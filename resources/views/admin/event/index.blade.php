        @extends('admin.layouts.layout')

        @section('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
        <style>
            /* Export buttons styling */
            .export-buttons {
                display: flex;
                gap: 10px;
                margin-left: 10px;
            }

            .export-btn {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                border-radius: 0.25rem;
                cursor: pointer;
                transition: all 0.2s;
            }

            .export-btn-excel {
                background-color: #1f7244;
                color: white;
                border: none;
            }

            .export-btn-excel:hover {
                background-color: #155a33;
            }

            .export-btn-pdf {
                background-color: #c93a3a;
                color: white;
                border: none;
            }

            .export-btn-pdf:hover {
                background-color: #a52929;
            }

            /* Filter Section Styling */
            .filter-card {
                border: none;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
                border-radius: 12px;
                transition: all 0.3s ease;
            }

            .filter-card:hover {
                box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            }

            .filter-card .card-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-radius: 12px 12px 0 0;
                border: none;
                padding: 1rem 1.5rem;
            }

            .filter-card .card-title {
                color: white;
                font-weight: 600;
                font-size: 1.1rem;
            }

            .filter-card .card-body {
                padding: 1.5rem;
                background: #fafbfc;
            }

            .form-label {
                font-size: 0.875rem;
                font-weight: 500;
                color: #6c757d;
                margin-bottom: 0.5rem;
            }

            .input-group {
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0,0,0,0.04);
                transition: all 0.3s ease;
            }

            .input-group:focus-within {
                box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
                transform: translateY(-1px);
            }

            .input-group-text {
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                color: #6c757d;
                font-size: 0.875rem;
                padding: 0.75rem 1rem;
            }

            .form-control, .form-select {
                border: 1px solid #e9ecef;
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                transition: all 0.3s ease;
            }

            .form-control:focus, .form-select:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            }

            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                border-radius: 8px;
                padding: 0.75rem 1.5rem;
                font-weight: 500;
                transition: all 0.3s ease;
                box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            }

            .btn-outline-secondary {
                border: 2px solid #6c757d;
                color: #6c757d;
                border-radius: 8px;
                padding: 0.75rem 1.5rem;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-outline-secondary:hover {
                background: #6c757d;
                border-color: #6c757d;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
            }

            .badge.highlighted {
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .filter-card .card-body {
                    padding: 1rem;
                }
                
                .input-group {
                    margin-bottom: 1rem;
                }
                
                .btn {
                    width: 100%;
                    margin-bottom: 0.5rem;
                }
            }

            /* Custom Pagination Styling (copied from other admin pages) */
            .pagination {
                margin-bottom: 0;
            }
            .page-item.active .page-link {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-color: #667eea;
            }
            .page-link {
                color: #667eea;
                padding: 0.5rem 0.75rem;
                margin: 0 3px;
                border-radius: 6px;
                transition: all 0.2s ease;
            }
            .page-link:hover {
                background-color: #f0f2ff;
                color: #5a6fd8;
                transform: translateY(-2px);
                box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
            }
            .page-link:focus {
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            }
            @media (max-width: 768px) {
                .pagination .page-link {
                    padding: 0.4rem 0.6rem;
                    font-size: 0.9rem;
                }
            }
        </style>
        @endsection

        @section('content')
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <div>
                        <h1 class="page-title fw-medium fs-18 mb-2">Event Bookings</h1>
                        <div>
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Events</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Event Bookings</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Filter Section - Modern Design -->
                <div class="card custom-card filter-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ri-filter-3-line me-2 text-primary"></i>
                            Filter Event Bookings
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.eventpage.index') }}" method="GET" id="searchForm">
                            <div class="row g-3">
                                <!-- Payment Status -->
                                <div class="col-lg-3 col-md-6">
                                    <label for="paymentStatusFilter" class="form-label fw-medium text-muted mb-2">
                                        <i class="ri-bank-card-line me-1"></i>Payment Status
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="ri-check-line text-muted"></i>
                                        </span>
                                        <select name="status" class="form-select border-start-0" id="paymentStatusFilter">
                                            <option value="">All Statuses</option>
                                            @foreach($statusList as $status)
                                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Event Mode -->
                                <div class="col-lg-3 col-md-6">
                                    <label for="eventModeFilter" class="form-label fw-medium text-muted mb-2">
                                        <i class="ri-video-line me-1"></i>Event Mode
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="ri-settings-line text-muted"></i>
                                        </span>
                                        <select name="event_mode" class="form-select border-start-0" id="eventModeFilter">
                                            <option value="">All Modes</option>
                                            @foreach($eventModes as $mode)
                                                <option value="{{ $mode }}" {{ request('event_mode') == $mode ? 'selected' : '' }}>
                                                    {{ ucfirst($mode) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Search Input -->
                                <div class="col-lg-3 col-md-6">
                                    <label for="searchInput" class="form-label fw-medium text-muted mb-2">
                                        <i class="ri-search-line me-1"></i>Search
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="ri-user-line text-muted"></i>
                                        </span>
                                        <input type="search" name="search" class="form-control border-start-0" 
                                            id="searchInput" placeholder="Search by name or event" value="{{ request('search') }}">
                                    </div>
                                </div>
                                
                                <!-- Date Range -->
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-medium text-muted mb-2">
                                        <i class="ri-calendar-line me-1"></i>Date Range
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="ri-calendar-event-line text-muted"></i>
                                        </span>
                                        <input type="date" class="form-control border-start-0 border-end-0" 
                                            placeholder="Start Date" name="start_date" value="{{ request('start_date') }}">
                                        <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                        <input type="date" class="form-control border-start-0" 
                                            placeholder="End Date" name="end_date" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-end pt-2">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ri-search-line me-1"></i>Search
                                        </button>
                                        <a href="{{ route('admin.eventpage.index') }}" class="btn btn-outline-secondary px-4">
                                            <i class="ri-refresh-line me-1"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Add Export buttons outside the filter form -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="export-buttons">
                        <button type="button" class="export-btn export-btn-excel" onclick="exportData('excel')">
                            <i class="ri-file-excel-line me-1"></i> Export Excel
                        </button>
                        <button type="button" class="export-btn export-btn-pdf" onclick="exportData('pdf')">
                            <i class="ri-file-pdf-line me-1"></i> Export PDF
                        </button>
                    </div>
                </div>

                <!-- Add this hidden form for export -->
                <form id="export-form" method="GET" action="{{ route('admin.event.export') }}">
                    <!-- Hidden inputs to carry over current filters -->
                    <input type="hidden" name="search" id="export-search">
                    <input type="hidden" name="status" id="export-status">
                    <input type="hidden" name="event_mode" id="export-event-mode">
                    <input type="hidden" name="start_date" id="export-start-date">
                    <input type="hidden" name="end_date" id="export-end-date">
                    <input type="hidden" name="type" id="export-type">
                </form>

                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Event Bookings ({{ $bookings->count() }})
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" style="width: 100%; min-width: 1200px;">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Customer Name</th>
                                                <th>Event Name</th>
                                                <th>Event Date</th>
                                                <th>Location</th>
                                                <th>Type</th>
                                                <th>No. of Persons</th>
                                                <th>Phone</th>
                                                <th>Price</th>
                                                <th>Total Price</th>
                                                <th>Gmeet Link / Location</th>
                                                <th>Payment Status</th>
                                                <th>Order ID</th>
                                                <th>Payment Failure Reason</th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($bookings as $index => $booking)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $booking->event->heading ?? 'N/A' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @if($booking->type == 'offline')
                                                            <span class="badge bg-info text-white">
                                                                <i class="ri-map-pin-line me-1"></i>{{ $booking->location ?? 'Location not specified' }}
                                                            </span>
                                                        @else
                                                            {{ $booking->location ?? 'N/A' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!-- Always highlight the type with badges -->
                                                        @if($booking->type == 'online')
                                                            <span class="badge bg-success highlighted">Online</span>
                                                        @elseif($booking->type == 'offline')
                                                            <span class="badge bg-warning highlighted">Offline</span>
                                                        @else
                                                            <span class="badge bg-secondary highlighted">{{ ucfirst($booking->type ?? 'N/A') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $booking->persons ?? 'N/A' }}</td>
                                                    <td>{{ $booking->phone ?? 'N/A' }}</td>
                                                    <td>₹{{ number_format($booking->price, 2) }}</td>
                                                    <td>₹{{ number_format($booking->total_price, 2) }}</td>
                                                    <td>
                                                        @if($booking->type == 'online')
                                                        <form action="{{ route('admin.event.updateGmeetLink', $booking->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                                            @csrf
                                                            <input type="text" name="gmeet_link" class="form-control form-control-sm" value="{{ $booking->gmeet_link }}" placeholder="Enter Google Meet link" style="min-width:250px; max-width:400px;">
                                                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                        </form>
                                                        @elseif($booking->type == 'offline')
                                                            <span class="badge bg-info text-white">
                                                                <i class="ri-map-pin-line me-1"></i>{{ $booking->location ?? 'Location not specified' }}
                                                            </span>
                                                        @else
                                                        <span class="text-muted">Not applicable</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($booking->payment_status == 'success')
                                                            <span class="badge bg-success">Confirmed</span>
                                                        @elseif($booking->payment_status == 'failed')
                                                            <span class="badge bg-warning text-dark">Failed</span>
                                                        @else
                                                            <span class="badge bg-danger">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $booking->order_id ?? 'N/A' }}</td>
                                                    <td>{{ $booking->payment_failure_reason ?? 'N/A' }}</td>
                                                    <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                                                </tr>
                                            @empty
                                            <tr>
                                                <td colspan="14" class="text-center py-3">No event bookings found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $bookings->withQueryString()->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script>
            $(document).ready(function() {
                $('input[name="search"]').keypress(function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                        $('#searchForm').submit();
                    }
                });
            });

            window.exportData = function(type) {
                document.getElementById('export-type').value = type;
                document.getElementById('export-search').value = document.getElementById('searchInput').value || '';
                document.getElementById('export-status').value = document.getElementById('paymentStatusFilter').value || '';
                document.getElementById('export-event-mode').value = document.getElementById('eventModeFilter').value || '';
                document.getElementById('export-start-date').value = document.querySelector('input[name="start_date"]').value || '';
                document.getElementById('export-end-date').value = document.querySelector('input[name="end_date"]').value || '';
                document.getElementById('export-form').submit();
            }
        </script>
        @endsection