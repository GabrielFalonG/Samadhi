<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\OrderEditForm;
use App\Services\Orders\Contracts\OrderServiceInterface;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class OrderEdit extends Component
{
    public OrderEditForm $form;

    //Modal
    public bool $showConfirmModal = false;

    protected OrderServiceInterface $orderService;

    public function boot(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function mount(int $id): void
    {
        $order = $this->orderService->getOrderById($id, true);
        $this->form->setOrder($order);
    }

    public function confirmSaveData(): void
    {
        try {
            $this->form->validate();
            $this->showConfirmModal = true;
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        }
    }

    public function save()
    {
        try {
            $this->form->validate();

            $this->form->order->update([
                'customer_phone' => $this->form->customer_phone,
                'customer_instagram' => $this->form->customer_instagram,
                'customer_email' => $this->form->customer_email,
            ]);

            $this->showConfirmModal = false;
            flashMessageSuccess('Se ha actualizado correctamente la pedido');
            return $this->redirectRoute('admin.orders', navigate: true);
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        } catch (Exception $e) {
            flashMessageError('Ha ocurrido un error al actualizar la pedido');
            throw $e;
        }
    }

    public function statusLabel(): string
    {
        if ($this->form->status instanceof \App\Enums\OrderStatus) {
            return $this->form->status->label();
        }

        return \App\Enums\OrderStatus::tryFrom((string) $this->form->status)?->label() ?? (string) $this->form->status;
    }

    public function addStatusHistory(): void
    {
        try {
            $this->form->validate($this->form->rulesHistory(), $this->form->messagesHistory());
            $this->form->addStatusChange();
            flashMessageSuccess('Estado e historial actualizados');
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        } catch (Exception $e) {
            report($e);
            flashMessageError('Ha ocurrido un error al intentar actualizar el estado');
        }
    }

    public function render()
    {
        return view('livewire.admin.order-edit')
                        ->layout('components.layouts.admin');
    }
}
