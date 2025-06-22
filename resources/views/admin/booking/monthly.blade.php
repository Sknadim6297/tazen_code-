@extends('admin.layouts.layout')

@section('styles')
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

    /* Enhanced table scrolling for mobile */
    @media (max-width: 767.98px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            position: relative;
        }
        
        .table {
            width: auto;
            min-width: 100%;
            white-space: nowrap;
            margin-bottom: 0;
        }
        
        /* Custom scrollbar styling */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
            background-color: #f5f5f5;
        }
        
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }
        
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }
        
        .table-responsive::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 10px;
        }
        
        /* Prevent horizontal page scrolling */
        html, body {
            overflow-x: hidden;
            width: 100%;
        }
    }
    
    .btn-meeting-link {
        white-space: nowrap;
        transition: all 0.3s ease;
    }
    
    .btn-meeting-link:hover {
        transform: scale(1.05);
    }
    
    .meeting-link-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .latest-link-badge {
        font-size: 0.7em;
        padding: 2px 5px;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Monthly Booking</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Booking</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Monthly</li>
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
                    Filter Monthly Bookings
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.monthly') }}" method="GET" id="searchForm">
                    <div class="row g-3">
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
                                       id="searchInput" placeholder="Search" value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="statusFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-check-line me-1"></i>Status
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-settings-line text-muted"></i>
                                </span>
                                <select name="status" class="form-select border-start-0" id="statusFilter">
                                    <option value="">All Statuses</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Service Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="serviceFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-service-line me-1"></i>Service
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-briefcase-line text-muted"></i>
                                </span>
                                <select name="service" class="form-select border-start-0" id="serviceFilter">
                                    <option value="">All Services</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service }}" {{ request('service') == $service ? 'selected' : '' }}>
                                            {{ $service }}
                                        </option>
                                    @endforeach
                                </select>
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
                                       placeholder="Start Date" name="start_date" id="start_date" value="{{ request('start_date') }}">
                                <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                <input type="date" class="form-control border-start-0" 
                                       placeholder="End Date" name="end_date" id="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.monthly') }}" class="btn btn-outline-secondary px-4">
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
        <form id="export-form" method="GET" action="{{ route('admin.booking.monthly.export') }}">
            <!-- Hidden inputs to carry over current filters -->
            <input type="hidden" name="search" id="export-search">
            <input type="hidden" name="status" id="export-status">
            <input type="hidden" name="service" id="export-service">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
        </form>

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Free Hand Bookings: {{ $bookings->count() }}
                        </div>
                    </div>
                    <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table text-nowrap">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Customer Name</th>
                    <th>Professional Name</th>
                    <th>Service Required</th>
                    <th>Paid Amount</th>
                    <th>Number Of Session</th>
                    <th>Number Of Session Taken</th>
                    <th>Number Of Session Pending</th>
                    <th>Validity Till</th>
                    <th>Current Service Date On</th>
                    <th>Current Service Time</th>
                    <th>Meeting Link</th> 
                    <th>Details</th>
                    <th>Professional Document</th>
                    <th>Customer Document</th>
                    <th>Status</th>
                    <th>Admin remarks to professional</th>
                    <th>Telecaller Remarks </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($bookings as $key => $booking)
                @php
                // Get earliest upcoming date
                $earliestTimedate = $booking->timedates && $booking->timedates->count() > 0 
                    ? $booking->timedates
                        ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->isFuture())
                        ->sortBy('date')
                        ->first()
                    : null;

                $completedSessions = 0;
                $pendingSessions = 0;

                if ($booking->timedates && $booking->timedates->count() > 0) {
                    foreach ($booking->timedates as $td) {
                        $slots = explode(',', $td->time_slot);
                        if ($td->status === 'completed') {
                            $completedSessions += count($slots);
                        } else {
                            $pendingSessions += count($slots);
                        }
                    }
                }
                @endphp

                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $booking->customer_name}}
                    <br>
                    ({{ $booking->customer_phone }})
                    </td>
                    <td>{{ $booking->professional->name }}
                    <br>
                    ({{ $booking->professional->phone }})
                    </td>
                    <td>{{ $booking->service_name }}</td>
                    <td>
    @if($booking->payment_status === 'paid')
        ₹{{ number_format($booking->amount, 2) }}
    @else
        <span class="text-muted">Not Paid</span>
    @endif
</td>
<td>{{ is_array($booking->days) ? count($booking->days) : count(json_decode($booking->days, true)) }}</td>                                          
                    <td>{{ $completedSessions }}</td>
                    <td>{{ $pendingSessions }}</td>  
                    <td>{{ $booking->month }}</td>

                    <td>
    @php
        $nextBooking = $booking->timedates
            ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->startOfDay()->gte(now()->startOfDay()))
            ->sortBy('date')
            ->first();
    @endphp
    
    @if($nextBooking)
        {{ \Carbon\Carbon::parse($nextBooking->date)->format('d M Y') }}
        @if(\Carbon\Carbon::parse($nextBooking->date)->isToday())
            <span class="badge bg-info">Today</span>
        @endif
    @else
        <span class="text-danger">No upcoming sessions</span>
    @endif
</td>

                    <td>
    @if($nextBooking)
        {!! str_replace(',', '<br>', $nextBooking->time_slot) !!}
    @else
        -
    @endif
</td>
                    <td>
                        @if($booking->latest_meeting_link)
                               {{ $booking->latest_meeting_link }}
                        @endif
                    </td>
                    <td>
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary see-details-btn" data-id="{{ $booking->id }}">
                        See Details
                    </a>
                    </td>
                    <td>
             @if(!empty($booking->professional_documents))
        @foreach(explode(',', $booking->professional_documents) as $doc)
            <a href="{{ asset('storage/' . $doc) }}" target="_blank"
               class="d-inline-flex justify-content-center align-items-center me-2 mb-1"
               style="width: 40px; height: 40px; border: 1px solid #ddd; border-radius: 5px;">
                <i class="bi bi-download fs-4 text-primary"></i>
            </a>
        @endforeach
    @else
        No Document
    @endif
</td>
<td>
    @if(!empty($booking->customer_document))
        @foreach(explode(',', $booking->customer_document) as $doc)
            <a href="{{ asset('storage/' . $doc) }}" target="_blank"
               class="d-inline-flex justify-content-center align-items-center me-2 mb-1"
               style="width: 40px; height: 40px; border: 1px solid #ddd; border-radius: 5px;">
                <i class="bi bi-download fs-4 text-primary"></i>
            </a>
        @endforeach
    @else
        No Document
    @endif
</td>
<td>Pending</td>
<td>
    <form action="{{ route('admin.professional-add-remarks', ['id' => $booking->id]) }}" method="POST">
        @csrf
        <div class="d-flex">
            <input id="remarks_for_professional" class="form-control" type="text" name="remarks_for_professional" placeholder="Remarks" style="width: 350px;" value="{{ $booking->remarks_for_professional}}">
            <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
        </div>
    </form>
</td>
<td>
    <form action="{{ route('admin.add-remarks', ['id' => $booking->id]) }}" method="POST">
        @csrf
        <div class="d-flex">
            <input id="marks" class="form-control" type="text" name="remarks" placeholder="Remarks" style="width: 350px;" value="{{ $booking->remarks }}">
            <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
        </div>
    </form>
</td>
            </tr>
        @endforeach
    </tbody>
</table>

                        </div>
                    </div>
                    <!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="detailsModalBody">
        <!-- Data will be inserted here -->
      </div>
    </div>
  </div>
