<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = (int) $this->route('product');

        return [
            'sku' => ['sometimes', 'required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($productId)],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'brand' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'cost_price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'stock_quantity' => ['sometimes', 'required', 'integer', 'min:0'],
            'low_stock_threshold' => ['sometimes', 'required', 'integer', 'min:0'],
            'specifications' => ['sometimes', 'nullable', 'array'],
            'images' => ['sometimes', 'nullable', 'array'],
            'compatibility_data' => ['sometimes', 'nullable', 'array'],
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'supplier_id' => ['sometimes', 'required', 'integer', 'exists:suppliers,id'],
            'status' => ['sometimes', 'required', Rule::in(ProductStatus::values())],
        ];
    }
}
