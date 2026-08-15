<?php

namespace App\Contracts\Repositories;

use App\Models\PaymentMethod;
use Illuminate\Support\Collection;

interface PaymentMethodRepository
{
    public function activeMethods(): Collection;

    public function create(array $data): PaymentMethod;

    public function update(PaymentMethod $paymentMethod, array $data): PaymentMethod;
}
