<?php

use App\Http\Controllers\Api\V1\Admin\PaymentMethodController as AdminPaymentMethodController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\ProductVariantController as AdminProductVariantController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PaymentMethodController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Middleware\AuthenticateStaffToken;
use App\Http\Middleware\RequireStaffRole;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    Route::get('/payment-methods', [PaymentMethodController::class, 'index']);

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware([AuthenticateStaffToken::class, RequireStaffRole::class.':admin'])->prefix('admin')->group(function () {
        Route::post('/products', [AdminProductController::class, 'store']);
        Route::patch('/products/{product}', [AdminProductController::class, 'update']);
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy']);

        Route::post('/products/{product}/variants', [AdminProductVariantController::class, 'store']);
        Route::patch('/variants/{variant}', [AdminProductVariantController::class, 'update']);
        Route::delete('/variants/{variant}', [AdminProductVariantController::class, 'destroy']);

        Route::post('/payment-methods', [AdminPaymentMethodController::class, 'store']);
        Route::patch('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'update']);
    });
});
