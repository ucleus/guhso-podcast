<?php
// app/Models/Show.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Show extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'description',
        'cover_image_url',
        'rss_feed_url',
        'language',
        'author',
        'website',
        'is_active',
        'last_fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_fetched_at' => 'datetime',
        ];
    }

    // Relationships
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function publishedEpisodes()
    {
        return $this->episodes()->where('is_published', true)->orderBy('published_at', 'desc');
    }

    // Scout searchable configuration
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'language' => $this->language,
        ];
    }

    // Helper methods
    public function isRssFeed(): bool
    {
        return !is_null($this->rss_feed_url);
    }

    public function getLatestEpisode()
    {
        return $this->publishedEpisodes()->first();
    }

    public function getEpisodeCount(): int
    {
        return $this->publishedEpisodes()->count();
    }
}