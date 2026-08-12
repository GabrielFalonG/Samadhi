<?php

namespace App\Services\Products;


use App\DTOs\Products\ProductFilterData;
use App\DTOs\Products\ProductSaveData;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Products\Contracts\ProductServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    public function paginated(ProductFilterData $filters): LengthAwarePaginator
    {
        return $this->productRepository->paginated($filters);
    }

    public function getSelectableProducts(array $associatedProductsId = []): array
    {
        return $this->productRepository->getSelectableProducts($associatedProductsId);
    }

    public function getSelectableIngredients(): array
    {
        return $this->productRepository->getSelectableIngredients();
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAllProducts();
    }

    public function getProductById(int $id): Product
    {
        return $this->productRepository->getProductById($id);
    }

    public function getProductBySlug(string $slug): Product
    {
        return $this->productRepository->getProductBySlug($slug);
    }

    public function generateSlug(string $title): string
    {
        return $this->productRepository->generateSlug($title);
    }

    public function create(ProductSaveData $data): Product
    {
        return $this->productRepository->create($data);
    }

    public function update(Product $product, ProductSaveData $data): Product
    {
        return $this->productRepository->update($product, $data);
    }

    public function delete(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }
}
