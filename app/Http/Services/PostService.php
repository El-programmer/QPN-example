<?php

namespace App\Http\Services;

use App\Models\Comment;
use App\Models\Post;

class PostService
{

    function addComment(Post $post , $inputs){
        $inputs['user_id'] = auth()->id();
        $comment = $post->comments()->create($inputs);
        return $comment;
    }
    function addReplay(Comment $comment , $inputs){
        $inputs['user_id'] = auth()->id();
        $inputs['post_id'] = $comment->post_id;
        $inputs['comment_id'] = $comment->id;
        $comment = $comment->replies()->create($inputs);
//        dd($comment);
        return $comment;
    }
}
