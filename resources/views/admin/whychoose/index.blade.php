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
                                                    {{-- Section Sub Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="section_sub_heading" class="form-label">Section Sub Heading</label>
                                                        <input type="text" class="form-control" name="section_sub_heading" id="section_sub_heading" placeholder="Enter Section Sub Heading">
                                                    </div>
                                    
                                                    {{-- Cards 1 to 5 --}}
                                                    @for ($i = 1; $i <= 6; $i++)
                                                        <div class="col-xl-12 mt-4">
                                                            <h6>Card {{ $i }}</h6>
                                                        </div>
                                    
                                                        <div class="col-xl-6">
                                                            <label for="card{{ $i }}" class="form-label">Card {{ $i }} Title</label>
                                                            <input type="text" class="form-control" name="card{{ $i }}" id="card{{ $i }}" placeholder="Enter Card Title">
                                                        </div>
                                    
                                                        <div class="col-xl-6">
                                                            <label for="mini_heading{{ $i }}" class="form-label">Mini Heading</label>
                                                            <input type="text" class="form-control" name="mini_heading{{ $i }}" id="mini_heading{{ $i }}" placeholder="Enter Mini Heading">
                                                        </div>
                                    
                                                        <div class="col-xl-6">
                                                            <label for="heading{{ $i }}" class="form-label">Heading</label>
                                                            <input type="text" class="form-control" name="heading{{ $i }}" id="heading{{ $i }}" placeholder="Enter Heading">
                                                        </div>
                                    
                                                        <div class="col-xl-6">
                                                            <label for="icon_name{{ $i }}" class="form-label">Icon Name</label>
                                                            <input type="text" class="form-control" name="icon_name{{ $i }}" id="icon_name{{ $i }}" placeholder="Enter Icon Class Name">
                                                        </div>
                                    
                                                        <div class="col-xl-12">
                                                            <label for="description{{ $i }}" class="form-label">Description</label>
                                                            <textarea class="form-control" name="description{{ $i }}" id="description{{ $i }}" rows="3" placeholder="Enter Description"></textarea>
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
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Section Heading</th>
                                        <th>Section Sub Heading</th>

                                        {{-- Card 1 --}}
                                        <th>Card 1 Mini Heading</th>
                                        <th>Card 1 Heading</th>
                                        <th>Card 1 Icon</th>
                                        <th>Card 1 Description</th>

                                        {{-- Card 2 --}}
                                        <th>Card 2 Mini Heading</th>
                                        <th>Card 2 Heading</th>
                                        <th>Card 2 Icon</th>
                                        <th>Card 2 Description</th>

                                        {{-- Card 3 --}}
                                        <th>Card 3 Mini Heading</th>
            <th>Card 3 Heading</th>
            <th>Card 3 Icon</th>
            <th>Card 3 Description</th>

            {{-- Card 4 --}}
            <th>Card 4 Mini Heading</th>
            <th>Card 4 Heading</th>
            <th>Card 4 Icon</th>
            <th>Card 4 Description</th>

            {{-- Card 5 --}}
            <th>Card 5 Mini Heading</th>
            <th>Card 5 Heading</th>
            <th>Card 5 Icon</th>
            <th>Card 5 Description</th>

            {{-- Card 6 --}}
            <th>Card 6 Mini Heading</th>
            <th>Card 6 Heading</th>
            <th>Card 6 Icon</th>
            <th>Card 6 Description</th>

            <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($whychoose as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->section_heading }}</td>
                                        <td>{{ $item->section_sub_heading }}</td>
                            
                                        {{-- Card 1 --}}
                                        <td>{{ $item->card1_mini_heading }}</td>
                                        <td>{{ $item->card1_heading }}</td>
                                        <td>{{ $item->card1_icon }}</td>
                                        <td>{{ $item->card1_description }}</td>
                            
                                        {{-- Card 2 --}}
                                        <td>{{ $item->card2_mini_heading }}</td>
                                        <td>{{ $item->card2_heading }}</td>
                                        <td>{{ $item->card2_icon }}</td>
                                        <td>{{ $item->card2_description }}</td>
                            
                                        {{-- Card 3 --}}
                                        <td>{{ $item->card3_mini_heading }}</td>
                                        <td>{{ $item->card3_heading }}</td>
                                        <td>{{ $item->card3_icon }}</td>
                                        <td>{{ $item->card3_description }}</td>
                            
                                        {{-- Card 4 --}}
                                        <td>{{ $item->card4_mini_heading }}</td>
                                        <td>{{ $item->card4_heading }}</td>
                                        <td>{{ $item->card4_icon }}</td>
                                        <td>{{ $item->card4_description }}</td>
                            
                                        {{-- Card 5 --}}
                                        <td>{{ $item->card5_mini_heading }}</td>
                                        <td>{{ $item->card5_heading }}</td>
                                        <td>{{ $item->card5_icon }}</td>
                                        <td>{{ $item->card5_description }}</td>
                            
                                        {{-- Card 6 --}}
                                        <td>{{ $item->card6_mini_heading }}</td>
                                        <td>{{ $item->card6_heading }}</td>
                                        <td>{{ $item->card6_icon }}</td>
                                        <td>{{ $item->card6_description }}</td>
                            
                                        <td>
                                            {{-- Action Buttons --}}
                                            <a href="{{ route('admin.whychoose.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('admin.whychoose.destroy', $item->id) }}" method="POST" style="display:inline-block;">
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