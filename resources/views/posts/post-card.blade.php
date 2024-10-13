<div class="card mb-4 post-card">
    <div class="card-header">
        <h5>{{ $post->title }}</h5>
    </div>
    <div class="card-body">
        <p>{{ $post->content }}</p>

<div class="d-flex justify-content-between">
    <!-- Button to toggle comments -->
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseComments-{{ $post->id }}" aria-expanded="false"
            aria-controls="collapseComments-{{ $post->id }}">
        View Comments
        <strong class="comments-count">({{ $post->comments_count }}) </strong>
    </button>
{{--    <a class="btn btn-info">show</a>--}}

</div>
        <!-- Add Comment Form -->
        <div class="mt-3">
            <h6>Add a Comment</h6>
            <form method="POST" class="add-comment" action="{{ route('posts.add-comment',$post) }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="input-group mb-3">
                    <input type="text" name="comment" class="form-control" placeholder="Enter your comment"
                           required>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>

        <!-- Collapsible Comments Section -->
        <div class="collapse mt-3 post-comments" id="collapseComments-{{ $post->id }}">
            <h6>Comments</h6>
            @foreach ($post->comments as $comment)
                <div class="mb-2 comment comment-card">
                    <strong>{{ $comment->user->name??'anonymous' }}</strong>
                    <p class="w-100 message">
                        {{ $comment->comment }}
                    </p>
                    <div class="d-flex justify-content-center">

                        <p>
                            @if($comment->replies->count() < 5)

                                <a class="reply-btn" data-bs-toggle="modal"
                                   data-bs-target="#replyModal" data-comment-id="{{ $comment->id }}">Reply
                                </a>
                        <p>
                                        <span class="replies-count">
                                            {{$comment->replies->count()}}/ 5
                                        </span>
                            replies
                        </p>
                        @else
                            <p>max replies</p>
                            @endif
                            </p>
                    </div>


                    <!-- Display Replies -->
                    <div class="ps-3 comment-replies">
                        @foreach ($comment->replies as $reply)
                            <div class="mb-1 comment">
                                <strong>{{ $reply->user->name??'anonymous' }}</strong>
                                <div class="message">

                                    {{ $reply->comment }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
