<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Admin Controllers
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\HowworksController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AboutBannerController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\MCQController;
use App\Http\Controllers\Admin\HelpController;

// Auth Controllers
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Frontend\AuthController;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\SearchController;

// Customer & Professional
use App\Http\Controllers\Customer\UpcomingAppointmentController;
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Professional\ProfessionalController;
use App\Http\Controllers\Professional\BillingController;

// Models
use App\Models\AboutUs;
use App\Models\Whychoose;
use App\Models\Testimonial;
use App\Models\AboutBanner;
use App\Models\AboutExperience;
use App\Models\AboutHowWeWork;
use App\Models\AboutFAQ;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\EventFAQ;
use App\Models\Contactbanner;
use App\Models\ContactDetail;
use App\Models\BlogBanner;
use App\Models\BlogPost;
use App\Models\Blog;
use App\Models\Service;
use App\Models\AllEvent;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\Customer\BookingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Route to check login status (no authentication required)
Route::post('/check-login', [BookingController::class, 'checkLogin'])->name('check.login');

Route::get('/run-migrations', function() {
        Artisan::call('migrate', ['--force' => true]);
        return "Migrations ran successfully!";
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('gridlisting', [HomeController::class, 'professionals'])->name('gridlisting');

// Professional details page - public viewing but requires auth for booking
Route::get("professionals/details/{id}/{professional_name?}", [HomeController::class, 'professionalsDetails'])->name('professionals.details');

Route::get('about', function () {
    $about_us = AboutUs::latest()->get();
    $whychooses = Whychoose::latest()->get();
    $testimonials = Testimonial::latest()->get();
    $banners = AboutBanner::latest()->get();
    $aboutexperiences = AboutExperience::latest()->get();
    $abouthowweworks = AboutHowWeWork::latest()->get();
    $aboutfaqs = AboutFAQ::latest()->get();
    $services = Service::latest()->get();

    return view('frontend.sections.about', compact('services', 'about_us', 'whychooses', 'testimonials', 'banners', 'aboutexperiences', 'abouthowweworks', 'aboutfaqs'));
});
Route::get('/eventlist', function (Request $request) {
    $filter = $request->query('filter');
    $category = $request->query('category');
    $price_range = $request->query('price_range');
    $city = $request->query('city');
    $event_mode = $request->query('event_mode');

    $events = EventDetail::with('event'); // Eager load event relation

    $events = $events->whereHas('event', function ($query) use ($filter, $category, $price_range) {
        if ($filter == 'today') {
            $query->whereDate('date', Carbon::today()->toDateString());
        } elseif ($filter == 'tomorrow') {
            $query->whereDate('date', Carbon::tomorrow()->toDateString());
        } elseif ($filter == 'weekend') {
            $startOfWeekend = Carbon::now()->next(Carbon::SATURDAY)->startOfDay();
            $endOfWeekend = Carbon::now()->next(Carbon::SUNDAY)->endOfDay();
            $query->whereBetween('date', [$startOfWeekend, $endOfWeekend]);
        }

        if ($category) {
            $query->where('mini_heading', $category);
        }

        if ($price_range) {
            switch ($price_range) {
                case '100-200':
                    $query->whereBetween('starting_fees', [100, 200]);
                    break;
                case '200-300':
                    $query->whereBetween('starting_fees', [200, 300]);
                    break;
                case '300-400':
                    $query->whereBetween('starting_fees', [300, 400]);
                    break;
                case '400-500':
                    $query->whereBetween('starting_fees', [400, 500]);
                    break;
                case '500-1000':
                    $query->whereBetween('starting_fees', [500, 1000]);
                    break;
            }
        }
    });

    // Add city filter
    if ($city) {
        $events = $events->where('city', $city);
    }

    // Add event mode filter
    if ($event_mode) {
        $events = $events->where('event_mode', $event_mode);
    }

    $events = $events->latest()->paginate(12); // Change from get() to paginate() with 12 items per page
    $services = Service::latest()->get();

    // Get unique categories for the filter
    $categories = AllEvent::distinct()->pluck('mini_heading');

    // Get unique cities for the filter
    $cities = EventDetail::distinct()->pluck('city')->filter();

    // Get unique event modes for the filter
    $event_modes = ['online', 'offline'];

    return view('frontend.sections.eventlist', compact('events', 'services', 'filter', 'categories', 'category', 'price_range', 'cities', 'city', 'event_modes', 'event_mode'));
})->name('event.list');
Route::get('/allevent/{id}', function ($id) {
    $event = Event::with('eventDetails')->findOrFail($id);
    $services = Service::all();
    $eventfaqs = EventFAQ::latest()->get();

    return view('frontend.sections.allevent', compact('event', 'services', 'eventfaqs'));
})->name('event.details');
Route::get('allevent', function ($id) {
    $eventdetails = Eventdetail::with('event')->latest()->get();
    // dd($eventdetails);
    $eventfaqs = EventFAQ::latest()->get();
    $event = Event::findOrFail($id);

    return view('frontend.sections.allevent', compact('eventdetails', 'eventfaqs', 'event'));
});

Route::get('/allevents', [EventController::class, 'index'])->name('allevents');
Route::get('/service/{id}', [ServiceController::class, 'show'])->name('service.show');
Route::get('/service/{id}/questions', [HomeController::class, 'getServiceQuestions'])->name('service.questions');


Route::get('blog', function (Request $request) {
    $blogbanners = BlogBanner::latest()->get();
    $services = Service::latest()->get();
    $latestBlogs = BlogPost::latest()->take(3)->get();
    $categoryCounts = BlogPost::select('category', DB::raw('count(*) as post_count'))
        ->groupBy('category')
        ->get();
    $search = $request->input('search');
    $category = $request->input('category');

    $blogPosts = BlogPost::with('blog')
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->whereHas('blog', function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%');
                })
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        })
        ->when($category, function ($query, $category) {
            return $query->where('category', $category);
        })
        ->latest()
        ->get();

    return view('frontend.sections.blog', compact('blogbanners', 'blogPosts', 'services', 'latestBlogs', 'categoryCounts', 'search', 'category'));
})->name('blog.index');
Route::get('/blog-post/{identifier}', function ($identifier) {
    // identifier can be numeric ID or slugified title
    if (is_numeric($identifier)) {
        // Handle numeric ID
        $blogPost = DB::table('blog_posts')->where('id', $identifier)->first();
    } else {
        // Handle slug - find by matching slugified title
        $allBlogPosts = BlogPost::with('blog')->get();
        $blogPost = null;
        foreach ($allBlogPosts as $bp) {
            if (\Illuminate\Support\Str::slug($bp->blog->title) === $identifier) {
                $blogPost = $bp;
                break;
            }
        }
        // Convert to compatible format if found via Eloquent
        if ($blogPost) {
            $blogPost = (object) [
                'id' => $blogPost->id,
                'title' => $blogPost->blog->title,
                'image' => $blogPost->image,
                'content' => $blogPost->content,
                'category' => $blogPost->category,
                'published_at' => $blogPost->published_at,
                'author_name' => $blogPost->author_name,
                'blog_id' => $blogPost->blog_id,
            ];
        }
    }

    // Handle case where blog doesn't exist
    if (!$blogPost) {
        abort(404, 'Blog not found');
    }

    $relatedBlog = DB::table('blogs')->where('id', $blogPost->blog_id)->first();
    $latestBlogs = BlogPost::latest()->take(3)->get();
    $categoryCounts = BlogPost::select('category', DB::raw('count(*) as post_count'))
        ->groupBy('category')
        ->get();
    $comments = \App\Models\Comment::where('blog_post_id', $blogPost->id)
        ->where('is_approved', true)
        ->latest()
        ->take(4)
        ->get();

    // Fetch latest services
    $services = Service::latest()->get();

    return view('frontend.sections.blog-post', compact('blogPost', 'services', 'relatedBlog', 'latestBlogs', 'categoryCounts', 'comments'));
})->name('blog.show');
Route::get('eventdetails', function () {
    return view('frontend.sections.eventdetails');
});
Route::get('interiordesign', function () {
    return view('frontend.sections.interiordesign');
});
Route::get('pshychology', function () {
    return view('frontend.sections.pshychology');
});
Route::get('fitness', function () {
    return view('frontend.sections.fitness-yoga');
});
Route::get('dieticians', function () {
    return view('frontend.sections.dieticians');
});
Route::get('contact', function () {
    $contactbanners = Contactbanner::latest()->get();
    $contactdetails = ContactDetail::latest()->get();
    $services = Service::latest()->get();
    return view('frontend.sections.contact', compact('contactbanners', 'contactdetails', 'services'));
});

