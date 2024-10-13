<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable =[
        'post_id' , 'comment','comment_id'
    ];
    protected $with = ['user'];
    public function user()
    {
        return $this->belongsTo(User::class)->select('id','name');
    }
    public function replies()
    {
        return $this->hasMany(Comment::class , 'comment_id');
    }
}
