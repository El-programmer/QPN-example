<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'post_id' =>  [
                'required',
                'exists:posts,id',
                function ($attribute, $value, $fail) {
                    $post = Post::find($value);

                    if ($post && $post->comments()->count() >= 5) {
                        $fail('This post already has 5 comments.');
                    }
                }
            ],
            'comment'=>'required|string|min:3',
        ];
    }
}
