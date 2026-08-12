<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->string('order_number')->unique();
            $table->enum('status', [
                            'pending',
                            'confirmed',
                            'paid',
                            'preparing',
                            'shipped',
                            'completed',
                            'cancelled',
                            'awaiting_payment',
                            'waiting_stock',
                            'ready_for_pickup',
                            'returned',
                            'refunded',
                        ])->default('pending');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_instagram')->nullable();
            $table->string('customer_email')->nullable();
            $table->text('customer_notes')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->boolean('accept_terms');
            $table->string('source')->default('web');
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('status');
            $table->index('customer_phone');
            $table->index('created_at');
        });

        /*
        |--------------------------------------------------------------------------
        | Order Items
        |--------------------------------------------------------------------------
        */
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relación con la orden (Obligatoria)
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relación con el producto real (Obligatoria)
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            $table->string('product_name');

            // Trazabilidad del origen: carrusel desde donde se añadió (Opcional)
            $table->foreignId('carousel_item_id')
                ->nullable()
                ->constrained('carousel_items')
                ->nullOnDelete();

            $table->string('carousel_item_name')->nullable();

            // Detalles del ítem
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();
            $table->softDeletes();

            // Índices para optimizar búsquedas
            $table->index('order_id');
            $table->index('product_id');
            $table->index('carousel_item_id');
        });

        /*
        |--------------------------------------------------------------------------
        | Order Status History
        |--------------------------------------------------------------------------
        */

        Schema::create('order_status_history', function (Blueprint $table) {

            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('status');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_history');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
