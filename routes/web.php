<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TestimonialController;

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

Route::get('/', function () {
    return view('frontend.index');
});
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
// Route::get('adminindex', function () {
//     return view('admin.index');
// });
// Route::get('adminabout', function () {
//     return view('admin.about');
// });

Route::get('admin/dashboard', function () {
    return view('admin.index');
});

Route::resource('testimonial', App\Http\Controllers\admin\TestimonialController::class);
Route::resource('about', App\Http\Controllers\admin\AboutController::class);
Route::resource('whychooseus', App\Http\Controllers\admin\WhyController::class);



// Route::prefix('admin')->group(function () {
//     Route::get('/about', [AdminAboutPageController::class, 'edit'])->name('admin.about.edit');
//     Route::put('/about', [AdminAboutPageController::class, 'update'])->name('admin.about.update');
// });
