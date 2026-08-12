<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\CarouselForm;
use App\Services\Carousel\Contracts\CarouselServiceInterface;
use App\Services\Products\Contracts\ProductServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CarouselCreateAdmin extends Component
{
    protected CarouselServiceInterface $carouselService;
    protected ProductServiceInterface $productService;

    public CarouselForm $form;

    // Listado reactivo de ítems vinculados al formulario
    public ?int $selectedProduct = null;
    public array $selectableProducts = [];
    public ?Collection $allProducts = null;

    //Modal
    public bool $showConfirmModal = false;

    public function mount()
    {
        $this->selectableProducts = $this->getSelectableProducts($this->form->products);
        $this->allProducts = $this->productService->getAllProducts();
    }

    public function boot(CarouselServiceInterface $carouselService, ProductServiceInterface $productService): void
    {
        $this->carouselService = $carouselService;
        $this->productService = $productService;
    }

    public function removeItem(int $index)
    {
        if (count($this->form->products) > 1) {
            unset($this->form->products[$index]);
            $this->form->products = array_values($this->form->products); // Reindexar el array
        }
    }


    public function getSelectableProducts(array $associatedProducts): array
    {
        $ids = collect($associatedProducts)->pluck('productId');
        return $this->productService->getSelectableProducts($ids->toArray());
    }

    public function updatedSelectedProduct(?int $productId): void
    {
        try {
            $product = $this->allProducts?->firstWhere('id', $productId);

            if ($product) {
                $this->form->products[] = [
                    'productId' => $product['id'],
                    'title' => $product['title'],
                    'description' => $product['description'] ?? '',
                    'image_url' => $product['image_url'],
                    'link_url' => $product['link_url'] ?? '',
                    'price' => $product['price'] ?? 0.0,
                    'ingredients' => $product['ingredients'] ?? '',
                ];

                $this->selectableProducts = array_values($this->getSelectableProducts($this->form->products));
                $this->selectedProduct = null;
            }

            $this->form->validateOnly('products');
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        } catch (\Exception $e) {
            report($e);
            flashMessageError('Ocurrió un error al actualizar los productos');
        }
    }

    public function removeProduct(int $id)
    {
        try {
            $this->form->products = collect($this->form->products)
                            ->reject(fn ($product) => $product['productId'] === $id)
                            ->all();

            $this->form->products = array_values($this->form->products); // Reindexar el array
            $this->selectableProducts = array_values($this->getSelectableProducts($this->form->products));
            $this->form->validateOnly('products');
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        } catch (\Exception $e) {
            report($e);
            flashMessageError('Ocurrió un error al actualizar los productos');
        }
    }

    public function confirmSaveData(): void
    {
        try {
            $this->form->validate();
            $this->showConfirmModal = true;
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        }
    }

    public function save()
    {
        try {
            $this->carouselService->create($this->form->toDto());
            $this->resetForm();
            flashMessageSuccess('Carrusel creado correctamente.');
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        } catch (\Exception $e) {
            report($e);
            flashMessageError('Error al guardar el carrusel: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.carousel.carousel-create-admin')
                ->layout('components.layouts.admin');
    }
}
