<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderNotifications implements ShouldQueue
{
    /**
     * Maneja el evento OrderCompleted.
     */
    public function handle(OrderCompleted $event): void
    {
        // Obtener el ID del chat de Telegram desde la configuración
        $chatId = config('services.telegram-bot-api.chat_id');

        if (!$chatId) {
            return;
        }

        // Ruteamos la notificación a los canales deseados
        Notification::route('telegram', $chatId)
            ->route('mail', config('mail.from.address')) // Preparado para cuando actives 'mail' en el método via() de la notificación
            ->notify(new NewOrderNotification($event->order));
    }
}
