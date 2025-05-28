<?php
// app/Http/Controllers/ShowController.php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index(Request $request)
    {
        $query = Show::where('is_active', true)->withCount('episodes');

        // Filter by category if provided
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('author', 'LIKE', '%' . $request->search . '%');
            });
        }

        $shows = $query->latest()->paginate(12);

        return view('shows.index', compact('shows'));
    }

    public function show(Show $show)
    {
        $show->load(['categories', 'episodes' => function ($query) {
            $query->where('is_published', true)
                  ->with('favorites', 'comments')
                  ->latest('published_at');
        }]);

        $episodes = $show->episodes()->paginate(20);

        return view('shows.show', compact('show', 'episodes'));
    }
}