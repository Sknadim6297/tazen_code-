@extends('professional.layout.layout')

@section('styles')
<style>
    .search-container {
        max-width: 600px;
    }
    .search-form {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .form-group {
        flex: 1 1 100%;
    }
    .form-group label {
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .form-group select {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    .search-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-start;
        margin-top: 10px;
    }

    .search-buttons .btn-success,
    .search-buttons .btn-secondary {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    /* Fix for table scrolling */
    .table-responsive {
        overflow-x: auto;
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
    }

    /* Ensure the content doesn't overflow its container */
    .card-body {
        overflow: hidden;
    }

    /* Prevent table from expanding beyond container */
    .table {
        width: 100%;
        table-layout: auto;
        margin-bottom: 0;
    }

    /* Ensure parent containers respect width constraints */
    .content-wrapper, .card {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }
    @media screen and (max-width: 767px) {
    /* Fix header to prevent horizontal scrolling */
    .page-header {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
        padding-top: 10px;
        padding-bottom: 10px;
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
    }
    
    /* Make table container scrollable horizontally */
    .table-wrapper {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
    }
    
    /* Ensure the table takes full width of container */
    .data-table {
        width: 100%;
        table-layout: auto;
    }
    
    /* Fix the search container from overflowing */
    .search-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure content wrapper doesn't cause horizontal scroll */
    .content-wrapper {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
        padding: 20px 10px;
    }
    
    /* Fix card width */
    .card {
        width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure the card body doesn't cause overflow */
    .card-body {
        padding: 10px 5px;
    }
    
    /* Optional: Make some table columns width-responsive */
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
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Availability</li>
        </ul>
    </div>
    <div class="search-container">
        <form action="{{ route('professional.availability.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search_month">Month</label>
               @php
        $monthNames = [
            'jan' => 'January',
            'feb' => 'February',
            'mar' => 'March',
            'apr' => 'April',
            'may' => 'May',
            'jun' => 'June',
            'jul' => 'July',
            'aug' => 'August',
            'sep' => 'September',
            'oct' => 'October',
            'nov' => 'November',
            'dec' => 'December',
        ];
    @endphp

    <select name="search_month" id="search_month" class="form-control">
        <option value="">Select Month</option>
        @foreach ($availableMonths as $monthKey)
            <option value="{{ $monthKey }}" {{ request('search_month') == $monthKey ? 'selected' : '' }}>
                {{ $monthNames[$monthKey] ?? ucfirst($monthKey) }}
            </option>
        @endforeach
    </select>
            </div>
            <div class="search-buttons">
                <button type="submit" class="btn-success">Search</button>
                <a href="{{ route('professional.availability.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>Availability List</h4>
                <div class="card-actions">
                    <a href="{{ route('professional.availability.create') }}" style="background-color: #0d67c7;color:white;padding:7px;border-radius:10px">Add Availability</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Month</th>
                            <th>Session Duration (mins)</th>
                            <th>Weekdays</th>
                            <th>Slots</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availability as $item)
                            <tr>
                                <td>{{ $item->month }}</td>
                                <td>{{ $item->session_duration }}</td>
                                <td>
                                    @foreach(json_decode($item->weekdays) as $day)
                                        <span class="badge bg-info text-dark">{{ $day }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($item->slots->count())
                                        <ul class="list-unstyled mb-0">
                                            @foreach($item->slots as $slot)
                                                <li>
                                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">No slots</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('professional.availability.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-url="{{  route('professional.availability.destroy', $item->id)  }}" class="btn btn-sm btn-outline-warning delete-item" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No availability found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection