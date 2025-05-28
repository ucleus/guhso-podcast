<?php
// app/Models/Episode.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Episode extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'show_id',
        'title',
        'description',
        'audio_url',
        'duration',
        'published_at',
        'guid',
        'thumbnail_url',
        'is_manual',
        'episode_number',
        'season_number',
        'file_size',
        'mime_type',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_manual' => 'boolean',
            'is_published' => 'boolean',
            'file_size' => 'integer',
        ];
    }

    // Relationships
    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // Scout searchable configuration
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'show_title' => $this->show->title ?? '',
            'published_at' => $this->published_at?->timestamp,
        ];
    }

    // Helper methods that are called in the controller
    public function getFormattedDuration(): string
    {
        if (!$this->duration) {
            return 'Unknown';
        }

        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function getFormattedFileSize(): string
    {
        if (!$this->file_size) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 1) . ' ' . $units[$unit];
    }

    public function getFavoritesCount(): int
    {
        return $this->favorites()->count();
    }

    public function getCommentsCount(): int
    {
        return $this->comments()->count();
    }

    // Additional helper method to check if a specific user has favorited this episode
    public function isFavoritedBy(User $user): bool
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}