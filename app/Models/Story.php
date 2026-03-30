<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'cover_path',
        'drive_file_id',
        'youtube_url',
        'views',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class)->orderBy('episode_number', 'asc');
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->youtube_url) return null;
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_url, $matches);
        return isset($matches[1]) ? "https://www.youtube.com/embed/" . $matches[1] : null;
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->avg('rating'), 1);
    }

    public function getUserRatingAttribute()
    {
        if (auth()->check()) {
            return $this->ratings()->where('user_id', auth()->id())->value('rating');
        }
        return null;
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class)->latest();
    }
}
