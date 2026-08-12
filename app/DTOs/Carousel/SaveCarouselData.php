<?php

namespace App\DTOs\Carousel;

readonly class SaveCarouselData
{
    /**
     * @param CarouselItemData[] $items
     */
    public function __construct(
        public ?int $id,
        public string $title,
        public ?string $subtitle,
        public ?string $description,
        public string $section,
        public int $position,
        public bool $active,
        public array $items,
    ) {
    }
}
