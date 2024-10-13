<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\ReplayCommentRequest;
use App\Http\Services\PostService;
use App\Models\Comment;
use App\Models\Post;

class PostController extends Controller
{

    public function __construct(
        public PostService $service
    )
    {
    }

    public function index()
    {
        $posts = Post::withCount('comments')->with(['comments' => function ($query) {
            $query->latest()->take(5);
        },'comments.replies'])->paginate(10);
        return view('posts.index' , compact('posts'));
    }
    public function show(Post $post)
    {
        return view('posts.show' , compact('post'));
    }

    public function addComment(Post $post , CommentRequest $request)
    {
        $comment= $this->service->addComment($post , $request->validated());
        return response()->json($comment);
    }
    public function addReplay(ReplayCommentRequest $request)
    {
        $comment = Comment::find($request->comment_id);
        $comment = $this->service->addReplay($comment , $request->validated());
        return response()->json($comment);
    }

}
