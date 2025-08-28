@extends('professional.layout.layout')

@section('styles')
<style>
    /* Search card - compact and responsive */
    .search-card {
        background: #fff;
        border: 1px solid var(--border-color);
        padding: 12px 14px;
        border-radius: 8px;
        box-shadow: 0 8px 20px rgba(17,24,39,0.03);
        display: flex;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .search-card .form-group 
    .search-card .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #333; }
    .search-card .form-control { padding: 10px 12px; border-radius: 6px; border: 1px solid #e6e9ef; background: #fff; }

    .search-actions { display:flex; gap:8px; align-items:center; }
    .search-actions .btn { padding: 9px 14px; border-radius: 6px; }
    .search-actions .btn + .btn { margin-left: 6px; }

    /* Small screens: stack search fields */
    @media screen and (max-width: 767px) {
        .search-card { flex-direction: column; align-items: stretch; }
        .search-card .form-group { width: 100%; }
        .search-actions { justify-content: flex-end; }
    }

    /* Table layout tweaks kept minimal */
    .table-responsive { overflow-x: auto; }
    .table { width: 100%; border-collapse: collapse; }

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
        <form action="{{ route('professional.availability.index') }}" method="GET">
            <div class="search-card">
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
                <div class="search-actions">
                    <button type="submit" class="btn btn-success">Search</button>
                    <a href="{{ route('professional.availability.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Availability List</h4>
                    <small class="text-muted">Manage availability per sub-service</small>
                </div>
                <div class="card-actions">
                    <a href="{{ route('professional.availability.create') }}" class="btn btn-primary btn-sm">Add Availability</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Service</th>
                            <th>Sub-Service</th>
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
                                <td data-label="Service">
                                    <div class="service-info">
                                        <div class="service-name">{{ $item->professionalService->service_name ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td data-label="Sub-Service">
                                    @if($item->subService)
                                        {{ $item->subService->name }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td data-label="Month">{{ $item->month }}</td>
                                <td data-label="Session Duration">{{ $item->session_duration }}</td>
                                <td data-label="Weekdays">
                                    @foreach(json_decode($item->weekdays) as $day)
                                        <span class="badge bg-info text-dark">{{ $day }}</span>
                                    @endforeach
                                </td>
                                <td data-label="Slots">
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
                                <td data-label="Actions" class="text-nowrap">
                                    <div class="" role="group">
                                        <a href="{{ route('professional.availability.edit', $item->id) }}" class="rate-button" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-url="{{  route('professional.availability.destroy', $item->id)  }}" class="delete-item" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No availability found. Start by adding availability for your services.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .service-name { font-weight: 600; color: #0d6efd; }
    .subservice-name { font-size: 0.9rem; }

    /* Ensure action links use outline look and are touch-friendly */
    .rate-button, .delete-item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid transparent;
        color: var(--text-dark);
        background: transparent;
    }

    .rate-button { border-color: var(--primary); color: var(--primary); }
    .rate-button:hover { background: var(--primary); color: #fff; }

    .delete-item { border-color: var(--danger); color: var(--danger); }
    .delete-item:hover { background: var(--danger); color: #fff; }

    .table .service-info { min-width: 220px; }

    /* Mobile: action buttons become flexible for stacked cards */
    @media screen and (max-width: 767px) {
        table.table td[data-label="Actions"] a { flex: 1 1 auto; margin-left: 8px; }
    }
</style>

@endsection

@section('scripts')
@endsection