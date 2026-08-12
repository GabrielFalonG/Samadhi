<?php

namespace App\DTOs\Carousel;

readonly class CarouselItemData
{
    public function __construct(
        public int $productId,
        public int $position,
        public ?string $title,
        public ?string $description,
        public ?string $imageUrl,
        public ?string $linkUrl,
        public float $price,
        public ?string $ingredients,
    ) {
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'position' => $this->position,
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->imageUrl,
            'link_url' => $this->linkUrl,
            'price' => $this->price,
            'ingredients' => $this->ingredients,
        ];
    }
}
