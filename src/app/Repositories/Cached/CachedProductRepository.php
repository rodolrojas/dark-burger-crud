<?php

namespace App\Repositories\Cached;

use App\Contracts\Repositories\ProductRepository;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CachedProductRepository implements ProductRepository
{
    private const ACTIVE_CATALOG_KEY = 'catalog:products:active:v3';

    public function __construct(private readonly ProductRepository $inner)
    {
    }

    public function activeCatalog(int $perPage = 10, bool $nested = true): LengthAwarePaginator
    {
        $perPage = max(1, min($perPage, 100));
        $pageName = 'page';
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);
        
        $cacheKey = sprintf(
            "%s:per_page:%d:nested:%d:page:%d",
            self::ACTIVE_CATALOG_KEY,
            $perPage,
            $nested ? 1 : 0,
            $page
        );
        
        $catalog = Cache::remember(
            $cacheKey,
            config('cache.ttl.catalog', now()->addMinutes(5)),
            function () use ($perPage, $nested): array {
                $paginator = $this->inner->activeCatalog($perPage, $nested);

                return [
                    'items' => $paginator->getCollection()
                        ->map(fn (Product $product): array =>
                            $this->productToCacheArray($product)
                        )
                        ->all(),
                    'total' => $paginator->total(),
                    'per_page' => $paginator->perPage(),
                    'current_page' => $paginator->currentPage(),
                    'options' => [
                        'path' => $paginator->path(),
                        'pageName' => $paginator->getPageName(),
                    ],
                ];
            }
        );

        return new LengthAwarePaginator(
            collect($catalog['items'])
                ->map(fn (array $product) => $this->productFromCacheArray($product)),
            $catalog['total'],
            $catalog['per_page'],
            $catalog['current_page'],
            $catalog['options']
        );
    }

    public function findBySlug(string $slug): ?Product
    {
        $product = Cache::remember(
            $this->productSlugKey($slug),
            now()->addMinutes(5),
            fn () => ($product = $this->inner->findBySlug($slug))
                ? $this->productToCacheArray($product)
                : null
        );

        return $product ? $this->productFromCacheArray($product) : null;
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
        return "catalog:product:slug:{$slug}:v2";
    }

    private function productToCacheArray(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'image_url' => $product->image_url,
            'active' => $product->active,
            'variants' => $product->variants
                ->map(fn (ProductVariant $variant) => [
                    'id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'name' => $variant->name,
                    'sku' => $variant->sku,
                    'price' => $variant->price,
                    'active' => $variant->active,
                    'default' => $variant->is_default,
                ])
                ->all(),
        ];
    }

    private function productFromCacheArray(array $data): Product
    {
        $variants = collect($data['variants'] ?? [])
            ->map(function (array $variantData) {
                $variant = new ProductVariant();
                $variant->setRawAttributes($variantData, true);
                $variant->exists = true;

                return $variant;
            });

        unset($data['variants']);

        $product = new Product();
        $product->setRawAttributes($data, true);
        $product->exists = true;
        $product->setRelation('variants', $variants);

        return $product;
    }
}