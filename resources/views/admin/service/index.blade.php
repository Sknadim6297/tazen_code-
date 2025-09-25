@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center  flex-wrap gap-2" >
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Services List View</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Service</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);"></a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Task List View</li> --}}
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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Service</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Service</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4">
                                                <div class="row gy-2">
                                                    <!-- Service Name -->
                                                    <div class="col-xl-12">
                                                        <label for="service-name" class="form-label">Service Name</label>
                                                        <input type="text" class="form-control" name="name" id="service-name" placeholder="Enter service name" required>
                                                    </div>

                                                    <!-- Slug -->
                                                    <div class="col-xl-12">
                                                        <label for="service-slug" class="form-label">Slug (URL friendly)</label>
                                                        <input type="text" class="form-control" name="slug" id="service-slug" placeholder="Auto-generated from name">
                                                        <small class="form-text text-muted">Leave empty to auto-generate from service name</small>
                                                    </div>

                                                    <!-- Meta Title -->
                                                    <div class="col-xl-12">
                                                        <label for="meta-title" class="form-label">Meta Title (SEO)</label>
                                                        <input type="text" class="form-control" name="meta_title" id="meta-title" placeholder="Enter meta title for SEO" maxlength="255">
                                                        <small class="form-text text-muted">Recommended: 50-60 characters</small>
                                                    </div>

                                                    <!-- Meta Description -->
                                                    <div class="col-xl-12">
                                                        <label for="meta-description" class="form-label">Meta Description (SEO)</label>
                                                        <textarea class="form-control" name="meta_description" id="meta-description" rows="3" placeholder="Enter meta description for SEO" maxlength="500"></textarea>
                                                        <small class="form-text text-muted">Recommended: 150-160 characters</small>
                                                    </div>
                            
                                                    <!-- Image -->
                                                    <div class="col-xl-12">
                                                        <label for="service-image" class="form-label">Image</label>
                                                        <input type="file" class="form-control" name="image" id="service-image" accept="image/*">
                                                    </div>
                            
                                                    <!-- Status -->
                                                    <div class="col-xl-12">
                                                        <label for="service-status" class="form-label">Status</label>
                                                        <select class="form-control" name="status" id="service-status" required>
                                                            <option value="active">Active</option>
                                                            <option value="inactive">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add Service</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            <input class="form-check-input check-all" type="checkbox" id="all-tasks" value="" aria-label="...">
                                        </th>
                                        <th scope="col">Service Name</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Meta Title</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $key => $service)
                                        <tr class="task-list">
                                            <td class="task-checkbox">
                                                <input class="form-check-input" type="checkbox" value="" aria-label="...">
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $service->name }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $service->slug ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ Str::limit($service->meta_title ?? 'N/A', 30) }}</span>
                                            </td>
                                            <td>
                                                @if($service->image)
                                                    <img src="{{ asset('storage/' . $service->image) }}" width="50" height="50" alt="Service Image">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-medium 
                                                    @if($service->status == 'active') 
                                                        bg-success text-white px-2 py-1 rounded
                                                    @else 
                                                        bg-secondary text-white px-2 py-1 rounded
                                                    @endif
                                                ">
                                                    {{ ucfirst($service->status) }}
                                                </span>
                                            </td>
                                            
                                            <td>
                                                <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light btn-icon ms-1 btn-sm task-delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="ri-delete-bin-5-line"></i>
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

<script>
// Auto-generate slug from service name
document.addEventListener('DOMContentLoaded', function() {
    const serviceNameInput = document.getElementById('service-name');
    const serviceSlugInput = document.getElementById('service-slug');
    
    if (serviceNameInput && serviceSlugInput) {
        serviceNameInput.addEventListener('input', function() {
            if (!serviceSlugInput.value || serviceSlugInput.dataset.userEdited !== 'true') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                    .trim();
                serviceSlugInput.value = slug;
            }
        });
        
        // Mark slug as user-edited if manually changed
        serviceSlugInput.addEventListener('input', function() {
            this.dataset.userEdited = 'true';
        });
    }
});
</script>
@endsection