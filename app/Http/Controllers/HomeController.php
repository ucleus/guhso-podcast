<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Episode;
use App\Models\Show;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get the latest episode for the hero section
        $latestEpisode = Episode::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->first();

        // Get featured show (you can add a 'featured' column to shows table later)
        // For now, get the show with most episodes or most recent
        $featuredShow = Show::where('is_active', true)
            ->withCount('episodes')
            ->orderBy('episodes_count', 'desc')
            ->first();

        // Get categories with show counts
        $categories = Category::withCount('shows')
            ->orderBy('shows_count', 'desc')
            ->limit(6)
            ->get();

        // Get recent episodes for the slider (9 episodes to show 3 sets of 3)
        $recentEpisodes = Episode::where('is_published', true)
            ->with(['show'])
            ->orderBy('published_at', 'desc')
            ->limit(9)
            ->get();

        // Get hero image for the background
        $heroImage = $this->getHeroImage();

        return view('home', compact(
            'latestEpisode',
            'featuredShow', 
            'categories',
            'recentEpisodes',
            'heroImage'  // Added hero image variable
        ));
    }

    /**
     * Get the hero image for the background
     * You can customize this method to suit your needs
     */
    private function getHeroImage()
    {
        // Hero Image Options - Choose one of these approaches:
        
        // Option 1: Use a specific image URL
        $heroImage = 'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80';
        
        // Option 2: Use the featured episode's thumbnail (if available)
        // $latestEpisode = Episode::where('is_published', true)->orderBy('published_at', 'desc')->first();
        // $heroImage = $latestEpisode?->thumbnail_url;
        
        // Option 3: Use featured show's cover image
        // $featuredShow = Show::where('is_active', true)->withCount('episodes')->orderBy('episodes_count', 'desc')->first();
        // $heroImage = $featuredShow?->cover_image_url;
        
        // Option 4: No image (will use gradient fallback)
        // $heroImage = null;
        
        // Option 5: Randomly choose from a collection
        // $heroImages = [
        //     'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?auto=format&fit=crop&w=2070&q=80',
        //     'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=2070&q=80',
        //     'https://images.unsplash.com/photo-1504270997636-07ddfbd48945?auto=format&fit=crop&w=2070&q=80'
        // ];
        // $heroImage = $heroImages[array_rand($heroImages)];

        return $heroImage;
    }

    /**
     * Alternative method to manage hero images with more options
     * You could store hero images in a config file, database, or admin panel
     */
    private function getHeroImageAdvanced()
    {
        $heroOptions = [
            'podcast_studio' => 'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?auto=format&fit=crop&w=2070&q=80',
            'microphone' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=2070&q=80',
            'headphones' => 'https://images.unsplash.com/photo-1504270997636-07ddfbd48945?auto=format&fit=crop&w=2070&q=80',
            'recording' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&w=2070&q=80'
        ];
        
        // Return a specific one, random one, or null for gradient
        return $heroOptions['podcast_studio'] ?? null;
    }

    /**
     * Get hero image based on time of day or other logic
     */
    private function getDynamicHeroImage()
    {
        $hour = date('H');
        
        if ($hour >= 6 && $hour < 12) {
            // Morning - bright studio
            return 'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?auto=format&fit=crop&w=2070&q=80';
        } elseif ($hour >= 12 && $hour < 18) {
            // Afternoon - microphone focus
            return 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=2070&q=80';
        } else {
            // Evening/Night - cozy headphones
            return 'https://images.unsplash.com/photo-1504270997636-07ddfbd48945?auto=format&fit=crop&w=2070&q=80';
        }
    }
}