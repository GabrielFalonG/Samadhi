<?php

namespace App\Services\Products\Contracts;

use App\DTOs\Products\ProductFilterData;
use App\DTOs\Products\ProductSaveData;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductServiceInterface
{
    public function paginated(ProductFilterData $filters): LengthAwarePaginator;
    public function getAllProducts(): Collection;
    public function getProductById(int $id): Product;
    public function getProductBySlug(string $slug): Product;
    public function getSelectableProducts(array $associatedProductsId = []): array;
    public function getSelectableIngredients(): array;
    public function generateSlug(string $title): string;
    public function create(ProductSaveData $data): Product;
    public function update(Product $product, ProductSaveData $data): Product;
    public function delete(Product $product): bool;
}
