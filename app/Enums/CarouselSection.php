<?php

namespace App\Enums;

enum CarouselSection: string
{
    case HOME = 'home';
    case PRODUCTS = 'products';
    case CATEGORY = 'category';
    case PRODUCT_DETAIL = 'product_detail';
    case CART = 'cart';
    case OFFERS = 'offers';
    case SERVICES = 'services';
    case ABOUT_US = 'about_us';

    /**
     * Etiqueta legible en español para mostrar en la UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::HOME => 'Inicio',
            self::PRODUCTS => 'Productos',
            self::CATEGORY => 'Categorías',
            self::PRODUCT_DETAIL => 'Detalle de producto',
            self::CART => 'Carrito',
            self::OFFERS => 'Ofertas',
            self::SERVICES => 'Servicios',
            self::ABOUT_US => 'Sobre nosotros',
        };
    }
}
