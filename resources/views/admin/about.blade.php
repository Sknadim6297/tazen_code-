<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServicePro Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/adminabout.css') }}"> 
</head>
<body>
    
   <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('frontend/assets/img/tazen_logo-01-removebg-preview.png') }}" alt="Logo" class="sidebar-logo" height="100">
                <i class="fas fa-times close-sidebar"></i>
            </div> 

            <div class="sidebar-menu">
                <div class="menu-title">Main</div>
                <a href="index.html" class="menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <div class="menu-title">Pages</div>
                <div class="menu-dropdown">
                    <div class="menu-item active">
                        <div>
                            <i class="fas fa-file-alt"></i>
                            <span>All Pages</span>
                        </div>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="submenu">
                        <a href="#" class="menu-item ">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>
                        <a href="#" class="menu-item active">
                            <i class="fas fa-info-circle"></i>
                            <span>About Us</span>
                        </a>
                        <a href="#" class="menu-item">
                            <i class="fas fa-concierge-bell"></i>
                            <span>Services</span>
                        </a>
                        <a href="#" class="menu-item">
                            <i class="fas fa-user-plus"></i>
                            <span>Add User</span>
                        </a>
                        <a href="#" class="menu-item">
                            <i class="fas fa-blog"></i>
                            <span>Blog</span>
                        </a>
                        <a href="#" class="menu-item">
                            <i class="fas fa-newspaper"></i>
                            <span>Blog Details</span>
                        </a>
                        <a href="#" class="menu-item">
                            <i class="fas fa-briefcase"></i>
                            <span>Career</span>
                        </a>
                        <a href="#" class="menu-item">
                            <i class="fas fa-address-book"></i>
                            <span>Contact Us</span>
                        </a>
                        <a href="#" class="menu-item">
                            <i class="fas fa-calendar"></i>
                            <span>Event Page</span>
                        </a>
                    </div>
                </div>

                <div class="menu-title">Manage</div>
                <a href="professional.html" class="menu-item">
                    <i class="fas fa-user-tie"></i>
                    <span>Professional</span>
                </a>
                <a href="customer.html" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>Customer</span>
                </a>
                
                <div class="menu-title">Booking</div>
                <a href="one-time.html" class="menu-item">
                    <i class="fas fa-calendar-day"></i>
                    <span>One Time</span>
                </a>
                <a href="monthly.html" class="menu-item">
                    <i class="fas fa-calendar-week"></i>
                    <span>Monthly</span>
                </a>
                <a href="quaterly.html" class="menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Quarterly</span>
                </a>
                <a href="free-hand.html" class="menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Free Hand</span>
                </a>

                <div class="menu-title">Billing</div>
                <a href="customer-bill.html" class="menu-item">
                    <i class="fas fa-receipt"></i>
                    <span>Customer Billing</span>
                </a>
                <a href="professional-bill.html" class="menu-item">
                    <i class="fas fa-file-invoice"></i>
                    <span>Professional Billing</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <div class="toggle-sidebar">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                </div>

                <div class="header-right">
                    <div class="header-icon">
                        <i class="far fa-envelope"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="header-icon">
                        <i class="far fa-bell"></i>
                        <span class="badge">5</span>
                    </div>
                    <div class="user-profile">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User">
                        <div class="user-info">
                            <h5>Sarah Smith</h5>
                            <p>Admin</p>
                        </div>
                    </div>
                </div>
            </div>

           
           <!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>About Page Content Management</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">About Page</li>
        </ul>
    </div>

    <!-- About Page Form -->
    <div class="table-container">
        <form id="aboutPageForm" method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hero Section -->
            <div class="form-section">
                <h4 class="section-title">Hero Section</h4>
                <div class="form-group">
                    <label>Hero Title</label>
                    <input type="text" class="form-control" name="hero_title" value="{{ $about->hero_title ?? 'About Tazen' }}">
                </div>
                <div class="form-group">
                    <label>Hero Subtitle</label>
                    <input type="text" class="form-control" name="hero_subtitle" value="{{ $about->hero_subtitle ?? 'Know More About Our Company' }}">
                </div>
                <div class="form-group">
                    <label>Hero Background Image</label>
                    <input type="file" class="form-control" name="hero_image">
                    @if(isset($about->hero_image))
                        <img src="{{ asset($about->hero_image) }}" width="100" class="mt-2">
                        <a href="#" class="remove-image" data-field="hero_image">Remove Image</a>
                    @endif
                </div>
            </div>

            <!-- Why Choose Us Section -->
            <div class="form-section">
                <h4 class="section-title">Why Choose Us Section</h4>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" class="form-control" name="why_choose_title" value="{{ $about->why_choose_title ?? 'Why Choose Us' }}">
                </div>
                <div class="form-group">
                    <label>Section Description</label>
                    <textarea class="form-control" name="why_choose_description">{{ $about->why_choose_description ?? 'Cum doctus civibus efficiantur in imperdiet deterruisset.' }}</textarea>
                </div>

                <!-- Cards -->
                <div class="row">
                    @for($i = 1; $i <= 6; $i++)
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">Card {{ $i }}</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="card{{$i}}_title" value="{{ $about->{'card'.$i.'_title'} ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="card{{$i}}_description">{{ $about->{'card'.$i.'_description'} ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Icon Class (Font Awesome)</label>
                                    <input type="text" class="form-control" name="card{{$i}}_icon" value="{{ $about->{'card'.$i.'_icon'} ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Small Text</label>
                                    <input type="text" class="form-control" name="card{{$i}}_small_text" value="{{ $about->{'card'.$i.'_small_text'} ?? 'Lorem, ipsum.' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- About Content Section -->
            <div class="form-section">
                <h4 class="section-title">About Content Section</h4>
                <div class="form-group">
                    <label>Section Small Title</label>
                    <input type="text" class="form-control" name="about_small_title" value="{{ $about->about_small_title ?? '--- About Us ---' }}">
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" class="form-control" name="about_section_title" value="{{ $about->about_section_title ?? 'Explore Our Services And Boost Your Online Presence' }}">
                </div>
                <div class="form-group">
                    <label>Section Description</label>
                    <textarea class="form-control" name="about_section_description">{{ $about->about_section_description ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Years of Experience</label>
                    <input type="number" class="form-control" name="years_experience" value="{{ $about->years_experience ?? 12 }}">
                </div>
                <div class="form-group">
                    <label>About Image</label>
                    <input type="file" class="form-control" name="about_image">
                    @if(isset($about->about_image))
                        <img src="{{ asset($about->about_image) }}" width="100" class="mt-2">
                        <a href="#" class="remove-image" data-field="about_image">Remove Image</a>
                    @endif
                </div>
                
                <!-- Bullet Points -->
                <div class="form-group">
                    <label>Bullet Point 1</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-check"></i></span>
                        <input type="text" class="form-control" name="bullet1" value="{{ $about->bullet1 ?? '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Bullet Point 2</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-check"></i></span>
                        <input type="text" class="form-control" name="bullet2" value="{{ $about->bullet2 ?? '' }}">
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Button Text</label>
                            <input type="text" class="form-control" name="button1_text" value="{{ $about->button1_text ?? 'Get Started' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Second Button Text</label>
                            <input type="text" class="form-control" name="button2_text" value="{{ $about->button2_text ?? 'Discover More' }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Experience Section -->
            <div class="form-section">
                <h4 class="section-title">Experience Section</h4>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" class="form-control" name="experience_title" value="{{ $about->experience_title ?? 'Experience Make Tazen Different' }}">
                </div>
                <div class="form-group">
                    <label>Section Description</label>
                    <input type="text" class="form-control" name="experience_description" value="{{ $about->experience_description ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit.' }}">
                </div>
                <div class="form-group">
                    <label>Main Heading</label>
                    <input type="text" class="form-control" name="experience_heading" value="{{ $about->experience_heading ?? 'Grow Your Online Presence.' }}">
                </div>
                <div class="form-group">
                    <label>Main Description</label>
                    <textarea class="form-control" name="experience_main_description">{{ $about->experience_main_description ?? 'Hundreds of thousands of small businesses have found new customers on Tazen' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Button Text</label>
                    <input type="text" class="form-control" name="experience_button_text" value="{{ $about->experience_button_text ?? 'Get Started' }}">
                </div>

                <!-- Stats -->
                @for($i = 1; $i <= 3; $i++)
                <div class="card mb-3">
                    <div class="card-header">Stat {{ $i }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Percentage</label>
                            <input type="number" class="form-control" name="stat{{$i}}_percentage" value="{{ $about->{'stat'.$i.'_percentage'} ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="stat{{$i}}_title" value="{{ $about->{'stat'.$i.'_title'} ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="stat{{$i}}_description">{{ $about->{'stat'.$i.'_description'} ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- How We Work Section -->
            <div class="form-section">
                <h4 class="section-title">How We Work Section</h4>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" class="form-control" name="work_title" value="{{ $about->work_title ?? 'How We work?' }}">
                </div>
                <div class="form-group">
                    <label>Section Subtitle</label>
                    <input type="text" class="form-control" name="work_subtitle" value="{{ $about->work_subtitle ?? 'Our Process For Delivering Results' }}">
                </div>
                <div class="form-group">
                    <label>Section Description</label>
                    <textarea class="form-control" name="work_description">{{ $about->work_description ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Background Image</label>
                    <input type="file" class="form-control" name="work_image">
                    @if(isset($about->work_image))
                        <img src="{{ asset($about->work_image) }}" width="100" class="mt-2">
                        <a href="#" class="remove-image" data-field="work_image">Remove Image</a>
                    @endif
                </div>
                <div class="form-group">
                    <label>Right Column Heading</label>
                    <input type="text" class="form-control" name="work_right_heading" value="{{ $about->work_right_heading ?? 'Join a buzzing marketplace' }}">
                </div>
                <div class="form-group">
                    <label>Right Column Description</label>
                    <textarea class="form-control" name="work_right_description">{{ $about->work_right_description ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Button Text</label>
                    <input type="text" class="form-control" name="work_button_text" value="{{ $about->work_button_text ?? 'Join Team' }}">
                </div>

                <!-- Process Steps -->
                @for($i = 1; $i <= 4; $i++)
                <div class="card mb-3">
                    <div class="card-header">Process Step {{ $i }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="step{{$i}}_title" value="{{ $about->{'step'.$i.'_title'} ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="step{{$i}}_description">{{ $about->{'step'.$i.'_description'} ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Icon Class (Font Awesome)</label>
                            <input type="text" class="form-control" name="step{{$i}}_icon" value="{{ $about->{'step'.$i.'_icon'} ?? '' }}">
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Testimonials Section -->
            <div class="form-section">
                <h4 class="section-title">Testimonials Section</h4>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" class="form-control" name="testimonials_title" value="{{ $about->testimonials_title ?? 'TESTIMONIALS' }}">
                </div>
                <div class="form-group">
                    <label>Section Description</label>
                    <input type="text" class="form-control" name="testimonials_description" value="{{ $about->testimonials_description ?? 'More than 10k 5-star reviews' }}">
                </div>

                <!-- Testimonials -->
                @for($i = 1; $i <= 6; $i++)
                <div class="card mb-3">
                    <div class="card-header">Testimonial {{ $i }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="form-control" name="testimonial{{$i}}_content">{{ $about->{'testimonial'.$i.'_content'} ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Author Image</label>
                            <input type="file" class="form-control" name="testimonial{{$i}}_image">
                            @if(isset($about->{'testimonial'.$i.'_image'}))
                                <img src="{{ asset($about->{'testimonial'.$i.'_image'}) }}" width="100" class="mt-2">
                                <a href="#" class="remove-image" data-field="testimonial{{$i}}_image">Remove Image</a>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Author Name</label>
                            <input type="text" class="form-control" name="testimonial{{$i}}_name" value="{{ $about->{'testimonial'.$i.'_name'} ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Author Position</label>
                            <input type="text" class="form-control" name="testimonial{{$i}}_position" value="{{ $about->{'testimonial'.$i.'_position'} ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Background Color Class</label>
                            <input type="text" class="form-control" name="testimonial{{$i}}_bg_color" value="{{ $about->{'testimonial'.$i.'_bg_color'} ?? '' }}" placeholder="bg-blue, bg-green, bg-pink, etc.">
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- FAQ Section -->
            <div class="form-section">
                <h4 class="section-title">FAQ Section</h4>
                <div class="form-group">
                    <label>Section Small Title</label>
                    <input type="text" class="form-control" name="faq_small_title" value="{{ $about->faq_small_title ?? 'FAQ' }}">
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" class="form-control" name="faq_title" value="{{ $about->faq_title ?? 'Frequently Asked Questions' }}">
                </div>
                <div class="form-group">
                    <label>Section Description</label>
                    <textarea class="form-control" name="faq_description">{{ $about->faq_description ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.' }}</textarea>
                </div>

                <!-- FAQs -->
                @for($i = 1; $i <= 4; $i++)
                <div class="card mb-3">
                    <div class="card-header">FAQ {{ $i }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" class="form-control" name="faq{{$i}}_question" value="{{ $about->{'faq'.$i.'_question'} ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea class="form-control" name="faq{{$i}}_answer">{{ $about->{'faq'.$i.'_answer'} ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Save All Changes</button>
            </div>
        </form>
    </div>
</div>



<script src="{{ asset('frontend/assets/js/adminabout.js') }}"></script>
</body>

</html>