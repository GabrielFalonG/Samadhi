<?php

namespace App\Services\Orders\Contracts;

use App\DTOs\Orders\CreateOrderData;
use App\DTOs\Orders\OrderFiltersData;
use App\Models\Order;

interface OrderServiceInterface
{
    public function notifyme(Order $order): void;
    public function generatePdf(Order $order): string;
    public function create(CreateOrderData $data): Order;
    public function getOrderById(int $id, bool $items = false): Order;
    public function updateOrderHistory(int $orderId, string $status, string $comment): Order;
    public function paginate(OrderFiltersData $filters);
    public function statuses();
}
