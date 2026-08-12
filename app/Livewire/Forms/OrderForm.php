<?php

namespace App\Livewire\Forms;

use App\DTOs\Orders\CreateOrderData;
use App\DTOs\Orders\OrderItemData;
use App\DTOs\Orders\OrderStatusHistoryData;
use Illuminate\Validation\Rule;
use Livewire\Form;

class OrderForm extends Form
{
    // Datos del cliente
    public string $customer_name = '';
    public string $customer_phone = '';
    public ?string $customer_instagram = null;
    public ?string $customer_email = null;
    public ?string $customer_notes = null;

    // Totales
    public float $subtotal = 0.0;
    public float $shipping_cost = 0.0;
    public float $total = 0.0;

    // Términos y origen
    public bool $accept_terms = false;
    public string $source = 'web';

    // Comentario inicial
    public ?string $comment = null;

    // Lista de ítems seleccionados (Estructura: id, title, price, quantity, carousel_item_id, carousel_item_name)
    public array $items = [];

    public function rules(): array
    {
        return [
            'customer_name'      => ['required', 'string', 'min:3', 'max:250'],
            'customer_phone'     => ['required', 'string', 'max:50'],
            'customer_instagram' => ['nullable', 'string', 'max:100'],
            'customer_email'     => ['nullable', 'email', 'max:250'],
            'customer_notes'     => ['nullable', 'string', 'max:1000'],

            'subtotal'      => ['required', 'numeric', 'min:0'],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'total'         => ['required', 'numeric', 'min:0'],

            'accept_terms' => ['required', 'boolean', 'accepted'],
            'source'       => ['nullable', 'string', 'max:50'],
            'comment'      => ['nullable', 'string', 'max:500'],

            // Validaciones del producto principal
            'items'                     => ['required', 'array', 'min:1'],
            'items.*.id'                => ['required', 'integer', 'exists:products,id,deleted_at,NULL'],
            'items.*.title'             => ['required', 'string', 'max:250'],
            'items.*.quantity'          => ['required', 'integer', 'min:1'],
            'items.*.price'             => ['required', 'numeric', 'min:0'],

            // Validaciones opcionales para el origen del carrusel
            'items.*.carousel_item_id'   => ['nullable', 'integer', 'exists:carousels,id,deleted_at,NULL'],
            'items.*.carousel_item_name' => ['nullable', 'string', 'max:250'],
        ];
    }

