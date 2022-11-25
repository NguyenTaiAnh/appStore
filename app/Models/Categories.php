<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $primaryKey = 'id';

    protected $fillable=['name','description'];
    public function story()
    {
        return $this->belongsToMany(Stories::class, 'story_category', 'category_id', 'story_id');//not available story_id
    }
}
