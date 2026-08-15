<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentMethodRequest extends FormRequest
{
    public function rules(): array
    {
        $paymentMethod = $this->route('paymentMethod');

        return [
            'code' => ['sometimes', 'string', 'max:80', Rule::unique('payment_methods', 'code')->ignore($paymentMethod)],
            'name' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', 'string', 'max:80'],
            'active' => ['sometimes', 'boolean'],
            'configuration' => ['nullable', 'array'],
        ];
    }
}
