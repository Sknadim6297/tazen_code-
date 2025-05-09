@extends('professional.layout.layout')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Availability</li>
        </ul>
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
                                <td colspan="4" class="text-center text-muted">No availability found.</td>
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
