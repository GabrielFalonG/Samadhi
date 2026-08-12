<?php

namespace App\Repositories\SqlDB;

use App\DTOs\Orders\CreateOrderData;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\DTOs\Orders\OrderFiltersData;
use App\DTOs\Orders\OrderItemData;
use App\DTOs\Orders\OrderStatusHistoryData;
use App\Models\OrderStatusHistory;
use Exception;
use Illuminate\Support\Facades\DB;
use Override;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(CreateOrderData $data): Order
    {
        try {
            return DB::transaction(function () use ($data) {

                $order = Order::create($data->toArray());

                $itemsData = array_map(
                    fn (OrderItemData $item) => $item->toArray(),
                    $data->items
                );

                if (! empty($itemsData)) {
                    $order->items()->createMany($itemsData);
                }

                $order->recalculateTotals($data->shippingCost ?? 0.0);
                $historyDto = $data->statusHistory ?? new OrderStatusHistoryData();
                $order->statusHistory()->create($historyDto->toArray());
                return $order->load(['items', 'statusHistory']);
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function paginate(OrderFiltersData $filters)
    {
        return Order::query()

            ->when($filters->search, function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('order_number', 'like', "%{$filters->search}%")
                        ->orWhere('customer_name', 'like', "%{$filters->search}%")
                        ->orWhere('customer_phone', 'like', "%{$filters->search}%")
                        ->orWhere('customer_email', 'like', "%{$filters->search}%");

                });
            })

            ->when($filters->status, fn ($query) =>
                $query->where('status', $filters->status)
            )

            ->when($filters->date, fn ($query) =>
                $query->whereDate('created_at', $filters->date)
            )

            ->orderBy(
                $filters->sortBy,
                $filters->sortDirection
            )

            ->paginate($filters->perPage);
    }

    public function getOrderById(int $id, bool $items = false): Order
    {
        return Order::when($items, fn ($query) => $query->with('items'))
            ->findOrFail($id);
    }

    public function updateOrderHistory(int $orderId, string $status, string $comment): Order
    {
        try {
            return DB::transaction(function () use ($orderId, $status, $comment) {

                OrderStatusHistory::create([
                    'order_id' => $orderId,
                    'status' => $status,
                    'comment' => $comment,
                ]);

                $order = $this->getOrderById($orderId);
                $order->update(['status' => $status]);
                return $order;
            });
        } catch (Exception $e) {
            throw $e;
        }
    }
}
