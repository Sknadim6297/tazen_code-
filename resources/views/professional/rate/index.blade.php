@extends('professional.layout.layout')

@section('style')


@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Rates</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>Rate List</h4>
                <div class="card-actions">
                    @if($rateCount < 4)
                    <a href="{{ route('professional.rate.create') }}">
                        <i class="fas fa-plus"></i> Add Rate
                    </a>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Session Type</th>
                            <th>No. of Sessions</th>
                            <th>Rate/Session (₹)</th>
                            <th>Final Rate (₹)</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rates as $rate)
                            <tr>
                                <td data-label="Session Type">{{ $rate->session_type }}</td>
                                <td data-label="No. of Sessions">{{ $rate->num_sessions }}</td>
                                <td data-label="Rate/Session">₹{{ number_format($rate->rate_per_session, 2) }}</td>
                                <td data-label="Final Rate">₹{{ number_format($rate->final_rate, 2) }}</td>
                                <td data-label="Duration">{{ $rate->duration }} min</td>
                                <td data-label="Actions">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('professional.rate.edit', $rate->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>     
                                        <a href="javascript:void(0)" data-url="{{ route('professional.rate.destroy', $rate->id) }}" class="btn btn-sm btn-outline-warning delete-item" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No rate details found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
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

@section('scripts')
@endsection