@extends('professional.layout.layout')

@section('style')
<style>
    @media screen and (max-width: 767px) {
        /* Fix header size and layout */
        .page-header {
            padding: 10px 15px;
            margin-bottom: 15px;
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .page-header .breadcrumb {
            margin: 5px 0 0;
            padding: 0;
            font-size: 12px;
        }

        .page-header .breadcrumb li {
            display: inline-block;
            margin-right: 5px;
        }

        .page-header .breadcrumb li:after {
            content: '/';
            margin-left: 5px;
            color: #999;
        }

        .page-header .breadcrumb li:last-child:after {
            display: none;
        }

        /* Card header adjustments */
        .card-header {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h4 {
            font-size: 16px;
            margin: 0;
        }

        .card-actions a {
            font-size: 13px;
            padding: 6px 12px;
        }

        /* Prevent page scrolling */
        body {
            overflow: hidden !important;
            position: fixed;
            width: 100%;
            height: 100%;
        }

        /* Allow content wrapper to scroll vertically only */
        .content-wrapper {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            height: 100%;
            position: relative;
        }

        /* Make table container scrollable horizontally */
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Event Details</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Events Without Details Card -->
    @if($eventsWithoutDetails->count() > 0)
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-header">
                <h4 class="text-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Events Without Details ({{ $eventsWithoutDetails->count() }})
                </h4>
            </div>
            <p class="text-muted mb-3">The following events don't have detailed information yet. Add details to make them more attractive to customers:</p>
            <div class="row">
                @foreach($eventsWithoutDetails as $event)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card border-warning">
                        <div class="card-body">
                            <h6 class="card-title">{{ $event->heading }}</h6>
                            <p class="card-text text-muted">{{ Str::limit($event->short_description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'No date' }}</small>
                                <a href="{{ route('professional.event-details.create', ['event_id' => $event->id]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-plus mr-1"></i>Add Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Event Details List -->
    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Event Details</h4>
                    <small class="text-muted">Manage detailed information for your events ({{ $eventdetails->count() }})</small>
                </div>
                <div class="card-actions">
                    @if($eventsWithoutDetails->count() > 0)
                        <a href="{{ route('professional.event-details.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>Add Event Details
                        </a>
                    @endif
                </div>
            </div>
            
            @if($eventdetails->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Type</th>
                                <th>Starting Date</th>
                                <th>Starting Fees</th>
                                <th>Mode</th>
                                <th>City</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($eventdetails as $detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($detail->banner_image)
                                                        @php
                                                            $bannerImages = json_decode($detail->banner_image);
                                                            $firstImage = is_array($bannerImages) && count($bannerImages) > 0 ? $bannerImages[0] : null;
                                                        @endphp
                                                        @if($firstImage)
                                                            <img src="{{ asset('storage/' . $firstImage) }}" alt="Event" class="avatar avatar-sm rounded me-2" style="width: 100px;">
                                                        @endif
                                                    @endif
                                                    <div>
                                                        <span class="fw-semibold">{{ $detail->event->heading ?? 'N/A' }}</span>
                                                        <div class="text-muted">{{ Str::limit($detail->event->mini_heading ?? '', 30) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-transparent">{{ $detail->event_type }}</span>
                                            </td>
                                            <td>{{ $detail->starting_date ? $detail->starting_date->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                <span class="fw-semibold text-success">₹{{ number_format($detail->starting_fees, 2) }}</span>
                                            </td>
                                            <td>
                                                @if($detail->event_mode)
                                                    <span class="badge bg-{{ $detail->event_mode === 'online' ? 'info' : 'warning' }}-transparent">
                                                        {{ ucfirst($detail->event_mode) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $detail->city ?? 'N/A' }}</td>
                                            <td>{{ $detail->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('professional.event-details.show', $detail) }}" class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('professional.event-details.edit', $detail) }}" class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('professional.event-details.destroy', $detail) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event detail?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                </div>
            @else
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-calendar-alt display-4 text-muted"></i>
                    </div>
                    <h5 class="text-muted">No Event Details Found</h5>
                    <p class="text-muted">You haven't added details to any of your events yet.</p>
                    @if($eventsWithoutDetails->count() > 0)
                        <a href="{{ route('professional.event-details.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Add Your First Event Detail
                        </a>
                    @else
                        <p class="text-muted">Create an event first, then come back to add details.</p>
                        <a href="{{ route('professional.events.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus mr-1"></i>Create Event
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection