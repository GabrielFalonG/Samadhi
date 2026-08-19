<?php

namespace App\Livewire\Components;

use App\DTOs\Carousel\CarouselFiltersData;
use App\Services\Carousel\Contracts\CarouselServiceInterface;
use Exception;
use Livewire\Component;

class CarouselSection extends Component
{
    protected CarouselServiceInterface $carouselService;

    public function mount()
    {
    }

    public function boot(CarouselServiceInterface $carouselService): void
    {
        $this->carouselService = $carouselService;
    }

    public function loadCarrousels()
    {
        try {
            $filter = new CarouselFiltersData(search: null, section: null, active: true, sortBy: 'position',sortDirection: 'asc', perPage: 10);
            return $this->carouselService->paginated($filter)->items();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.carousel.carousel-section', [
            'carousels' => $this->loadCarrousels(),
        ]);
    }
}
