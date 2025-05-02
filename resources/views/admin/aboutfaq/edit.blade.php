@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container">
        <h4>Edit FAQ</h4>
    
        <form action="{{ route('admin.aboutfaq.update', $faq->id) }}" method="POST">
            @csrf
            @method('PUT')
    
            <div class="mb-3">
                <label for="faq_description" class="form-label">FAQ Section Description</label>
                <textarea name="faq_description" class="form-control" id="faq_description" rows="3" required>{{ old('faq_description', $faq->faq_description) }}</textarea>
            </div>
    
            <table class="table table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 4; $i++)
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="question{{ $i }}" value="{{ old("question$i", $faq->{'question' . $i}) }}" placeholder="Question {{ $i }}">
                            </td>
                            <td>
                                <textarea class="form-control" name="answer{{ $i }}" rows="2" placeholder="Answer {{ $i }}">{{ old("answer$i", $faq->{'answer' . $i}) }}</textarea>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
    
            <button type="submit" class="btn btn-success mt-3">Update FAQ</button>
        </form>
    </div>

</div>
@endsection