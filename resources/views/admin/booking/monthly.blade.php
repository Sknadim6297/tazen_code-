@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Monthly Booking</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Booking</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Monthly</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
     <form action="{{ route('admin.monthly') }}" method="GET" class="d-flex gap-2 flex-wrap">
    <div class="col-md-2">
        <div class="card custom-card">
            <input type="search" name="search" value="{{ request('search') }}" class="form-control" id="autoComplete" placeholder="Search">
        </div>
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">-- Select Status --</option>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="service" class="form-select">
            <option value="">-- Select Service --</option>
            @foreach ($services as $service)
                <option value="{{ $service }}" {{ request('service') == $service ? 'selected' : '' }}>
                    {{ $service }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <div class="card-body p-2">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                    <input type="date" class="form-control" placeholder="Start Date" name="start_date" id="start_date" value="{{ request('start_date') }}">
                    <span class="input-group-text">to</span>
                    <input type="date" class="form-control" placeholder="End Date" name="end_date" id="end_date" value="{{ request('end_date') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 d-flex align-items-center">
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('admin.monthly') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('admin.booking.monthly.export', request()->all()) }}" class="btn btn-success">
                <i class="fas fa-file-pdf"></i> Export
            </a>
        </div>
    </div>
</form>
        <!-- Page Header Close -->

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Free Hand Bookings: 
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
<style>
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
        
        /* Fix form elements on mobile */
        .page-header-breadcrumb form {
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .page-header-breadcrumb form .col-xl-2,
        .page-header-breadcrumb form .col-xl-4,
        .page-header-breadcrumb form .col-xl-6 {
            width: 100%;
            max-width: 100%;
            padding-right: 0;
            padding-left: 0;
        }
        
        /* Prevent horizontal page scrolling */
        html, body {
            overflow-x: hidden;
            width: 100%;
        }
         .table {
        width: auto;
        min-width: 100%;
    }
    
    /* Optional: prevent page scrolling when table is being scrolled */
    html, body {
        overflow-x: hidden;
        width: 100%;
    }
}

    /* Existing styles... */
    
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
@section('scripts')
<script>
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