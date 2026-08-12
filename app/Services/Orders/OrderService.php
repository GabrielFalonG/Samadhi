<?php

namespace App\Services\Orders;

use App\DTOs\Orders\CreateOrderData;
use App\DTOs\Orders\OrderFiltersData;
use App\Enums\OrderStatus;
use App\Events\OrderCompleted;
use App\Exports\Pdf\GenrateOrderPdf;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Orders\Contracts\OrderServiceInterface;
use Illuminate\Support\Str;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly GenrateOrderPdf $pdf
    ) {
    }

    public function generatePdf(Order $order): string
    {
        return $this->pdf->generateOrderPdf($order);
    }

    public function notifyme(Order $order): void
    {
        OrderCompleted::dispatch($order);
    }

    private function generateOrderNumber(): string
    {
        return 'SAM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }

    public function create(CreateOrderData $data): Order
    {
        return $this->orders->create($data);
    }

    public function getOrderById(int $id, bool $items = false): Order
    {
        return $this->orders->getOrderById($id, $items);
    }

    public function updateOrderHistory(int $orderId, string $status, string $comment): Order
    {
        return $this->orders->updateOrderHistory($orderId, $status, $comment);
    }

    public function paginate(OrderFiltersData $filters)
    {
        return $this->orders->paginate($filters);
    }

    public function statuses()
    {
        return OrderStatus::cases();
    }
}
