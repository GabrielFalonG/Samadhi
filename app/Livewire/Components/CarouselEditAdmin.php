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
    public ?Collection $allProducts = null;

    //Modal
    public bool $showConfirmModal = false;

    public function mount(int $id)
    {
        $this->form->editingId = $id;
        $this->setCarouselAndProducts($this->form->editingId);
        $this->allProducts = $this->productService->getAllProducts();
    }

    public function boot(CarouselServiceInterface $carouselService, ProductServiceInterface $productService): void
    {
        $this->carouselService = $carouselService;
        $this->productService = $productService;
    }

    public function setCarouselAndProducts(int $id)
    {
        try {
            $carousel = $this->carouselService->getCarouselById($id);
            if (!$carousel) return;
            $this->carousel = $carousel;
            $this->form->setCarousel($carousel);
        } catch (Exception $e) {
            report($e);
            flashMessageError('Ha ocurrido un error al cargar los datos del carrousel');
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
            $this->form->validate();
            $this->carouselService->update($this->carousel, $this->form->toDto());
            $this->showConfirmModal = false;
            flashMessageSuccess('Carrusel actualizado correctamente.');
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
        return view('livewire.carousel.carousel-edit-admin')
            ->layout('components.layouts.admin');
    }
}

