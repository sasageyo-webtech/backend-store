<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCartRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'amount' => 'required|integer|min:1',
        ];
    }
    public function messages(): array {
        return [
            'customer_id.required' => 'The customer ID is required.',
            'customer_id.integer' => 'The customer ID must be an integer.',
            'customer_id.exists' => 'The selected customer ID is not found.',
            'product_id.required' => 'The product ID is required.',
            'product_id.integer' => 'The product ID must be an integer.',
            'product_id.exists' => 'The selected product ID is not found    .',
            'amount.required' => 'The amount is required.',
            'amount.integer' => 'The amount must be an integer.',
            'amount.min' => 'The amount must be at least 1.',
        ];
    }
}
