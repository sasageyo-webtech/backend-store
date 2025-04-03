<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|min:4|max:20|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'gender' => 'required|in:MALE,FEMALE,OTHER',
            'password' => 'required|string|min:8|max:32|confirmed',
        ];
    }

    public function messages(): array {
        return [
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a valid string.',
            'username.min' => 'Username must be at least 4 characters.',
            'username.max' => 'Username must not exceed 20 characters.',
            'username.unique' => 'This username is already taken.',

            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'This email is already registered.',

            'firstname.required' => 'Firstname is required.',
            'firstname.string' => 'Firstname must be a valid string.',
            'firstname.max' => 'Firstname must not exceed 50 characters.',

            'lastname.required' => 'Lastname is required.',
            'lastname.string' => 'Lastname must be a valid string.',
            'lastname.max' => 'Lastname must not exceed 50 characters.',

            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either male, female, or other.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password must not exceed 32 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ];
    }
}
