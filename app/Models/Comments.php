<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table='comments';
    protected $fillable=['contents', 'user_id', 'story_id', 'chapter_id', 'level_comment'];

}
