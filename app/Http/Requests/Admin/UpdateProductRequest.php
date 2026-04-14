<?php

namespace App\Http\Requests\Admin;

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
        $id = $this->route('product')?->id;

        return [
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($id)],
            'description'       => ['nullable', 'string'],
            'price'             => ['required', 'numeric', 'min:0'],
            'compare_price'     => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'stock'             => ['required', 'integer', 'min:0'],
            'sku'               => ['nullable', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($id)],
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'category_id'       => ['nullable', Rule::exists('categories', 'id')],
            'brand_id'          => ['nullable', Rule::exists('brands', 'id')],
            'active'            => ['required', 'boolean'],
            'product_number'    => ['nullable', 'string', 'max:100', Rule::unique('products', 'product_number')->ignore($id)],
            'ean'               => ['nullable', 'string', 'max:100'],
            'property_options'  => ['nullable', 'array'],
            'property_options.*'=> ['integer', Rule::exists('property_options', 'id')],
            'categories'        => ['nullable', 'array'],
            'categories.*'      => ['integer', Rule::exists('categories', 'id')],
        ];
    }
}