</div>

                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="javascript:void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle Enter key on search input
        $('input[name="search"]').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#searchForm').submit();
            }
        });
    });
    
    // Export data function
    window.exportData = function(type) {
        // Set the values of the hidden inputs to current filter values
        document.getElementById('export-search').value = document.getElementById('searchInput').value || '';
        document.getElementById('export-status').value = document.getElementById('statusFilter').value || '';
        document.getElementById('export-service').value = document.getElementById('serviceFilter').value || '';
        document.getElementById('export-start-date').value = document.getElementById('start_date').value || '';
        document.getElementById('export-end-date').value = document.getElementById('end_date').value || '';

        // Set the correct action for the export
        let form = document.getElementById('export-form');
        if (type === 'excel') {
            form.action = "{{ route('admin.booking.monthly.export-excel') }}";
        } else if (type === 'pdf') {
            form.action = "{{ route('admin.booking.monthly.export') }}";
        }

        form.submit();
    }

    function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

</script>
    <script>
        $(document).ready(function () {
    $('.see-details-btn').click(function () {
        let bookingId = $(this).data('id');
        let csrf = '{{ csrf_token() }}';
        let route = '{{ url("admin/booking/add-link") }}';

        $.ajax({
            url: '/admin/booking/details/' + bookingId,
            type: 'GET',
            success: function (response) {
                if (response.dates && response.dates.length > 0) {
                    let html = `
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle" style="background-color: #e6f7ff;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time Slot</th>
                                        <th>Status</th>
                                        <th>Professional Remarks to customer</th>
                                        <th>Meeting Link</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                    // First show future dates (sorted by date)
                    const futureDates = response.dates.filter(date => !date.is_expired);
                    const expiredDates = response.dates.filter(date => date.is_expired);
                    
                    // Show future dates first
                    futureDates.forEach(dateInfo => {
                        html += buildDateRow(dateInfo, csrf, route, false);
                    });
                    
                    // Then show expired dates
                    if (expiredDates.length > 0) {
                        html += `
                            <tr>
                                <td colspan="5" class="text-center bg-light"><strong>Past Sessions</strong></td>
                            </tr>
                        `;
                        
                        expiredDates.forEach(dateInfo => {
                            html += buildDateRow(dateInfo, csrf, route, true);
                        });
                    }

                    html += `</tbody></table></div>`;
                    $('#detailsModalBody').html(html);
                } else {
                    $('#detailsModalBody').html('<p>No booking dates available.</p>');
                }

                $('#detailsModal').modal('show');
            },
            error: function () {
                $('#detailsModalBody').html('<p>Error fetching booking details.</p>');
                $('#detailsModal').modal('show');
            }
        });
    });
    
    function buildDateRow(dateInfo, csrf, route, isExpired) {
        const rowClass = isExpired ? 'text-muted' : (dateInfo.is_today ? 'table-info' : '');
        const statusBadge = getStatusBadge(dateInfo.status, isExpired);
        
        return `
            <tr class="${rowClass}">
                <td>${formatDate(dateInfo.date)} ${dateInfo.is_today ? '<span class="badge bg-info">Today</span>' : ''}</td>
                <td>${dateInfo.time_slot}</td>
                <td>${statusBadge}</td>
                <td>${dateInfo.remarks ?? '-'}</td>
                <td>
                    <form action="${route}" method="POST" class="d-flex">
                        <input type="hidden" name="_token" value="${csrf}">
                        <input type="hidden" name="timedate_id" value="${dateInfo.id}">
                        <input type="url" name="meeting_link" class="form-control" placeholder="Add Link" value="${dateInfo.meeting_link || ''}" required ${isExpired ? 'disabled' : ''}>
                        <button type="submit" class="btn btn-sm btn-primary ms-2" ${isExpired ? 'disabled' : ''}>Save</button>
                    </form>
                </td>
            </tr>`;
    }
    
    function getStatusBadge(status, isExpired) {
        if (isExpired && status !== 'completed') {
            return '<span class="badge bg-danger">Expired</span>';
        }
        
        switch(status.toLowerCase()) {
            case 'completed':
                return '<span class="badge bg-success">Completed</span>';
            case 'cancelled':
                return '<span class="badge bg-danger">Cancelled</span>';
            case 'pending':
                return '<span class="badge bg-warning">Pending</span>';
            default:
                return '<span class="badge bg-secondary">' + status + '</span>';
        }
    }
});
    </script>
@endsection