<?php

namespace App\Notifications;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use NotificationChannels\Telegram\TelegramFile;

class NewOrderTelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via(mixed $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram(mixed $notifiable)
    {
        try {
            // Carga de relaciones
            $this->order->loadMissing(['items']);

            // Generar PDF
            $pdf = Pdf::loadView('livewire.order.order-pdf', ['order' => $this->order])
                    ->setPaper('a4', 'portrait');

            $filename = "orders/order-{$this->order->id}.pdf";
            Storage::disk('public')->put($filename, $pdf->output());
            $pdfAbsolutePath = Storage::disk('public')->path($filename);

            $cleanPhone = preg_replace('/[^0-9]/', '', $this->order->customer_phone);
            $waMessage = urlencode("Hola {$this->order->customer_name}, te contacto por tu pedido #{$this->order->id}.");
            $whatsAppUrl = "https://wa.me/{$cleanPhone}?text={$waMessage}";

            // Extraer el chat_id desde la ruta del notifiable y castearlo a INT
            $chatId = (int) ($notifiable->routes['telegram'] ?? config('services.telegram-bot-api.chat_id'));

            return TelegramFile::create()
                ->to($chatId)
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
            dd($e);
        }
    }
}
