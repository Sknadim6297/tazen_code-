<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::resource('banner', BannerController::class);
Route::resource('service', ServiceController::class);
