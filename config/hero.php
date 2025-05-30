<?php

// Create this file: config/hero.php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Hero Section Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your hero section appearance and behavior
    |
    */
    
    'background' => [
        
        // Set to 'image', 'gradient', or 'auto'
        'type' => env('HERO_BACKGROUND_TYPE', 'auto'),
        
        // Hero background images (used when type is 'image' or 'auto')
        'images' => [
            'default' => env('HERO_IMAGE_DEFAULT', 'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'),
            
            'podcast_studio' => 'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'microphone' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'headphones' => 'https://images.unsplash.com/photo-1504270997636-07ddfbd48945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'recording' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
        ],
        
        // Gradient colors (used when type is 'gradient' or as fallback)
        'gradient' => [
            'from' => 'amber-400',
            'via' => 'orange-400', 
            'to' => 'red-400'
        ]
    ],
    
    // Auto-rotate images daily
    'rotate_daily' => env('HERO_ROTATE_DAILY', true),
    
];