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

    public function category()
    {
        return $this->belongsToMany(Categories::class,'story_category','story_id', 'category_id');
    }
    public function user(){
        return $this->belongsToMany(User::class,'user_story','story_id','user_id');
    }
    public function Author(){
        return $this->belongsTo(Author::class);
    }
//    public function Status(){
//        return $this->belongsTo(Status::class);
//    }
    public function Chapters(){
        return $this->hasMany(Chapters::class,'story_id');
    }
    public function categoryName( $value ) {
        return Categories::whereIn('id',json_decode( $value ))->get(['id','name']);
    }
}
