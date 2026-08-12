<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pedido #{{ $order->order_number ?? $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* Encabezado */
        .header {
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 15px;
        }
        .header table {
            width: 100%;
        }
        .brand-title {
            font-size: 22px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
        }
        .order-title {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            color: #475569;
        }

        /* Secciones de Datos */
        .details-box {
            width: 100%;
            margin-bottom: 20px;
        }
        .details-box td {
            vertical-align: top;
            width: 50%;
        }
        .card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
        }
        .card-title {
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 8px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
        }

        /* Tabla de Productos */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #f1f5f9;
            color: #334155;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
            border-bottom: 2px solid #cbd5e1;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .origin-badge {
            display: inline-block;
            font-size: 9px;
            color: #2563eb;
            background-color: #eff6ff;
            padding: 2px 6px;
            border-radius: 4px;
            margin-top: 3px;
        }

        /* Totales */
        .totals-table {
            width: 40%;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 6px 10px;
            text-align: right;
        }
        .totals-table .label {
            color: #64748b;
        }
        .totals-table .amount {
            font-weight: bold;
        }
        .totals-table .grand-total {
            font-size: 14px;
            color: #1e3a8a;
            border-top: 2px solid #3b82f6;
            padding-top: 8px;
        }

        /* Comentarios y Pie */
        .notes-box {
            margin-top: 20px;
            background-color: #fffbebfb;
            border: 1px solid #fef08a;
            border-radius: 6px;
            padding: 10px;
            font-size: 11px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="brand-title">Tu E-Commerce</div>
                    <span style="color: #64748b; font-size: 10px;">Comprobante de Reserva / Pedido</span>
                </td>
                <td class="order-title">
                    PEDIDO #{{ $order->order_number ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}<br>
                    <span style="font-size: 10px; font-weight: normal; color: #64748b;">
                        Fecha: {{ $order->created_at->format('d/m/Y H:i') }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Datos del Cliente y Pedido -->
    <table class="details-box">
        <tr>
            <td style="padding-right: 10px;">
                <div class="card">
                    <div class="card-title">Datos del Cliente</div>
                    <strong>Nombre:</strong> {{ $order->customer_name }}<br>
                    <strong>Teléfono:</strong> {{ $order->customer_phone }}<br>
                    @if($order->customer_email)
                        <strong>Email:</strong> {{ $order->customer_email }}<br>
                    @endif
                    @if($order->customer_instagram)
                        <strong>Instagram:</strong> {{ $order->customer_instagram }}<br>
                    @endif
                </div>
            </td>
            <td style="padding-left: 10px;">
                <div class="card">
                    <div class="card-title">Detalles del Envío y Estado</div>
                    <strong>Estado actual:</strong>
                    <span style="text-transform: uppercase; font-weight: bold; color: #d97706;">
                        {{ $order->status }}
                    </span><br>
                    <strong>Origen de compra:</strong> {{ ucfirst($order->source ?? 'Web') }}<br>
                    <strong>Costo de Envío:</strong> ${{ number_format($order->shipping_cost, 2, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Tabla de Ítems Comprados -->
    <table class="items-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th style="text-align: center;">Cant.</th>
                <th style="text-align: right;">Precio Unit.</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->carousel_item_name)
                            <br>
                            <span class="origin-badge">
                                Seccion: {{ $item->carousel_item_name }}
                            </span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">${{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td style="text-align: right;">${{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla de Liquidación -->
    <table class="totals-table">
        <tr>
            <td class="label">Subtotal:</td>
            <td class="amount">${{ number_format($order->subtotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Costo de Envío:</td>
            <td class="amount">${{ number_format($order->shipping_cost, 2, ',', '.') }}</td>
        </tr>
        <tr class="grand-total">
            <td class="label" style="font-weight: bold; color: #1e3a8a;">TOTAL:</td>
            <td class="amount" style="font-size: 14px; color: #1e3a8a;">
                ${{ number_format($order->total, 2, ',', '.') }}
            </td>
        </tr>
    </table>

    <!-- Observaciones del Cliente -->
    @if($order->customer_notes)
        <div class="notes-box">
            <strong>Observaciones del Cliente:</strong><br>
            {{ $order->customer_notes }}
        </div>
    @endif

    <!-- Pie del Documento -->
    <div class="footer">
        Gracias por tu compra. Si tenés alguna duda sobre este pedido, ponete en contacto con nosotros.
    </div>

</body>
</html>
