<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'max:255', Rule::unique('brands', 'name')],
            'slug'   => ['nullable', 'string', 'max:255', Rule::unique('brands', 'slug')],
            'logo'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'active' => ['required', 'boolean'],
        ];
    }
}
