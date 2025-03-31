<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'address_customer_id' => 'required|integer|exists:address_customers,id',
            'image_receipt_path' => 'required|image|mimes:jpg,jpeg,png|max:2048', // ตรวจสอบไฟล์ภาพ
        ];
    }

    public function messages(): array {
        return [
            'customer_id.required' => 'Customer ID is required.',
            'customer_id.integer' => 'Customer ID must be an integer.',
            'customer_id.exists' => 'The specified Customer ID does not exist.',
            'address_customer_id.required' => 'Address Customer ID is required.',
            'address_customer_id.integer' => 'Address Customer ID must be an integer.',
            'address_customer_id.exists' => 'The specified Address Customer ID does not exist.',
            'image_receipt_path.required' => 'An image receipt is required.',
            'image_receipt_path.image' => 'The receipt must be an image.',
            'image_receipt_path.mimes' => 'The receipt must be a file of type: jpg, jpeg, png.',
            'image_receipt_path.max' => 'The receipt image must not be larger than 2MB.',
        ];
    }
}
