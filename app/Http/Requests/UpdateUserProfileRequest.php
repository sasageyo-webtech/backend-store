<?php

namespace App\Http\Requests;

use App\Models\Enums\GenderType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in([GenderType::FEMALE, GenderType::MALE, GenderType::OTHER])],
            'citizen_code' => [
                'nullable',
                'string',
                'size:13',
                Rule::unique('users', 'citizen_code')->ignore($this->user->id)
            ],
            'birthdate' => ['nullable', 'date'],
            'phone_number' => [
                'nullable',
                'string',
                'regex:/^0[0-9]{9}$/', // ตรวจสอบว่าเป็นเบอร์โทรแบบไทย (10 หลัก)
                Rule::unique('users', 'phone_number')->ignore($this->user->id)
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'firstname.required' => 'Please enter your first name.',
            'firstname.string' => 'First name must be a valid text.',
            'firstname.max' => 'First name must not exceed 255 characters.',

            'lastname.required' => 'Please enter your last name.',
            'lastname.string' => 'Last name must be a valid text.',
            'lastname.max' => 'Last name must not exceed 255 characters.',

            'gender.required' => 'Please select your gender.',
            'gender.in' => 'Gender must be either male, female, or other.',

            'citizen_code.string' => 'Citizen code must be a valid string.',
            'citizen_code.size' => 'Citizen code must be exactly 13 digits.',
            'citizen_code.unique' => 'This citizen code is already in use.',

            'birthdate.date' => 'Birthdate must be a valid date format (YYYY-MM-DD).',

            'phone_number.string' => 'Phone number must be a valid text.',
            'phone_number.regex' => 'Phone number must be 10 digits and start with 0.',
            'phone_number.unique' => 'This phone number is already in use.',
        ];
    }

}
