<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:80', 'unique:product_variants,sku'],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
