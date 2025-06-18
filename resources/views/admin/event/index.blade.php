@extends('admin.layouts.layout')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<style>
    /* Style for export buttons group */
    .export-buttons {
        display: flex;
        gap: 10px;
    }
    
    /* Style for filter form */
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: end;
    }
    
    .filter-form .form-group {
        flex: 1;
        min-width: 200px;
    }
    
    .badge.highlighted {
        font-size: 0.85rem;
        padding: 0.4rem 0.6rem;
    }
    
    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
            gap: 15px;
        }
        
        .filter-form .form-group {
            width: 100%;
        }
        
        .export-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .export-buttons a {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
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

        <!-- Search and Filter Container -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.eventpage.index') }}" method="GET" class="filter-form" id="searchForm">
                    <div class="form-group">
                        <label class="form-label">Payment Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach($statusList as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Event Mode</label>
                        <select name="event_mode" class="form-select">
                            <option value="">All Modes</option>
                            @foreach($eventModes as $mode)
                                <option value="{{ $mode }}" {{ request('event_mode') == $mode ? 'selected' : '' }}>
                                    {{ ucfirst($mode) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Search</label>
                        <input type="search" name="search" class="form-control" placeholder="Search by name or event" value="{{ request('search') }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Date Range</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>

                    <div class="form-group" style="flex: 0 0 auto;">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('admin.eventpage.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Event Bookings ({{ $bookings->count() }})
                        </div>
                        <!-- Export Buttons -->
                        <div class="export-buttons">
                            <a href="{{ route('admin.event.export', request()->all()) }}" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-1"></i> Export to PDF
                            </a>
                            <a href="{{ route('admin.event.export.excel', request()->all()) }}" class="btn btn-success">
                                <i class="fas fa-file-excel me-1"></i> Export to Excel
                            </a>
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
                                        <th>Gmeet Link</th>
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
                                            <td>{{ $booking->event_date }}</td>
                                            <td>{{ $booking->location ?? 'N/A' }}</td>
                                            <td>
                                                <!-- Highlight the type if it's filtered -->
                                                @if(request('event_mode') == $booking->type)
                                                    <span class="badge bg-info highlighted">{{ ucfirst($booking->type ?? 'N/A') }}</span>
                                                @else
                                                    {{ ucfirst($booking->type ?? 'N/A') }}
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
                                                    <input type="text" name="gmeet_link" class="form-control form-control-sm" value="{{ $booking->gmeet_link }}" placeholder="Enter Google Meet link">
                                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                </form>
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
                                        <td colspan="15" class="text-center py-3">No event bookings found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
        // Your existing JavaScript...

        // Handle Enter key on search input
        $('input[name="search"]').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#searchForm').submit();
            }
        });
    });
</script>
@endsection