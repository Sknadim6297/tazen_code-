<?php

use App\Http\Controllers\frontend\AuthController;
use App\Http\Controllers\Professional\AuthController as ProfessionalAuthController;
use App\Http\Controllers\Professional\AvailabilityController;
use App\Http\Controllers\Professional\BillingController;
use App\Http\Controllers\Professional\BookingController;
use App\Http\Controllers\Professional\ProfessionalController;
use App\Http\Controllers\Professional\ProfessionalEventController;
use App\Http\Controllers\Professional\ProfileController;
use App\Http\Controllers\Professional\RateController;
use App\Http\Controllers\Professional\RequestedServiceController;
use App\Http\Controllers\Professional\ServiceController;
use App\Http\Controllers\BookingChatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Routes accessible for authenticated professionals regardless of status
Route::middleware(['auth:professional'])->group(function () {
    Route::get('rejected', [ProfessionalController::class, 'rejectedPage'])->name('rejected.view');
    Route::post('/re-submit', [ProfessionalController::class, 'reSubmit'])->name('register.re-submit');
    Route::get('/pending', [ProfessionalController::class, 'pendingPage'])->name('pending.view');

    // Debug route to test authentication
    Route::get('/debug-auth', function () {
        return response()->json([
            'authenticated' => Auth::guard('professional')->check(),
            'user_id' => Auth::guard('professional')->id(),
            'user_name' => Auth::guard('professional')->user()->name ?? 'No user'
        ]);
    });
});

// Routes only for accepted professionals
Route::middleware(['auth:professional', 'professional.status'])->group(function () {
    Route::get('dashboard', function () {
        $professional = Auth::guard('professional')->user();

        // Clean up notifications older than 30 days
        $thirtyDaysAgo = \Carbon\Carbon::now()->subDays(30);
        DB::table('notifications')
            ->where('notifiable_type', 'App\Models\Professional')
            ->where('notifiable_id', $professional->id)
            ->where('created_at', '<', $thirtyDaysAgo)
            ->delete();

        return view('professional.index');
    })->name('dashboard');

    Route::resource('profile', ProfileController::class);
    Route::get('service/get-sub-services', [ServiceController::class, 'getSubServices'])->name('service.getSubServices');
    Route::resource('service', ServiceController::class);
    Route::resource('rate', RateController::class);
    Route::resource('availability', AvailabilityController::class);
    Route::resource('booking', BookingController::class);
    Route::resource('billing', BillingController::class);
    Route::resource('requested_services', RequestedServiceController::class);

    // Additional billing routes
    Route::get('/billing/download-invoice/{booking}', [BillingController::class, 'downloadInvoice'])->name('billing.download-invoice');
    Route::get('/billing/customer-invoice/{booking}', [BillingController::class, 'viewCustomerInvoice'])->name('billing.customer-invoice.view');
    Route::get('/billing/customer-invoice/{booking}/download', [BillingController::class, 'downloadCustomerInvoice'])->name('billing.customer-invoice.download');

    Route::get('bookings/{id}/details', [BookingController::class, 'details']);
    Route::post('bookings/search', [BookingController::class, 'search'])->name('booking.search');

    Route::post('/bookings/{booking}/upload-documents', [BookingController::class, 'uploadDocuments'])->name('doc.upload');
    Route::post('/bookings/update-status', [BookingController::class, 'updateStatus']);

    // Add route for getting questionnaire answers
    Route::get('/bookings/{booking}/questionnaire', [App\Http\Controllers\Professional\BookingController::class, 'getQuestionnaireAnswers'])->name('booking.questionnaire');

    // TEMPORARILY DISABLED - Additional Services routes
    /*
    Route::prefix('additional-services')->name('additional-services.')->group(function () {
        Route::get('/', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'show'])->name('show');
        Route::post('/{id}/mark-completed', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'markConsultationCompleted'])->name('mark-completed');
        Route::post('/{id}/set-delivery-date', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'setDeliveryDate'])->name('set-delivery-date');
        Route::post('/{id}/update-delivery-date', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'updateDeliveryDate'])->name('update-delivery-date');
        Route::post('/{id}/complete-consultation', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'completeConsultation'])->name('complete-consultation');
        Route::get('/get-bookings/ajax', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'getBookings'])->name('get-bookings');
        // Professional negotiation routes
        Route::post('/{id}/respond-negotiation', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'respondToNegotiation'])->name('respond-negotiation');
        Route::post('/{id}/update-price', [App\Http\Controllers\Professional\AdditionalServiceController::class, 'updatePrice'])->name('update-price');
    });
    */

    // Notification routes
    Route::post('/notifications/{notification}/mark-as-read', function ($notificationId) {
        $professional = Auth::guard('professional')->user();

        // Use DB query to find and update notification
        $updated = DB::table('notifications')
            ->where('id', $notificationId)
            ->where('notifiable_type', 'App\Models\Professional')
            ->where('notifiable_id', $professional->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($updated) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    })->name('notifications.mark-as-read');

    // Professional Events routes
    Route::resource('events', ProfessionalEventController::class);

    // Booking Chat Routes for Professional
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/booking/{bookingId}', [BookingChatController::class, 'openChat'])->name('open');
        Route::post('/booking/{bookingId}/send', [BookingChatController::class, 'sendMessage'])->name('send');
        Route::get('/booking/{bookingId}/messages', [BookingChatController::class, 'getMessages'])->name('messages');
        Route::get('/booking/{bookingId}/unread-count', [BookingChatController::class, 'getUnreadCount'])->name('unread');
        Route::get('/total-unread-count', [BookingChatController::class, 'getTotalUnreadCount'])->name('total-unread');
    });
});
