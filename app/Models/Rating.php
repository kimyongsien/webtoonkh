<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['user_id', 'story_id', 'rating'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
