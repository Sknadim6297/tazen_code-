@extends('layouts.layout')

@php
use App\Helpers\ImageHelper;
@endphp

@section('meta')
<!-- Blog-specific Meta Tags -->
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($blogPost->content), 150) }}">
<meta name="keywords" content="{{ $blogPost->category }}, {{ $relatedBlog->title }}, blog, Tazen">

<!-- Open Graph Meta Tags for Social Media -->
<meta property="og:title" content="{{ $relatedBlog->title }}">
<meta property="og:site_name" content="Tazen.in">
<meta property="og:url" content="{{ route('blog.show', \Illuminate\Support\Str::slug($relatedBlog->title)) }}">
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($blogPost->content), 150) }}">
<meta property="og:type" content="article">
<meta property="og:image" content="{{ ImageHelper::getStorageImageUrl($blogPost->image, 'img/lazy-placeholder.png') }}">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $relatedBlog->title }}">
<meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($blogPost->content), 150) }}">
<meta name="twitter:image" content="{{ ImageHelper::getStorageImageUrl($blogPost->image, 'img/lazy-placeholder.png') }}">

<title>{{ $relatedBlog->title }} | Tazen.in Blog</title>
@endsection

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
    
    /* Social Media Share Buttons */
    .social-share-section {
        margin: 30px 0;
        padding: 20px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }
    
    .social-share-section h5 {
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }
    
    .social-share-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 16px;
    }
    
    .share-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        text-decoration: none;
        color: white;
    }
    
    .share-btn.facebook {
        background-color: #3b5998;
    }
    
    .share-btn.facebook:hover {
        background-color: #2d4373;
        color: white;
    }
    
    .share-btn.twitter {
        background-color: #1da1f2;
    }
    
    .share-btn.twitter:hover {
        background-color: #0d8bd9;
        color: white;
    }
    
    .share-btn.linkedin {
        background-color: #0077b5;
    }
    
    .share-btn.linkedin:hover {
        background-color: #005582;
        color: white;
    }
    
    .share-btn.whatsapp {
        background-color: #25d366;
    }
    
    .share-btn.whatsapp:hover {
        background-color: #1aab4b;
        color: white;
    }
    
    .share-btn.email {
        background-color: #ea4335;
    }
    
    .share-btn.email:hover {
        background-color: #d23321;
        color: white;
    }
    
    .share-btn.copy {
        background-color: #6c757d;
    }
    
    .share-btn.copy:hover {
        background-color: #545b62;
        color: white;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .social-share-section {
            margin: 20px 0;
            padding: 15px 0;
        }
        
        .social-share-buttons {
            justify-content: center;
        }
        
        .share-btn {
            width: 35px;
            height: 35px;
            font-size: 14px;
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
                                <a href="{{ route('blog.show', $latestBlog->id) }}">
                                    <img src="{{ ImageHelper::getStorageImageUrl($latestBlog->image, 'img/lazy-placeholder.png') }}" alt="{{ $latestBlog->blog->title }}">
                                </a>
                            </div>
                            <small>Category - {{ $latestBlog->category }} - {{ $latestBlog->created_at->format('d M Y') }}</small>
                            <p><a href="{{ route('blog.show', $latestBlog->id) }}"><b>{{ $latestBlog->blog->title }}</b></a></p>
                            <h3><a href="{{ route('blog.show', $latestBlog->id) }}" title="{{ $latestBlog->blog->title }}">{{ \Illuminate\Support\Str::limit($latestBlog->blog->title, 50) }}</a></h3>
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
                    <figure><img alt="{{ $relatedBlog->title }}" class="img-fluid" src="{{ ImageHelper::getStorageImageUrl($blogPost->image, 'img/lazy-placeholder.png') }}"></figure>
                    <h1>{{ $relatedBlog->title }}</h1>
                    <div class="postmeta">
                        <ul>
                            <li><a href="#"><i class="icon_folder-alt"></i> {{ $blogPost->category }}</a></li>
                            <li><i class="icon_calendar"></i> {{ $blogPost->published_at }}</li>
                            <li><a href="#"><i class="icon_pencil-edit"></i> {{ $blogPost->author_name }}</a></li>
                            {{-- <li><a href="#"><i class="icon_comment_alt"></i> ({{ $blogPost->comment_count ?? 0 }}) Comments</a></li> --}}
                        </ul>
                    </div>
                    
                    <!-- Social Media Share Section -->
                    <div class="social-share-section">
                        <h5>Share this post:</h5>
                        <div class="social-share-buttons">
                            @php
                                $blogUrl = route('blog.show', \Illuminate\Support\Str::slug($relatedBlog->title));
                                $blogTitle = $relatedBlog->title;
                                $shareText = $blogTitle . ' - ' . $blogUrl;
                            @endphp
                            
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($blogUrl) }}" 
                               target="_blank" class="share-btn facebook" title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($blogUrl) }}&text={{ urlencode($blogTitle) }}" 
                               target="_blank" class="share-btn twitter" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($blogUrl) }}" 
                               target="_blank" class="share-btn linkedin" title="Share on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($shareText) }}" 
                               target="_blank" class="share-btn whatsapp" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($blogTitle) }}&body={{ urlencode('Check out this blog post: ' . $blogUrl) }}" 
                               class="share-btn email" title="Share via Email">
                                <i class="fas fa-envelope"></i>
                            </a>
                            
                        </div>
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
                                <a href="#"><img src="{{ asset('img/default-avatar.jpg') }}" alt="{{ $comment->name }}">
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

