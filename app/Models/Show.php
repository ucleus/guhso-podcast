<?php
// app/Models/Show.php (Laravel 10)

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
        'author',
        'email',
        'website',
        'rss_feed',
        'artwork_url',
        'language',
        'is_active',
        'category_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Helper methods
    public function getLatestEpisode()
    {
        return $this->episodes()
            ->where('is_published', true)
            ->latest('published_at')
            ->first();
    }

    public function getEpisodesCount(): int
    {
        return $this->episodes()->where('is_published', true)->count();
    }

    // Scout searchable configuration
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
        ];
    }
}