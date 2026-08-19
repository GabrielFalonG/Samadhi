<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\DTOs\Carousel\SaveCarouselData;
use App\DTOs\Carousel\CarouselItemData;
use App\Enums\CarouselSection;
use App\Models\Carousel;

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

    public function setCarousel(Carousel $carousel): void
    {
        $this->editingId = $carousel->id;
        $this->title = $carousel->title;
        $this->subtitle = $carousel->subtitle ?? '';
        $this->description = $carousel->description ?? '';
        $this->section = $carousel->section;
        $this->position = $carousel->position;
        $this->active = (bool) $carousel->active;

        $this->products = $carousel->products->pluck('id')
                                            ->map(fn ($id) => (int) $id)
                                            ->values()
                                            ->all();
    }

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
            'products' => ['required', 'array', 'min:1', 'max:5'],
            'products.*' => ['required', 'integer', 'exists:products,id'],
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
            'products.required' => 'Debes seleccionar al menos un producto.',
            'products.array'    => 'Los productos seleccionados no tienen un formato válido.',
            'products.min'      => 'Debes seleccionar al menos un producto.',
            'products.max'      => 'Puedes seleccionar como máximo 5 productos.',

            'products.*.required' => 'El producto seleccionado es obligatorio.',
            'products.*.integer'  => 'El producto seleccionado no es válido.',
            'products.*.exists'   => 'Uno de los productos seleccionados no existe.',
        ];
    }

    /**
     * Nombres personalizados para los atributos
     */
    public function validationAttributes(): array
    {
        return [
            'title'    => 'título del carrusel',
            'section'  => 'sección',
            'position' => 'posición del carrusel',
            'products' => 'productos',
            'products.*' => 'producto',
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
                    ->values()
                    ->map(fn ($productId, $index) => new CarouselItemData(
                        productId: (int) $productId,
                        position: $index + 1,
                    ))
                    ->all(),
        );
    }

    public function sections(): array
    {
        return array_map(
            fn (CarouselSection $section) => [
                'value' => $section->value,
                'label' => $section->label(),
            ],
            CarouselSection::cases()
        );
    }

    public function getSelectableProducts(array $products): array
    {
        return array_map(
            fn(array $item) => [
                'id' => $item['id'],
                'name' => $item['title'],
                'image' => $item['image_url'] ?? null,
            ],
            $products
        );
    }
}
