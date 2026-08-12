<?php

namespace App\DTOs\Products;

class ProductFilterData
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?bool $active = null,
        public readonly string $sortBy = 'created_at',
        public readonly string $sortDirection = 'desc',
        public readonly int $perPage = 10,
        public ?float $minPrice = null,
        public ?float $maxPrice = null,
        //Categories
        public array $categories = [],
    ) {}

    public function toArray(): array
    {
        return [
            'search' => $this->search,
            'active' => $this->active,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
            'categories' => $this->categories,
            'perPage' => $this->perPage,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
        ];
    }
}
