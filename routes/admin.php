<?php

use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::resource('banner', BannerController::class);
