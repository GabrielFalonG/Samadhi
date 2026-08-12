<?php

namespace App\Services\Favorite;


use App\Models\Product;
use App\Repositories\Contracts\FavoriteStorageInterface;
use App\Services\Favorite\Contracts\FavoriteServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class FavoriteService implements FavoriteServiceInterface
{
    public function __construct(
        protected FavoriteStorageInterface $storage
    ) {}

    public function toggleFavorite(int $productId, string|int|null $userId = null): bool
    {
        $userId = $this->resolveUserId($userId);
        if ($this->storage->has($productId, $userId)) {
            $this->storage->remove($productId, $userId);
            // Opcional: Despachar Job para eliminar de DB en segundo plano
            return false; // Indicamos que ya no es favorito
        }

        $this->storage->add($productId, $userId);
        // Opcional: Despachar Job para guardar en DB en segundo plano
        return true; // Indicamos que se agregó a favoritos
    }

    /**
     * Obtiene los modelos de los productos favoritos cargados desde MySQL
     * utilizando los IDs almacenados en Redis.
     */
    public function getFavoriteProducts(string|int|null $userId = null): Collection
    {
        try {
            $userId = $this->resolveUserId($userId);
            $productIds = $this->storage->get($userId);

            if (empty($productIds)) {
                return new Collection();
            }

            return Product::whereIn('id', $productIds)->get();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function isFavorite( int $productId, string|int|null $userId = null): bool
    {
        $userId = $this->resolveUserId($userId);
        return $this->storage->has($productId, $userId);
    }

    private function resolveUserId(string|int|null $userId): string|int
    {
        return $userId ?? auth()->id() ?? session()->getId();
    }
}
