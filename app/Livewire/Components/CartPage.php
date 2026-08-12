<?php

namespace App\Livewire\Components;

use App\Services\CartStorage\Contracts\CartServiceInterface;
use Livewire\Component;

class CartPage extends Component
{
    protected CartServiceInterface $cartService;

    public array $items = [];

    public function mount()
    {
        $this->items = $this->cartService->items();
    }

    public function boot(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function checkoutPage()
    {
        return redirect()->route('checkout');
    }

    public function increase(int $id)
    {
        $this->cartService->increase($id);

        $this->refresh();
    }

    public function decrease(int $id)
    {
        $this->cartService->decrease($id);

        $this->refresh();
    }

    public function remove(int $id)
    {
        $this->cartService->remove($id);

        $this->refresh();
    }

    protected function refresh()
    {
        $this->items = $this->cartService->items();
    }

    public function getSubtotalProperty()
    {
        return $this->cartService->subtotal();
    }

    public function getTotalProperty()
    {
        return $this->cartService->total();
    }

    public function render()
    {
        return view('livewire.cart-drawer.cart-page');
    }
}
