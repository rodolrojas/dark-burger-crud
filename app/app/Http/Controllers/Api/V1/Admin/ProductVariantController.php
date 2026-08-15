<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\Repositories\ProductRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductVariantRequest;
use App\Http\Requests\Admin\UpdateProductVariantRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductVariantController extends Controller
{
    public function __construct(private readonly ProductRepository $products)
    {
    }

    public function store(StoreProductVariantRequest $request, Product $product): JsonResponse
    {
        $product = $this->products->addVariant($product, $request->validated());

        return ProductResource::make($product)->response()->setStatusCode(201);
    }

    public function update(UpdateProductVariantRequest $request, string $variant): ProductResource
    {
        return ProductResource::make($this->products->updateVariant($variant, $request->validated()));
    }

    public function destroy(string $variant): ProductResource
    {
        return ProductResource::make($this->products->deleteVariant($variant));
    }
}
