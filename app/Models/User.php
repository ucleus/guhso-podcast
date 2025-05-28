<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'language_pref',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELATIONSHIPS - These were missing and causing the errors
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favoriteEpisodes()
    {
        return $this->belongsToMany(Episode::class, 'favorites');
    }

    // HELPER METHODS - These were missing and causing the undefined method errors
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasFavorited(Episode $episode): bool
    {
        return $this->favorites()->where('episode_id', $episode->id)->exists();
    }

    // Additional helper method for checking if user favorited by episode ID
    public function hasFavoritedEpisode($episodeId): bool
    {
        return $this->favorites()->where('episode_id', $episodeId)->exists();
    }
}