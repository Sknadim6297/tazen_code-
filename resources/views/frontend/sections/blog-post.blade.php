@extends('layouts.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/blog.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
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
                                <a href="{{ route('blog.show', $latestBlog->id) }}">
                                    <img src="{{ asset('storage/' . $latestBlog->image) }}" alt="{{ $latestBlog->blog_id }}">
                                </a>
                            </div>
                            <small>Category - {{ $latestBlog->category }} - {{ $latestBlog->created_at->format('d M Y') }}</small>
                            <p><b>{{ $latestBlog->blog->title }}</b></p>
                            <h3><a href="{{ route('blog.show', $latestBlog->id) }}" title="{{ $latestBlog->title }}">{{ \Illuminate\Support\Str::limit($latestBlog->title, 50) }}</a></h3>
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
                            <li><a href="#"><i class="icon_comment_alt"></i> ({{ $blogPost->comment_count ?? 0 }}) Comments</a></li>
                        </ul>
                    </div>
                    <div class="post-content">
                        <p>{{ $blogPost->content }}</p>
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
                                    @if($comment->website)
                                        <a href="{{ $comment->website }}" target="_blank">Website</a>
                                    @endif
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
                                <input type="url" name="website" id="website3" class="form-control" placeholder="Website">
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