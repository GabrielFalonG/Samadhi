<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Livewire\Forms\CarouselForm;
use App\Models\Carousel;
use App\Services\Carousel\Contracts\CarouselServiceInterface;
use App\Services\Products\Contracts\ProductServiceInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CarouselEditAdmin extends Component
{
    protected CarouselServiceInterface $carouselService;
    protected ProductServiceInterface $productService;

    public CarouselForm $form;
    public Carousel $carousel;

    // Listado reactivo de ítems vinculados al formulario
    public ?int $selectedProduct = null;
    public array $selectableProducts = [];
    public ?Collection $allProducts = null;

    //Modal
    public bool $showConfirmModal = false;

    public function mount(int $id)
    {
        $this->resetForm();
        $this->form->editingId = $id;
        $this->setCarouselAndProducts($this->form->editingId);
        $this->selectableProducts = $this->getSelectableProducts($this->form->products);
        $this->allProducts = $this->productService->getAllProducts();
    }

    public function boot(CarouselServiceInterface $carouselService, ProductServiceInterface $productService): void
    {
        $this->carouselService = $carouselService;
        $this->productService = $productService;
    }

    public function resetForm()
    {
        $this->form->editingId = null;
        $this->form->title = '';
        $this->form->subtitle = '';
        $this->form->description = '';
        $this->form->section = 'productos';
        $this->form->position = 1;
        $this->form->active = true;
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

    public function setCarouselAndProducts(int $id)
    {
        try {
            $carousel = $this->carouselService->getCarouselById($id);
            if (!$carousel) return;

            $this->carousel = $carousel;
            $this->form->editingId = $carousel->id;
            $this->form->title = $carousel->title;
            $this->form->subtitle = $carousel->subtitle ?? '';
            $this->form->description = $carousel->description ?? '';
            $this->form->section = $carousel->section;
            $this->form->position = $carousel->position;
            $this->form->active = (bool) $carousel->active;

            $this->form->products = $carousel->products->map(function ($product) {
                return [
                    'productId' => $product->id,
                    'position' => $product->position,
                    'title' => $product->title,
                    'description' => $product->description ?? '',
                    'image_url' => $product->image_url,
                    'link_url' => $product->price ?? 0.0,
                    'ingredients' => $product->ingredients ?? '',
                ];
            })->toArray();
        } catch (Exception $e) {
            report($e);
            flashMessageError('Ha ocurrido un error al cargar los datos del carrousel');
        }
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
            $this->carouselService->update($this->carousel, $this->form->toDto());
            $this->setCarouselAndProducts($this->form->editingId);
            $this->selectableProducts = $this->getSelectableProducts($this->form->products);
            $this->showConfirmModal = false;
            flashMessageSuccess('Carrusel guardado correctamente.');
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
        return view('livewire.carousel.carousel-edit-admin')
            ->layout('components.layouts.admin');
    }
}

