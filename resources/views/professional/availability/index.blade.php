@extends('professional.layout.layout')

@section('styles')
<style>
    /* Fix container overflow */
    .main-content {
        max-width: 100%;
        overflow-x: hidden;
    }

    .container-fluid {
        max-width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        overflow-x: hidden;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 1.5rem;
    }

    .page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0.5rem;
    }

    .page-header-breadcrumb {
        flex-wrap: wrap;
        gap: 1rem;
    }

    /* Availability Cards */
    .availability-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
        max-width: 100%;
        overflow: hidden;
    }

    .availability-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-color: #d1d5db;
    }

    .card-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
        border-radius: 8px 8px 0 0;
    }

    .card-header .d-flex {
        flex-wrap: wrap;
        gap: 1rem;
    }

    .month-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
        margin: 0;
    }

    .month-info {
        font-size: 0.875rem;
        color: #6c757d;
        margin: 0;
    }

    .card-body {
        padding: 1rem;
        overflow-x: auto;
    }

    /* Time Slots Display */
    .slots-section {
        margin-bottom: 1rem;
    }

    .slots-section h6 {
        font-size: 0.875rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .day-slots {
        margin-bottom: 1rem;
    }

    .day-name {
        font-weight: 600;
        color: #495057;
        font-size: 0.875rem;
        text-transform: capitalize;
        margin-bottom: 0.5rem;
        padding: 0.25rem 0.5rem;
        background: #f1f3f4;
        border-radius: 4px;
        display: inline-block;
    }

    .time-slots {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .time-slot {
        background: #e3f2fd;
        color: #1565c0;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Action Buttons */
    .card-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 0;
        flex-shrink: 0;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    /* Search and Filter */
    .search-section {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        max-width: 100%;
        overflow: hidden;
    }

    .search-section .form-control {
        border-radius: 6px;
    }

    .search-section .row {
        margin-right: 0;
        margin-left: 0;
    }

    .search-section .col-md-4 {
        padding-right: 15px;
        padding-left: 15px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    /* Desktop Layout Fix */
    @media (min-width: 769px) {
        .row {
            margin-right: 0;
            margin-left: 0;
        }

        .col-12 {
            padding-right: 0;
            padding-left: 0;
        }

        .card-header .d-flex {
            align-items: flex-start;
        }

        .card-actions {
            flex-wrap: nowrap;
        }
    }

    /* Tablet and Desktop */
    @media (min-width: 992px) {
        .container-fluid {
            padding-right: 30px;
            padding-left: 30px;
        }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .time-slots {
            flex-direction: column;
        }
        
        .card-actions {
            flex-direction: column;
            width: 100%;
            margin-top: 1rem;
        }
        
        .btn-sm {
            width: 100%;
        }

        .card-header .d-flex {
            flex-direction: column;
        }

        .page-header-breadcrumb .ms-auto {
            margin-left: 0 !important;
            margin-top: 1rem;
        }

        .search-section .col-md-4 {
            margin-bottom: 1rem;
        }
    }

    /* Ensure no horizontal scroll */
    body {
        overflow-x: hidden;
    }

    .app-content {
        overflow-x: hidden;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">My Availability</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Availability</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="ms-auto">
                <a href="{{ route('professional.availability.create') }}" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i>Add New Availability
                </a>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form method="GET" action="{{ route('professional.availability.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="search_month" class="form-label">Search by Month</label>
                        <select name="search_month" id="search_month" class="form-control">
                            <option value="">All Months</option>
                            @foreach($availableMonths as $month)
                                <option value="{{ $month }}" {{ request('search_month') == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="ri-search-line me-1"></i>Search
                        </button>
                        @if(request('search_month'))
                            <a href="{{ route('professional.availability.index') }}" class="btn btn-outline-secondary ms-2">
                                <i class="ri-refresh-line me-1"></i>Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Availability List -->
        <div class="row">
            <div class="col-12">
                @if($availability->count() > 0)
                    @foreach($availability as $avail)
                        <div class="availability-card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h5 class="month-title">
                                            {{ \Carbon\Carbon::parse($avail->month . '-01')->format('F Y') }}
                                        </h5>
                                        <p class="month-info">
                                            Session Duration: {{ $avail->session_duration }} minutes
                                        </p>
                                    </div>
                                    <div class="card-actions ms-3">
                                        <a href="{{ route('professional.availability.edit', $avail->id) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="ri-edit-line"></i><span class="d-none d-lg-inline ms-1">Edit</span>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-availability" 
                                                data-id="{{ $avail->id }}" data-month="{{ \Carbon\Carbon::parse($avail->month . '-01')->format('F Y') }}"
                                                title="Delete">
                                            <i class="ri-delete-bin-line"></i><span class="d-none d-lg-inline ms-1">Delete</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($avail->slots && $avail->slots->count() > 0)
                                    <div class="slots-section">
                                        <h6>Weekly Schedule</h6>
                                        @php
                                            $weekdays = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                                            $dayNames = [
                                                'mon' => 'Monday',
                                                'tue' => 'Tuesday', 
                                                'wed' => 'Wednesday',
                                                'thu' => 'Thursday',
                                                'fri' => 'Friday',
                                                'sat' => 'Saturday',
                                                'sun' => 'Sunday'
                                            ];
                                            $slotsByDay = $avail->slots->groupBy('weekday');
                                        @endphp
                                        
                                        @foreach($weekdays as $day)
                                            @if(isset($slotsByDay[$day]) && $slotsByDay[$day]->count() > 0)
                                                <div class="day-slots">
                                                    <div class="day-name">{{ $dayNames[$day] }}</div>
                                                    <div class="time-slots">
                                                        @foreach($slotsByDay[$day] as $slot)
                                                            <span class="time-slot">
                                                                {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - 
                                                                {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">No time slots configured for this month.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="ri-calendar-line"></i>
                        <h4>No Availability Set</h4>
                        <p class="mb-3">You haven't configured your availability yet. Set up your schedule to start receiving bookings.</p>
                        <a href="{{ route('professional.availability.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i>Add Your First Availability
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete availability functionality
    document.querySelectorAll('.delete-availability').forEach(button => {
        button.addEventListener('click', function() {
            const availabilityId = this.getAttribute('data-id');
            const monthName = this.getAttribute('data-month');
            
            if (confirm(`Are you sure you want to delete availability for ${monthName}? This action cannot be undone.`)) {
                fetch(`{{ route('professional.availability.index') }}/${availabilityId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the card from DOM
                        this.closest('.availability-card').remove();
                        
                        // Show success message
                        alert('Availability deleted successfully!');
                        
                        // Reload page if no more cards
                        if (document.querySelectorAll('.availability-card').length === 0) {
                            window.location.reload();
                        }
                    } else {
                        alert('Error: ' + (data.message || 'Failed to delete availability'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the availability');
                });
            }
        });
    });
});
</script>
@endsection