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
                        <div class="d-flex gap-2">
                            {{-- Service Filter --}}
                            <form action="{{ route('admin.servicemcq.index') }}" method="GET" class="d-flex gap-2">
                                <select name="service_filter" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Services</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ request('service_filter') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(request('service_filter'))
                                    <a href="{{ route('admin.servicemcq.index') }}" class="btn btn-light">Clear Filter</a>
                                @endif
                            </form>
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create MCQ</button>
                            <!-- Start::add task modal -->
                            
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    {{-- Show Success or Error Messages --}}
                                    
                                    <form action="{{ route('admin.servicemcq.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Question for Service</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                @if($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
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
                                    
                                                    {{-- Question Type Selection --}}
                                                    <div class="col-xl-12">
                                                        <label class="form-label">Question Type</label>
                                                        <select name="question_type" id="question_type" class="form-control" required onchange="toggleQuestionType()">
                                                            <option value="text">Text Question</option>
                                                            <option value="mcq">Multiple Choice Question</option>
                                                        </select>
                                                    </div>
                                    
                                                    {{-- Question Input --}}
                                                    <div class="col-xl-12 mt-4">
                                                        <label class="form-label">Question</label>
                                                        <input type="text" class="form-control" name="question" placeholder="Enter Question" required>
                                                    </div>
                                    
                                                    {{-- MCQ Options Container --}}
                                                    <div id="mcq_options_container" class="col-xl-12" style="display: none;">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <label class="form-label mb-0">Options</label>
                                                            <button type="button" class="btn btn-sm btn-primary" onclick="addOption()">Add Option</button>
                                                        </div>
                                                        <div id="options_container">
                                                            <div class="option-row mb-2">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="options[]" placeholder="Option 1" required>
                                                                    <button type="button" class="btn btn-danger" onclick="removeOption(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Other Option --}}
                                                        <div class="mt-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="include_other" name="include_other" value="1">
                                                                <label class="form-check-label" for="include_other">
                                                                    Include "Other" option
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <script>
                                        let optionCount = 1;
                                        
                                        function addOption() {
                                            const container = document.getElementById('options_container');
                                            const newOption = document.createElement('div');
                                            newOption.className = 'option-row mb-2';
                                            optionCount++;
                                            
                                            newOption.innerHTML = `
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="options[]" placeholder="Option ${optionCount}" required>
                                                    <button type="button" class="btn btn-danger" onclick="removeOption(this)">Remove</button>
                                                </div>
                                            `;
                                            
                                            container.appendChild(newOption);
                                        }
                                        
                                        function removeOption(button) {
                                            button.closest('.option-row').remove();
                                        }
                                        
                                        function toggleQuestionType() {
                                            const questionType = document.getElementById('question_type').value;
                                            const mcqContainer = document.getElementById('mcq_options_container');
                                            
                                            if (questionType === 'mcq') {
                                                mcqContainer.style.display = 'block';
                                                // Make options required for MCQ
                                                document.querySelectorAll('input[name="options[]"]').forEach(input => {
                                                    input.required = true;
                                                });
                                            } else {
                                                mcqContainer.style.display = 'none';
                                                // Remove required attribute for text questions
                                                document.querySelectorAll('input[name="options[]"]').forEach(input => {
                                                    input.required = false;
                                                });
                                            }
                                        }

                                        // Initialize form state
                                        document.addEventListener('DOMContentLoaded', function() {
                                            toggleQuestionType();
                                        });
                                    </script>
                                    
                                    
                                    
                                                                      
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
                                        <th>Question Type</th>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($servicemcqs as $index => $mcq)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $mcq->service->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge {{ $mcq->question_type === 'mcq' ? 'bg-primary' : 'bg-info' }}">
                                                    {{ strtoupper($mcq->question_type) }}
                                                </span>
                                            </td>
                                            <td>{{ $mcq->question }}</td>
                                            <td>
                                                @if($mcq->question_type === 'mcq')
                                                    @if($mcq->options)
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($mcq->options as $option)
                                                                <li>{{ $option }}</li>
                                                            @endforeach
                                                            @if($mcq->has_other_option)
                                                                <li class="text-muted"><em>Other</em></li>
                                                            @endif
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">No options</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Text Question</span>
                                                @endif
                                            </td>
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