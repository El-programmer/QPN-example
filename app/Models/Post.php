<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable =[
        'post_id' , 'title','user_id'
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('comment_id');
    }

}
