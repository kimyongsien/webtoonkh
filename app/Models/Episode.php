<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = [
        'story_id',
        'title',
        'episode_number',
        'drive_file_id',
        'youtube_url',
        'views'
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