Route::get('help', function () {
    $services = Service::latest()->get();
    return view('frontend.sections.help', compact('services'));
});

Route::get('influencer', function () {
    return view('frontend.sections.influencer');
});
Route::get('stylist', function () {
    return view('frontend.sections.stylist');
});
Route::get('job', function () {
    return view('frontend.sections.job');
});
Route::get('astro', function () {
    return view('frontend.sections.astro');
});
Route::get('blog-post', function () {
    $blogbanners = BlogBanner::latest()->get();

    return view('frontend.sections.blog-post', compact('blogbanners'));
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('register', [LoginController::class, 'showRegisterForm'])->name('register');

Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('register', [LoginController::class, 'register'])->name('register.submit');
Route::post('/register/send-otp', [App\Http\Controllers\Frontend\LoginController::class, 'sendOtp'])->name('register.send-otp');
Route::post('/register/verify-otp', [App\Http\Controllers\Frontend\LoginController::class, 'verifyOtp'])->name('register.verify-otp');


Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/store', [AdminLoginController::class, 'store'])->name('admin.store');
Route::get('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


// Route::prefix('admin')->group(function () {
//     Route::get('/about', [AdminAboutPageController::class, 'edit'])->name('admin.about.edit');
//     Route::put('/about', [AdminAboutPageController::class, 'update'])->name('admin.about.update');
// });

Route::post('/submit-questionnaire', [HomeController::class, 'submitQuestionnaire'])->name('submitQuestionnaire');

// Service session save route (no authentication required for sharing)
Route::post('/set-service-session', [HomeController::class, 'setServiceSession'])->name('set.service.session');

// Professionals listing page (no authentication required for viewing)
Route::get("professionals", [HomeController::class, 'professionals'])->name('professionals');

Route::middleware(['auth:user'])->group(function () {
    // Upcoming appointments routes
    Route::get('/upcoming-appointments', [UpcomingAppointmentController::class, 'index'])->name('user.upcoming-appointment.index');
    Route::post('/customer/upload-document', [UpcomingAppointmentController::class, 'uploadDocument'])->name('user.upload-document');
    Route::get('/customer/document-info/{id}', [UpcomingAppointmentController::class, 'getDocumentInfo'])->name('user.document-info');

    // Booking and Payment routes
    Route::post('/booking/initiate-payment', [CustomerBookingController::class, 'initiatePayment'])->name('user.booking.initiate-payment');
    Route::post('/booking/verify-payment', [CustomerBookingController::class, 'verifyPayment'])->name('user.booking.verify-payment');
    Route::get('/booking/success', [CustomerBookingController::class, 'success'])->name('user.booking.success');
    Route::get('/event/booking/success', [CustomerBookingController::class, 'eventSuccess'])->name('user.event.booking.success');

    // Customer Billing routes
    Route::get('/customer/billing', [CustomerBookingController::class, 'billing'])->name('user.billing.index');
    Route::get('/customer/billing/download/{id}', [CustomerBookingController::class, 'downloadInvoice'])->name('user.billing.download');

    // New routes for paymentFailed and retryBooking
    Route::post('customer/booking/payment-failed', [CustomerBookingController::class, 'paymentFailed'])->name('user.customer.booking.payment.failed');
    Route::get('customer/booking/retry/{booking_id}', [CustomerBookingController::class, 'retryBooking'])->name('user.customer.booking.retry');
});

Route::get('/admin/banners', [BannerController::class, 'index'])->name('admin.banner.index');
Route::post('/admin/banners', [BannerController::class, 'store'])->name('admin.banner.store');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('homeblog', \App\Http\Controllers\Admin\HomeBlogController::class);
    Route::resource('howworks', \App\Http\Controllers\Admin\HowworksController::class);
    Route::resource('about-banner', AboutBannerController::class);
    Route::get('/mcq-answers', [App\Http\Controllers\Admin\McqAnswerController::class, 'index'])->name('mcq-answers.index');
    Route::get('/contact-forms', [App\Http\Controllers\Admin\ContactFormController::class, 'index'])->name('contact-forms.index');
    Route::get('/contact-forms/export', [App\Http\Controllers\Admin\ContactFormController::class, 'export'])->name('contact-forms.export');
    Route::delete('/contact-forms/{contactForm}', [App\Http\Controllers\Admin\ContactFormController::class, 'destroy'])->name('contact-forms.destroy');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('aboutus', \App\Http\Controllers\Admin\AboutUsController::class);
});
Route::get('professional/login', [ProfessionalController::class, 'showLoginForm'])->name('professional.login');
Route::post('professional/store', [ProfessionalController::class, 'store'])->name('professional.store');
Route::get('professional/logout', [ProfessionalController::class, 'logout'])->name('professional.logout');
Route::get('professional/register', [ProfessionalController::class, 'registerForm'])->name('professional.register');
Route::post('professional/register', [ProfessionalController::class, 'register'])->name('professional.register.submit');
Route::post('professional/send-otp', [ProfessionalController::class, 'sendOTP'])->name('professional.send.otp');
Route::post('professional/verify-otp', [ProfessionalController::class, 'verifyOTP'])->name('professional.verify.otp');


// Route::get('/get-mcqs/{service_id}', [ServiceController::class, 'getMcqs']);
Route::post('/submit-mcq', [MCQController::class, 'store'])->name('submit.mcq');
Route::get('/get-mcq-questions/{serviceId}', [HomeController::class, 'getServiceQuestions']);
// Forgot Password
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.form');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.send');

