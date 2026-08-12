<?php

namespace App\Livewire\Components;

use App\DTOs\Carousel\CarouselFiltersData;
use App\Models\Carousel;
use App\Services\Carousel\Contracts\CarouselServiceInterface;
use App\Services\Products\Contracts\ProductServiceInterface;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CarouselAdmin extends Component
{
    protected CarouselServiceInterface $carouselService;
    protected ProductServiceInterface $productService;

    //Filters
    #[Url(as: 'q')]
    public string $search = '';

    #[Url(except: '')]
    public string $section = '';

    #[Url(except: '')]
    public string $active = '';

    public ?Collection $allProducts = null;
    public bool $showDeleteModal = false;
    public ?Carousel $carouselToDelete = null;

    public function mount()
    {
        $this->allProducts = $this->productService->getAllProducts();
    }

    public function boot(CarouselServiceInterface $carouselService, ProductServiceInterface $productService)
    {
        $this->carouselService = $carouselService;
        $this->productService = $productService;
    }

    #[Computed]
    public function carousels()
    {
        return $this->carouselService->paginated(
            new CarouselFiltersData(
                search: $this->search,
                section: $this->section,
                active: $this->active,
                sortBy: $this->sortBy ?? 'position',
                sortDirection: $this->sortDirection ?? 'asc',
                perPage: $this->perPage ?? 10,
            )
        );
    }

    public function confirmDelete(Carousel $carousel): void
    {
        $this->carouselToDelete = $carousel;
        $this->showDeleteModal = true;
    }

    public function restartDeleteAction(): void
    {
        $this->carouselToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deleteCarousel(): void
    {
        try {
            if (!$this->carouselToDelete) {
                flashMessageError('No se pudo encontrar el carrusel a eliminar.');
                return;
            }

            $isDeleted = $this->carouselService->delete($this->carouselToDelete);

            if(!$isDeleted) {
                flashMessageError('No se pudo eliminar el carrusel.');
                return;
            }

            $this->restartDeleteAction();
            flashMessageSuccess('Carrusel eliminado correctamente.');
        } catch (Exception $e) {
            flashMessageError('Ocurrió un error al eliminar el carrusel.');
        }
    }

    public function render()
    {
        return view('livewire.carousel.carousel-admin')
            ->layout('components.layouts.admin');
    }
}
