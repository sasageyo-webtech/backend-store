<?php

namespace App\Http\Requests;

use App\Models\Enums\ProductAccessibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255',
                Rule::unique('products', 'name')
                    ->where(fn ($query) => $query->where('brand_id', $this->brand_id))
                    ->ignore($this->product)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array {
        return [
            'category_id.required' => 'Please select a product category.',
            'category_id.exists' => 'The selected category does not exist in the system.',
            'brand_id.required' => 'Please select a product brand.',
            'brand_id.exists' => 'The selected brand does not exist in the system.',
            'name.required' => 'Please enter the product name.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name must not exceed 255 characters.',
            'name.unique' => 'This product name has already been used for this brand.',
            'description.string' => 'The product description must be a string.',
            'price.required' => 'Please enter the product price.',
            'price.numeric' => 'The product price must be a number.',
            'price.min' => 'The product price must be greater than or equal to 0.',
        ];

    }
}
