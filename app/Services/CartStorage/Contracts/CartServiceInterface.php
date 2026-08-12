<?php

namespace App\Services\CartStorage\Contracts;

interface CartServiceInterface
{
    public function items(string|int|null $userId = null): array;
    public function itemsValues(string|int|null $userId = null): array;
    public function add(array $productData, string|int|null $userId = null): void;
    public function updateQuantity(int $productId, int $quantity, string|int|null $userId = null): void;
    public function remove(int $productId, string|int|null $userId = null): void;
    public function increase(int $productId, string|int|null $userId = null): void;
    public function decrease(int $productId, string|int|null $userId = null): void;
    public function clear(string|int|null $userId = null): void;
    public function count(string|int|null $userId = null): int;
    public function subtotal(string|int|null $userId = null): float;
    public function total(string|int|null $userId = null): float;
}
