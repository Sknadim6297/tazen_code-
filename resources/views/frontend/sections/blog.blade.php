@extends('layouts.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/blog.css') }}">

@endsection
@section('content')
<main class="bg_color">
    @foreach($blogbanners as $banner)
    <!-- blog header  -->
    <div class="hero_single blog-head" style="background-image: url('{{ asset('storage/' . $banner->banner_image) }}');">
        <!-- Content inside the div, if needed -->    
     <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
         <div class="container">
             <div class="row">
                 <div class="col-xl-12 col-lg-12">
                     <h1>{{ $banner->heading }}</h1>
                     <p>{{ $banner->subheading }}</p>
                     
                 </div>
             </div>
             <!-- /row -->
         </div>
     </div>
 </div>
 @endforeach
     <!-- blog header section end  -->
     <div class="container margin_45_40">			
         <div class="row">
             <div class="col-lg-12 pb-5">
                 <div class="widget search_blog">
                    <form action="{{ route('blog.index') }}" method="GET">
                        <div class="form-group">
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search Blogs or Categories..." value="{{ request('search') }}">
                            <span><input type="submit" value="Search"></span>
                        </div>
                    </form>
                 </div>
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
                            <h3><a href="{{ route('blog.show', \Illuminate\Support\Str::slug($latestBlog->blog->title)) }}" title="{{ $latestBlog->blog->title }}">{{ \Illuminate\Support\Str::limit($latestBlog->blog->title, 50) }}</a></h3>
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
                <div class="row">
                    @foreach($blogPosts as $blogPost)
                        <div class="col-md-4">
                            <article class="blog" style="max-width: 100%; margin-bottom: 20px;">
                                <figure style="height: 200px; overflow: hidden;">
                                    <a href="{{ route('blog.show', \Illuminate\Support\Str::slug($blogPost->blog->title)) }}">
                                        <img src="{{ asset('storage/' . $blogPost->image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                        <div class="preview"><span>Read more</span></div>
                                    </a>
                                </figure>
                                <div class="post_info" style="padding: 15px;">
                                    <small>{{ $blogPost->category }} - {{ $blogPost->created_at->format('d M Y') }}</small>
                                    <h2 style="font-size: 1.2rem; margin: 10px 0;"><a href="{{ route('blog.show', \Illuminate\Support\Str::slug($blogPost->blog->title)) }}">{{ $blogPost->blog->title }}</a></h2>
                                    <p style="font-size: 0.9rem;">{{ \Illuminate\Support\Str::limit($blogPost->content, 100) }}</p>
                                    <ul style="margin-top: 10px;">
                                        <li>
                                            <div class="thumb" style="width: 30px; height: 30px;">
                                                <img src="{{ asset('storage/' . $blogPost->author_avatar) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <a href="#" style="font-size: 0.9rem;">{{ $blogPost->author_name }}</a> 
                                        </li>
                                        <li>
                                            <a href="#" style="font-size: 0.9rem;"><i class="icon_comment_alt"></i> {{ $blogPost->comment_count}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </article>
                            <!-- /article -->
                        </div>
                    @endforeach
                </div>
            
                <!-- Pagination (if needed) -->
                {{-- <div class="pagination_fg">
                    {{ $blogPosts->links() }}
                </div> --}}
            </div>
            
         <!-- /row -->	
     </div>
     <!-- /container -->
     
 </main>

@endsection