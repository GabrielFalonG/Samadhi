<?php

namespace App\Livewire\Forms;

use App\DTOs\Products\ProductSaveData;
use App\Models\Product;
use App\Services\Products\Contracts\ProductServiceInterface;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;
use Livewire\Attributes\Validate;

class ProductForm extends Form
{
    #[Validate('required|string|min:3|max:250')]
    public string $title = '';

    #[Validate('nullable|string|min:3|max:250')]
    public string $description = '';

    #[Validate('nullable|string|min:3|max:500')]
    public string $long_description = '';

    #[Validate('nullable|string|min:3|max:500')]
    public string $ingredients = '';

    #[Validate('required|numeric|min:0')]
    public $price = '';

    #[Validate('boolean')]
    public bool $active = true;

    #[Validate('required|array|min:1')]
    public array $categories = [];

    // #[Validate('required|image|max:2048')]
    public $image = null;

    // Path de la imagen actual guardada en la DB
    public ?string $existingImage = null;
    public array $defaultCategory = [\App\Models\Category::DEFAULT_ID];
    public array $selectedIngredients = [];

    public function toDto(): ProductSaveData
    {
        $productService = app(ProductServiceInterface::class);
        $this->ingredients = implode(',', $this->selectedIngredients);

        return new ProductSaveData(
            productId: null,
            title: $this->title,
            description: $this->description,
            long_description: $this->long_description,
            price: $this->price,
            active: $this->active,
            image: $this->image,
            ingredients: $this->ingredients,
            categories: $this->categories,
        );
    }

    /**
     * Mapea y setea los datos desde la base de datos a las propiedades del Form
     */
    public function setProduct(Product $product): void
    {
        $this->title            = $product->title;
        $this->description      = $product->description;
        $this->long_description = $product->long_description;
        $this->ingredients      = $product->ingredients ?? '';
        $this->price            = $product->price;
        $this->active           = $product->active;
        $this->categories       = $product->categories->pluck('id')->all();

        $this->existingImage    = $product->image_url;
    }

    /**
     * Retorna la URL correspondiente a mostrar (Preview o DB)
     */
    public function getImageUrl(): ?string
    {
        if ($this->image) {
            return $this->image->temporaryUrl();
        }

        // 2. Si hay ruta en la BD
        if ($this->existingImage) {
            // Si el valor guardado en BD ya empieza con "storage/" o "/storage/"
            if (str_starts_with(ltrim($this->existingImage, '/'), 'storage/')) {
                return asset(ltrim($this->existingImage, '/'));
            }

            // Si en la BD solo tenés "products/calma.png"
            return Storage::url($this->existingImage);
        }

        return null;
    }

    /**
     * Devuelve únicamente la URL de la imagen guardada en la DB
     */
    public function getOriginalImageUrl(): ?string
    {
        if ($this->existingImage) {
            if (str_starts_with(ltrim($this->existingImage, '/'), 'storage/')) {
                return asset(ltrim($this->existingImage, '/'));
            }

            return Storage::url($this->existingImage);
        }

        return null;
    }

    protected function rules(): array
    {
        $isImgRequired = empty($this->existingImage) ? 'required' : 'nullable';

        return [
            'title'            => ['required', 'string', 'min:3', 'max:250'],
            'description'      => ['nullable', 'string', 'min:3', 'max:250'],
            'long_description' => ['nullable', 'string', 'min:3', 'max:500'],
            'ingredients'      => ['nullable', 'string', 'min:3', 'max:500'],
            'price'            => ['required', 'numeric', 'min:0'],
            'active'           => ['boolean'],
            'image'            => [$isImgRequired, 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required'            => 'El nombre del producto es obligatorio.',
            'title.string'              => 'El nombre debe ser un texto válido.',
            'title.min'                 => 'El nombre debe tener al menos 3 caracteres.',
            'title.max'                 => 'El nombre no puede superar los 255 caracteres.',

            'description.string'        => 'La descripción corta debe ser un texto válido.',
            'description.min'           => 'La descripción corta debe tener al menos 3 caracteres.',
            'description.max'           => 'La descripción corta no puede superar los 250 caracteres.',

            'long_description.string'   => 'La descripción detallada debe ser un texto válido.',
            'long_description.min'      => 'La descripción detallada debe tener al menos 3 caracteres.',
            'long_description.max'      => 'La descripción detallada no puede superar los 500 caracteres.',

            'ingredients.string'        => 'Los ingredientes deben ser un texto válido.',
            'ingredients.min'           => 'Los ingredientes deben tener al menos 3 caracteres.',
            'ingredients.max'           => 'Los ingredientes no pueden superar los 500 caracteres.',

            'price.required'            => 'El precio es obligatorio.',
            'price.numeric'             => 'El precio debe ser un número válido.',
            'price.min'                 => 'El precio no puede ser negativo.',

            'active.boolean'            => 'El estado debe ser activo o inactivo.',

            'image.required'            => 'La imagen del producto es obligatoria.',
            'image.image'               => 'El archivo seleccionado debe ser una imagen.',
            'image.max'                 => 'La imagen no debe pesar más de 2 MB (2048 KB).',
        ];
    }
}
