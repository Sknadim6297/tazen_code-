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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Event</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.allevents.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Event</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                    
                                                    {{-- Card Image --}}
                                                    <div class="col-xl-12">
                                                        <label for="card_image" class="form-label">Event Image</label>
                                                        <input type="file" class="form-control" id="card_image" name="card_image" accept="image/*" required>
                                                    </div>
                                    
                                                    {{-- Date --}}
                                                    <div class="col-xl-6">
                                                        <label for="date" class="form-label">Event Date</label>
                                                        <input type="date" class="form-control" id="date" name="date" required>
                                                    </div>
                                    
                                                    {{-- Starting Fees --}}
                                                    <div class="col-xl-6">
                                                        <label for="starting_fees" class="form-label">Starting Fees</label>
                                                        <input type="number" class="form-control" id="starting_fees" name="starting_fees" placeholder="Enter Starting Fees" required>
                                                    </div>
                                    
                                                    {{-- Mini Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="mini_heading" class="form-label">Event Type</label>
                                                        <input type="text" class="form-control" id="mini_heading" name="mini_heading" placeholder="Enter Mini Heading" required>
                                                    </div>
                                    
                                                    {{-- Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="heading" class="form-label">Event Name</label>
                                                        <input type="text" class="form-control" id="heading" name="heading" placeholder="Enter Main Heading" required>
                                                    </div>
                                    
                                                    {{-- Short Description --}}
                                                    <div class="col-xl-12">
                                                        <label for="short_description" class="form-label">Short Description</label>
                                                        <textarea class="form-control" id="short_description" name="short_description" rows="4" placeholder="Enter a short description about the event" required></textarea>
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Event Image</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Event Type</th>
                                        <th scope="col">Event Name</th>
                                        <th scope="col">Short Description</th>
                                        <th scope="col">Starting Fees</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allevents as $event)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/' . $event->card_image) }}" alt="Event Image" width="100" height="100">
                                            </td>
                                            <td>{{ $event->date }}</td>
                                            <td>{{ $event->mini_heading }}</td>
                                            <td>{{ $event->heading }}</td>
                                            <td>{{ Str::limit($event->short_description, 50) }}</td>
                                            <td>₹{{ number_format($event->starting_fees, 2) }}</td>
                                            <td>
                                                <a href="{{ route('admin.allevents.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.allevents.destroy', $event->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?')">
                                                        Delete
                                                    </button>
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