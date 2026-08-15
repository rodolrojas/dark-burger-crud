<?php

namespace App\Providers;

use App\Contracts\Repositories\PaymentMethodRepository;
use App\Contracts\Repositories\ProductRepository;
use App\Repositories\Cached\CachedPaymentMethodRepository;
use App\Repositories\Cached\CachedProductRepository;
use App\Repositories\Eloquent\EloquentPaymentMethodRepository;
use App\Repositories\Eloquent\EloquentProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepository::class, function () {
            return new CachedProductRepository(new EloquentProductRepository());
        });

        $this->app->bind(PaymentMethodRepository::class, function () {
            return new CachedPaymentMethodRepository(new EloquentPaymentMethodRepository());
        });
    }

    public function boot(): void
    {
    }
}