// Reset Password
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

// Add these routes for user password reset
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotForm'])
        ->name('forgot.form');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLink'])
        ->name('forgot.send');
    Route::get('/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset.form');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword'])
        ->name('password.reset');
});

// Add these routes for professional password reset
Route::prefix('professional')->name('professional.')->group(function () {
    Route::middleware('guest:professional')->group(function () {
        Route::get('/forgot-password', [App\Http\Controllers\Professional\AuthController::class, 'showForgotForm'])
            ->name('forgot.form');
        Route::post('/forgot-password', [App\Http\Controllers\Professional\AuthController::class, 'sendResetLink'])
            ->name('forgot.send');
        Route::get('/reset-password', [App\Http\Controllers\Professional\AuthController::class, 'showResetForm'])
            ->name('password.reset.form');
        Route::post('/reset-password', [App\Http\Controllers\Professional\AuthController::class, 'resetPassword'])
            ->name('password.reset');
    });
});

Route::middleware(['auth:professional'])->group(function () {
    // Professional billing routes
    Route::get('/billing', [BillingController::class, 'index'])->name('professional.billing.index');
    Route::get('/billing/download-invoice/{booking}', [\App\Http\Controllers\Professional\ProfessionalBillingController::class, 'downloadInvoice'])->name('professional.billing.download-invoice');
});

