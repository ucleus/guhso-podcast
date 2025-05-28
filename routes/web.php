<?php
require __DIR__.'/admin.php';

// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/podcast', [HomeController::class, 'podcast'])->name('podcast');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Shows
Route::get('/shows', [ShowController::class, 'index'])->name('shows.index');
Route::get('/shows/{show}', [ShowController::class, 'show'])->name('shows.show');

// Episodes
Route::get('/episodes/{episode}', [EpisodeController::class, 'show'])->name('episodes.show');

// Episode interactions (requires auth)
Route::middleware('auth')->group(function () {
    Route::post('/episodes/{episode}/favorite', [EpisodeController::class, 'favorite'])->name('episodes.favorite');
    Route::post('/episodes/{episode}/comment', [EpisodeController::class, 'comment'])->name('episodes.comment');
});

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Authentication routes
Auth::routes();
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
