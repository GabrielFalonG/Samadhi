<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use App\Services\Category\Contracts\CategoryServiceInterface;
use App\Services\Products\Contracts\ProductServiceInterface;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class ProductsAdminEdit extends Component
{
    use WithFileUploads;

    public ProductForm $form;
    public ?Product $product = null;

    //Select categories
    public ?Collection $selectableCategories = null;

    //Ingredients
    public array $selectableIngredients = [];

    // Path de la imagen actual guardada en la DB
    public ?string $existingImage = null;

    //Modal
    public bool $showConfirmModal = false;

    protected ProductServiceInterface $productService;
    protected CategoryServiceInterface $categoryService;

    public function boot(
        ProductServiceInterface $productService,
        CategoryServiceInterface $categoryService
    ): void
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function mount(int $id)
    {
        try {
            $this->product = $this->productService->getProductById($id);
            $this->form->setProduct($this->product);
            $this->selectableCategories = $this->categoryService->getActiveCategories();
            $this->selectableIngredients = $this->productService->getSelectableIngredients();
            $this->form->selectedIngredients = str($this->form->ingredients)
                                                    ->explode(',')
                                                    ->map(fn ($item) => trim($item))
                                                    ->filter()->values()->all();
        } catch (Exception $e) {
            report($e);
            flashMessageError('Ha ocurrido un error al cargar los datos del productos');
        }
    }

    #[Computed]
    public function imagePreview(): ?string
    {
        return $this->form->getImageUrl();
    }

    #[Computed]
    public function originalImage(): ?string
    {
        return $this->form->getOriginalImageUrl();
    }

    public function confirmSave(): void
    {
        try {
            $this->form->validate();
            $this->showConfirmModal = true;
        } catch (ValidationException $e) {
            flashMessageError('Hay errores en el formulario, revisá los campos.');
            throw $e;
        }
    }

    public function cancelSave(): void
    {
        $this->showConfirmModal = false;
    }

    public function save(): void
    {
        try {
            $this->productService->update($this->product, $this->form->toDto());
            $this->showConfirmModal = false;
            flashMessageSuccess('Producto editado correctamente.');
            $this->redirectRoute('admin.products', navigate: true);
        } catch (Exception $e) {
            report($e);
            flashMessageError('Ocurrió un error al crear el producto.');
        }
    }

    public function render()
    {
        return view('livewire.products.products-admin-edit')
                    ->layout('components.layouts.admin');
    }
}
