<?php
// app/Models/User.php (Laravel 10/11 version)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'language_pref',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ===========================
    // RELATIONSHIPS
    // ===========================
    
    /**
     * Get all favorites for this user.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get all comments by this user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get episodes that this user has favorited.
     */
    public function favoriteEpisodes()
    {
        return $this->belongsToMany(Episode::class, 'favorites');
    }

    // ===========================
    // HELPER METHODS
    // ===========================
    
    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has favorited a specific episode.
     */
    public function hasFavorited(Episode $episode): bool
    {
        return $this->favorites()->where('episode_id', $episode->id)->exists();
    }

    /**
     * Check if user has favorited an episode by ID.
     */
    public function hasFavoritedEpisode($episodeId): bool
    {
        return $this->favorites()->where('episode_id', $episodeId)->exists();
    }

    /**
     * Get user's preferred language.
     */
    public function getPreferredLanguage(): string
    {
        return $this->language_pref ?? 'en';
    }

    /**
     * Get user's initials for avatar display.
     */
    public function getInitials(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        
        return substr($initials, 0, 2); // Limit to 2 characters
    }
}