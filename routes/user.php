<?php


// routes/user.php

use App\Http\Controllers\frontend\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:user'])->group(function () {
    Route::get('dashboard', function () {
        return view('customer.index');
    })->name('dashboard');

    // Add profile route
    Route::get('add-profile', function () {
        return view('customer.add-profile.index');
    })->name('add-profile');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});
