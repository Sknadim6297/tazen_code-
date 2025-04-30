@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

            
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Task List View</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Apps</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Task</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Task List View</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->



        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Tasks
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Add Event Details</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.eventdetails.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Event Details</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                    
                                                    {{-- Banner Image --}}
                                                    <div class="col-xl-12">
                                                        <label for="banner_image" class="form-label">Banner Image</label>
                                                        <input type="file" class="form-control" name="banner_image" id="banner_image" accept="image/*" required>
                                                    </div>
                                    
                                                    {{-- Event Name --}}
                                                    {{-- Event Name (Dropdown from All Events) --}}
                                                    <div class="col-xl-6">
                                                        <label for="event_id" class="form-label">Event Name</label>
                                                        <select class="form-select" name="event_id" id="event_id" required>
                                                        <option value="" disabled selected>Select Event</option>
                                                        @foreach($allevents as $event)
                                                        <option value="{{ $event->id }}">{{ $event->heading }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                    
                                                    {{-- Event Type --}}
                                                    <div class="col-xl-6">
                                                        <label for="event_type" class="form-label">Event Type</label>
                                                        <input type="text" class="form-control" name="event_type" id="event_type" placeholder="Enter Event Type" required>
                                                    </div>
                                    
                                                    {{-- Event Details --}}
                                                    <div class="col-xl-12">
                                                        <label for="event_details" class="form-label">Event Details</label>
                                                        <textarea class="form-control" name="event_details" id="event_details" rows="4" placeholder="Enter Event Details" required></textarea>
                                                    </div>
                                    
                                                    {{-- Starting Date --}}
                                                    <div class="col-xl-6">
                                                        <label for="starting_date" class="form-label">Starting Date</label>
                                                        <input type="date" class="form-control" name="starting_date" id="starting_date" required>
                                                    </div>
                                    
                                                    {{-- Starting Fees --}}
                                                    <div class="col-xl-6">
                                                        <label for="starting_fees" class="form-label">Starting Fees</label>
                                                        <input type="number" class="form-control" name="starting_fees" id="starting_fees" placeholder="Enter Starting Fees" min="0" required>
                                                    </div>
                                    
                                                    {{-- Event Gallery --}}
                                                    <div class="col-xl-12">
                                                        <label for="event_gallery" class="form-label">Event Gallery (Multiple Images)</label>
                                                        <input type="file" class="form-control" name="event_gallery[]" id="event_gallery" accept="image/*" multiple required>
                                                    </div>
                                    
                                                    {{-- Map Location Link (NEW FIELD) --}}
                                                    <div class="col-xl-12">
                                                        <label for="map_link" class="form-label">Event Location Map Link</label>
                                                        <input type="text" class="form-control" name="map_link" id="map_link" placeholder="Paste Google Map URL" required>
                                                        <small class="text-muted">Example: https://www.google.com/maps/place/Chandannagar,+West+Bengal</small>
                                                    </div>
                                    
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add Event</button>
                                            </div>
                                        </div>
                                    </form>
                                                                      
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Banner Image</th>
                                        <th>Event Name</th>
                                        <th>Event Type</th>
                                        <th>Details</th>
                                        <th>Start Date</th>
                                        <th>Fees</th>
                                        <th>Gallery</th>
                                        <th>Map Link</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($eventdetails as $key => $event)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('uploads/eventdetails/' . $event->banner_image) }}" width="70" height="50" alt="Banner">
                                            </td>
                                            <td>{{ $event->event->heading ?? 'N/A' }}</td>
                                            <td>{{ $event->event_type }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($event->event_details, 50) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($event->starting_date)->format('d M Y') }}</td>
                                            <td>₹{{ $event->starting_fees }}</td>
                                            <td>
                                                @php
                                                    $gallery = json_decode($event->event_gallery, true);
                                                @endphp
                                                @if($gallery && is_array($gallery))
                                                    @foreach($gallery as $img)
                                                        <img src="{{ asset('uploads/eventgallery/' . $img) }}" width="40" height="40" class="rounded me-1 mb-1" alt="Gallery Image">
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $event->map_link }}</td>
                                            <td>{{ $event->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.eventdetails.edit', $event->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('admin.eventdetails.destroy', $event->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                                
                                
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="javascript:void(0);">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->


    </div>
</div>
@endsection