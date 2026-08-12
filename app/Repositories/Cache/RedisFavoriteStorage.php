<?php

namespace App\Repositories\Cache;

use App\Repositories\Contracts\FavoriteStorageInterface;
use Illuminate\Support\Facades\Redis;

class RedisFavoriteStorage implements FavoriteStorageInterface
{
    const PREFIX = 'favorites:';

    public function add(int $productId, string|int|null $userId = null): void
    {
        Redis::sAdd($this->getKey($userId), $productId);
    }

    public function remove(int $productId, string|int|null $userId = null): void
    {
        Redis::sRem($this->getKey($userId), $productId);
    }

    public function get(string|int|null $userId = null): array
    {
        // Devuelve un array con todos los IDs de productos almacenados
        $items = Redis::sMembers($this->getKey($userId));

        return array_map('intval', $items);
    }

    public function has(int $productId, string|int|null $userId = null): bool
    {
        return Redis::sIsMember($this->getKey($userId), $productId);
    }

    public function count(string|int|null $userId = null): int
    {
        return Redis::sCard($this->getKey($userId));
    }

    private function getKey(string|int|null $userId = null): string
    {
        return self::PREFIX . "{$userId}";
    }
}
