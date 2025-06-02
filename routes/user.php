<?php

use App\Http\Controllers\Customer\AppointmentController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\EventController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\UpcomingAppointmentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

Route::middleware(['auth:user'])->group(function () {
    Route::get('dashboard', function () {
        $userId = Auth::guard('user')->id();

        $monthlyCount = Booking::where('plan_type', 'monthly')
            ->where('user_id', $userId)
            ->count();

        $quarterlyCount = Booking::where('plan_type', 'quarterly')
            ->where('user_id', $userId)
            ->count();

        $totalSubscriptions = $monthlyCount + $quarterlyCount;

        return view('customer.index', compact('monthlyCount', 'quarterlyCount', 'totalSubscriptions'));
    })->name('dashboard');


    Route::get('/service/{id}/questions', [HomeController::class, 'getServiceQuestions'])->name('service.questions');

    Route::get('/service/{id}/questions', [HomeController::class, 'getServiceQuestions'])->name('service.questions');


    Route::get('booking', function () {
        $services = Service::latest()->get();
        return view('customer.booking.booking', compact('services'));
    })->name('booking');


    Route::post('/booking/store', [HomeController::class, 'store'])->name('booking.store');



    Route::get('/booking/success', [HomeController::class, 'success'])->name('booking.success');
    Route::post('/booking/session-store', [HomeController::class, 'storeInSession'])->name('booking.session.store');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::post('/set-service', [HomeController::class, 'setServiceSession'])->name('service.save');
    Route::resource('all-appointment', AppointmentController::class);
    Route::resource('upcoming-appointment', UpcomingAppointmentController::class);

    Route::get('appointments/{id}/details', [AppointmentController::class, 'showDetails'])->name('appointment.details');

    Route::resource('profile', ProfileController::class);
    Route::resource('customer-event', EventController::class);
    Route::post('/check-login', [BookingController::class, 'checkLogin'])->name('check.login');
    Route::get('/booking/summary', [BookingController::class, 'bookingSummary'])->name('booking.summary');

    Route::post('/booking/payment/init', [BookingController::class, 'initPayment'])->name('booking.payment.init');
    Route::post('/booking/payment/success', [BookingController::class, 'paymentSuccess'])->name('booking.payment.success');
    Route::get('/booking/success', [BookingController::class, 'successPage'])->name('booking.success');
    Route::post('/booking/payment/failed', [BookingController::class, 'paymentFailed'])->name('booking.payment.failed');
    Route::get('/reset-booking', [BookingController::class, 'resetBooking'])->name('reset-booking');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');
});
