<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ManageProfessionalController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\WhychooseController;
use App\Http\Controllers\Admin\ContactBannerController;
use App\Http\Controllers\Admin\ContactDetailController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogBannerController;
use App\Http\Controllers\Admin\EventDetailsController;
use App\Http\Controllers\Admin\AboutExperienceController;
use App\Http\Controllers\Admin\AboutHowWeWorkController;
use App\Http\Controllers\Admin\AboutFAQController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ServiceDetailsController;
use App\Http\Controllers\Admin\EventFAQController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\MCQController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AllEventController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ServiceMCQController;


use App\Http\Controllers\Admin\ProfessionalRequestedController;
use App\Http\Controllers\frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');


    Route::resource('banners', BannerController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('contactbanner', ContactBannerController::class);
    Route::resource('contactdetails', ContactDetailController::class);
    Route::resource('blogposts', BlogPostController::class);
    Route::resource('blogbanners', BlogBannerController::class);
    Route::resource('eventdetails', EventDetailsController::class);
    Route::resource('aboutexperiences', AboutExperienceController::class);
    Route::resource('abouthowweworks', AboutHowWeWorkController::class);
    Route::resource('aboutfaq', AboutFAQController::class);
    Route::resource('service-details', ServiceDetailsController::class);
    Route::resource('eventfaq', EventFAQController::class);
    Route::resource('logo', LogoController::class);

    Route::resource('blogs', BlogController::class);
    Route::resource('allevents', AllEventController::class);

    Route::get('/admin/banner', [BannerController::class, 'index'])->name('admin.banner.index');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('whychoose', [WhychooseController::class, 'index'])->name('admin.whychoose.index');
        Route::post('whychoose', [WhychooseController::class, 'store'])->name('whychoose.store');
        Route::get('whychoose/{id}/edit', [WhychooseController::class, 'edit'])->name('whychoose.edit');
        Route::put('whychoose/{id}', [WhychooseController::class, 'update'])->name('whychoose.update');
    });

    Route::resource('whychoose', WhychooseController::class);

    Route::resource('testimonials', TestimonialController::class);
    Route::get('/admin/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.index');
    Route::resource('servicemcq', ServiceMCQController::class);



    Route::resource('banner', BannerController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('manage-professional', ManageProfessionalController::class);

    Route::resource('mcq', MCQController::class);
    Route::get('/professional-requests', [ProfessionalRequestedController::class, 'index'])->name('professional.requests');
    Route::post('/professional-requests/{id}/approve', [ProfessionalRequestedController::class, 'approve'])->name('professional.requests.approve');
    Route::get('/professional-requests/{id}/reject', [ProfessionalRequestedController::class, 'reject'])->name('professional.requests.reject');
    Route::get('/professional-requests/{id}/show', [ProfessionalRequestedController::class, 'show'])->name('professional.requests.show');

    Route::get('/get-availability-slots', [HomeController::class, 'getAvailabilitySlots'])->name('get.availability.slots');
    Route::get('/booking/onetime', [BookingController::class, 'oneTimeBooking'])->name('onetime');
    Route::get('/booking/freehand', [BookingController::class, 'freeHandBooking'])->name('freehand');
    Route::get('/booking/monthly', [BookingController::class, 'monthlyBooking'])->name('monthly');
    Route::get('/booking/quaterly', [BookingController::class, 'quaterlyBooking'])->name('quaterly');
    Route::post('/booking/add-link/{id}', [BookingController::class, 'updateLink'])->name('add-link');

    Route::post('/professional/reject/{id}', [ProfessionalRequestedController::class, 'reject'])->name('professional.requests.reject');

    Route::get('booking/details/{id}', [BookingController::class, 'show'])->name('booking.details');

});
