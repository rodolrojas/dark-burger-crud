<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\PaymentMethodRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    public function __construct(private readonly PaymentMethodRepository $paymentMethods)
    {
    }

    public function index(): JsonResponse
    {
        return PaymentMethodResource::collection($this->paymentMethods->activeMethods())->response();
    }
}
