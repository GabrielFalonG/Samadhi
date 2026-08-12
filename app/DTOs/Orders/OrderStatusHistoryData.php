<?php

namespace App\DTOs\Orders;

readonly class OrderStatusHistoryData
{
    public function __construct(
        public string $status = 'pending',
        public ?string $comment = 'Pedido creado e ingresada al sistema.'
    ) {
    }

    public function toArray(): array
    {
        return [
            'status'  => $this->status,
            'comment' => $this->comment,
        ];
    }
}
