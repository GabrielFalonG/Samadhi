<?php

namespace App\Repositories\Cache;

use App\Repositories\Contracts\CartStorageInterface;
use Illuminate\Support\Facades\Cache;

class RedisCartStorage implements CartStorageInterface
{
    public const STORAGE_KEY = 'shopping_cart';

    public function get(array $default = [], string|int|null $userId = null): array
    {
        return Cache::store('redis')->get(self::STORAGE_KEY . ":{$userId}", $default);
    }

    public function put(array $value, string|int|null $userId = null): void
    {
        Cache::store('redis')->put(self::STORAGE_KEY . ":{$userId}", $value, now()->addDays(7));
    }

    public function forget(string|int|null $userId = null): void
    {
        Cache::store('redis')->forget(self::STORAGE_KEY . ":{$userId}");
    }
}
