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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Blog</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.mcq.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add MCQ</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    {{-- Question --}}
                                                    <div class="col-xl-12">
                                                        <label for="question{{ $i }}" class="form-label">Question {{ $i }}</label>
                                                        <input type="text" class="form-control" id="question{{ $i }}" name="question{{ $i }}" placeholder="Enter Question {{ $i }}" required>
                                                    </div>
                                    
                                                    {{-- Option A --}}
                                                    <div class="col-xl-6">
                                                        <label for="option{{ $i }}_a" class="form-label">Option A</label>
                                                        <input type="text" class="form-control" id="option{{ $i }}_a" name="option{{ $i }}_a" placeholder="Enter Option A" required>
                                                    </div>
                                    
                                                    {{-- Option B --}}
                                                    <div class="col-xl-6">
                                                        <label for="option{{ $i }}_b" class="form-label">Option B</label>
                                                        <input type="text" class="form-control" id="option{{ $i }}_b" name="option{{ $i }}_b" placeholder="Enter Option B" required>
                                                    </div>
                                    
                                                    {{-- Option C --}}
                                                    <div class="col-xl-6">
                                                        <label for="option{{ $i }}_c" class="form-label">Option C</label>
                                                        <input type="text" class="form-control" id="option{{ $i }}_c" name="option{{ $i }}_c" placeholder="Enter Option C" required>
                                                    </div>
                                    
                                                    {{-- Option D --}}
                                                    <div class="col-xl-6">
                                                        <label for="option{{ $i }}_d" class="form-label">Option D</label>
                                                        <input type="text" class="form-control" id="option{{ $i }}_d" name="option{{ $i }}_d" placeholder="Enter Option D" required>
                                                    </div>
                                                    @endfor
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
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question 1</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
                                    <th>Question 2</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
                                    <th>Question 3</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
                                    <th>Question 4</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
                                    <th>Question 5</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mcqs as $index => $mcq)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $mcq->question1 }}</td>
                                        <td>{{ $mcq->option1_a }}</td>
                                        <td>{{ $mcq->option1_b }}</td>
                                        <td>{{ $mcq->option1_c }}</td>
                                        <td>{{ $mcq->option1_d }}</td>
                                        <td>{{ $mcq->question2 }}</td>
                                        <td>{{ $mcq->option2_a }}</td>
                                        <td>{{ $mcq->option2_b }}</td>
                                        <td>{{ $mcq->option2_c }}</td>
                                        <td>{{ $mcq->option2_d }}</td>
                                        <td>{{ $mcq->question3 }}</td>
                                        <td>{{ $mcq->option3_a }}</td>
                                        <td>{{ $mcq->option3_b }}</td>
                                        <td>{{ $mcq->option3_c }}</td>
                                        <td>{{ $mcq->option3_d }}</td>
                                        <td>{{ $mcq->question4 }}</td>
                                        <td>{{ $mcq->option4_a }}</td>
                                        <td>{{ $mcq->option4_b }}</td>
                                        <td>{{ $mcq->option4_c }}</td>
                                        <td>{{ $mcq->option4_d }}</td>
                                        <td>{{ $mcq->question5 }}</td>
                                        <td>{{ $mcq->option5_a }}</td>
                                        <td>{{ $mcq->option5_b }}</td>
                                        <td>{{ $mcq->option5_c }}</td>
                                        <td>{{ $mcq->option5_d }}</td>
                                        <td>{{ $mcq->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.mcq.edit', $mcq->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.mcq.destroy', $mcq->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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