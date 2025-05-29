<?php
// app/Models/Category.php (Laravel 10)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // Relationships
    public function shows()
    {
        return $this->belongsToMany(Show::class, 'show_category');
    }

    // Helper methods
    public function getShowsCount(): int
    {
        return $this->shows()->where('is_active', true)->count();
    }
}