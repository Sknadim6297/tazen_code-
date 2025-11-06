@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

            
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">FAQ Management</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">FAQs</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            All FAQs
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-faq"><i class="ri-add-line fw-medium align-middle me-1"></i>Add FAQ</button>
                            <!-- Start::add faq modal -->
                            <div class="modal fade" id="create-faq" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <form action="{{ route('admin.faq.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add FAQ</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                    
                                                    <!-- Question -->
                                                    <div class="col-md-12">
                                                        <label for="question" class="form-label">Question</label>
                                                        <input type="text" class="form-control" name="question" id="question" placeholder="Enter FAQ question" required>
                                                    </div>
                                    
                                                    <!-- Answer -->
                                                    <div class="col-md-12">
                                                        <label for="answer" class="form-label">Answer</label>
                                                        <textarea class="form-control" name="answer" id="answer" rows="4" placeholder="Enter FAQ answer" required></textarea>
                                                    </div>

                                                    <!-- Order -->
                                                    <div class="col-md-6">
                                                        <label for="order" class="form-label">Display Order</label>
                                                        <input type="number" class="form-control" name="order" id="order" placeholder="0" value="0">
                                                    </div>
                                    
                                                    <!-- Status -->
                                                    <div class="col-md-6">
                                                        <div class="form-check mt-4">
                                                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" checked>
                                                            <label class="form-check-label" for="status">Active</label>
                                                        </div>
                                                    </div>
                                    
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save FAQ</button>
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
                                <thead class="table-light">
                                    <tr>
                                        <th style="border: 1px solid #dee2e6;">#</th>
                                        <th style="border: 1px solid #dee2e6;">Question</th>
                                        <th style="border: 1px solid #dee2e6;">Answer</th>
                                        <th style="border: 1px solid #dee2e6;">Order</th>
                                        <th style="border: 1px solid #dee2e6;">Status</th>
                                        <th style="border: 1px solid #dee2e6;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($faqs as $index => $faq)
                                        <tr>
                                            <td style="border: 1px solid #dee2e6;">{{ $index + 1 }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $faq->question }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ Str::limit($faq->answer, 100) }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $faq->order }}</td>
                                            <td style="border: 1px solid #dee2e6;">
                                                @if($faq->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td style="border: 1px solid #dee2e6;">
                                                <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn btn-sm btn-info">Edit</a>
                                                <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center" style="border: 1px solid #dee2e6;">No FAQs found</td>
                                        </tr>
                                    @endforelse
                                </tbody>                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->


    </div>
</div>
@endsection

