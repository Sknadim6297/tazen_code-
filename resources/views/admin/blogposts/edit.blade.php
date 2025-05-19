@extends('admin.layouts.layout')

@section('style')

@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <h2>Edit Blog Post</h2>

        <form action="{{ route('admin.blogposts.update', $blogPost->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>Category:</label>
                    <input type="text" name="category" value="{{ $blogPost->category }}" required>
                </div>

                <div class="form-group">
                    <label>Published Date:</label>
                    <input type="date" name="published_at" value="{{ $blogPost->published_at->format('Y-m-d') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Blog Title:</label>
                <select name="blog_id" required>
                    @foreach($blogTitles as $blog)
                        <option value="{{ $blog->id }}" {{ $blogPost->blog_id == $blog->id ? 'selected' : '' }}>
                            {{ $blog->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Content:</label>
                <textarea name="content" required>{{ $blogPost->content }}</textarea>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Author Name:</label>
                    <input type="text" name="author_name" value="{{ $blogPost->author_name }}" required>
                </div>

                <div class="form-group">
                    <label>Comment Count:</label>
                    <input type="number" name="comment_count" value="{{ $blogPost->comment_count }}">
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image">
                    @if($blogPost->image)
                        <div class="image-preview">
                            <img src="{{ asset('storage/' . $blogPost->image) }}" width="100">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Author Avatar:</label>
                    <input type="file" name="author_avatar">
                    @if($blogPost->author_avatar)
                        <div class="image-preview">
                            <img src="{{ asset('storage/' . $blogPost->author_avatar) }}" width="50">
                        </div>
                    @endif
                </div>
            </div>

            <button type="submit">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</div>
<style>
    :root {
        --primary-color: #4361ee;
        --primary-hover: #3a56d4;
        --secondary-color: #3f37c9;
        --text-color: #2b2d42;
        --light-text: #8d99ae;
        --border-color: #edf2f4;
        --bg-color: #f8f9fa;
        --card-bg: #ffffff;
        --success-color: #4cc9f0;
        --warning-color: #f8961e;
        --danger-color: #ef233c;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        --border-radius: 8px;
        --input-focus: 0 0 0 3px rgba(67, 97, 238, 0.2);
    }

    .main-content {
        padding: 2rem;
        background-color: var(--bg-color);
        min-height: calc(100vh - 60px);
    }

    .container-fluid {
        max-width: 1200px;
        margin: 0 auto;
    }

    h2 {
        color: var(--text-color);
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
        position: relative;
        padding-bottom: 0.5rem;
    }

    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    form {
        background: var(--card-bg);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    form:hover {
        box-shadow: var(--shadow-lg);
    }

    label {
        display: block;
        margin: 1rem 0 0.5rem;
        font-weight: 500;
        color: var(--text-color);
        font-size: 0.95rem;
    }

    input[type="text"],
    input[type="date"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        font-size: 0.95rem;
        transition: var(--transition);
        background-color: var(--card-bg);
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: var(--input-focus);
    }

    textarea {
        min-height: 200px;
        resize: vertical;
    }

    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%238d99ae' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    .image-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1rem 0;
    }

    .image-preview img {
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 2px solid var(--border-color);
    }

    .image-preview img:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    button[type="submit"] {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 1.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
    }

    button[type="submit"]:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(67, 97, 238, 0.3);
    }

    button[type="submit"]:active {
        transform: translateY(0);
    }

    /* Form grid layout */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main-content {
            padding: 1.5rem;
        }
        
        form {
            padding: 1.5rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    @media (max-width: 576px) {
        .main-content {
            padding: 1rem;
        }
        
        form {
            padding: 1.25rem;
        }
        
        h2 {
            font-size: 1.5rem;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        :root {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #e0e0e0;
            --light-text: #9e9e9e;
            --border-color: #2d2d2d;
        }
        
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            background-color: #2a2a2a;
        }
        
        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%239e9e9e' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        }
    }
</style>
@endsection