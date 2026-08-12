<?php

namespace App\DTOs\Orders;

readonly class OrderFiltersData
{
    public function __construct(
        public ?string $search = null,
        public ?string $status = null,
        public ?string $date = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $perPage = 10,
    ) {}
}
