<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case PAID = 'paid';
    case PREPARING = 'preparing';
    case SHIPPED = 'shipped';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case AWAITING_PAYMENT = 'awaiting_payment';
    case WAITING_STOCK = 'waiting_stock';
    case READY_FOR_PICKUP = 'ready_for_pickup';
    case RETURNED = 'returned';
    case REFUNDED = 'refunded';

    /**
     * Etiqueta legible en español para mostrar en la UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendiente',
            self::CONFIRMED => 'Confirmado',
            self::PAID => 'Pagado',
            self::PREPARING => 'En preparación',
            self::SHIPPED => 'Enviado',
            self::COMPLETED => 'Completado',
            self::CANCELLED => 'Cancelado',
            self::AWAITING_PAYMENT => 'Esperando pago',
            self::WAITING_STOCK => 'Esperando stock',
            self::READY_FOR_PICKUP => 'Listo para retirar',
            self::RETURNED => 'Devuelto',
            self::REFUNDED => 'Reembolsado',
        };
    }

    /**
     * Clases de colores Tailwind CSS para Badges en la vista.
     */
    public function color(): string
    {
        return match ($this) {
            // Espera y Pago
            self::PENDING => 'bg-amber-50 text-amber-700 border-amber-200',
            self::AWAITING_PAYMENT => 'bg-yellow-50 text-yellow-700 border-yellow-200',
            self::PAID => 'bg-emerald-50 text-emerald-700 border-emerald-200',

            // Procesamiento y Logística
            self::CONFIRMED => 'bg-blue-50 text-blue-700 border-blue-200',
            self::WAITING_STOCK => 'bg-orange-50 text-orange-700 border-orange-200',
            self::PREPARING => 'bg-sky-50 text-sky-700 border-sky-200',
            self::SHIPPED => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            self::READY_FOR_PICKUP => 'bg-violet-50 text-violet-700 border-violet-200',

            // Éxito
            self::COMPLETED => 'bg-teal-50 text-teal-700 border-teal-200',

            // Cancelaciones y Devoluciones
            self::CANCELLED => 'bg-rose-50 text-rose-700 border-rose-200',
            self::RETURNED => 'bg-slate-100 text-slate-700 border-slate-200',
            self::REFUNDED => 'bg-purple-50 text-purple-700 border-purple-200',
        };
    }
}