@section('scripts')
<script>
    // Copy to clipboard function
    function copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                showCopyMessage('Link copied to clipboard!');
            }, function(err) {
                // Fallback method
                fallbackCopyTextToClipboard(text);
            });
        } else {
            // Fallback method for older browsers
            fallbackCopyTextToClipboard(text);
        }
    }
    
    // Fallback copy method for older browsers
    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            var successful = document.execCommand('copy');
            if (successful) {
                showCopyMessage('Link copied to clipboard!');
            } else {
                showCopyMessage('Failed to copy link');
            }
        } catch (err) {
            showCopyMessage('Failed to copy link');
        }
        
        document.body.removeChild(textArea);
    }
    
    // Show copy message
    function showCopyMessage(message) {
        // Create or update message element
        var messageEl = document.getElementById('copy-message');
        if (!messageEl) {
            messageEl = document.createElement('div');
            messageEl.id = 'copy-message';
            messageEl.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 10px 20px;
                border-radius: 5px;
                z-index: 9999;
                font-size: 14px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                transform: translateX(100%);
                transition: transform 0.3s ease;
            `;
            document.body.appendChild(messageEl);
        }
        
        messageEl.textContent = message;
        messageEl.style.backgroundColor = message.includes('Failed') ? '#dc3545' : '#28a745';
        
        // Show message
        setTimeout(() => {
            messageEl.style.transform = 'translateX(0)';
        }, 100);
        
        // Hide message after 3 seconds
        setTimeout(() => {
            messageEl.style.transform = 'translateX(100%)';
        }, 3000);
    }
    
    // Handle image loading errors with fallbacks
    document.addEventListener('DOMContentLoaded', function() {
        // Handle blog images
        const blogImages = document.querySelectorAll('.singlepost img, .alignleft img, .thumb img, .avatar img');
        
        blogImages.forEach(img => {
            img.addEventListener('error', function() {
                if (this.src.includes('storage/') || this.src.includes('frontend/assets/img/')) {
                    // If it's a storage image that failed, use fallback
                    if (this.closest('.alignleft') || this.closest('.thumb') || this.closest('.avatar')) {
                        // Avatar fallback
                        this.src = '{{ asset("img/default-avatar.jpg") }}';
                    } else {
                        // Blog image fallback
                        this.src = '{{ asset("img/lazy-placeholder.png") }}';
                    }
                    this.style.opacity = '0.7';
                }
            });
            
            img.addEventListener('load', function() {
                this.classList.add('loaded');
                this.style.opacity = '1';
            });
        });
    });
</script>
@endsection