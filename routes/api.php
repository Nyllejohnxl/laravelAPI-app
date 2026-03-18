<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\CorsMiddleware;

// Test endpoint
Route::get('/test', function () {
    return response()->json([
        'message' => 'Connected to Laravel API',
        'status' => 'success'
    ]);
});

// Public auth routes with CORS middleware
Route::middleware([CorsMiddleware::class])->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
});

// Protected auth routes with CORS middleware
Route::middleware(['auth:sanctum', CorsMiddleware::class])->group(function () {
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});