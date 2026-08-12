<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatusHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_status_history';

    protected $fillable = [
        'order_id',
        'status',
        'comment',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    /**
     * Obtiene el pedido asociado a este registro de historial.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
