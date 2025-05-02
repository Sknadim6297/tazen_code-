@extends('professional.layout.layout')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Bookings</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>Service List</h4>
                <div class="card-actions">
                    <a href="{{ route('professional.service.create') }}" style="background-color: #0d67c7;color:white;padding:7px;border-radius:10px">Add Service</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Category</th>
                            <th>Duration</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Tags</th>
                            <th>Client Requirements</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
    <tr>
        <td>{{ $service->service_name }}</td>
        <td>{{ $service->category }}</td>
        <td>{{ $service->duration }} mins</td>
        <td>
            @if($service->image_path)
                <img src="{{ asset('upload/services/' . $service->image_path) }}" alt="Image" width="60">
            @else
                <span class="text-muted">No Image</span>
            @endif
        </td>
        <td>{{ Str::limit($service->description, 50) }}</td>
        <td>{{ $service->tags }}</td>
        <td>{{ $service->requirements }}</td>
        <td>
            <div style="display: flex; gap: 10px;">
        
                <a href="{{ route('professional.service.edit', $service->id) }}" 
                   style="background-color: #28a745; 
                          color: white; 
                          padding: 8px 16px; 
                          font-size: 14px; 
                          font-weight: 500;
                          border: none; 
                          border-radius: 8px; 
                          text-decoration: none; 
                          display: inline-flex; 
                          align-items: center; 
                          justify-content: center;
                          transition: background-color 0.3s ease;">
                    <i class="fas fa-edit" style="margin-right: 6px;"></i> Edit
                </a>
        
                <a href="javascript:void(0)" 
                   class="delete-item" 
                   data-url="{{ route('professional.service.destroy', $service->id) }}"
                   style="background-color: #dc3545; 
                          color: white; 
                          padding: 8px 16px; 
                          font-size: 14px; 
                          font-weight: 500;
                          border: none; 
                          border-radius: 8px; 
                          text-decoration: none; 
                          display: inline-flex; 
                          align-items: center; 
                          justify-content: center;
                          transition: background-color 0.3s ease;">
                    <i class="far fa-trash-alt" style="margin-right: 6px;"></i> Delete
                </a>
        
            </div>
        </td>
        
    </tr>
@endforeach

                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
