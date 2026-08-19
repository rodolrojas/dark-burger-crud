<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\Repositories\ProductRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ProductRepository $products)
    {
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->products->create($request->validated());

        return ProductResource::make($product->load('variants'))->response()->setStatusCode(201);
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        return ProductResource::make($this->products->update($product, $request->validated()));
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->products->delete($product);

        return response()->json(status: 204);
    }
}
