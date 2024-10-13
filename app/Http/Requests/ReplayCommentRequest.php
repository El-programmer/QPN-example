<?php

namespace App\Http\Requests;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class ReplayCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment_id' => [
                'required',
                'exists:comments,id',
                function ($attribute, $value, $fail) {
                    $comment = Comment::withCount('replies')->find($value);
                    if (!$comment)
                        $fail('This comment not exists');
                    if ($comment && $comment->replies_count >= 5) {
                        $fail('This post already has 5 comments.');
                    }
                }],
            'comment' => 'required|string|min:3',
        ];
    }
}
