<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\OrderForm;
use App\Services\CartStorage\Contracts\CartServiceInterface;
use App\Services\Orders\Contracts\OrderServiceInterface;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Computed;

class CheckoutPage extends Component
{
    protected OrderServiceInterface $orderService;
    protected CartServiceInterface $cartService;

    public OrderForm $form;

    /*
    |--------------------------------------------------------------------------
    | Inicialización
    |--------------------------------------------------------------------------
    */
    public function mount(): void
    {
        $this->loadCart();
    }

    public function boot(
        OrderServiceInterface $orderService,
        CartServiceInterface $cartService,
    ): void
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function loadCart(): void
    {
        $this->form->items = $this->cartService->items();
    }

    #[Computed]
    public function subtotal(): int
    {
        return $this->cartService->total();
    }

    #[Computed]
    public function totalItems(): int
    {
        return collect($this->form->items)->sum('quantity');
    }

    public function confirmOrder(): void
    {

        try {
            $this->form->validate();
            $order = $this->orderService->create($this->form->toDto());
            $this->cartService->clear();
            $this->dispatch('cart:finished');
            // $this->orderService->notifyme($order);
            $this->form->reset();
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        } catch (Exception $e) {
            flashMessageError('Ha ocurrido un error');
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.cart-drawer.checkout-page');
    }
}
