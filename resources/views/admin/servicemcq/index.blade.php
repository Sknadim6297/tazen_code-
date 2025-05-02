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
                            Add only 5 MCQ questions per service
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Testimonials</button>
                            <!-- Start::add task modal -->
                            
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    {{-- Show Success or Error Messages --}}
                                    
                                    <form action="{{ route('admin.servicemcq.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add MCQ Question for Service</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                    
                                                    {{-- Service Name Dropdown --}}
                                                    <div class="col-xl-12">
                                                        <label for="service_id" class="form-label">Select Service</label>
                                                        <select name="service_id" id="service_id" class="form-control" required>
                                                            <option value="">-- Select a Service --</option>
                                                            @foreach($services as $service)
                                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                    
                                                    {{-- One Question and 4 Answers --}}
                                                    <div class="col-xl-12 mt-4">
                                                        <label class="form-label">Question</label>
                                                        <input type="text" class="form-control" name="question" placeholder="Enter Question" required>
                                                    </div>
                                    
                                                    <div class="col-xl-6">
                                                        <label class="form-label">Answer 1</label>
                                                        <input type="text" class="form-control" name="answer1" placeholder="Answer 1" required>
                                                    </div>
                                    
                                                    <div class="col-xl-6">
                                                        <label class="form-label">Answer 2</label>
                                                        <input type="text" class="form-control" name="answer2" placeholder="Answer 2" required>
                                                    </div>
                                    
                                                    <div class="col-xl-6">
                                                        <label class="form-label">Answer 3</label>
                                                        <input type="text" class="form-control" name="answer3" placeholder="Answer 3" required>
                                                    </div>
                                    
                                                    <div class="col-xl-6">
                                                        <label class="form-label">Answer 4</label>
                                                        <input type="text" class="form-control" name="answer4" placeholder="Answer 4" required>
                                                    </div>
                                    
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
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
                                        <th>#</th>
                                        <th>Service Name</th>
                                        <th>Question</th>
                                        <th>Answer 1</th>
                                        <th>Answer 2</th>
                                        <th>Answer 3</th>
                                        <th>Answer 4</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($servicemcqs as $index => $mcq)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $mcq->service->name ?? 'N/A' }}</td>
                                            <td>{{ $mcq->question }}</td>
                                            <td>{{ $mcq->answer1 }}</td>
                                            <td>{{ $mcq->answer2 }}</td>
                                            <td>{{ $mcq->answer3 }}</td>
                                            <td>{{ $mcq->answer4 }}</td>
                                            <td>
                                                <a href="{{ route('admin.servicemcq.edit', $mcq->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                
                                                <form action="{{ route('admin.servicemcq.destroy', $mcq->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
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