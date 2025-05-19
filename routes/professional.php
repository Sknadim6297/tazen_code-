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
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:professional'])->group(function () {
    Route::get('dashboard', function () {
        return view('professional.index');
    })->name('dashboard');

    Route::resource('profile', ProfileController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('rate', RateController::class);
    Route::resource('availability', AvailabilityController::class);
    Route::resource('booking', BookingController::class);
    Route::resource('billing', BillingController::class);
    Route::resource('requested_services', RequestedServiceController::class);
    Route::get('rejected', [ProfessionalController::class, 'rejectedPage'])->name('rejected.view');
    Route::post('/re-submit', [ProfessionalController::class, 'reSubmit'])->name('register.re-submit');
    Route::get('/pending', [ProfessionalController::class, 'pendingPage'])->name('pending.view');

    Route::get('bookings/{id}/details', [BookingController::class, 'details']);
    Route::post('bookings/search', [BookingController::class, 'search'])->name('booking.search');

    Route::post('/bookings/{booking}/upload-documents', [BookingController::class, 'uploadDocuments'])->name('doc.upload');
    Route::post('/bookings/update-status', [BookingController::class, 'updateStatus']);

   
});
