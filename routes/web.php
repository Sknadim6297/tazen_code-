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

// Auth Controllers
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Frontend\AuthController;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\ServiceController;

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
use App\Models\ContactBanner;
use App\Models\ContactDetail;
use App\Models\BlogBanner;
use App\Models\BlogPost;
use App\Models\Blog;
use App\Models\Service;
use App\Models\AllEvent;


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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('gridlisting', function () {
    return view('frontend.sections.gridlisting');
});
Route::get('professionaldetails', function () {
    return view('frontend.sections.professional-details')->name('professionals.details');
});
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

    $events = $events->latest()->get(); // Order by latest
    $services = Service::latest()->get();

    // Get unique categories for the filter
    $categories = AllEvent::distinct()->pluck('mini_heading');

    return view('frontend.sections.eventlist', compact('events', 'services', 'filter', 'categories', 'category', 'price_range'));
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
    $blogPosts = BlogPost::latest()->get();
    $services = Service::latest()->get();
    $latestBlogs = BlogPost::latest()->take(3)->get();
    $categoryCounts = BlogPost::select('category', DB::raw('count(*) as post_count'))
        ->groupBy('category')
        ->get();
    $search = $request->input('search');

    $blogPosts = BlogPost::with('blog')
        ->when($search, function ($query, $search) {
            return $query->whereHas('blog', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        })
        ->latest()
        ->get(); // or paginate() if needed


    return view('frontend.sections.blog', compact('blogbanners', 'blogPosts', 'services', 'latestBlogs', 'categoryCounts', 'search'));
})->name('blog.index');
Route::get('/blog-post/{id}', function ($id) {
    // Fetch the blog by ID
    $blogPost = DB::table('blog_posts')->where('id', $id)->first();
    $relatedBlog = DB::table('blogs')->where('id', $blogPost->blog_id)->first();
    $latestBlogs = BlogPost::latest()->take(3)->get();
    $categoryCounts = BlogPost::select('category', DB::raw('count(*) as post_count'))
        ->groupBy('category')
        ->get();

    // Optional: Handle case where blog doesn't exist
    if (!$blogPost) {
        abort(404, 'Blog not found');
    }

    // Fetch latest services
    $services = Service::latest()->get();

    return view('frontend.sections.blog-post', compact('blogPost', 'services', 'relatedBlog', 'latestBlogs', 'categoryCounts'));
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



Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/store', [AdminLoginController::class, 'store'])->name('admin.store');
Route::get('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


// Route::prefix('admin')->group(function () {
//     Route::get('/about', [AdminAboutPageController::class, 'edit'])->name('admin.about.edit');
//     Route::put('/about', [AdminAboutPageController::class, 'update'])->name('admin.about.update');
// });

Route::post('/submit-questionnaire', [HomeController::class, 'submitQuestionnaire'])->name('submitQuestionnaire');
Route::middleware(['auth:user'])->group(function () {
    // Professional routes
    Route::get("professionals", [HomeController::class, 'professionals'])->name('professionals');
    Route::get("professionals/details/{id}", [HomeController::class, 'professionalsDetails'])->name('professionals.details');

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
});

Route::get('/admin/banners', [BannerController::class, 'index'])->name('admin.banner.index');
Route::post('/admin/banners', [BannerController::class, 'store'])->name('admin.banner.store');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('homeblog', \App\Http\Controllers\Admin\HomeBlogController::class);
    Route::resource('howworks', \App\Http\Controllers\Admin\HowworksController::class);
    Route::resource('about-banner', AboutBannerController::class);
    Route::get('/mcq-answers', [App\Http\Controllers\Admin\McqAnswerController::class, 'index'])->name('mcq-answers.index');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('aboutus', \App\Http\Controllers\Admin\AboutUsController::class);
});
Route::get('professional/login', [ProfessionalController::class, 'showLoginForm'])->name('professional.login');
Route::post('professional/store', [ProfessionalController::class, 'store'])->name('professional.store');
Route::get('professional/logout', [ProfessionalController::class, 'logout'])->name('professional.logout');
Route::get('professional/register', [ProfessionalController::class, 'registerForm'])->name('professional.register');
Route::post('professional/register', [ProfessionalController::class, 'register'])->name('professional.register.submit');


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
Route::middleware(['auth:admin'])->group(function() {
    // Existing routes...
    Route::post('/admin/professional/payment/save', [App\Http\Controllers\Admin\BillingController::class, 'savePayment'])
        ->name('admin.professional.payment.save');
    Route::post('/admin/professional/payment/update-status', [App\Http\Controllers\Admin\BillingController::class, 'updatePaymentStatus'])
        ->name('admin.professional.payment.update-status');
});

