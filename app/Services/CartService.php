<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    public const SESSION_KEY = 'shopping_cart';

    /**
     * Obtiene todos los productos del carrito como array asociativo [id => item].
     */
    public static function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    /**
     * Obtiene los ítems indexados numéricamente (útil para enviar a Livewire/Forms).
     */
    public static function itemsValues(): array
    {
        return array_values(self::items());
    }

    /**
     * Guarda la estructura actual del carrito en la sesión.
     */
    protected static function save(array $cart): void
    {
        Session::put(self::SESSION_KEY, $cart);
    }

    /**
     * Agrega o actualiza un producto en el carrito.
     * Soporta tanto datos planos del item como arrays anidados [$id => $item].
     */
    public static function add(array $productData): void
    {
        $id = (int) array_key_first($productData);
        $item = $productData[$id];
        $cart = self::items();

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += (int) ($item['quantity'] ?? 1);

            // Mantiene el origen del carrusel si el ítem existente no lo tenía y ahora sí viene
            if (isset($item['carousel_item_id'])) {
                $cart[$id]['carousel_item_id'] = $item['carousel_item_id'];
                $cart[$id]['carousel_item_name'] = $item['carousel_item_name'] ?? null;
            }
        } else {
            $cart[$id] = [
                'id'                 => $id,
                'title'              => $item['title'] ?? $item['name'] ?? '',
                'slug'               => $item['slug'] ?? '',
                'description'        => $item['description'],
                'price'              => (float) $item['price'],
                'quantity'           => (int) ($item['quantity'] ?? 1),
                'image_url'          => $item['image_url'] ?? null,
                'carousel_item_id'   => $item['carousel_item_id'] ?? null,
                'carousel_item_name' => $item['carousel_item_name'] ?? null,
            ];
        }

        self::save($cart);
    }

    /**
     * Actualiza la cantidad exacta de un producto.
     */
    public static function updateQuantity(int $productId, int $quantity): void
    {
        $cart = self::items();

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }

            self::save($cart);
        }
    }

    /**
     * Elimina un producto por su ID.
     */
    public static function remove(int $productId): void
    {
        $cart = self::items();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            self::save($cart);
        }
    }

    /**
     * Incrementa la cantidad de un producto en 1.
     */
    public static function increase(int $productId): void
    {
        $cart = self::items();

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            self::save($cart);
        }
    }

    /**
     * Decrementa la cantidad de un producto en 1.
     */
    public static function decrease(int $productId): void
    {
        $cart = self::items();

        if (! isset($cart[$productId])) {
            return;
        }

        $cart[$productId]['quantity']--;

        if ($cart[$productId]['quantity'] <= 0) {
            unset($cart[$productId]);
        }

        self::save($cart);
    }

    /**
     * Vacía completamente el carrito.
     */
    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * Devuelve la cantidad total de unidades en el carrito.
     */
    public static function count(): int
    {
        return (int) collect(self::items())->sum('quantity');
    }

    /**
     * Devuelve el subtotal sumando (precio * cantidad) de todos los items.
     */
    public static function subtotal(): float
    {
        return (float) collect(self::items())
            ->sum(fn ($item) => (float) $item['price'] * (int) $item['quantity']);
    }

    /**
     * Alias de subtotal().
     */
    public static function total(): float
    {
        return self::subtotal();
    }
}
