<?php

use App\Http\Controllers\frontend\AuthController;
use App\Http\Controllers\Professional\AuthController as ProfessionalAuthController;
use App\Http\Controllers\Professional\AvailabilityController;
use App\Http\Controllers\Professional\BillingController;
use App\Http\Controllers\Professional\BookingController;
use App\Http\Controllers\Professional\ProfessionalController;
use App\Http\Controllers\Professional\ProfileController;
use App\Http\Controllers\Professional\RateController;
use App\Http\Controllers\Professional\RequestedServiceController;
use App\Http\Controllers\Professional\ServiceController;
use App\Http\Controllers\Professional\ReRequestedServiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Routes accessible for authenticated professionals regardless of status
Route::middleware(['auth:professional'])->group(function () {
    Route::get('rejected', [ProfessionalController::class, 'rejectedPage'])->name('rejected.view');
    Route::post('/re-submit', [ProfessionalController::class, 'reSubmit'])->name('register.re-submit');
    Route::get('/pending', [ProfessionalController::class, 'pendingPage'])->name('pending.view');
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
        
        // For professional dashboard, we don't show reschedule notifications (they're only in notification icon)
        // Only get unread notifications for notification icon count, but don't pass reschedule notifications to view
        
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
    
    // Re-requested Service Routes
    Route::prefix('re-requested-service')->name('re-requested-service.')->group(function () {
        Route::get('/', [ReRequestedServiceController::class, 'index'])->name('index');
        Route::get('/create', [ReRequestedServiceController::class, 'create'])->name('create');
        Route::post('/', [ReRequestedServiceController::class, 'store'])->name('store');
        Route::get('/{id}', [ReRequestedServiceController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ReRequestedServiceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ReRequestedServiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [ReRequestedServiceController::class, 'destroy'])->name('destroy');
    });

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

});
