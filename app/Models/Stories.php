<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    use HasFactory;
    protected $table='stories';
    protected $fillable=[
        'name',
        'another_name',
        'description',
        'image',
        'category_id',
        'author_id',
        'comment_id',
        'rate',
        'status',
        'view_follow',
        'view_story',
        'view_like'
    ];
}
