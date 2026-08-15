<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\PaymentMethodRepository;
use App\Models\PaymentMethod;
use Illuminate\Support\Collection;

class EloquentPaymentMethodRepository implements PaymentMethodRepository
{
    public function activeMethods(): Collection
    {
        return PaymentMethod::query()->active()->orderBy('name')->get();
    }

    public function create(array $data): PaymentMethod
    {
        return PaymentMethod::create($data);
    }

    public function update(PaymentMethod $paymentMethod, array $data): PaymentMethod
    {
        $paymentMethod->update($data);

        return $paymentMethod->refresh();
    }
}
