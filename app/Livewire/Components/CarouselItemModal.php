<?php

namespace App\Livewire\Components;

use App\Models\Carousel;
use App\Models\Product;
use App\Services\Carousel\Contracts\CarouselServiceInterface;
use App\Services\CartStorage\Contracts\CartServiceInterface;
use App\Services\Products\Contracts\ProductServiceInterface;
use Livewire\Component;
use Livewire\Attributes\On;

class CarouselItemModal extends Component
{
    protected CarouselServiceInterface $carouselService;
    protected ProductServiceInterface $productService;
    protected CartServiceInterface $cartService;

    public bool $open = false;
    public ?Product $product = null;
    public ?Carousel $carousel = null;

    public function boot(
        CarouselServiceInterface $carouselService,
        ProductServiceInterface $productService,
        CartServiceInterface $cartService,
    )
    {
        $this->carouselService = $carouselService;
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    #[On('open-product')]
    public function openProduct(string $slug, ?int $carousel = null)
    {
        $this->product = $this->productService->getProductBySlug($slug);

        if (is_null($carousel)) {
            $this->product = $this->product->load(['carousels']);
            $this->carousel = $this->product->carousels()->first();
        } else {
            $this->carousel = $this->carouselService->getCarouselById($carousel);
        }

        $this->open = true;
    }

    public function addToCart()
    {
        $item = [
            $this->product->id => [
                'id'                => $this->product->id,
                'title'             => $this->product->title,
                'slug'              => $this->product->slug,
                'description'       => $this->product->description,
                'price'             => $this->product->price,
                'quantity'          => 1,
                'image_url'         => $this->product->image_url,
                'carousel_item_id'   => $this->carousel->id ?? null,
                'carousel_item_name' => $this->carousel->title ?? null,
            ]
        ];

        $this->cartService->add($item);

        $this->dispatch('cart:updated');

        $this->close();
    }

    public function close()
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.carousel.carousel-item-modal');
    }
}
