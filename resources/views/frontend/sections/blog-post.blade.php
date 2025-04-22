@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
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
                <div class="singlepost">
                    <figure><img alt="" class="img-fluid" src="img/blog-single.jpg"></figure>
                    <h1>Lawyer consulting</h1>
                    <div class="postmeta">
                        <ul>
                            <li><a href="#"><i class="icon_folder-alt"></i> Category</a></li>
                            <li><i class="icon_calendar"></i> 23/12/2015</li>
                            <li><a href="#"><i class="icon_pencil-edit"></i> Admin</a></li>
                            <li><a href="#"><i class="icon_comment_alt"></i> (14) Comments</a></li>
                        </ul>
                    </div>
                    <!-- /post meta -->
                    <div class="post-content">
                        <div class="dropcaps">
                            <p>Aorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>

                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                    </div>
                    <!-- /post -->
                </div>
                <!-- /single-post -->

                <div id="comments">
                    <h5>Comments</h5>
                    <ul>
                        <li>
                            <div class="avatar">
                                <a href="#"><img src="img/avatar1.jpg" alt="">
                                </a>
                            </div>
                            <div class="comment_right clearfix">
                                <div class="comment_info">
                                    By <a href="#">Anna Smith</a><span>|</span>25/10/2019<span>|</span><a href="#">Reply</a>
                                </div>
                                <p>
                                    Nam cursus tellus quis magna porta adipiscing. Donec et eros leo, non pellentesque arcu. Curabitur vitae mi enim, at vestibulum magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sit amet sem a urna rutrumeger fringilla. Nam vel enim ipsum, et congue ante.
                                </p>
                            </div>
                            <ul class="replied-to">
                                <li>
                                    <div class="avatar">
                                        <a href="#"><img src="img/avatar4.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="comment_right clearfix">
                                        <div class="comment_info">
                                            By <a href="#">Anna Smith</a><span>|</span>25/10/2019<span>|</span><a href="#">Reply</a>
                                        </div>
                                        <p>
                                            Nam cursus tellus quis magna porta adipiscing. Donec et eros leo, non pellentesque arcu. Curabitur vitae mi enim, at vestibulum magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sit amet sem a urna rutrumeger fringilla. Nam vel enim ipsum, et congue ante.
                                        </p>
                                        <p>
                                            Aenean iaculis sodales dui, non hendrerit lorem rhoncus ut. Pellentesque ullamcorper venenatis elit idaipiscingi Duis tellus neque, tincidunt eget pulvinar sit amet, rutrum nec urna. Suspendisse pretium laoreet elit vel ultricies. Maecenas ullamcorper ultricies rhoncus. Aliquam erat volutpat.
                                        </p>
                                    </div>
                                    <ul class="replied-to">
                                        <li>
                                            <div class="avatar">
                                                <a href="#"><img src="img/avatar6.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="comment_right clearfix">
                                                <div class="comment_info">
                                                    By <a href="#">Anna Smith</a><span>|</span>25/10/2019<span>|</span><a href="#">Reply</a>
                                                </div>
                                                <p>
                                                    Nam cursus tellus quis magna porta adipiscing. Donec et eros leo, non pellentesque arcu. Curabitur vitae mi enim, at vestibulum magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sit amet sem a urna rutrumeger fringilla. Nam vel enim ipsum, et congue ante.
                                                </p>
                                                <p>
                                                    Aenean iaculis sodales dui, non hendrerit lorem rhoncus ut. Pellentesque ullamcorper venenatis elit idaipiscingi Duis tellus neque, tincidunt eget pulvinar sit amet, rutrum nec urna. Suspendisse pretium laoreet elit vel ultricies. Maecenas ullamcorper ultricies rhoncus. Aliquam erat volutpat.
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="avatar">
                                <a href="#"><img src="img/avatar1.jpg" alt="">
                                </a>
                            </div>

                            <div class="comment_right clearfix">
                                <div class="comment_info">
                                    By <a href="#">Anna Smith</a><span>|</span>25/10/2019<span>|</span><a href="#">Reply</a>
                                </div>
                                <p>
                                    Cursus tellus quis magna porta adipiscin
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>

                <hr>

                <h5>Leave a comment</h5>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name2" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="email" id="email2" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <input type="text" name="email" id="website3" class="form-control" placeholder="Website">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="comments" id="comments2" rows="6" placeholder="Comment"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" id="submit2" class="btn_1 add_bottom_15">Submit</button>
                </div>

            </div>
            <!-- /col -->

            
        </div>
        <!-- /row -->	
    </div>
    <!-- /container -->
    
</main>

@endsection