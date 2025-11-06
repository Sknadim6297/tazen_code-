<?php

use App\Http\Controllers\Customer\AppointmentController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Customer\EventController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\UpcomingAppointmentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\BookingChatController;
use Illuminate\Support\Facades\Route;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;


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

    // My Bookings with Chat
    Route::get('my-bookings', [App\Http\Controllers\Customer\MyBookingController::class, 'index'])->name('my-bookings');

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
    Route::get('/booking/retry/{booking_id}', [BookingController::class, 'retryBooking'])->name('booking.retry');
    Route::get('/reset-booking', [BookingController::class, 'resetBooking'])->name('reset-booking');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');

    // Additional Services routes for customers
    Route::prefix('additional-services')->name('additional-services.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\AdditionalServiceController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Customer\AdditionalServiceController::class, 'show'])->name('show');
        Route::post('/{id}/negotiate', [App\Http\Controllers\Customer\AdditionalServiceController::class, 'negotiate'])->name('negotiate');
        Route::post('/{id}/confirm-consultation', [App\Http\Controllers\Customer\AdditionalServiceController::class, 'confirmConsultation'])->name('confirm-consultation');
        Route::post('/{id}/create-payment-order', [App\Http\Controllers\Customer\AdditionalServiceController::class, 'createPaymentOrder'])->name('create-payment-order');
        Route::post('/{id}/payment-success', [App\Http\Controllers\Customer\AdditionalServiceController::class, 'handlePaymentSuccess'])->name('payment-success');
        
        // Invoice Generation Routes
        Route::get('/{id}/invoice', [App\Http\Controllers\Customer\AdditionalServiceController::class, 'generateInvoice'])->name('invoice');
        Route::get('/{id}/invoice/pdf', [App\Http\Controllers\Customer\AdditionalServiceController::class, 'generatePdfInvoice'])->name('invoice.pdf');
    });

    Route::get('billing/export-all', [CustomerBookingController::class, 'exportAllTransactions'])
        ->name('billing.export-all');

    // Booking Chat Routes for Customer
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/booking/{bookingId}', [BookingChatController::class, 'openChat'])->name('open');
        Route::post('/booking/{bookingId}/send', [BookingChatController::class, 'sendMessage'])->name('send');
        Route::get('/booking/{bookingId}/messages', [BookingChatController::class, 'getMessages'])->name('messages');
        Route::get('/booking/{bookingId}/unread-count', [BookingChatController::class, 'getUnreadCount'])->name('unread');
        Route::get('/total-unread-count', [BookingChatController::class, 'getTotalUnreadCount'])->name('total-unread');
    });

    // Admin-Customer Chat Routes
    Route::prefix('admin-chat')->name('admin-chat.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\ChatController::class, 'index'])->name('index');
        Route::post('/get-or-create', [App\Http\Controllers\Customer\ChatController::class, 'getOrCreateChat'])->name('get-or-create');
        Route::post('/send-message', [App\Http\Controllers\Customer\ChatController::class, 'sendMessage'])->name('send-message');
        Route::get('/messages', [App\Http\Controllers\Customer\ChatController::class, 'getMessages'])->name('messages');
        Route::post('/mark-as-read', [App\Http\Controllers\Customer\ChatController::class, 'markAsRead'])->name('mark-as-read');
        Route::get('/unread-count', [App\Http\Controllers\Customer\ChatController::class, 'getUnreadCount'])->name('unread-count');
        Route::get('/attachment/{id}/download', [App\Http\Controllers\Customer\ChatController::class, 'downloadAttachment'])->name('attachment.download');
    });
});
