<?php

namespace App\Repositories\Cached;

use App\Contracts\Repositories\ProductRepository;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CachedProductRepository implements ProductRepository
{
    private const ACTIVE_CATALOG_KEY = 'catalog:products:active:v1';

    public function __construct(private readonly ProductRepository $inner)
    {
    }

    public function activeCatalog(): Collection
    {
        return Cache::remember(self::ACTIVE_CATALOG_KEY, now()->addMinutes(5), fn () => $this->inner->activeCatalog());
    }

    public function findBySlug(string $slug): ?Product
    {
        return Cache::remember($this->productSlugKey($slug), now()->addMinutes(5), fn () => $this->inner->findBySlug($slug));
    }

    public function create(array $data): Product
    {
        $product = $this->inner->create($data);
        $this->forgetCatalog();

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $oldSlug = $product->slug;
        $updated = $this->inner->update($product, $data);
        $this->forgetCatalog();
        Cache::forget($this->productSlugKey($oldSlug));
        Cache::forget($this->productSlugKey($updated->slug));

        return $updated;
    }

    public function delete(Product $product): void
    {
        $this->inner->delete($product);
        $this->forgetCatalog();
        Cache::forget($this->productSlugKey($product->slug));
    }

    public function addVariant(Product $product, array $data): Product
    {
        $updated = $this->inner->addVariant($product, $data);
        $this->forgetProduct($updated);

        return $updated;
    }

    public function updateVariant(string $variantId, array $data): Product
    {
        $updated = $this->inner->updateVariant($variantId, $data);
        $this->forgetProduct($updated);

        return $updated;
    }

    public function deleteVariant(string $variantId): Product
    {
        $updated = $this->inner->deleteVariant($variantId);
        $this->forgetProduct($updated);

        return $updated;
    }

    private function forgetProduct(Product $product): void
    {
        $this->forgetCatalog();
        Cache::forget($this->productSlugKey($product->slug));
    }

    private function forgetCatalog(): void
    {
        Cache::forget(self::ACTIVE_CATALOG_KEY);
    }

    private function productSlugKey(string $slug): string
    {
        return "catalog:product:slug:{$slug}:v1";
    }
}
