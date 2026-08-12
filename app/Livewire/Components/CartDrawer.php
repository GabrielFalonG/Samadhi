<?php

namespace App\Livewire\Components;

use App\Services\CartStorage\Contracts\CartServiceInterface;
use Livewire\Component;

use Livewire\Attributes\On;

class CartDrawer extends Component
{

    protected CartServiceInterface $cartService;

    public array $items = [];
    public float $total = 0;
    public bool $open = false;

    public function mount()
    {
        $this->items = $this->cartService->items();
        $this->total = $this->cartService->total();
    }

    public function boot(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    #[On('cart:updated')]
    public function refreshCart()
    {
        $this->items = $this->cartService->items();
        $this->total = $this->cartService->total();
        $this->open = true;
    }

    #[On('cart:open')]
    public function open()
    {
        $this->items = $this->cartService->items();
        $this->total = $this->cartService->total();
        $this->open = true;
    }

    public function calculateTotal(): void
    {
        $this->total = array_reduce($this->items, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function increase(int $id)
    {
        $this->cartService->increase($id);
        $this->dispatch('cart:updated');
        $this->refreshCart();
    }

    public function decrease(int $id)
    {
        $this->cartService->decrease($id);
        $this->dispatch('cart:updated');
        $this->refreshCart();
    }

    public function remove(int $id)
    {
        $this->cartService->remove($id);
        $this->dispatch('cart:updated');
        $this->refreshCart();
    }

    public function clear()
    {
        $this->cartService->clear();
        $this->dispatch('cart:updated');
        $this->refreshCart();
    }

    public function close()
    {
        $this->open = false;
    }

    public function checkout()
    {
        return redirect()->route('cart');
    }

    public function render()
    {
        return view('livewire.cart-drawer.index');
    }
}
