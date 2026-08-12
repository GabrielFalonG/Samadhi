<?php

namespace App\DTOs\Orders;

use Illuminate\Support\Str;

readonly class CreateOrderData
{
    public function __construct(
        public string $customerName,
        public string $customerPhone,
        public ?string $customerInstagram,
        public ?string $customerEmail,
        public ?string $customerNotes,

        public float $subtotal,
        public float $shippingCost,
        public float $total,

        public bool $acceptTerms,

        public string $source = 'web',
        public ?string $orderNumber = null,

        /** @var OrderItemData[] */
        public array $items = [],

        public ?OrderStatusHistoryData $statusHistory = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'order_number'       => $this->orderNumber ?? 'ORD-' . strtoupper(Str::random(10)),
            'status'             => $this->statusHistory?->status ?? 'pending',
            'customer_name'      => $this->customerName,
            'customer_phone'     => $this->customerPhone,
            'customer_instagram' => $this->customerInstagram,
            'customer_email'     => $this->customerEmail,
            'customer_notes'     => $this->customerNotes,

            'subtotal'      => $this->subtotal,
            'shipping_cost' => $this->shippingCost,
            'total'         => $this->total,

            'accept_terms' => $this->acceptTerms,
            'source'       => $this->source,
        ];
    }
}
