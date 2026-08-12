<?php

namespace App\DTOs\Carousel;

readonly class CarouselFiltersData
{
    public function __construct(
        public ?string $search = null,
        public ?string $section = null,
        public ?string $active = null, //1, 0, ''
        public string $sortBy = 'position',
        public string $sortDirection = 'asc',
        public int $perPage = 10,
    ) {
    }
}
