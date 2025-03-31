<?php

namespace App\Http\Requests;

use App\Models\Enums\OrderStatus;
use App\Models\Enums\ProductAccessibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                OrderStatus::PENDING,
                OrderStatus::APPROVED,
                OrderStatus::DELIVERED,
                OrderStatus::FAIL,
                OrderStatus::SUCCEED,
            ])],
        ];
    }

    public function messages(): array {
        return [
            'status.required' => 'Status is required.',
            'status.in' => "The valid values for status are PENDING, APPROVED, DELIVERED, FAIL, SUCCEED",
        ];
    }
}
