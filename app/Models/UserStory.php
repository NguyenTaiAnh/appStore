<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
    protected $table="user_story";
    protected $fillable=[
        'id',
        'user_id',
        'story_id',
    ];
    public function story(){
        return $this->belongsTo(Stories::class);
    }
}
