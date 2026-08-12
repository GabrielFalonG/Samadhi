<?php

namespace App\Exports\Pdf;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Storage;

class GenrateOrderPdf
{
    public function generateOrderPdf(Order $order): string
    {
        try {
            $pdf = Pdf::loadView('livewire.order.order-pdf', ['order' => $order])
                ->setPaper('a4', 'portrait');

            $path = "orders/order-{$order->id}.pdf";
            Storage::disk('public')->put($path, $pdf->output());
            return Storage::url($path);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
