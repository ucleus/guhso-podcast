<?php
// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'episode_id',
        'content',
        'rating',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'rating' => 'integer',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }

    // Helper methods
    public function hasRating(): bool
    {
        return !is_null($this->rating);
    }

    public function getStarRating(): string
    {
        if (!$this->hasRating()) {
            return '';
        }

        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}