<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('subdomain')) {
            $this->merge([
                'subdomain' => Str::lower(trim((string) $this->input('subdomain'))),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'subdomain' => [
                'required',
                'string',
                'min:3',
                'max:63',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('tenants', 'subdomain'),
            ],
            'custom_domain' => ['nullable', 'string', 'max:255', Rule::unique('tenants', 'custom_domain')],
        ];
    }
}
