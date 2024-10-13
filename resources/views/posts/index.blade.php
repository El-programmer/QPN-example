@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Posts</h1>

        <!-- Loop through posts -->
        @forelse($posts as $post)
            @include('posts.post-card')
        @empty
            <h3 class="text-center">No Posts Found</h3>
        @endforelse

    </div>
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('posts.add-replay') }}" class="add-replay">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">Reply to Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="comment_id" id="comment-id">
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="3" placeholder="Enter your reply"
                                      required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('js')

    <script>
        // Pass comment ID to the reply modal
        $(document).on('click', '.reply-btn', function () {
            var commentId = $(this).data('comment-id');
            $('#comment-id').val(commentId);
        });


        $(function () {

            $(document).on('submit', 'form.add-comment', function (e) {
                e.preventDefault(); // Prevent default form submission
                var submitButton = undefined;
                let submitButtonText = "";
                if (e.originalEvent) {
                    submitButton = e.originalEvent.submitter;
                    submitButtonText = $(submitButton).text();
                    $(submitButton).prop('disabled', true).text('...');

                }


                var form = $(this); // Get the form

                var method = form.attr('method') ? form.attr('method').toUpperCase() : 'GET';

                var formData = (method === 'POST') ? new FormData(this) : form.serialize();
                var that = $(this);
                sendForm(form, formData, submitButton, submitButtonText, (comment) => {
                    that.closest('.post-card').find('.comments-count').text(
                        parseInt(that.closest('.post-card').find('.comments-count').text() + 1)
                    );
                    form.reset();
                    let name = comment.user?.name ?? 'anonymous';
                    that.closest('.post-card').find('.post-comments').append(`
                            <div class="mb-2 comment">
                                <strong>${name}</strong>
<p class="w-100 message">${comment.comment}</p>
                                <div class="d-flex justify-content-center"><p>
                                <a class="reply-btn" data-bs-toggle="modal" data-bs-target="#replyModal" data-comment-id="${comment.id}">
                                        Reply
                                </a>
                                <p><span class="replies-count">0/ 5</span> replies
                                </p></div><div class="ps-3 comment-replies"></div></div>`)
                })
                // Perform AJAX request
            });
            $(document).on('submit', 'form.add-replay', function (e) {
                e.preventDefault(); // Prevent default form submission
                var submitButton = undefined;
                let submitButtonText = "";
                if (e.originalEvent) {
                    submitButton = e.originalEvent.submitter;
                    submitButtonText = $(submitButton).text();
                    $(submitButton).prop('disabled', true).text('...');
                }

                var form = $(this); // Get the form
                var method = form.attr('method') ? form.attr('method').toUpperCase() : 'GET';
                var formData = (method === 'POST') ? new FormData(this) : form.serialize();
                sendForm(form, formData, submitButton, submitButtonText, (comment) => {
                    let commentCard = $('.reply-btn[data-comment-id="' + comment.comment_id + '"]').closest('.comment-card');
                    let replaysCount = parseInt($(commentCard).find('.replies-count').text());
                    $(commentCard).find('.replies-count').text(
                        replaysCount + 1
                    );
                    if (replaysCount >= 5)
                        $(commentCard).find('.reply-btn').remove();
                    let name = comment.user?.name ?? 'anonymous';
                    $(commentCard).find('.comment-replies').append(`
                        <div class="mb-1 comment">
                            <strong>${name}</strong>
                            <div class="message">${comment.comment}</div>
                    </div>`)
                    $("#replyModal").modal("hide")
                })
                // Perform AJAX request
            });
        });
    </script>
@endpush
