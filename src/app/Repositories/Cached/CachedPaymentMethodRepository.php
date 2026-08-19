<?php

namespace App\Repositories\Cached;

use App\Contracts\Repositories\PaymentMethodRepository;
use App\Models\PaymentMethod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CachedPaymentMethodRepository implements PaymentMethodRepository
{
    private const ACTIVE_METHODS_KEY = 'catalog:payment-methods:active:v1';

    public function __construct(private readonly PaymentMethodRepository $inner)
    {
    }

    public function activeMethods(): Collection
    {
        return Cache::remember(self::ACTIVE_METHODS_KEY, now()->addMinutes(5), fn () => $this->inner->activeMethods());
    }

    public function create(array $data): PaymentMethod
    {
        $paymentMethod = $this->inner->create($data);
        $this->forgetMethods();

        return $paymentMethod;
    }

    public function update(PaymentMethod $paymentMethod, array $data): PaymentMethod
    {
        $updated = $this->inner->update($paymentMethod, $data);
        $this->forgetMethods();

        return $updated;
    }

    private function forgetMethods(): void
    {
        Cache::forget(self::ACTIVE_METHODS_KEY);
    }
}
