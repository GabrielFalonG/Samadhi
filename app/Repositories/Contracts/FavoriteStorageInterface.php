<?php

namespace App\Repositories\Contracts;

interface FavoriteStorageInterface
{
    /**
     * Agrega un item a los favoritos del usuario.
     */
    public function add(int $productId, string|int|null $userId = null): void;

    /**
     * Remueve un item de los favoritos.
     */
    public function remove(int $productId, string|int|null $userId = null): void;

    /**
     * Obtiene la lista completa de IDs de productos favoritos.
     */
    public function get(string|int|null $userId = null): array;

    /**
     * Comprueba si un producto específico está en favoritos.
     */
    public function has(int $productId, string|int|null $userId = null): bool;

    /**
     * Devuelve la cantidad total de favoritos.
     */
    public function count(string|int|null $userId = null): int;
}
