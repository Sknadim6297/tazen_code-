@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

            
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">All Professionals</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                     
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Professional</li>
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
                            Total Professionals
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input check-all" type="checkbox" id="all-professionals" aria-label="..."></th>
                                        <th scope="col">Sl.No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($professionals as $professional)
                                    <tr class="professional-list">
                                        <td class="professional-checkbox">
                                            <input class="form-check-input" type="checkbox" value="{{ $professional->id }}" aria-label="...">
                                        </td>
                                        <td>
                                            <span class="fw-medium">{{ $loop->iteration }}</span>
                                            
                                        </td>
                                        <td>
                                            <span class="fw-medium">{{ $professional->name }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-medium">{{ $professional->email }}</span>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($professional->created_at)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="view">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.manage-professional.edit', $professional->id) }}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <a href="{{ route('admin.manage-professional.destroy', $professional->id) }}" class="btn btn-danger-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="Delete" >
                                                <i class="ri-delete-bin-5-line"></i>
                                            </a>
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