<?php


// routes/user.php

use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\LoginController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:user'])->group(function () {
    Route::get('dashboard', function () {
        return view('customer.index');
    })->name('dashboard');

    Route::get('/service/{id}/questions', [HomeController::class, 'getServiceQuestions'])->name('service.questions');

    Route::get('booking', function () {
        return view('customer.booking.booking');
    })->name('booking');
    Route::post('/booking/store', [HomeController::class, 'store'])->name('booking.store');


    Route::get('/booking/success', [HomeController::class, 'success'])->name('booking.success');
    Route::post('/booking/session-store', [HomeController::class, 'storeInSession'])->name('booking.session.store');
    // Add profile route
    Route::get('add-profile', function () {
        return view('customer.add-profile.index');
    })->name('add-profile');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});
