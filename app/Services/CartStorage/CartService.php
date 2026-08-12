<?php

namespace App\Services\CartStorage;

use App\Repositories\Contracts\CartStorageInterface;
use App\Services\CartStorage\Contracts\CartServiceInterface;

class CartService implements CartServiceInterface
{
    public function __construct(
        protected CartStorageInterface $storage
    ) {}

    /**
     * Obtiene todos los productos del carrito como array asociativo [id => item].
     */
    public function items(string|int|null $userId = null): array
    {
        $userId = $this->resolveUserId($userId);
        return $this->storage->get([], $userId);
    }

    /**
     * Obtiene los ítems indexados numéricamente.
     */
    public function itemsValues(string|int|null $userId = null): array
    {
        return array_values($this->items($userId));
    }

    /**
     * Guarda la estructura actual del carrito en el almacenamiento.
     */
    protected function save(array $cart, string|int|null $userId = null): void
    {
        $userId = $this->resolveUserId($userId);
        $this->storage->put($cart, $userId);
    }

    /**
     * Agrega o actualiza un producto en el carrito.
     */
    public function add(array $productData, string|int|null $userId = null): void
    {
        $id = (int) array_key_first($productData);
        $item = $productData[$id];
        $cart = $this->items($userId);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += (int) ($item['quantity'] ?? 1);

            if (isset($item['carousel_item_id'])) {
                $cart[$id]['carousel_item_id'] = $item['carousel_item_id'];
                $cart[$id]['carousel_item_name'] = $item['carousel_item_name'] ?? null;
            }
        } else {
            $cart[$id] = [
                'id'                 => $id,
                'title'              => $item['title'] ?? $item['name'] ?? '',
                'slug'               => $item['slug'] ?? '',
                'description'        => $item['description'] ?? '',
                'price'              => (float) $item['price'],
                'quantity'           => (int) ($item['quantity'] ?? 1),
                'image_url'          => $item['image_url'] ?? null,
                'carousel_item_id'   => $item['carousel_item_id'] ?? null,
                'carousel_item_name' => $item['carousel_item_name'] ?? null,
            ];
        }

        $this->save($cart, $userId);
    }

    public function updateQuantity(int $productId, int $quantity, string|int|null $userId = null): void
    {
        $cart = $this->items($userId);

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }

            $this->save($cart, $userId);
        }
    }

    public function remove(int $productId, string|int|null $userId = null): void
    {
        $cart = $this->items($userId);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->save($cart, $userId);
        }
    }

    public function increase(int $productId, string|int|null $userId = null): void
    {
        $cart = $this->items($userId);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            $this->save($cart, $userId);
        }
    }

    public function decrease(int $productId, string|int|null $userId = null): void
    {
        $cart = $this->items($userId);

        if (! isset($cart[$productId])) {
            return;
        }

        $cart[$productId]['quantity']--;

        if ($cart[$productId]['quantity'] <= 0) {
            unset($cart[$productId]);
        }

        $this->save($cart, $userId);
    }

    public function clear(string|int|null $userId = null): void
    {
        $userId = $this->resolveUserId($userId);
        $this->storage->forget($userId);
    }

    public function count(string|int|null $userId = null): int
    {
        return (int) collect($this->items($userId))->sum('quantity');
    }

    public function subtotal(string|int|null $userId = null): float
    {
        return (float) collect($this->items($userId))
            ->sum(fn ($item) => (float) $item['price'] * (int) $item['quantity']);
    }

    public function total(string|int|null $userId = null): float
    {
        return $this->subtotal($userId);
    }

    private function resolveUserId(string|int|null $userId): string|int
    {
        return $userId ?? auth()->id() ?? session()->getId();
    }
}
