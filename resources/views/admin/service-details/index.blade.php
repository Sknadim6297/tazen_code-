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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Add Service Details</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.service-details.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Service Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body">
                                                <!-- Service Name Section -->
                                                <div class="card mb-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">Service Name</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-12">
                                                                <label for="service_id" class="form-label">Select Service Name</label>
                                                                <select class="form-select" name="service_id" id="service_id" required>
                                                                    <option value="" disabled selected>Select a service</option>
                                                                    @foreach($services as $service)
                                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <!-- Banner Section -->
                                                <div class="card mb-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">Banner Section</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="banner_image" class="form-label">Banner Image</label>
                                                                <input type="file" class="form-control" name="banner_image" id="banner_image">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="banner_image_alt" class="form-label">Banner Image Alt Text</label>
                                                                <input type="text" class="form-control" name="banner_image_alt" id="banner_image_alt" placeholder="Describe the banner image">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="banner_heading" class="form-label">Banner Heading</label>
                                                                <input type="text" class="form-control" name="banner_heading" id="banner_heading" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="banner_sub_heading" class="form-label">Banner Sub Heading</label>
                                                                <input type="text" class="form-control" name="banner_sub_heading" id="banner_sub_heading">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <!-- About Section -->
                                                <div class="card mb-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">About Section</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="about_image" class="form-label">About Image</label>
                                                                <input type="file" class="form-control" name="about_image" id="about_image">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="about_image_alt" class="form-label">About Image Alt Text</label>
                                                                <input type="text" class="form-control" name="about_image_alt" id="about_image_alt" placeholder="Describe the about section image">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="about_heading" class="form-label">About Heading</label>
                                                                <input type="text" class="form-control" name="about_heading" id="about_heading" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="about_subheading" class="form-label">About Subheading</label>
                                                                <input type="text" class="form-control" name="about_subheading" id="about_subheading">
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="about_description" class="form-label">About Description</label>
                                                                <textarea class="form-control" name="about_description" id="about_description" rows="4" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <!-- How It Works Section -->
                                                <div class="card mb-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">How It Works Section</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label for="background_image" class="form-label">Background Image</label>
                                                                <input type="file" class="form-control" name="background_image" id="background_image">
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="background_image_alt" class="form-label">Background Image Alt Text</label>
                                                                <input type="text" class="form-control" name="background_image_alt" id="background_image_alt" placeholder="Describe the background image">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="how_it_works_subheading" class="form-label">Section Subheading</label>
                                                                <input type="text" class="form-control" name="how_it_works_subheading" id="how_it_works_subheading">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="content_heading" class="form-label">Content Heading</label>
                                                                <input type="text" class="form-control" name="content_heading" id="content_heading" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="content_sub_heading" class="form-label">Content Sub Heading</label>
                                                                <input type="text" class="form-control" name="content_sub_heading" id="content_sub_heading">
                                                            </div>
                                                        </div>
                                    
                                                        <!-- Steps -->
                                                        <div class="mt-4">
                                                            <h6 class="mb-3">Steps</h6>
                                                            <div class="row g-3">
                                                                @for($i = 1; $i <= 3; $i++)
                                                                <div class="col-md-12">
                                                                    <div class="card mb-3">
                                                                        <div class="card-header bg-light py-2">
                                                                            <h6 class="mb-0">Step {{ $i }}</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row g-3">
                                                                                <div class="col-md-6">
                                                                                    <label for="step{{$i}}_heading" class="form-label">Heading</label>
                                                                                    <input type="text" class="form-control" name="step{{$i}}_heading" id="step{{$i}}_heading" {{ $i == 1 ? 'required' : '' }}>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <label for="step{{$i}}_description" class="form-label">Description</label>
                                                                                    <textarea class="form-control" name="step{{$i}}_description" id="step{{$i}}_description" rows="3" {{ $i == 1 ? 'required' : '' }}></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                                                                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead class="table-light align-middle">
                                    <tr>
                                        <th rowspan="2" width="5%">#</th>
                                        <th rowspan="2" width="10%">Service Nmae</th>
                                        <th colspan="3">Banner Section</th>
                                        <th colspan="4">About Section</th>
                                        <th colspan="3">How It Works</th>
                                        <th colspan="6">Steps</th>
                                        <th rowspan="2" width="8%" class="text-center">Actions</th>
                                    </tr>
                                    <tr>
                                        <!-- Banner Section Sub-Headers -->
                                        <th width="10%">Image</th>
                                        <th width="12%">Heading</th>
                                        <th width="12%">Sub Heading</th>
                            
                                        <!-- About Section Sub-Headers -->
                                        <th width="10%">Image</th>
                                        <th width="12%">Heading</th>
                                        <th width="12%">Subheading</th>
                                        <th width="15%">Description</th>
                            
                                        <!-- How It Works Sub-Headers -->
                                        <th width="10%">BG Image</th>
                                        <th width="12%">Content Heading</th>
                                        <th width="12%">Sub Heading</th>
                            
                                        <!-- Steps Sub-Headers -->
                                        <th width="10%">Step 1 Heading</th>
                                        <th width="10%">Step 1 Description</th>
                                        <th width="10%">Step 2 Heading</th>
                                        <th width="10%">Step 2 Description</th>
                                        <th width="10%">Step 3 Heading</th>
                                        <th width="10%">Step 3 Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($serviceDetails as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->service->name }}</td>
                            
                                        <!-- Banner Section -->
                                        <td>
                                            @if($item->banner_image)
                                            <img src="{{ asset('storage/'.$item->banner_image) }}" width="50" class="img-thumbnail">
                                            @else
                                            <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($item->banner_heading, 20) }}</td>
                                        <td>{{ Str::limit($item->banner_sub_heading, 20) }}</td>
                            
                                        <!-- About Section -->
                                        <td>
                                            @if($item->about_image)
                                            <img src="{{ asset('storage/'.$item->about_image) }}" width="50" class="img-thumbnail">
                                            @else
                                            <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($item->about_heading, 20) }}</td>
                                        <td>{{ Str::limit($item->about_subheading, 20) }}</td>
                                        <td>{{ Str::limit($item->about_description, 30) }}</td>
                            
                                        <!-- How It Works -->
                                        <td>
                                            @if($item->background_image)
                                            <img src="{{ asset('storage/'.$item->background_image) }}" width="50" class="img-thumbnail">
                                            @else
                                            <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($item->content_heading, 20) }}</td>
                                        <td>{{ Str::limit($item->content_sub_heading, 20) }}</td>
                            
                                        <!-- Steps -->
                                        <td>{{ Str::limit($item->step1_heading, 15) }}</td>
                                        <td>{{ Str::limit($item->step1_description, 25) }}</td>
                                        <td>{{ Str::limit($item->step2_heading, 15) }}</td>
                                        <td>{{ Str::limit($item->step2_description, 25) }}</td>
                                        <td>{{ Str::limit($item->step3_heading, 15) }}</td>
                                        <td>{{ Str::limit($item->step3_description, 25) }}</td>
                            
                                        <!-- Actions -->
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.service-details.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
                                        
                                            <!-- Delete Form with Confirmation -->
                                            <form action="{{ route('admin.service-details.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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