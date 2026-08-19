<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\ProductRepository;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentProductRepository implements ProductRepository
{
    public function activeCatalog(int $perPage = 10, bool $nested): LengthAwarePaginator
    {
        return Product::query()
            ->active()
            ->with($nested ? ['variants' => fn ($query) => $query->active()->orderBy('price')->orderBy('name')] : [])
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::query()
            ->active()
            ->where('slug', $slug)
            ->with(['variants' => fn ($query) => $query->active()->orderBy('price')->orderBy('name')])
            ->first();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->refresh()->load('variants');
    }

    public function delete(Product $product): void
    {
        $product->update(['active' => false]);
    }

    public function addVariant(Product $product, array $data): Product
    {
        $product->variants()->create($data);

        return $product->refresh()->load('variants');
    }

    public function updateVariant(string $variantId, array $data): Product
    {
        return DB::transaction(function () use ($variantId, $data) {
            $variant = ProductVariant::query()->findOrFail($variantId);
            $variant->update($data);

            return $variant->product()->with('variants')->firstOrFail();
        });
    }

    public function deleteVariant(string $variantId): Product
    {
        return DB::transaction(function () use ($variantId) {
            $variant = ProductVariant::query()->findOrFail($variantId);
            $variant->update(['active' => false]);

            return $variant->product()->with('variants')->firstOrFail();
        });
    }
}
