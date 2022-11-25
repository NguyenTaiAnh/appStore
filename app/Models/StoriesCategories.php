<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoriesCategories extends Model
{
    use HasFactory;
    protected $table = 'stories_categories';
    protected $fillable=['id','category_id','story_id'];

    public function story()
    {
        return $this->belongsTo(Stories::class, 'story_id');
    }
}
