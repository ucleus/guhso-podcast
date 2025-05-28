<?php
// routes/api.php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShowController as ApiShowController;
use App\Http\Controllers\Api\EpisodeController as ApiEpisodeController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Authentication endpoints
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::put('/user', [AuthController::class, 'updateProfile']);
        
        // Favorites
        Route::get('/user/favorites', [FavoriteController::class, 'index']);
        Route::post('/episodes/{episode}/favorite', [FavoriteController::class, 'store']);
        Route::delete('/episodes/{episode}/favorite', [FavoriteController::class, 'destroy']);
        
        // Comments
        Route::post('/episodes/{episode}/comments', [CommentController::class, 'store']);
        Route::put('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    });
    
    // Public API endpoints
    Route::apiResource('shows', ApiShowController::class)->only(['index', 'show']);
    Route::get('/shows/{show}/episodes', [ApiShowController::class, 'episodes']);
    Route::apiResource('episodes', ApiEpisodeController::class)->only(['index', 'show']);
    Route::get('/episodes/{episode}/comments', [CommentController::class, 'index']);
    
    // Search
    Route::get('/search', [SearchController::class, 'api']);
});