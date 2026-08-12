<?php

namespace App\Livewire\Forms;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\Orders\Contracts\OrderServiceInterface;
use Exception;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderEditForm extends Form
{
    public ?Order $order = null;

    //Status
    public ?OrderStatus $h_status = null;
    #[Validate('nullable|string|max:500')]
    public ?string $h_new_comment = null;
    public array $history = [];

    // Campos del formulario
    public string $order_number = '';
    public string $status = 'pending';

    //Cutomer
    public string $customer_name = '';
    public ?string $customer_notes = null;
    public ?string $customer_phone = null;
    public ?string $customer_instagram = null;
    public ?string $customer_email = null;

    // Colección/Array de items y total
    public array $items = [];
    public float $total = 0.0;

    public function loadHistory(): void
    {
        //Current history form
        $this->h_new_comment = null;
        $this->h_status = null;

        $this->order->load('statusHistory');

        $this->history = $this->order->statusHistory->map(fn ($item) => [
            'id' => $item->id,
            'status' => $item->status,
            'comment' => $item->comment,
            'created_at' => $item->created_at->format('d/m/Y H:i'),
        ])->toArray();
    }

    /**
     * Carga los datos del modelo Order en el FormObject.
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
        $this->loadHistory();

        $this->order_number = $order->order_number;
        $this->customer_name = $order->user?->name ?? $order->customer_name ?? 'Cliente Invitado';

        $this->status = $order->status->value;

        //Customer
        $this->customer_notes = $order->customer_notes;
        $this->customer_phone = $order->customer_phone;
        $this->customer_instagram = $order->customer_instagram;
        $this->customer_email = $order->customer_email;
        // $this->notify_customer = false; // Reset por defecto

        // Formateamos los items para la tabla de la vista
        $this->items = $order->items->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->product_name ?? $item->product?->name ?? 'Producto no disponible',
                'image_url' => $item->product?->image_url ?? null,
                'quantity' => $item->quantity,
                'price' => (float) $item->price,
            ];
        })->toArray();

        $this->total = (float) $order->total;
    }

    public function addStatusChange(): void
    {
        $orderService = app(OrderServiceInterface::class);
        $orderService->updateOrderHistory($this->order->id, $this->h_status->value, $this->h_new_comment);

        $this->order->refresh();
        $this->status = $this->order->status->value;

        $this->h_new_comment = null;
        $this->h_status = null;
        $this->loadHistory();
    }

    /**
     * Reglas de validación para los campos editables.
     */
    public function rules(): array
    {
        return [
            'customer_phone' => ['nullable', 'string', 'min:8', 'max:20', 'regex:/^\+?[0-9]+(-[0-9]+)*$/'],
            'customer_instagram' => ['nullable', 'string', 'max:100'],
            'customer_email' => ['nullable', 'email', 'max:150'],
        ];
    }

    /**
     * Mensajes de error personalizados (opcional).
     */
    public function messages(): array
    {
        return [
            //Customer
            'customer_phone.string' => 'El teléfono debe ser un texto válido.',
            'customer_phone.max'    => 'El teléfono no puede superar los 20 caracteres.',
            'customer_phone.min'    => 'El teléfono debe tener al menos 8 caracteres.',
            'customer_phone.regex'  => 'El teléfono ingresado tiene un formato inválido.',

            'customer_instagram.string' => 'El usuario de Instagram debe ser un texto válido.',
            'customer_instagram.max'    => 'El usuario de Instagram no puede superar los 100 caracteres.',

            'customer_email.email' => 'Debés ingresar una dirección de correo electrónico válida.',
            'customer_email.max'   => 'El correo electrónico no puede superar los 150 caracteres.',

            //History
            'h_status.required' => 'Debés seleccionar un nuevo estado.',
            'h_status.enum'     => 'El estado seleccionado no es válido.',
            'h_status.Illuminate\Validation\Rules\Enum' => 'El estado seleccionado no es válido.',

            'h_new_comment.string' => 'El comentario debe ser un texto válido.',
            'h_new_comment.max'    => 'El comentario no puede superar los 500 caracteres.',
        ];
    }

    public function rulesHistory(): array
    {
        return [
            //History
            'h_status' => ['required', Rule::enum(OrderStatus::class)],
            'h_new_comment' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messagesHistory(): array
    {
        return [
            //History
            'h_status.required' => 'Debés seleccionar un nuevo estado.',
            'h_status.enum'     => 'El estado seleccionado no es válido.',
            'h_status.Illuminate\Validation\Rules\Enum' => 'El estado seleccionado no es válido.',

            'h_new_comment.string' => 'El comentario debe ser un texto válido.',
            'h_new_comment.max'    => 'El comentario no puede superar los 500 caracteres.',
        ];
    }
}
