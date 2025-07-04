<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::apiResource('services', \App\Http\Controllers\Api\ServiceController::class);
        Route::get('appointments', [\App\Http\Controllers\Api\AppointmentController::class, 'index']);
    });
    
    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});

// Public routes
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::get('services', [\App\Http\Controllers\Api\ServiceController::class, 'index']);
Route::get('services/{service}', [\App\Http\Controllers\Api\ServiceController::class, 'show']);
Route::get('appointments/available-slots', [\App\Http\Controllers\Api\AppointmentController::class, 'availableSlots']);
Route::post('appointments', [\App\Http\Controllers\Api\AppointmentController::class, 'store']);