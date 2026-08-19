<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'active' => ['sometimes', 'boolean'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated($key, $default);
        $data['slug'] ??= Str::slug($data['name']);

        return $data;
    }
}
