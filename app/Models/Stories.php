<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    use HasFactory;

    const STATUS_NEW = 0;
    const STATUS_UPDATE = 1;
    const STATUS_PENDING = 2;
    const STATUS_DONE = 3;
    const STATUS_DROP = 4;

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
        'start_date',
        'view_follow',
        'view_story',
        'view_like'
    ];

}
