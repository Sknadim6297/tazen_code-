@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container mt-5">
        <h2>Edit Event FAQ</h2>
        <form action="{{ route('admin.eventfaq.update', $faq->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            @for ($i = 1; $i <= 4; $i++)
                <div class="mb-3">
                    <label>Question {{ $i }}</label>
                    <input type="text" name="question{{ $i }}" class="form-control" value="{{ $faq->{'question'.$i} }}" required>
                </div>
                <div class="mb-3">
                    <label>Answer {{ $i }}</label>
                    <textarea name="answer{{ $i }}" class="form-control" rows="2" required>{{ $faq->{'answer'.$i} }}</textarea>
                </div>
            @endfor
    
            <button type="submit" class="btn btn-primary">Update FAQ</button>
            <a href="{{ route('admin.eventfaq.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection