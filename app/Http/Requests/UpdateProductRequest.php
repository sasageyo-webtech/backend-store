<?php

namespace App\Http\Requests;

use App\Models\Enums\ProductAccessibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'brand_id' => ['sometimes', 'required', 'exists:brands,id'],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')
                    ->where(fn ($query) => $query->where('brand_id', $this->brand_id))
                    ->ignore($this->route('product_id')),
            ],
            'description' => ['sometimes', 'nullable', 'string'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'accessibility' => ['sometimes', 'required', Rule::in([ProductAccessibility::PUBLIC, ProductAccessibility::PRIVATE])],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a product category.',
            'category_id.exists' => 'The selected category does not exist in the system.',
            'brand_id.required' => 'Please select a product brand.',
            'brand_id.exists' => 'The selected brand does not exist in the system.',
            'name.required' => 'Please enter the product name.',
            'name.unique' => 'This product name already exists.',
            'price.required' => 'Please enter the product price.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be greater than or equal to 0.',
            'accessibility.required' => 'Please specify the product accessibility status.',
            'accessibility.in' => 'The valid values for accessibility are PUBLIC or PRIVATE.',
        ];
    }
}
