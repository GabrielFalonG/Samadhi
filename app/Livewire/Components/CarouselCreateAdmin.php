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
    public ?Collection $allProducts = null;

    //Modal
    public bool $showConfirmModal = false;

    public function mount()
    {
        $this->allProducts = $this->productService->getAllProducts();
    }

    public function boot(CarouselServiceInterface $carouselService, ProductServiceInterface $productService): void
    {
        $this->carouselService = $carouselService;
        $this->productService = $productService;
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
            $this->showConfirmModal = false;
            flashMessageSuccess('Carrusel creado correctamente.');
            $this->redirectRoute('admin.carousels', navigate: true);
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
