<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAddressCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|min:10',
            'house_number' => 'required|string|max:50',
            'building' => 'nullable|string|max:100',
            'street' => 'required|string|max:100',
            'sub_district' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:10',
            'detail_address' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'The customer ID is required.',
            'customer_id.integer' => 'The customer ID must be an integer.',
            'customer_id.exists' => 'The customer ID must exist in the customers table.',

            'name.required' => 'The receiver name is required.',
            'name.string' => 'The receiver name must be a string.',
            'name.max' => 'The receiver name may not be greater than 255 characters.',

            'phone_number.required' => 'The receiver phone number is required.',
            'phone_number.string' => 'The receiver phone number must be a string.',
            'phone_number.max' => 'The receiver phone number may not be greater than 20 characters.',
            'phone_number.min' => 'The receiver phone number must be at least 10 characters.',

            'house_number.required' => 'The house number is required.',
            'house_number.string' => 'The house number must be a string.',
            'house_number.max' => 'The house number may not be greater than 50 characters.',

            'building.string' => 'The building (room, floor, etc.) must be a string.',
            'building.max' => 'The building may not be greater than 100 characters.',

            'street.required' => 'The street is required.',
            'street.string' => 'The street must be a string.',
            'street.max' => 'The street may not be greater than 100 characters.',

            'sub_district.required' => 'The sub-district is required.',
            'sub_district.string' => 'The sub-district must be a string.',
            'sub_district.max' => 'The sub-district may not be greater than 100 characters.',

            'district.required' => 'The district is required.',
            'district.string' => 'The district must be a string.',
            'district.max' => 'The district may not be greater than 100 characters.',

            'province.required' => 'The province is required.',
            'province.string' => 'The province must be a string.',
            'province.max' => 'The province may not be greater than 100 characters.',

            'country.string' => 'The country must be a string.',
            'country.max' => 'The country may not be greater than 100 characters.',
            'country.in' => 'The country must be Thailand or nullable.',

            'postal_code.required' => 'The postal code is required.',
            'postal_code.string' => 'The postal code must be a string.',
            'postal_code.max' => 'The postal code may not be greater than 10 characters.',

            'detail_address.string' => 'The detail address must be a string.',
            'detail_address.max' => 'The detail address may not be greater than 255 characters.',
        ];
    }

}
