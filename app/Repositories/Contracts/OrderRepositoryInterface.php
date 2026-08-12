<?php

namespace App\Repositories\Contracts;

use App\DTOs\Orders\CreateOrderData;
use App\DTOs\Orders\OrderFiltersData;
use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(CreateOrderData $data): Order;
    public function paginate(OrderFiltersData $filters);
    public function getOrderById(int $id, bool $items = false): Order;
    public function updateOrderHistory(int $orderId, string $status, string $comment): Order;
}
