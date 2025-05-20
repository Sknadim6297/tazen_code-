@extends('professional.layout.layout')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Other Information</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Other Information List</h4>
                @if($serviceCount < 1)
                <a href="{{ route('professional.requested_services.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Add Information
                </a>
                @endif
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Heading</th>
                            <th>Requested Services</th>
                            <th>Prices</th>
                            <th>Statement</th>
                            <th>Specializations</th>
                            <th>Education Statement</th>
                            <th>Education</th>
                            <th class="actions-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requestedServices as $service)
                        @php
                            // Decode the JSON fields properly
                            $servicesList = json_decode($service->requested_service, true) ?? [];
                            $pricesList = json_decode($service->price, true) ?? [];
                            $specializationsList = json_decode($service->specializations, true) ?? [];
                            $educationList = json_decode($service->education, true) ?? [];
                        @endphp
                        
                        <tr>
                            <td>{{ $service->sub_heading }}</td>
                            <td>
                                @foreach($servicesList as $index => $item)
                                    <div>{{ $item ?? '-' }}</div>
                                @endforeach
                            </td>
            
                            <td>
                                @foreach($pricesList as $price)
                                    <div>₹{{ number_format((float) $price, 2) }}</div>
                                @endforeach
                            </td>
                            <td>{{ Str::limit($service->statement, 50) }}</td>
                            <td>
                                @foreach($specializationsList as $spec)
                                    <span class="badge">{{ $spec ?? '-' }}</span>
                                @endforeach
                            </td>
                            <td>{{ $service->education_statement }}</td>
                            <td>
                                @if(is_array($educationList))
                                    @foreach($educationList['college_name'] as $index => $college)
                                        <div>{{ $college ?? '-' }} - {{ $educationList['degree'][$index] ?? '-' }}</div>
                                    @endforeach
                                @else
                                    <div>-</div>
                                @endif
                            </td>
                            <td class="actions-cell">
                                <div style="display: flex; gap: 5px; align-items: center; justify-content: center;">
                                    <a href="{{ route('professional.requested_services.edit', $service->id) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                    <a href="javascript:void(0);" 
                                    data-url="{{ route('professional.requested_services.destroy', $service->id) }}"
                                    data-id="{{ $service->id }}" 
                                    class="btn btn-sm btn-danger delete-item">Delete</a>                             
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
        .badge {
            display: inline-block;
            padding: 0.25em 0.5em;
            background-color: #17a2b8;
            color: #fff;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            margin-right: 3px;
        }

        /* Base styles */
        .content-wrapper {
            padding: 15px;
            overflow-x: hidden; /* Prevent horizontal scrolling on page */
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden; /* Contain table overflow */
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto; /* Enable horizontal scrolling */
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        }

        table {
            width: 100%;
            min-width: 800px; /* Minimum width to force scrolling */
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        th {
            background-color: #f1f1f1;
            font-weight: 600;
        }

        .actions-cell {
            white-space: nowrap; /* Prevent action buttons from wrapping */
        }

        /* Mobile responsiveness */
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
    .card-header h4 {
    font-size: 17px;
    }
    .btn{
            font-size: 10px;
    }
}
    </style>
@endsection