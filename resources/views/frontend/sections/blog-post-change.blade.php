@extends('layouts.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/blog.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
<style>
    /* Rich text content styling */
    .post-content {
        line-height: 1.8;
        color: #333;
        font-size: 16px;
    }
    
    .post-content h1,
    .post-content h2,
    .post-content h3,
    .post-content h4,
    .post-content h5,
    .post-content h6 {
        margin: 1.5rem 0 1rem 0;
        color: #152a70;
        font-weight: 600;
        line-height: 1.3;
    }
    
    .post-content h1 { font-size: 2.2rem; }
    .post-content h2 { font-size: 1.8rem; }
    .post-content h3 { font-size: 1.5rem; }
    .post-content h4 { font-size: 1.3rem; }
    .post-content h5 { font-size: 1.1rem; }
    .post-content h6 { font-size: 1rem; }
    
    .post-content p {
        margin-bottom: 1.2rem;
        line-height: 1.8;
    }
    
    .post-content ul,
    .post-content ol {
        margin: 1rem 0 1rem 2rem;
        padding-left: 1rem;
    }
    
    .post-content li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    .post-content blockquote {
        border-left: 4px solid #c51010;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        background-color: #f8f9fa;
        font-style: italic;
        border-radius: 0 8px 8px 0;
    }
    
    .post-content blockquote p {
        margin: 0;
        color: #555;
    }
    
    .post-content a {
        color: #c51010;
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: all 0.3s ease;
    }
    
    .post-content a:hover {
        color: #152a70;
        border-bottom-color: #152a70;
    }
    
    .post-content strong,
    .post-content b {
        font-weight: 600;
        color: #152a70;
    }
    
    .post-content em,
    .post-content i {
        font-style: italic;
        color: #555;
    }
    
    .post-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .post-content table th,
    .post-content table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }
    
    .post-content table th {
        background-color: #152a70;
        color: white;
        font-weight: 600;
    }
    
    .post-content table tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .post-content table tr:hover {
        background-color: #e9ecef;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .post-content {
            font-size: 15px;
        }
        
        .post-content h1 { font-size: 1.8rem; }
        .post-content h2 { font-size: 1.5rem; }
        .post-content h3 { font-size: 1.3rem; }
        .post-content h4 { font-size: 1.2rem; }
        .post-content h5 { font-size: 1.1rem; }
        .post-content h6 { font-size: 1rem; }
        
        .post-content table {
            font-size: 14px;
        }
        
        .post-content table th,
        .post-content table td {
            padding: 8px 10px;
        }
    }
</style>
@endsection
@section('content')

<main class="bg_color">

    <!-- blog hero section  -->
    <div class="hero_single blog-head">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <h1>Blogs That Help You Find Information and Interest</h1>
                        <p>Our Recent Blogs Posts</p>
                        
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
    </div>
     <!-- blog hero section end  -->

    <div class="container margin_45_40">			
        <div class="row">
            <div class="col-lg-12 pb-5">
                {{-- <div class="widget search_blog">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search Blogs...">
                        <span><input type="submit" value="Search"></span>
                    </div>
                </div> --}}
            </div>
            <aside class="col-lg-3">
                
                <!-- /widget -->
                <div class="widget">
                    <div class="widget-title first">
                        <h4>Latest Post</h4>
                    </div>
                    <ul class="comments-list">
                        @foreach($latestBlogs as $latestBlog)
                        <li>
                            <div class="alignleft">
                                <a href="{{ route('blog.show', \Illuminate\Support\Str::slug($latestBlog->blog->title)) }}">
                                    <img src="{{ asset('storage/' . $latestBlog->image) }}" alt="{{ $latestBlog->blog_id }}">
                                </a>
                            </div>
                            <small>Category - {{ $latestBlog->category }} - {{ $latestBlog->created_at->format('d M Y') }}</small>
                            <p><b>{{ $latestBlog->blog->title }}</b></p>
                            <h3><a href="{{ route('blog.show', \Illuminate\Support\Str::slug($latestBlog->blog->title)) }}" title="{{ $latestBlog->title }}">{{ \Illuminate\Support\Str::limit($latestBlog->title, 50) }}</a></h3>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                 <!-- /widget -->
                 <div class="widget">
                    <div class="widget-title">
                        <h4>Categories</h4>
                    </div>
                    <ul class="cats">
                        @foreach($categoryCounts as $category)
                            <li>
                                <a href="{{ route('blog.index', ['category' => $category->category]) }}">{{ $category->category }} <span>({{ $category->post_count }})</span></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /widget -->
                <div class="widget">
                    <div class="widget-title">
                        <h4>Popular Tags</h4>
                    </div>
                    <div class="tags">
                        @foreach($categoryCounts as $category)
                            <a href="{{ route('blog.index', ['category' => $category->category]) }}">{{ $category->category }}</a>
                        @endforeach
                    </div>
                </div>
                
                <!-- /widget -->
            </aside>
            <!-- /aside -->


            <div class="col-lg-9">
                <div class="singlepost">
                    <figure><img alt="" class="img-fluid" src="{{ asset('storage/' . $blogPost->image) }}"></figure>
                    <h1>{{ $relatedBlog->title }}</h1>
                    <div class="postmeta">
                        <ul>
                            <li><a href="#"><i class="icon_folder-alt"></i> {{ $blogPost->category }}</a></li>
                            <li><i class="icon_calendar"></i> {{ $blogPost->published_at }}</li>
                            <li><a href="#"><i class="icon_pencil-edit"></i> {{ $blogPost->author_name }}</a></li>
                            {{-- <li><a href="#"><i class="icon_comment_alt"></i> ({{ $blogPost->comment_count ?? 0 }}) Comments</a></li> --}}
                        </ul>
                    </div>
                    <div class="post-content">
                        {!! $blogPost->content !!}
                    </div>
                </div>
                
                
                <!-- /single-post -->

                <div id="comments">
                    <h5>Comments</h5>
                    <ul>
                        @foreach($comments as $comment)
                        <li>
                            <div class="avatar">
                                <a href="#"><img src="{{ asset('frontend/assets/img/avatar1.jpg') }}" alt="">
                                </a>
                            </div>
                            <div class="comment_right clearfix">
                                <div class="comment_info">
                                    By <a href="#">{{ $comment->name }}</a><span>|</span>{{ $comment->created_at->format('d/m/Y') }}<span>|</span>
                                    {{-- @if($comment->website)
                                        <a href="{{ $comment->website }}" target="_blank">Website</a>
                                    @endif --}}
                                </div>
                                <p>{{ $comment->comment }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <hr>

                <h5>Leave a comment</h5>
                <form action="{{ route('blog.comment.store', $blogPost->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <input type="text" name="name" id="name2" class="form-control" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <input type="email" name="email" id="email2" class="form-control" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="tel" name="mobile" id="mobile2" class="form-control" placeholder="Mobile Number" pattern="[0-9]{10,15}" maxlength="15" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="comment" id="comments2" rows="6" placeholder="Comment" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submit2" class="btn_1 add_bottom_15" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12);">Submit</button>
                    </div>
                </form>

            </div>
            <!-- /col -->

            
        </div>
        <!-- /row -->	
    </div>
    <!-- /container -->
    
</main>

@endsection