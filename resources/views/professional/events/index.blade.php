@extends('professional.layout.layout')

@section('style')
<style>
    @media screen and (max-width: 767px) {
        .page-header {
            padding: 10px 15px;
            margin-bottom: 15px;
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .page-header .page-title h3 {
            font-size: 18px;
            margin: 0;
            padding: 0;
        }

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

        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        .data-table {
            min-width: 1000px;
        }

        .data-table th,
        .data-table td {
            white-space: nowrap;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>My Events</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Events</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>Event List</h4>
                <div class="card-actions">
                    <a href="{{ route('professional.events.create') }}" style="background-color: #0d67c7;color:white;padding:7px;border-radius:10px">Add Event</a>
                </div>
            </div>
            
            <div class="table-responsive">
                @if($events->count() > 0)
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Event Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Fees</th>
                                <th>Status</th>
                                <th>Meet Link</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $event->card_image) }}" 
                                             alt="Event Image" 
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    </td>
                                    <td>
                                        <strong>{{ $event->heading }}</strong>
                                        <br>
                                        <small style="color: #666;">{{ \Illuminate\Support\Str::limit($event->short_description, 50) }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge" style="background-color: #17a2b8; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                            {{ $event->mini_heading }}
                                        </span>
                                    </td>
                                    <td>₹{{ number_format($event->starting_fees, 2) }}</td>
                                    <td>
                                        @if($event->status === 'pending')
                                            <span class="badge" style="background-color: #ffc107; color: #212529; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                                Pending
                                            </span>
                                        @elseif($event->status === 'approved')
                                            <span class="badge" style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                                Approved
                                            </span>
                                        @else
                                            <span class="badge" style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($event->meet_link)
                                            <a href="{{ $event->meet_link }}" target="_blank" 
                                               style="background-color: #28a745; 
                                                      color: white; 
                                                      padding: 5px 10px; 
                                                      font-size: 12px; 
                                                      border-radius: 5px; 
                                                      text-decoration: none; 
                                                      display: inline-block;">
                                                <i class="fas fa-video"></i> Join Meeting
                                            </a>
                                        @else
                                            <span style="color: #6c757d; font-size: 12px;">
                                                <i class="fas fa-times-circle"></i> Not Set
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $event->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ route('professional.events.show', $event) }}" 
                                               style="background-color: #17a2b8; 
                                                      color: white; 
                                                      padding: 6px 12px; 
                                                      font-size: 12px; 
                                                      border-radius: 5px; 
                                                      text-decoration: none; 
                                                      display: inline-block;
                                                      text-align: center;">
                                                View
                                            </a>
                                            
                                            @if($event->status !== 'approved')
                                                <a href="{{ route('professional.events.edit', $event) }}" 
                                                   style="background-color: #28a745; 
                                                          color: white; 
                                                          padding: 6px 12px; 
                                                          font-size: 12px; 
                                                          border-radius: 5px; 
                                                          text-decoration: none; 
                                                          display: inline-block;
                                                          text-align: center;">
                                                    Edit
                                                </a>
                                                
                                                <button onclick="deleteEvent({{ $event->id }})" 
                                                        style="background-color: #dc3545; 
                                                               color: white; 
                                                               padding: 6px 12px; 
                                                               font-size: 12px; 
                                                               border-radius: 5px; 
                                                               border: none; 
                                                               cursor: pointer;">
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 50px 20px;">
                        <h4>No Events Yet</h4>
                        <p style="color: #666;">You haven't created any events yet. Create your first event to get started!</p>
                        <a href="{{ route('professional.events.create') }}" 
                           style="background-color: #0d67c7; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; margin-top: 15px;">
                            Create Your First Event
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function deleteEvent(eventId) {
    if(confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/professional/events/${eventId}`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';
        
        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection