<?php

use App\Http\Controllers\Api\v1\AuthController as v1AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('register', [v1AuthController::class, 'register']);
    Route::post('login', [v1AuthController::class, 'login']);
    
    // Routes that require authentication
    Route::middleware(['auth:api'])->group(function () {
        Route::get('profile', [v1AuthController::class, 'profile']);
        Route::get('refresh', [v1AuthController::class, 'refresh']);
        Route::post('logout', [v1AuthController::class, 'logout']);
    });
});
