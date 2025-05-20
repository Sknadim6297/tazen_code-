@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Free Hand Booking</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Booking</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Free hand</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
  <form action="{{ route('admin.freehand') }}" method="GET" class="d-flex gap-2">
    
    <div class="col-xl-4">
        <div class="card custom-card">
            <input type="search" name="search" class="form-control" id="autoComplete" placeholder="Search">
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                    <input type="date" class="form-control"  placeholder="Choose Start Date" name="start_date" id="start_date">
                    <span class="input-group-text">to</span>
                    <input type="date" class="form-control"  placeholder="Choose End Date" name="end_date" id="end_date">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>


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
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table text-nowrap" style="min-width: 1200px;"> <!-- Set a minimum width larger than mobile screens -->
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Customer Name</th>
                                        <th>Professional Name</th>
                                        <th>Service Required</th>
                                        <th>Paid Amount</th>
                                        <th>Number Of Service</th>
                                        <th>Number Of Service Taken</th>
                                        <th>Number Of Service Pending</th>
                                        <th>Validity Till</th>
                                        <th>Current Service Date On</th>
                                        <th>Current Service Time</th>
                                        <th>Add link for the Service</th>
                                        <th>Details</th>
                                        <th>Professional Document</th>
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
                                            <td>Null</td>
                                       <td>{{ is_array($booking->days) ? count($booking->days) : count(json_decode($booking->days, true)) }}</td>     
                                                       <td>{{ $completedSessions }}</td>
                <td>{{ $pendingSessions }}</td>  
                <td>{{ $booking->month }}</td>
                                             <td>{{ $earliestTimedate ? \Carbon\Carbon::parse($earliestTimedate->date)->format('d M Y') : '-' }}</td>

                <td>{!! $earliestTimedate ? str_replace(',', '<br>', $earliestTimedate->time_slot) : '-' !!}</td>
                                            <td>
                                                <form action="{{ route('admin.add-link', ['id' => $booking->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <input type="url" name="meeting_link" class="form-control" value="{{ $booking->meeting_link }}" placeholder="Add Link" required>
                                                        <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                      <td>
                                      <a href="javascript:void(0);" class="btn btn-sm btn-primary see-details-btn" data-id="{{ $booking->id }}">
                        See Details
                    </a>
                                      </td>
                                        <td>
    @foreach(explode(',', $booking->professional_documents) as $doc)
        <a href="{{ asset('storage/' . $doc) }}" target="_blank">View Document</a><br>
    @endforeach
</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            

                            </table>
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
                                    <a class="page-link" href="javascript:void(0);">2</a>
                                </li>
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
    @media (max-width: 767.98px) {
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
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
</style>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
    $('.see-details-btn').click(function () {
        let bookingId = $(this).data('id');

        $.ajax({
            url: '/admin/booking/details/' + bookingId, 
            type: 'GET',
            success: function (response) {
                if (response.dates.length > 0) {
                    let html = '<ul class="list-group">';
                    response.dates.forEach(dateInfo => {
                        html += `<li class="list-group-item">
                                    <strong>Date:</strong> ${dateInfo.date}<br>
                                    <strong>Time Slots:</strong> ${dateInfo.time_slot.join(', ')}<br>
                                    <strong>Status:</strong> ${dateInfo.status}
                                 </li>`;
                    });
                    html += '</ul>';
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
});

</script>
@endsection