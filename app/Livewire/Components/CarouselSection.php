<?php

namespace App\Livewire\Components;

use App\DTOs\Carousel\CarouselFiltersData;
use App\Services\Carousel\Contracts\CarouselServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class CarouselSection extends Component
{
    protected CarouselServiceInterface $carouselService;

    // Propiedad pública que recibirá los datos de los carruseles desde el componente padre o desde la base de datos
    public $carousels = [];

    public function mount()
    {
        // Cargamos los datos de los carruseles desde la base de datos al iniciar el componente
        $this->carousels = $this->carouselService->paginated(new CarouselFiltersData(
                                                                search: null,
                                                                section: null,
                                                                active: true,
                                                                sortBy: 'position',
                                                                sortDirection: 'asc',
                                                                perPage: 10
                                                            ))
                                                            ->items();
    }

    public function boot(CarouselServiceInterface $carouselService): void
    {
        $this->carouselService = $carouselService;
    }

    public function render()
    {
        return view('livewire.carousel.carousel-section');
    }
}
