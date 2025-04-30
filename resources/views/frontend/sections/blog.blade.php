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
                     <div class="form-group">
                         <input type="text" name="search" id="search" class="form-control" placeholder="Search Blogs...">
                         <span><input type="submit" value="Search"></span>
                     </div>
                 </div>
             </div>
             <aside class="col-lg-3">
                 
                 <!-- /widget -->
                 <div class="widget">
                     <div class="widget-title first">
                         <h4>Latest Post</h4>
                     </div>
                     <ul class="comments-list">
                         <li>
                             <div class="alignleft">
                                 <a href="#0"><img src="img/blog-5.jpg" alt=""></a>
                             </div>
                             <small>Category - 11.08.2016</small>
                             <h3><a href="#" title="">Verear qualisque ex minimum...</a></h3>
                         </li>
                         <li>
                             <div class="alignleft">
                                 <a href="#0"><img src="img/blog-6.jpg" alt=""></a>
                             </div>
                             <small>Category - 11.08.2016</small>
                             <h3><a href="#" title="">Verear qualisque ex minimum...</a></h3>
                         </li>
                         <li>
                             <div class="alignleft">
                                 <a href="#0"><img src="img/blog-4.jpg" alt=""></a>
                             </div>
                             <small>Category - 11.08.2016</small>
                             <h3><a href="#" title="">Verear qualisque ex minimum...</a></h3>
                         </li>
                     </ul>
                 </div>
                 <!-- /widget -->
                 <div class="widget">
                     <div class="widget-title">
                         <h4>Categories</h4>
                     </div>
                     <ul class="cats">
                         <li><a href="#">Dermatology <span>(12)</span></a></li>
                         <li><a href="#">Consulting <span>(21)</span></a></li>
                         <li><a href="#">Treatments <span>(44)</span></a></li>
                         <li><a href="#">Personal care <span>(31)</span></a></li>
                     </ul>
                 </div>
                 <!-- /widget -->
                 <div class="widget">
                     <div class="widget-title">
                         <h4>Popular Tags</h4>
                     </div>
                     <div class="tags">
                         <a href="#">Lawyer</a>
                         <a href="#">Accounting</a>
                         <a href="#">Consulting</a>
                         <a href="#">Doctors</a>
                         <a href="#">Best Offers</a>
                         <a href="#">Languages</a>
                         <a href="#">Teach</a>
                     </div>
                 </div>
                 <!-- /widget -->
             </aside>
             <!-- /aside -->


             <div class="col-lg-9">
                <div class="row">
                    @foreach($blogPosts as $blogPost)
                        <div class="col-md-6">
                            <article class="blog">
                                <figure>
                                    <a href="{{ route('blog.show', $blogPost->id) }}">
                                        <img src="{{ asset('storage/' . $blogPost->image) }}" alt="">
                                        <div class="preview"><span>Read more</span></div>
                                    </a>
                                </figure>
                                <div class="post_info">
                                    <small>{{ $blogPost->category }} - {{ $blogPost->created_at->format('d M Y') }}</small>
                                    <h2><a href="{{ route('blog.show', $blogPost->id) }}">{{ $blogPost->title }}</a></h2>
                                    <p>{{ \Illuminate\Support\Str::limit($blogPost->content, 150) }}</p>
                                    <ul>
                                        <li>
                                            <div class="thumb">
                                                <img src="{{ asset('storage/' . $blogPost->author_avatar) }}" alt="">
                                            </div>
                                            <a href="#">{{ $blogPost->author_name }}</a> 
                                        </li>
                                        <li>
                                            <a href="#"><i class="icon_comment_alt"></i> {{ $blogPost->comment_count}}</a>
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