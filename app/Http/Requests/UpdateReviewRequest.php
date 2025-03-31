<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => 'sometimes|nullable|string|max:500',
            'rating' => 'sometimes|required|integer|min:0|max:5',
        ];
    }

    public function messages(): array {
        return [
            'comment.string' => 'The comment must be a valid text.',
            'comment.max' => 'The comment must not exceed 500 characters.',

            'rating.required' => 'The rating is required.',
            'rating.integer' => 'The rating must be a number between 0-5.',
            'rating.min' => 'The rating must be at least 0.',
            'rating.max' => 'The rating must be at most 5.',
        ];
    }
}
