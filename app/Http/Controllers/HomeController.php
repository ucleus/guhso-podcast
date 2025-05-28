<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Episode;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured shows and latest episodes for homepage
        $featuredShows = Show::where('is_active', true)
            ->withCount('episodes')
            ->with('categories', 'episodes.favorites')
            ->latest()
            ->take(6)
            ->get();

        $latestEpisodes = Episode::where('is_published', true)
            ->with(['show', 'favorites'])
            ->latest('published_at')
            ->take(10)
            ->get();

        $categories = Category::withCount('shows')->get();

        return view('home', compact('featuredShows', 'latestEpisodes', 'categories'));
    }

    public function podcast()
    {
        // Podcast listing page
        $shows = Show::where('is_active', true)
            ->withCount('episodes')
            ->with('categories')
            ->paginate(12);

        $categories = Category::withCount('shows')->get();

        return view('podcast', compact('shows', 'categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}