<?php
// app/Http/Controllers/SearchController.php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Episode;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $shows = collect();
        $episodes = collect();

        if (!empty($query)) {
            // Search shows using Scout (or database)
            if (config('scout.driver') === 'database') {
                $shows = Show::where('is_active', true)
                    ->where(function ($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%")
                          ->orWhere('author', 'LIKE', "%{$query}%");
                    })
                    ->with('categories')
                    ->take(10)
                    ->get();

                $episodes = Episode::where('is_published', true)
                    ->where(function ($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%");
                    })
                    ->with('show')
                    ->latest('published_at')
                    ->take(20)
                    ->get();
            } else {
                // Use Scout search when configured
                $shows = Show::search($query)->take(10)->get();
                $episodes = Episode::search($query)->take(20)->get();
            }
        }

        return view('search.results', compact('query', 'shows', 'episodes'));
    }
}