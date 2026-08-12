<?php

namespace App\Services\Carousel;

use App\DTOs\Carousel\CarouselFiltersData;
use App\Models\Carousel;
use App\DTOs\Carousel\SaveCarouselData;
use App\Repositories\Contracts\CarouseRepositoryInterface;
use App\Services\Carousel\Contracts\CarouselServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CarouselService implements CarouselServiceInterface
{
    public function __construct(
        private readonly CarouseRepositoryInterface $carousel
    ) {
    }

    public function paginated(CarouselFiltersData $filters): LengthAwarePaginator
    {
        return $this->carousel->paginated($filters);
    }

    public function getCarouselById(int $id): Carousel
    {
        return $this->carousel->getCarouselById($id);
    }

    public function update(Carousel $carousel, SaveCarouselData $data): Carousel
    {
        return $this->carousel->update($carousel, $data);
    }

    public function create(SaveCarouselData $data): Carousel
    {
        return $this->carousel->create($data);
    }

    public function delete(Carousel $carousel): bool
    {
        return $this->carousel->delete($carousel);
    }
}
