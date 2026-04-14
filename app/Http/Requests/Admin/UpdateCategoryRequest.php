<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('category')?->id;

        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($id)],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:12048'],
            'parent_id'   => ['nullable', Rule::exists('categories', 'id'), Rule::notIn([$id])],
            'status'      => ['required', 'boolean'],
        ];
    }
}
