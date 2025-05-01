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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Why Choose Us</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.whychoose.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Why Choose Us Section</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    {{-- Section Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="section_heading" class="form-label">Section Heading</label>
                                                        <input type="text" class="form-control" name="section_heading" id="section_heading" placeholder="Enter Section Heading" required>
                                                    </div>
                                    
                                                    {{-- Section Sub Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="section_sub_heading" class="form-label">Section Sub Heading</label>
                                                        <input type="text" class="form-control" name="section_sub_heading" id="section_sub_heading" placeholder="Enter Section Sub Heading" required>
                                                    </div>
                                    
                                                    {{-- Cards --}}
                                                    @for ($i = 1; $i <= 6; $i++)
                                                        <div class="col-xl-12 mt-4">
                                                            <h6>Card {{ $i }}</h6>
                                                        </div>
                                    
                                                        {{-- Card Mini Heading --}}
                                                        <div class="col-xl-6">
                                                            <label for="card{{ $i }}_mini_heading" class="form-label">Card {{ $i }} Mini Heading</label>
                                                            <input type="text" class="form-control" name="card{{ $i }}_mini_heading" id="card{{ $i }}_mini_heading" placeholder="Enter Mini Heading" required>
                                                        </div>
                                    
                                                        {{-- Card Heading --}}
                                                        <div class="col-xl-6">
                                                            <label for="card{{ $i }}_heading" class="form-label">Card {{ $i }} Heading</label>
                                                            <input type="text" class="form-control" name="card{{ $i }}_heading" id="card{{ $i }}_heading" placeholder="Enter Heading" required>
                                                        </div>
                                    
                                                        {{-- Card Icon --}}
                                                        <div class="col-xl-6">
                                                            <label for="card{{ $i }}_icon" class="form-label">Card {{ $i }} Icon Name</label>
                                                            <input type="text" class="form-control" name="card{{ $i }}_icon" id="card{{ $i }}_icon" placeholder="Enter Icon Class Name" required>
                                                        </div>
                                    
                                                        {{-- Card Description --}}
                                                        <div class="col-xl-12">
                                                            <label for="card{{ $i }}_description" class="form-label">Card {{ $i }} Description</label>
                                                            <textarea class="form-control" name="card{{ $i }}_description" id="card{{ $i }}_description" rows="3" placeholder="Enter Description" required></textarea>
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
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Section Heading</th>
                                        <th scope="col">Section Sub Heading</th>
                                        <th scope="col">Card 1 Title</th>
                                        <th scope="col">Card 1 Mini Heading</th>
                                        <th scope="col">Card 1 Heading</th>
                                        <th scope="col">Card 1 Icon</th>
                                        <th scope="col">Card 1 Description</th>
                                        <th scope="col">Card 2 Title</th>
                                        <th scope="col">Card 2 Mini Heading</th>
                                        <th scope="col">Card 2 Heading</th>
                                        <th scope="col">Card 2 Icon</th>
                                        <th scope="col">Card 2 Description</th>
                                        <th scope="col">Card 3 Title</th>
                                        <th scope="col">Card 3 Mini Heading</th>
                                        <th scope="col">Card 3 Heading</th>
                                        <th scope="col">Card 3 Icon</th>
                                        <th scope="col">Card 3 Description</th>
                                        <th scope="col">Card 4 Title</th>
                                        <th scope="col">Card 4 Mini Heading</th>
                                        <th scope="col">Card 4 Heading</th>
                                        <th scope="col">Card 4 Icon</th>
                                        <th scope="col">Card 4 Description</th>
                                        <th scope="col">Card 5 Title</th>
                                        <th scope="col">Card 5 Mini Heading</th>
                                        <th scope="col">Card 5 Heading</th>
                                        <th scope="col">Card 5 Icon</th>
                                        <th scope="col">Card 5 Description</th>
                                        <th scope="col">Card 6 Title</th>
                                        <th scope="col">Card 6 Mini Heading</th>
                                        <th scope="col">Card 6 Heading</th>
                                        <th scope="col">Card 6 Icon</th>
                                        <th scope="col">Card 6 Description</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($whychooses as $whychoose)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $whychoose->section_heading }}</td>
                                        <td>{{ $whychoose->section_sub_heading }}</td>
                            
                                        <td>{{ $whychoose->card1_title }}</td>
                                        <td>{{ $whychoose->card1_mini_heading }}</td>
                                        <td>{{ $whychoose->card1_heading }}</td>
                                        <td>{{ $whychoose->card1_icon }}</td>
                                        <td>{{ $whychoose->card1_description }}</td>
                            
                                        <td>{{ $whychoose->card2_title }}</td>
                                        <td>{{ $whychoose->card2_mini_heading }}</td>
                                        <td>{{ $whychoose->card2_heading }}</td>
                                        <td>{{ $whychoose->card2_icon }}</td>
                                        <td>{{ $whychoose->card2_description }}</td>
                            
                                        <td>{{ $whychoose->card3_title }}</td>
                                        <td>{{ $whychoose->card3_mini_heading }}</td>
                                        <td>{{ $whychoose->card3_heading }}</td>
                                        <td>{{ $whychoose->card3_icon }}</td>
                                        <td>{{ $whychoose->card3_description }}</td>
                            
                                        <td>{{ $whychoose->card4_title }}</td>
                                        <td>{{ $whychoose->card4_mini_heading }}</td>
                                        <td>{{ $whychoose->card4_heading }}</td>
                                        <td>{{ $whychoose->card4_icon }}</td>
                                        <td>{{ $whychoose->card4_description }}</td>
                            
                                        <td>{{ $whychoose->card5_title }}</td>
                                        <td>{{ $whychoose->card5_mini_heading }}</td>
                                        <td>{{ $whychoose->card5_heading }}</td>
                                        <td>{{ $whychoose->card5_icon }}</td>
                                        <td>{{ $whychoose->card5_description }}</td>
                            
                                        <td>{{ $whychoose->card6_title }}</td>
                                        <td>{{ $whychoose->card6_mini_heading }}</td>
                                        <td>{{ $whychoose->card6_heading }}</td>
                                        <td>{{ $whychoose->card6_icon }}</td>
                                        <td>{{ $whychoose->card6_description }}</td>
                            
                                        <td>
                                            <!-- Actions: Edit / Delete buttons -->
                                            <a href="{{ route('admin.whychoose.edit', $whychoose->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.whychoose.destroy', $whychoose->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
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