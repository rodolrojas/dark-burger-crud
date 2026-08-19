<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\ProductRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ProductRepository $products)
    {
    }

    public function index(): JsonResponse
    {
        return ProductResource::collection($this->products->activeCatalog())->response();
    }

    public function show(string $slug): ProductResource|JsonResponse
    {
        $product = $this->products->findBySlug($slug);

        if (! $product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        return ProductResource::make($product);
    }
}