    public function messages(): array
    {
        return [
            // Datos del cliente
            'customer_name.required'  => 'Ingresá tu nombre completo.',
            'customer_name.string'    => 'El nombre debe ser un texto válido.',
            'customer_name.min'       => 'El nombre debe tener al menos :min caracteres.',
            'customer_name.max'       => 'El nombre no puede superar los :max caracteres.',

            'customer_phone.required' => 'Ingresá un teléfono de contacto.',
            'customer_phone.string'   => 'El teléfono debe ser un texto válido.',
            'customer_phone.max'      => 'El teléfono no puede superar los :max caracteres.',

            'customer_instagram.string' => 'El usuario de Instagram debe ser un texto válido.',
            'customer_instagram.max'    => 'El usuario de Instagram no puede superar los :max caracteres.',

            'customer_email.email'    => 'Ingresá una dirección de correo electrónico válida.',
            'customer_email.max'      => 'El correo electrónico no puede superar los :max caracteres.',

            'customer_notes.string'   => 'Las observaciones deben ser un texto válido.',
            'customer_notes.max'      => 'Las observaciones no pueden superar los :max caracteres.',

            // Montos y totales
            'subtotal.required'       => 'El subtotal del pedido es obligatorio.',
            'subtotal.numeric'        => 'El subtotal debe ser un número válido.',
            'subtotal.min'            => 'El subtotal no puede ser negativo.',

            'shipping_cost.required'  => 'El costo de envío es obligatorio.',
            'shipping_cost.numeric'   => 'El costo de envío debe ser un número válido.',
            'shipping_cost.min'       => 'El costo de envío no puede ser negativo.',

            'total.required'          => 'El total del pedido es obligatorio.',
            'total.numeric'           => 'El total debe ser un número válido.',
            'total.min'               => 'El total no puede ser negativo.',

            // Términos y origen
            'accept_terms.required'   => 'Debés aceptar los términos de contacto para continuar.',
            'accept_terms.accepted'   => 'Debés aceptar los términos de contacto para continuar.',
            'accept_terms.boolean'    => 'La opción de términos debe ser válida.',

            'source.string'           => 'El origen debe ser un texto válido.',
            'source.max'              => 'El origen no puede superar los :max caracteres.',

            'comment.string'          => 'El comentario debe ser un texto válido.',
            'comment.max'             => 'El comentario no puede superar los :max caracteres.',

            // Items del carrito
            'items.required'          => 'Tu carrito no contiene ningún producto.',
            'items.array'             => 'Los productos del carrito deben estar organizados en una lista.',
            'items.min'               => 'Debés agregar al menos un producto al carrito para realizar el pedido.',

            'items.*.id.required'     => 'Uno de los productos seleccionados no es válido.',
            'items.*.id.integer'      => 'El identificador del producto debe ser un número entero.',
            'items.*.id.exists'       => 'Uno de los productos seleccionados ya no se encuentra disponible.',

            'items.*.title.required'  => 'Falta el nombre de uno de los productos.',
            'items.*.title.string'    => 'El nombre del producto debe ser un texto válido.',
            'items.*.title.max'       => 'El nombre del producto supera la cantidad máxima de caracteres.',

            'items.*.quantity.required' => 'Debés indicar la cantidad para cada producto.',
            'items.*.quantity.integer'  => 'La cantidad de cada producto debe ser un número entero.',
            'items.*.quantity.min'      => 'La cantidad mínima por producto es 1.',

            'items.*.price.required'  => 'El precio unitario de uno de los productos es obligatorio.',
            'items.*.price.numeric'   => 'El precio unitario debe ser un valor numérico.',
            'items.*.price.min'       => 'El precio unitario no puede ser negativo.',

            'items.*.carousel_item_id.integer' => 'El origen del carrusel debe ser un entero válido.',
            'items.*.carousel_item_id.exists'  => 'El carrusel de origen especificado no existe.',
        ];
    }

    /**
     * Calcula dinámicamente el subtotal y el total del formulario.
     */
    public function calculateTotals(): void
    {
        $this->subtotal = array_reduce($this->items, function ($acc, $item) {
            return $acc + ((int) $item['quantity'] * (float) $item['price']);
        }, 0.0);

        $this->total = $this->subtotal + $this->shipping_cost;
    }

    /**
     * Convierte los datos de la vista/carrito al DTO para guardar en la BD.
     */
    public function toDto(): CreateOrderData
    {
        $itemsDto = array_map(
            fn (array $item) => new OrderItemData(
                productId: (int) $item['id'],
                productName: (string) $item['title'],
                quantity: (int) $item['quantity'],
                unitPrice: (float) $item['price'],
                subtotal: (float) ((int) $item['quantity'] * (float) $item['price']),
                carouselItemId: isset($item['carousel_item_id']) ? (int) $item['carousel_item_id'] : null,
                carouselItemName: isset($item['carousel_item_name']) ? (string) $item['carousel_item_name'] : null,
            ),
            $this->items
        );

        return new CreateOrderData(
            customerName: $this->customer_name,
            customerPhone: $this->customer_phone,
            customerInstagram: $this->customer_instagram,
            customerEmail: $this->customer_email,
            customerNotes: $this->customer_notes,
            subtotal: (float) $this->subtotal,
            shippingCost: (float) $this->shipping_cost,
            total: (float) $this->total,
            acceptTerms: (bool) $this->accept_terms,
            source: $this->source,
            items: $itemsDto,
            statusHistory: new OrderStatusHistoryData(
                status: 'pending',
                comment: $this->comment ?? 'Pedido registrado desde el formulario Livewire'
            )
        );
    }
}
