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

    /* Custom Pagination Styling (copied from event/index.blade.php) */
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
                <h1 class="page-title fw-medium fs-18 mb-2">One Time Booking</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Booking</a></li>
                            <li class="breadcrumb-item active" aria-current="page">One Time</li>
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
                    Filter One Time Bookings
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.onetime') }}" method="GET" id="searchForm">
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
                                       id="searchInput" placeholder="Search by name, phone" value="{{ request('search') }}">
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
                                <a href="{{ route('admin.onetime') }}" class="btn btn-outline-secondary px-4">
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
        <form id="export-form" method="GET" action="{{ route('admin.booking.onetime.export') }}">
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
                            Total One Time Bookings: {{ $bookings->total() }}
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
                                        <th>Sub-Service</th>
                                      <th>Status</th>
                                        <th>Service Date On</th>
                                        <th>Service Time</th>
                                        <th>Add link for the Service</th>
                                        <th>Paid Amount</th>
                                        <th>Professional document</th>
                                        <th>Customer Document</th>
                                        <th>Telecaller Remarks</th>
                                         <th>Professional Remarks to customer</th>
                                                   <th>Admin remarks to professional</th>
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
                                            <td>{{ $bookings->firstItem() + $key }}</td>
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
                                @if($booking->sub_service_name)
                                    <span class="badge bg-info">{{ $booking->sub_service_name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                     <td>
    {{ $booking->timedates->first()?->status ?? '-' }}
</td>

                <td>{{ $earliestTimedate ? \Carbon\Carbon::parse($earliestTimedate->date)->format('d M Y') : '-' }}</td>

                <td>{!! $earliestTimedate ? str_replace(',', '<br>', $earliestTimedate->time_slot) : '-' !!}</td>
                                        <td>
    @if($booking->timedates && $booking->timedates->count() > 0)
        @php
            // Check if ANY meeting link exists for this booking
            $hasAnyLink = false;
            $allLinksAdded = true;
            
            foreach ($booking->timedates as $timedate) {
                if (!empty($timedate->meeting_link)) {
                    $hasAnyLink = true;
                } else {
                    $allLinksAdded = false;
                }
            }
            
            // Set button class based on link status
            $btnClass = $allLinksAdded ? 'btn-success' : ($hasAnyLink ? 'btn-info' : 'btn-primary');
            $btnIcon = $allLinksAdded ? 'bi bi-check-circle me-1' : ($hasAnyLink ? 'bi bi-exclamation-circle me-1' : '');
        @endphp
        
        <!-- Button to open the modal with conditional styling -->
        <button type="button" class="btn {{ $btnClass }} btn-sm" data-bs-toggle="modal" data-bs-target="#meetingLinkModal{{ $booking->id }}">
            @if($btnIcon)
                <i class="{{ $btnIcon }}"></i>
            @endif
            Manage Links 
        </button>
        
        <!-- Modal for meeting links -->
        <div class="modal fade" id="meetingLinkModal{{ $booking->id }}" tabindex="-1" aria-labelledby="meetingLinkModalLabel{{ $booking->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="meetingLinkModalLabel{{ $booking->id }}">Meeting Links for {{ $booking->customer_name }}'s Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Meeting Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->timedates as $timedate)
                                    <tr class="{{ !empty($timedate->meeting_link) ? 'table-success' : '' }}">
                                        <td>{{ \Carbon\Carbon::parse($timedate->date)->format('d M Y') }}</td>
                                        <td>{!! str_replace(',', '<br>', $timedate->time_slot) !!}</td>
                                        <td>
                                            <span class="badge bg-{{ $timedate->status == 'completed' ? 'success' : ($timedate->status == 'pending' ? 'warning' : 'info') }}">
                                                {{ ucfirst($timedate->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.add-link') }}" method="POST" class="d-flex gap-2" style="width: 400px;">
                                                @csrf
                                                <input type="hidden" name="timedate_id" value="{{ $timedate->id }}">
                                                <input type="url" name="meeting_link" class="form-control form-control-sm" 
                                                       value="{{ $timedate->meeting_link ?? '' }}" 
                                                       placeholder="Add Link">
                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                                
                                                @if($timedate->meeting_link)
                                                <a href="{{ $timedate->meeting_link }}" target="_blank" class="btn btn-sm btn-success">
                                                    <i class="bi bi-box-arrow-up-right"></i> Open
                                                </a>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <span class="text-muted">No dates available</span>
    @endif
</td>   
                   <td>
    @if($booking->payment_status === 'paid')
        ₹{{ number_format($booking->amount, 2) }}
    @else
        <span class="text-muted">Not Paid</span>
    @endif
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
    <td>
                                                <form action="{{ route('admin.add-remarks', ['id' => $booking->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <input id="marks" class="form-control" type="text" name="remarks" placeholder="Remarks" style="width: 350px;" value="{{ $booking->remarks }}">
                                                        <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                  <td>
                  @if($booking->timedates->isNotEmpty())
                 @foreach($booking->timedates as $timedate)
                 {{ $timedate->remarks ?? '-' }}<br>
                    @endforeach
                @else
                     -
              @endif
          </td>
           <td>
    <form action="{{ route('admin.professional-add-remarks', ['id' => $booking->id]) }}" method="POST">
        @csrf
        <div class="d-flex">
            <input id="remarks_for_professional" class="form-control" type="text" name="remarks_for_professional" placeholder="Remarks for Professional" style="width: 350px;" value="{{ $booking->remarks_for_professional }}">
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bookings->appends(request()->query())->links('pagination::bootstrap-4') }}
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
            form.action = "{{ route('admin.booking.onetime.export-excel') }}";
        } else if (type === 'pdf') {
            form.action = "{{ route('admin.booking.onetime.export') }}";
        }

        form.submit();
    }
</script>
@endsection