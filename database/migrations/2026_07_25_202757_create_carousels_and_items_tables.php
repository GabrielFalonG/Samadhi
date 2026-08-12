<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Carousels
        |--------------------------------------------------------------------------
        */

        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('subtitle', 120)->nullable();
            $table->string('description', 300)->nullable();
            $table->enum('section', [
                'home',             // inicio
                'products',         // productos (catálogo general)
                'category',         // vista de categoría
                'product_detail',   // ficha/detalle del producto
                'cart',             // carrito / checkout
                'offers',           // ofertas / promociones
                'services',         // servicios / talleres
                'about_us',         // nosotros / institucional
            ])->default('products');
            $table->unsignedInteger('position')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index(
                ['section', 'active', 'position'],
                'idx_carousels_visibility'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('slug', 150)->unique();
            $table->string('description', 250)->nullable();
            $table->string('long_description', 500)->nullable();
            $table->string('image_url', 500)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('ingredients', 500)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index('active');
        });

        /*
        |--------------------------------------------------------------------------
        | Carousel Items (Tabla pivote)
        |--------------------------------------------------------------------------
        */

        Schema::create('carousel_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carousel_id')
                ->constrained('carousels')
                ->cascadeOnDelete();
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();
            $table->unsignedTinyInteger('position');
            $table->timestamps();
            /*
             * Un producto sólo puede aparecer una vez
             * dentro del mismo carrusel.
             */
            $table->unique(
                ['carousel_id', 'product_id'],
                'uq_carousel_product'
            );

            /*
             * Cada posición del carrusel debe ser única.
             */
            $table->unique(
                ['carousel_id', 'position'],
                'uq_carousel_position'
            );

            $table->index('product_id');
        });

        /*
        |--------------------------------------------------------------------------
        | Trigger MySQL 5.7
        |--------------------------------------------------------------------------
        */
        DB::unprepared('
            CREATE TRIGGER chk_carousel_item_position_insert
            BEFORE INSERT ON carousel_items
            FOR EACH ROW
            BEGIN
                IF NEW.position < 1 OR NEW.position > 15 THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error de restricción: position debe estar entre 1 y 15.";
                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER chk_carousel_item_position_update
            BEFORE UPDATE ON carousel_items
            FOR EACH ROW
            BEGIN
                IF NEW.position < 1 OR NEW.position > 15 THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Error de restricción: position debe estar entre 1 y 15.";
                END IF;
            END
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('carousel_items');
        Schema::dropIfExists('products');
        Schema::dropIfExists('carousels');
    }
};
