<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramFile;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Storage;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Crear la instancia de la notificación recibiendo la orden.
     */
    public function __construct(public Order $order)
    {
    }

    /**
     * Define por qué canales se enviará la notificación.
     */
    public function via(object $notifiable): array
    {
        // HOY: Solo enviamos por Telegram
        $rawChannels = config('services.notifications.channels', 'telegram');
        $channels = array_filter(array_map('trim', explode(',', $rawChannels)));
        return $channels;

        // FUTURO: Cuando quieras activar email, simplemente cambias a:
        // return ['telegram', 'mail'];
    }

    public function toTelegram(mixed $notifiable)
    {
        try {
            $this->order->loadMissing(['items']);

            $pdf = Pdf::loadView('livewire.order.order-pdf', ['order' => $this->order])
                ->setPaper('a4', 'portrait');

            $filename = "orders/order-{$this->order->id}.pdf";
            Storage::disk('public')->put($filename, $pdf->output());
            $pdfAbsolutePath = Storage::disk('public')->path($filename);

            $cleanPhone = preg_replace('/[^0-9]/', '', $this->order->customer_phone);
            $waMessage = urlencode("Hola {$this->order->customer_name}, te contacto por tu pedido #{$this->order->id}.");
            $whatsAppUrl = "https://wa.me/{$cleanPhone}?text={$waMessage}";

            // Simplemente retornas TelegramFile sin llamar a ->to(...)
            return TelegramFile::create()
                ->document($pdfAbsolutePath, "pedido-{$this->order->id}.pdf")
                ->content(
                    "🚨 *¡Nuevo Pedido Recibido!*\n\n" .
                    "*Pedido:* #{$this->order->id}\n" .
                    "*Cliente:* {$this->order->customer_name}\n" .
                    "*Total:* $" . number_format($this->order->total, 2, ',', '.')
                )
                ->button('📱 Abrir WhatsApp del Cliente', $whatsAppUrl);

        } catch (Exception $e) {
            report($e);
            throw $e;
        }
    }

    /**
     * Estructura del email (Listo para cuando actives 'mail' en via()).
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Nuevo Pedido #{$this->order->id}")
            ->greeting("¡Hola Admin!")
            ->line("Se ha recibido un nuevo pedido por un total de $" . number_format($this->order->total, 2, ',', '.'))
            ->action('Ver Pedido en Panel', url("/admin/orders/{$this->order->id}"));
    }
}
