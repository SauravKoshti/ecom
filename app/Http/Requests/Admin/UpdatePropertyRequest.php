<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('property')?->id;

        return [
            'name'                 => ['required', 'string', 'max:255', Rule::unique('properties', 'name')->ignore($id)],
            'type'                 => ['required', Rule::in(['select', 'color', 'text'])],
            'options'              => ['nullable', 'array', 'min:1'],
            'options.*.id'         => ['nullable', Rule::exists('property_options', 'id')],
            'options.*.value'      => ['required', 'string', 'max:255'],
            'options.*.color_hex'  => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }
}
