<?php

namespace App\Services\Favorite\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface FavoriteServiceInterface
{
    public function toggleFavorite(int $productId, string|int|null $userId = null): bool;
    public function getFavoriteProducts(string|int|null $userId = null): Collection;
    public function isFavorite(int $productId, string|int|null $userId = null): bool;
}
