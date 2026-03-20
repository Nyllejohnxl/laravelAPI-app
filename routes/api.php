<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProtocolController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoteController;
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

// Public API routes for discussions (no auth required)
Route::middleware([CorsMiddleware::class])->group(function () {
    // Protocols
    Route::get('/protocols', [ProtocolController::class, 'index']);
    Route::get('/protocols/{id}', [ProtocolController::class, 'show']);
    Route::get('/protocols/status/{status}', [ProtocolController::class, 'getByStatus']);
    
    // Threads
    Route::get('/threads', [ThreadController::class, 'index']);
    Route::get('/threads/{id}', [ThreadController::class, 'show']);
    Route::get('/protocols/{protocolId}/threads', [ThreadController::class, 'getByProtocol']);
    
    // Comments (read-only)
    Route::get('/threads/{threadId}/comments', [CommentController::class, 'getByThread']);
});

// Protected routes for creating comments and votes
Route::middleware(['auth:sanctum', CorsMiddleware::class])->group(function () {
    // Comments
    Route::post('/threads/{threadId}/comments', [CommentController::class, 'store']);
    
    // Votes
    Route::post('/comments/{commentId}/vote', [VoteController::class, 'store']);
    Route::delete('/votes/{voteId}', [VoteController::class, 'destroy']);
});