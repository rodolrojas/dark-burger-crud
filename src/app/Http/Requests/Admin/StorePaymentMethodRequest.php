<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:80', 'unique:payment_methods,code'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:80'],
            'active' => ['sometimes', 'boolean'],
            'configuration' => ['nullable', 'array'],
        ];
    }
}
