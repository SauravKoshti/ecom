<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                 => ['required', 'string', 'max:255', Rule::unique('properties', 'name')],
            'type'                 => ['required', Rule::in(['select', 'color', 'text'])],
            'options'              => ['nullable', 'array', 'min:1'],
            'options.*.value'      => ['required', 'string', 'max:255'],
            'options.*.color_hex'  => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }
}
