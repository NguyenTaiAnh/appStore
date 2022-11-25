<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $table='author';
    protected $fillable=['name','user_id'];

    public function story(){
        return $this->hasMany(Stories::class);
    }
}
