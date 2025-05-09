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
    
            <div class="mb-3">
                <label for="service_id" class="form-label">Service Name</label>
                <select name="service_id" id="service_id" class="form-control" required>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $servicemcq->service_id == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Question</label>
                <input type="text" name="question" class="form-control" value="{{ $servicemcq->question }}" required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Answer 1</label>
                <input type="text" name="answer1" class="form-control" value="{{ $servicemcq->answer1 }}" required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Answer 2</label>
                <input type="text" name="answer2" class="form-control" value="{{ $servicemcq->answer2 }}" required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Answer 3</label>
                <input type="text" name="answer3" class="form-control" value="{{ $servicemcq->answer3 }}" required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Answer 4</label>
                <input type="text" name="answer4" class="form-control" value="{{ $servicemcq->answer4 }}" required>
            </div>
    
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.servicemcq.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update Question</button>
            </div>
        </form>
    </div>
</div>
@endsection
