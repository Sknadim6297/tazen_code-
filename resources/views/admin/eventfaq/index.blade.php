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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i>Add FAQ</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.eventfaq.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Event FAQ</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    <!-- FAQ Table -->
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 45%">Question</th>
                                                                    <th style="width: 55%">Answer</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @for ($i = 1; $i <= 4; $i++)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" class="form-control" name="question{{ $i }}" placeholder="Question {{ $i }}" required>
                                                                        </td>
                                                                        <td>
                                                                            <textarea class="form-control" name="answer{{ $i }}" rows="2" placeholder="Answer {{ $i }}" required></textarea>
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                            </tbody>
                                                        </table>
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
                                        <th>#</th>
                                        <th>Question 1</th>
                                        <th>Answer 1</th>
                                        <th>Question 2</th>
                                        <th>Answer 2</th>
                                        <th>Question 3</th>
                                        <th>Answer 3</th>
                                        <th>Question 4</th>
                                        <th>Answer 4</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                                
                                <tbody>
                                    @foreach ($eventfaqs as $index => $faq)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $faq->question1 }}</td>
                                            <td>{{ $faq->answer1 }}</td>
                                            <td>{{ $faq->question2 }}</td>
                                            <td>{{ $faq->answer2 }}</td>
                                            <td>{{ $faq->question3 }}</td>
                                            <td>{{ $faq->answer3 }}</td>
                                            <td>{{ $faq->question4 }}</td>
                                            <td>{{ $faq->answer4 }}</td>
                                            <td>
                                                <a href="{{ route('admin.eventfaq.edit', $faq->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('admin.eventfaq.destroy', $faq->id) }}" method="POST" style="display:inline-block">
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