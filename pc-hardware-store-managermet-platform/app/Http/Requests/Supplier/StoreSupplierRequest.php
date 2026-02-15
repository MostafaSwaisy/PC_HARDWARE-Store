<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:suppliers,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'payment_terms' => ['nullable', 'string', 'max:255'],
            'average_delivery_days' => ['nullable', 'integer', 'min:0'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
        ];
    }
}
