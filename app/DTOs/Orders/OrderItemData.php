<?php

namespace App\DTOs\Orders;

readonly class OrderItemData
{
    public function __construct(
        public int $productId,
        public string $productName,
        public int $quantity,
        public float $unitPrice,
        public float $subtotal,
        public ?int $carouselItemId = null,
        public ?string $carouselItemName = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'product_id'         => $this->productId,
            'product_name'       => $this->productName,
            'quantity'           => $this->quantity,
            'unit_price'         => $this->unitPrice,
            'subtotal'           => $this->subtotal,
            'carousel_item_id'   => $this->carouselItemId,
            'carousel_item_name' => $this->carouselItemName,
        ];
    }
}
