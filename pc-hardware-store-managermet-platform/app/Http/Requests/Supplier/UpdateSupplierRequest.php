<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplierId = (int) $this->route('supplier');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'contact_person' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255', Rule::unique('suppliers', 'email')->ignore($supplierId)],
            'phone' => ['sometimes', 'nullable', 'string', 'max:50'],
            'address' => ['sometimes', 'nullable', 'string', 'max:500'],
            'payment_terms' => ['sometimes', 'nullable', 'string', 'max:255'],
            'average_delivery_days' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'rating' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:5'],
        ];
    }
}
