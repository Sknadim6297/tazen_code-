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

        .page-header .page-title h3 {
            font-size: 18px;
            margin: 0;
            padding: 0;
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

        /* Set table width to enable horizontal scroll */
        .data-table {
            min-width: 1000px;
        }

        /* Keep table cells from wrapping */
        .data-table th,
        .data-table td {
            white-space: nowrap;
        }

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
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0;
            padding: 0;
        }
        
        /* Set table width to enable horizontal scroll */
        .data-table {
            min-width: 1000px;
            width: 100%;
        }
        
        /* Keep table cells from wrapping */
        .data-table th,
        .data-table td {
            white-space: nowrap;
            padding: 8px;
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
            overflow-x: hidden;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Services</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>Service List</h4>
                <div class="card-actions">
                    @if(count($services) == 0)
                        <a href="{{ route('professional.service.create') }}" style="background-color: #0d67c7;color:white;padding:7px;border-radius:10px">Add Service</a>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Service Category</th>
                            <th>Session Type</th>
                            <th>Tags</th>
                            <th>Client Requirements</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td>{{ $service->service->name }}</td> 
                                <td>
                                    <span class="badge" style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                        Online Session
                                    </span>
                                </td>
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
            
            @if(count($services) == 0)
                <div class="text-center mt-4 p-3 bg-light rounded">
                    <p class="mb-0">No services added yet. Click "Add Service" to create your first service.</p>
                </div>
            @endif
        </div>
    </div>
</div>
<style>
        @media only screen and (min-width: 768px) and (max-width: 1024px) {
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
        .table-responsive-container {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            table-layout: auto;
            white-space: nowrap;
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
        
        /* Add scrollbar styling */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

            .user-profile-wrapper{
                margin-top: -57px;
            }
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

@section('scripts')
<script>
    // Delete confirmation with SweetAlert
    $(document).on('click', '.delete-item', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                response.message || 'Service has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message || 'Failed to delete service.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON?.message || 'An error occurred while deleting the service.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
@endsection
