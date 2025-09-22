<?php

use App\Http\Controllers\Customer\AppointmentController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Customer\EventController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\UpcomingAppointmentController;
use App\Http\Controllers\Customer\ReRequestedServiceController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

// Route to store booking session data (no authentication required)
Route::post('/booking/session-store', [HomeController::class, 'storeInSession'])->name('booking.session.store');

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


    Route::get('booking', [HomeController::class, 'booking'])->name('booking');


    Route::post('/booking/store', [HomeController::class, 'store'])->name('booking.store');



    Route::get('/booking/success', [HomeController::class, 'success'])->name('booking.success');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::resource('all-appointment', AppointmentController::class);
    Route::resource('upcoming-appointment', UpcomingAppointmentController::class);
    Route::post('/upcoming-appointment/reschedule', [UpcomingAppointmentController::class, 'reschedule'])->name('upcoming-appointment.reschedule');
    Route::get('/get-professional-availability/{professionalId}', [UpcomingAppointmentController::class, 'getProfessionalAvailability']);
    Route::post('/upload-document', [UpcomingAppointmentController::class, 'uploadDocument'])->name('upload.document');
    Route::get('/document-info/{id}', [UpcomingAppointmentController::class, 'getDocumentInfo'])->name('document.info');

    Route::get('appointments/{id}/details', [AppointmentController::class, 'showDetails'])->name('appointment.details');

    Route::resource('profile', ProfileController::class);
    Route::resource('customer-event', EventController::class);
    Route::get('/booking/summary', [BookingController::class, 'bookingSummary'])->name('booking.summary');

    Route::post('/booking/payment/init', [BookingController::class, 'initPayment'])->name('booking.payment.init');
    Route::post('/booking/payment/success', [BookingController::class, 'paymentSuccess'])->name('booking.payment.success');
    Route::get('/booking/success', [BookingController::class, 'successPage'])->name('booking.success');
    Route::post('/booking/payment/failed', [BookingController::class, 'paymentFailed'])->name('booking.payment.failed');
    Route::post('/booking/mcq/answers', [BookingController::class, 'storeMCQAnswers'])->name('booking.mcq.store');
    Route::get('/booking/retry/{booking_id}', [BookingController::class, 'retryBooking'])->name('booking.retry');
    Route::get('/reset-booking', [BookingController::class, 'resetBooking'])->name('reset-booking');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');

    // Test routes for MCQ functionality
    Route::get('/test/mcq', [BookingController::class, 'mcqTestPage'])->name('test.mcq');
    Route::post('/test/set-mcq-session', [BookingController::class, 'setMCQTestSession'])->name('test.set-mcq-session');

    Route::get('billing/export-all', [CustomerBookingController::class, 'exportAllTransactions'])
        ->name('billing.export-all');
    
    // Re-requested Service Routes (customer)
    Route::prefix('re-requested-service')->name('customer.re-requested-service.')->group(function () {
        Route::get('/', [ReRequestedServiceController::class, 'index'])->name('index');
        Route::get('/{id}', [ReRequestedServiceController::class, 'show'])->name('show');
        Route::get('/{id}/payment', [ReRequestedServiceController::class, 'createPayment'])->name('payment');
        Route::post('/{id}/payment', [ReRequestedServiceController::class, 'processPayment'])->name('process-payment');
        Route::get('/{id}/success', [ReRequestedServiceController::class, 'paymentSuccess'])->name('success');
        Route::post('/{id}/do-later', [ReRequestedServiceController::class, 'doLater'])->name('do-later');
        Route::get('/{id}/invoice', [ReRequestedServiceController::class, 'invoice'])->name('invoice');
    });
});