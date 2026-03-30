<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewHistory extends Model
{
    protected $fillable = ['user_id', 'story_id'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
