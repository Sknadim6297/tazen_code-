<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\frontend\HomeController;

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

Route::get('login', function () {
    return view('frontend.login.login');
});
Route::get('register', function () {
    return view('frontend.login.register');
});

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/store', [AdminLoginController::class, 'store'])->name('admin.store');
Route::get('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Route::prefix('admin')->group(function () {
//     Route::get('/about', [AdminAboutPageController::class, 'edit'])->name('admin.about.edit');
//     Route::put('/about', [AdminAboutPageController::class, 'update'])->name('admin.about.update');
// });

Route::get('/customer/dashboard', function () {
    return view('customer.index');
});

Route::get('/customer/add-profile', function () {
    return view('customer.addprofile.index');
})->name('customer.add-profile');
