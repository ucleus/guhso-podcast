<?php
// app/Http/Controllers/EpisodeController.php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EpisodeController extends Controller
{
    public function show(Episode $episode)
    {
        // Load relationships to avoid N+1 queries
        $episode->load([
            'show',
            'comments.user',
            'favorites'
        ]);

        // Get related episodes from the same show
        $relatedEpisodes = Episode::where('show_id', $episode->show_id)
            ->where('id', '!=', $episode->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('episodes.show', compact('episode', 'relatedEpisodes'));
    }

    public function favorite(Request $request, Episode $episode)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Authentication required'], 401);
            }
            return redirect()->route('login')->with('message', 'Please login to favorite episodes.');
        }

        $user = Auth::user();
        
        // Toggle favorite status
        if ($user->hasFavorited($episode)) {
            // Remove from favorites
            $user->favorites()->where('episode_id', $episode->id)->delete();
            $favorited = false;
            $message = 'Episode unfavorited!';
        } else {
            // Add to favorites
            $user->favorites()->create(['episode_id' => $episode->id]);
            $favorited = true;
            $message = 'Episode favorited!';
        }

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'favorited' => $favorited,
                'count' => $episode->getFavoritesCount()
            ]);
        }

        // Return with success message for regular requests
        return back()->with('success', $message);
    }

    public function comment(Request $request, Episode $episode)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to comment.');
        }

        // Create the comment
        Comment::create([
            'user_id' => Auth::id(),
            'episode_id' => $episode->id,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_approved' => true, // Auto-approve for now, can be changed later
        ]);

        return back()->with('success', 'Comment posted successfully!');
    }
}