// Professional payment routes
Route::middleware(['auth:admin'])->group(function () {
    // Existing routes...
    Route::post('/admin/professional/payment/save', [App\Http\Controllers\Admin\BillingController::class, 'savePayment'])
        ->name('admin.professional.payment.save');
    Route::post('/admin/professional/payment/update-status', [App\Http\Controllers\Admin\BillingController::class, 'updatePaymentStatus'])
        ->name('admin.professional.payment.update-status');
});

Route::get('user/terms-and-conditions', function () {
    return response()->file(public_path('pdf/user-terms-and-conditions.pdf'));
})->name('user.terms');
Route::get('professional/terms-and-conditions', function () {
    return response()->file(public_path('pdf/professional-terms-and-conditions.pdf'));
})->name('professional.terms');

Route::get('terms', function () {
    $services = Service::latest()->get();
    return view('frontend.sections.terms', compact('services'));
})->name('terms');

Route::get('/services/search', [HomeController::class, 'searchservice'])->name('services.search');

// Admin review routes
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:admin']], function () {
    Route::get('reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])
        ->name('reviews.index');
    Route::delete('reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});

// Professional review routes
Route::prefix('professional')->middleware(['auth:professional'])->name('professional.')->group(function () {
    Route::get('/reviews', [App\Http\Controllers\Professional\ReviewController::class, 'index'])
        ->name('reviews.index');
});
Route::get('/search-services', [HomeController::class, 'searchServices'])->name('search.services');
Route::get('event-booking/success', [EventController::class, 'bookingSuccess'])
    ->name('event.booking.success');

// Help & FAQ Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('help', \App\Http\Controllers\Admin\HelpController::class);
});

// Frontend Help & FAQ Route
Route::get('/help', [\App\Http\Controllers\Admin\HelpController::class, 'frontend'])->name('help.index');
Route::get('/check-auth-status', function () {
    return response()->json([
        'authenticated' => Auth::guard('user')->check()
    ]);
});

Route::post('/force-login', [App\Http\Controllers\Frontend\LoginController::class, 'forceLogin'])->name('force.login');

Route::middleware(['auth:user', 'check.active.session'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

Route::post('/blog-post/{id}/comment', [App\Http\Controllers\CommentController::class, 'store'])->name('blog.comment.store');

// Comment Management Routes
Route::get('/blog-comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin.comments.index');
Route::post('/blog-comments/{id}/approve', [App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('admin.comments.approve');
Route::delete('/blog-comments/{id}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('admin.comments.destroy');
Route::get('/blog-comments/export', [App\Http\Controllers\Admin\CommentController::class, 'export'])->name('admin.comments.export');

// Add this route for Excel export
Route::get('admin/professional/billing/export-excel', [App\Http\Controllers\Admin\BillingController::class, 'exportBillingToExcel'])
    ->name('admin.professional.billing.export-excel');

// Add this route for Customer billing Excel export
Route::get('admin/customer/billing/export-excel', [App\Http\Controllers\Admin\BillingController::class, 'exportCustomerBillingToExcel'])
    ->name('admin.customer.billing.export-excel');
Route::get('/privacy', function () {
    return view('frontend.sections.privacy');
})->name('privacy');

// Add this in the professional group routes section
Route::get('/professional/rate/session-types', [App\Http\Controllers\Professional\RateController::class, 'getSessionTypes'])->name('professional.rate.get-session-types')->middleware('auth:professional');
