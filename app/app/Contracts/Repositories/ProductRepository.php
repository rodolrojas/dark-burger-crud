<?php

namespace App\Contracts\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepository
{
    public function activeCatalog(): Collection;

    public function findBySlug(string $slug): ?Product;

    public function create(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function delete(Product $product): void;

    public function addVariant(Product $product, array $data): Product;

    public function updateVariant(string $variantId, array $data): Product;

    public function deleteVariant(string $variantId): Product;
}
