<?php

namespace App\Livewire\Components;

use App\DTOs\Products\ProductFilterData;
use App\Models\Product;
use App\Services\Products\Contracts\ProductServiceInterface;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsAdmin extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    public bool $showDeleteModal = false;

    public ?Product $productToDelete = null;

    protected ProductServiceInterface $productService;

    public function boot(ProductServiceInterface $productService): void
    {
        $this->productService = $productService;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $productId): void
    {
        try {
            $product = $this->productService->getProductById($productId);

            if (!$product) {
                flashMessageError('Ha ocurrido un error');
                return;
            }


            $this->productToDelete = $product;
            $this->showDeleteModal = true;
        } catch (Exception $e) {
            report($e);
            flashMessageError('Ha ocurrido un error');
        }
    }

    public function cancelDelete(): void
    {
        $this->resetDeleteAction();
    }

    public function deleteProduct(): void
    {
        try {
            if (!$this->productToDelete) {
                flashMessageError('No se encontró el producto.');
                return;
            }

            $deleted = $this->productService->delete(
                $this->productToDelete
            );

            if (!$deleted) {
                flashMessageError('No se pudo eliminar el producto.');
                return;
            }

            $this->resetDeleteAction();
            flashMessageSuccess('Producto eliminado correctamente.');

        } catch (Exception $e) {
            report($e);
            flashMessageError('Ocurrió un error al eliminar el producto.');
        }
    }

    protected function resetDeleteAction(): void
    {
        $this->showDeleteModal = false;
        $this->productToDelete = null;
    }

    private function toDto(): ProductFilterData
    {
        return new ProductFilterData(
            search: blank($this->search) ? null : $this->search,
            active: $this->status === '' ? null : (bool) $this->status,
            sortBy: 'created_at',
            sortDirection: 'desc',
            perPage: 10,
            categories: []
        );
    }

    public function getProductsProperty()
    {
        return $this->productService->paginated($this->toDto());
    }

    public function render()
    {
        return view('livewire.products.products-admin-index', [
            'products' => $this->products
        ])->layout('components.layouts.admin');
    }
}
