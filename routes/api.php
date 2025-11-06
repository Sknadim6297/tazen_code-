<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfessionalAvailabilityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Professional Availability API routes for frontend booking
Route::prefix('professional/{professionalId}')->group(function () {
    Route::get('/availability', [ProfessionalAvailabilityController::class, 'getAvailability']);
    Route::get('/available-dates', [ProfessionalAvailabilityController::class, 'getAvailableDates']);
    Route::get('/available-slots', [ProfessionalAvailabilityController::class, 'getAvailableSlots']);
});
