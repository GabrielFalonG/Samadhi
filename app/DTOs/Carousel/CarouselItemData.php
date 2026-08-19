<?php

namespace App\DTOs\Carousel;

readonly class CarouselItemData
{
    public function __construct(
        public int $productId,
        public int $position,
    ) {}

    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'position' => $this->position,
        ];
    }
}
