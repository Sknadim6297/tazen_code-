@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
    <h2>Edit Blog Post</h2>

    <form action="{{ route('admin.blogposts.update', $blogPost->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Category:</label>
        <input type="text" name="category" value="{{ $blogPost->category }}" required>

        <label>Published Date:</label>
        <input type="date" name="published_at" value="{{ $blogPost->published_at->format('Y-m-d') }}" required>

        <label>Blog Title:</label>
        <select name="blog_id" required>
            @foreach($blogTitles as $blog)
                <option value="{{ $blog->id }}" {{ $blogPost->blog_id == $blog->id ? 'selected' : '' }}>
                    {{ $blog->title }}
                </option>
            @endforeach
        </select>

        <label>Content:</label>
        <textarea name="content" required>{{ $blogPost->content }}</textarea>

        <label>Author Name:</label>
        <input type="text" name="author_name" value="{{ $blogPost->author_name }}" required>

        <label>Comment Count:</label>
        <input type="number" name="comment_count" value="{{ $blogPost->comment_count }}">

        <label>Image:</label>
        <input type="file" name="image">
        @if($blogPost->image)
            <img src="{{ asset('storage/' . $blogPost->image) }}" width="100">
        @endif

        <label>Author Avatar:</label>
        <input type="file" name="author_avatar">
        @if($blogPost->author_avatar)
            <img src="{{ asset('storage/' . $blogPost->author_avatar) }}" width="50">
        @endif

        <button type="submit">Update</button>
    </form>
</div>
</div>
@endsection
