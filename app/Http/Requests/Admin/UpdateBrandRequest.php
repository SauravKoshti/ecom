<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('brand')?->id;

        return [
            'name'   => ['required', 'string', 'max:255', Rule::unique('brands', 'name')->ignore($id)],
            'slug'   => ['nullable', 'string', 'max:255', Rule::unique('brands', 'slug')->ignore($id)],
            'logo'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'active' => ['required', 'boolean'],
        ];
    }
}
