<?php
// routes/admin.php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShowController as AdminShowController;
use App\Http\Controllers\Admin\EpisodeController as AdminEpisodeController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Shows management
    Route::apiResource('shows', AdminShowController::class);
    
    // Episodes management
    Route::apiResource('episodes', AdminEpisodeController::class);
    
    // Comments moderation
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
});