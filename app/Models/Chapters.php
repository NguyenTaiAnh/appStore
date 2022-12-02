<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapters extends Model
{
    use HasFactory;
    protected $table = 'chapters';
    protected $fillable = ['name', 'content','file_content' ,'story_id','comment_id'];

    public function story(){
        return $this->belongsTo(stories::class);
    }

}
