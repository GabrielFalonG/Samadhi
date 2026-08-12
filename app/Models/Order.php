<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'status',
        'customer_name',
        'customer_phone',
        'customer_instagram',
        'customer_email',
        'customer_notes',
        'subtotal',
        'shipping_cost',
        'total',
        'accept_terms',
        'source',
        'notified_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'accept_terms' => 'boolean',
        'notified_at' => 'datetime',
        'status' => OrderStatus::class,
    ];

    protected $appends = [
        'created_at_formatted',
        'created_time_formatted',
    ];

    /**
     * Obtiene todos los ítems asociados al pedido.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Obtiene el historial de estados del pedido.
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    protected function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->format('d-m-Y')
        );
    }

    protected function createdTimeFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->format('H:i:s')
        );
    }

    /**
     * Recalcula y guarda el subtotal y total según los items persistidos.
     */
    public function recalculateTotals(?float $shippingCost = null): void
    {
        if ($shippingCost !== null) {
            $this->shipping_cost = $shippingCost;
        }

        // Suma el subtotal directamente desde los items guardados
        $this->subtotal = (float) $this->items()->sum('subtotal');

        // Suma el costo de envío
        $this->total = $this->subtotal + (float) $this->shipping_cost;

        $this->save();
    }
}
