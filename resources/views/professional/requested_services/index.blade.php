@extends('professional.layout.layout')

@section('style')
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
    </style>
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
                            <th>Actions</th>
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
            
                            {{-- Prices --}}
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
           <td>
              {{ $service->education_statement }} 
           </td>
                            <td>
                                @if(is_array($educationList))
                                    @foreach($educationList['college_name'] as $index => $college)
                                        <div>{{ $college ?? '-' }} - {{ $educationList['degree'][$index] ?? '-' }}</div>
                                    @endforeach
                                @else
                                    <div>-</div>
                                @endif
                            </td>
                            {{-- Actions --}}
                            <td class="" style="display: flex; gap: 5px; align-items: center; justify-content: center;">
                                <a href="{{ route('professional.requested_services.edit', $service->id) }}" class="btn btn-sm btn-primary">
                                    Edit
                                </a>
                                <a href="javascript:void(0);" 
                                data-url="{{ route('professional.requested_services.destroy', $service->id) }}"
                                data-id="{{ $service->id }}" 
                                class="btn btn-sm btn-danger ml-2 delete-item">Delete</a>                             
                            </td>
                            
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            

        </div>
    </div>
</div>
@endsection
