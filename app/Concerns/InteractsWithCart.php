<?php

namespace App\Concerns;

use App\Services\Carousel\Contracts\CarouselServiceInterface;
use App\Services\CartStorage\Contracts\CartServiceInterface;
use App\Services\Products\Contracts\ProductServiceInterface;
use Exception;

trait InteractsWithCart
{
    public function addToCart(int $productId, ?int $carouselId = null): void
    {
        try {
            $productService = app(ProductServiceInterface::class);
            $carouselService = app(CarouselServiceInterface::class);
            $cartService = app(CartServiceInterface::class);

            $product = $productService->getProductById($productId);

            $carousel = null;
            if ($carouselId) $carousel = $carouselService->getCarouselById($carouselId);

            $item = [
                $product->id => [
                    'id'                 => $product->id,
                    'title'              => $product->title,
                    'slug'               => $product->slug,
                    'description'        => $product->description,
                    'price'              => $product->price,
                    'quantity'           => 1,
                    'image_url'          => $product->image_url,
                    'carousel_item_id'   => $carousel?->id,
                    'carousel_item_name' => $carousel?->title,
                ],
            ];

            $userId = auth()->check() ? auth()->id() : null;
            $cartService->add($item, $userId);
            $this->dispatch('cart:updated');

        } catch (Exception $e) {
            throw $e;
        }
    }
}
