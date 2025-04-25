<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\frontend\HomeController;

use App\Http\Controllers\Admin\HowworksController;
use App\Http\Controllers\Admin\AboutBannerController;

use App\Http\Controllers\frontend\LoginController;
use App\Http\Controllers\Professional\ProfessionalController;
use Illuminate\Auth\Events\Login;
use App\Http\Controllers\Admin\BannerController;
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
    return view('frontend.sections.professional-details');
});
Route::get('about', function () {
    return view('frontend.sections.about');
});
Route::get('eventlist', function () {
    return view('frontend.sections.eventlist');
});
Route::get('blog', function () {
    return view('frontend.sections.blog');
});
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
    return view('frontend.sections.contact');
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
    return view('frontend.sections.blog-post');
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
    Route::get("professionals", [HomeController::class, 'professionals'])->name('professionals');
});

Route::get('/admin/banners', [BannerController::class, 'index'])->name('admin.banner.index');
Route::post('/admin/banners', [BannerController::class, 'store'])->name('admin.banner.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('testimonial', App\Http\Controllers\Admin\TestimonialController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('homeblog', \App\Http\Controllers\Admin\HomeBlogController::class);
    Route::resource('howworks', \App\Http\Controllers\Admin\HowworksController::class); 
    Route::resource('about-banner', AboutBannerController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('aboutus', \App\Http\Controllers\Admin\AboutUsController::class);
});
