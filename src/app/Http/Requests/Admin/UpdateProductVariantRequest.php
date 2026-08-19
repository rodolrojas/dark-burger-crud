<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductVariantRequest extends FormRequest
{
    public function rules(): array
    {
        $variantId = $this->route('variant');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'sku' => ['sometimes', 'string', 'max:80', Rule::unique('product_variants', 'sku')->ignore($variantId)],
            'price' => ['sometimes', 'numeric', 'min:0', 'decimal:0,2'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
