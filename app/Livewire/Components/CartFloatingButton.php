<?php

namespace App\Livewire\Components;

use App\Services\CartStorage\Contracts\CartServiceInterface;
use Livewire\Component;
use Livewire\Attributes\On;

class CartFloatingButton extends Component
{
    protected CartServiceInterface $cartService;

    public int $count = 0;

    public function mount()
    {
        $this->refresh();
    }

    public function boot(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    #[On('cart:updated')]
    public function refresh()
    {
        $this->count = $this->cartService->count();
    }

    #[On('cart:finished')]
    public function restart()
    {
        $this->count = $this->cartService->count();
    }

    public function openCart()
    {
        $this->dispatch('cart:open');
    }

    public function render()
    {
        return view('livewire.cart-drawer.cart-floating-button');
    }
}
