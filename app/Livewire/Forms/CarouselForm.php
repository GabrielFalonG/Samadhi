<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\DTOs\Carousel\SaveCarouselData;
use App\DTOs\Carousel\CarouselItemData;

class CarouselForm extends Form
{
    public ?int $editingId = null;
    public string $title = '';
    public string $subtitle = '';
    public string $description = '';
    public string $section = 'productos';
    public int $position = 1;
    public bool $active = true;
    public array $products = [];

    public function rules(): array
    {
        return [
            // Reglas para el Carrusel
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'section'     => ['required', 'string', 'max:100'],
            'position'    => ['required', 'integer', 'min:1'],
            'active'      => ['required', 'boolean'],

            // Validaciones para los items/productos
            'products'               => ['required', 'array', 'min:1', 'max:5'],
            'products.*.productId'   => ['required', 'integer', 'exists:products,id'],
            'products.*.position'    => ['nullable', 'integer', 'min:1'], // <-- Cambiado a nullable
            'products.*.title'       => ['required', 'string', 'max:255'],
            'products.*.description' => ['nullable', 'string', 'max:500'],
            'products.*.image_url'   => ['required', 'string'],
            'products.*.link_url'    => ['nullable', 'string'],
        ];
    }

    /**
     * Mensajes de error personalizados para reglas específicas
     */
    public function messages(): array
    {
        return [
            // Title
            'title.required' => 'El título es obligatorio.',
            'title.string'   => 'El título debe ser un texto válido.',
            'title.max'      => 'El título no puede superar los 255 caracteres.',

            // Subtitle
            'subtitle.required' => 'El subtítulo es obligatorio.',
            'subtitle.string'   => 'El subtítulo debe ser un texto válido.',
            'subtitle.max'      => 'El subtítulo no puede superar los 255 caracteres.',

            // Description
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max'    => 'La descripción no puede superar los 1000 caracteres.',

            // Section
            'section.required' => 'La sección es obligatoria.',
            'section.string'   => 'La sección debe ser un texto válido.',
            'section.max'      => 'La sección no puede superar los 100 caracteres.',

            // Position
            'position.required' => 'La posición es obligatoria.',
            'position.integer'  => 'La posición debe ser un número entero.',
            'position.min'      => 'La posición debe ser como mínimo 1.',

            // Active
            'active.required' => 'El estado activo/inactivo es obligatorio.',
            'active.boolean'  => 'El estado debe ser verdadero o falso.',

            //Products
            'products.required' => 'Debes agregar al menos un producto al carrusel.',
            'products.min'      => 'Debes agregar al menos un producto al carrusel.',
            'products.max'      => 'No puedes agregar más de 5 productos a este carrusel.',
        ];
    }

    /**
     * Nombres personalizados para los atributos
     */
    public function validationAttributes(): array
    {
        return [
            'title'                => 'título del carrusel',
            'section'              => 'sección',
            'position'             => 'posición del carrusel',
            'products.*.productId' => 'ID del producto',
            'products.*.position'  => 'posición del producto',
            'products.*.title'     => 'título del producto',
            'products.*.image_url' => 'imagen del producto',
        ];
    }

    public function toDto(): SaveCarouselData
    {
        return new SaveCarouselData(
            id: $this->editingId,
            title: $this->title,
            subtitle: $this->subtitle ?: null,
            description: $this->description ?: null,
            section: $this->section,
            position: $this->position,
            active: $this->active,
            items: collect($this->products)
                ->map(fn ($product, $index) => new CarouselItemData(
                    productId: (int) $product['productId'],
                    position: (int) ($product['position'] ?? $index + 1),
                    title: $product['title'],
                    description: $product['description'] ?? '',
                    imageUrl: $product['image_url'],
                    linkUrl: $product['link_url'] ?? '',
                    price: (float) ($product['price'] ?? 0.0),
                    ingredients: $product['ingredients'] ?? '',
                ))
                ->all(),
        );
    }
}
