<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\Repositories\PaymentMethodRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePaymentMethodRequest;
use App\Http\Requests\Admin\UpdatePaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    public function __construct(private readonly PaymentMethodRepository $paymentMethods)
    {
    }

    public function store(StorePaymentMethodRequest $request): JsonResponse
    {
        $paymentMethod = $this->paymentMethods->create($request->validated());

        return PaymentMethodResource::make($paymentMethod)->response()->setStatusCode(201);
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod): PaymentMethodResource
    {
        return PaymentMethodResource::make($this->paymentMethods->update($paymentMethod, $request->validated()));
    }
}
