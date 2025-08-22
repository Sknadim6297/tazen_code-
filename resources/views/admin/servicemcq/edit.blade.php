@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container mt-4">
        <h4>Edit MCQ Question</h4>
    
        {{-- Show Success or Error Messages --}}
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
    
        <form action="{{ route('admin.servicemcq.update', $servicemcq->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row gy-3">
                {{-- Service Name Dropdown --}}
                <div class="col-xl-12">
                    <label for="service_id" class="form-label">Select Service</label>
                    <select name="service_id" id="service_id" class="form-control" required>
                        <option value="">-- Select a Service --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $servicemcq->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Question Type Selection --}}
                <div class="col-xl-12">
                    <label class="form-label">Question Type</label>
                    <select name="question_type" id="question_type" class="form-control" required onchange="toggleQuestionType()">
                        <option value="text" {{ $servicemcq->question_type == 'text' ? 'selected' : '' }}>Text Question</option>
                        <option value="mcq" {{ $servicemcq->question_type == 'mcq' ? 'selected' : '' }}>Multiple Choice Question</option>
                    </select>
                </div>

                {{-- Question Input --}}
                <div class="col-xl-12 mt-4">
                    <label class="form-label">Question</label>
                    <input type="text" class="form-control" name="question" value="{{ $servicemcq->question }}" placeholder="Enter Question" required>
                </div>

                {{-- MCQ Options Container --}}
                <div id="mcq_options_container" class="col-xl-12" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label mb-0">Options</label>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addOption()">Add Option</button>
                    </div>
                    <div id="options_container">
                        @if(is_array($servicemcq->options) && count($servicemcq->options))
                            @foreach($servicemcq->options as $idx => $option)
                                <div class="option-row mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="options[]" value="{{ $option }}" placeholder="Option {{ $idx+1 }}" required>
                                        <button type="button" class="btn btn-danger" onclick="removeOption(this)">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="option-row mb-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="options[]" placeholder="Option 1" required>
                                    <button type="button" class="btn btn-danger" onclick="removeOption(this)">Remove</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- Other Option --}}
                    <div class="mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="include_other" name="include_other" value="1" {{ $servicemcq->has_other_option ? 'checked' : '' }}>
                            <label class="form-check-label" for="include_other">
                                Include "Other" option
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.servicemcq.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update Question</button>
            </div>
        </form>
        <script>
            let optionCount = document.querySelectorAll('#options_container .option-row').length || 1;
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
                    document.querySelectorAll('input[name="options[]"]').forEach(input => {
                        input.required = true;
                    });
                } else {
                    mcqContainer.style.display = 'none';
                    document.querySelectorAll('input[name="options[]"]').forEach(input => {
                        input.required = false;
                    });
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                toggleQuestionType();
            });
        </script>
    </div>
</div>
@endsection
