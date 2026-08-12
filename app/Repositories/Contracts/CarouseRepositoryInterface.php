<?php

namespace App\Repositories\Contracts;

use App\DTOs\Carousel\CarouselFiltersData;
use App\DTOs\Carousel\SaveCarouselData;
use App\Models\Carousel;
use Illuminate\Pagination\LengthAwarePaginator;

interface CarouseRepositoryInterface
{
    public function paginated(CarouselFiltersData $filters): LengthAwarePaginator;
    public function getCarouselById(int $id): Carousel;
    public function update(Carousel $carousel, SaveCarouselData $data): Carousel;
    public function create(SaveCarouselData $data): Carousel;
    public function delete(Carousel $carousel): bool;
}
