<?php

namespace App\Livewire\Components;

use App\DTOs\Products\ProductFilterData;
use App\Models\Category;
use App\Services\Category\Contracts\CategoryServiceInterface;
use App\Services\Products\Contracts\ProductServiceInterface;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsCatalog extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    protected CategoryServiceInterface $categoryService;
    protected ProductServiceInterface $productService;

    public ?Collection $allCategories = null;

    public ?Category $categoryObj = null;

    #[Url]
    public string $category = '';

    #[Url]
    public string $search = '';

    #[Url]
    public ?int $minPrice = null;

    #[Url]
    public ?int $maxPrice = null;

    #[Url(keep: true)]
    public string $sortBy = 'created_at';

    #[Url(keep: true)]
    public string $sortDirection = 'desc';

    public array $sortOptions = [
        'created_at-desc' => 'Más recientes',
        'price-desc' => 'Mayor precio',
        'price-asc' => 'Menor precio',
    ];

    public function mount()
    {
        $this->categoryObj = $this->categoryService->getCategoryBySlug($this->category);
        $this->allCategories = $this->categoryService->getActiveCategories();
    }

    public function boot(
        CategoryServiceInterface $categoryService,
        ProductServiceInterface $productService
    ): void {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'minPrice',
            'maxPrice',
            'price',
        ]);

        $this->resetPage();
    }

    public function updatedCategory(string $value)
    {
        $this->categoryObj = $this->categoryService->getCategoryBySlug($value);
        $this->resetPage();
    }

    public function updatedMinPrice($value)
    {
        $this->minPrice = $value !== '' ? (int) $value : null;
        $this->resetPage();
    }

    public function updatedMaxPrice($value)
    {
        $this->maxPrice = $value !== '' ? (int) $value : null;
        $this->resetPage();
    }

    public function setSort(string $sortBy, string $sortDirection): void
    {
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;

        $this->resetPage();
    }

    public function applyPriceFilter()
    {
        $this->resetPage();
    }

    public function getCategories()
    {
        return $this->categoryService->getActiveCategories();
    }

    private function toDto(): ProductFilterData
    {
        return new ProductFilterData(
            search: blank($this->search) ? null : $this->search,
            active: true,
            sortBy: $this->sortBy,
            sortDirection: $this->sortDirection,
            categories: [$this->categoryObj?->id ?? Category::DEFAULT_ID],
            minPrice: $this->minPrice !== null ? (float) $this->minPrice : null,
            maxPrice: $this->maxPrice !== null ? (float) $this->maxPrice : null,
            perPage: 12,
        );
    }

    public function getProducts()
    {
        return $this->productService->paginated($this->toDto())
                                    ->withPath(route('category'));
    }

    public function render()
    {
        $start = microtime(true);
        logger()->info('START PRODUCTS');
        $products = $this->getProducts();
        logger()->info('AFTER PRODUCTS', [
            'ms' => round((microtime(true) - $start) * 1000, 2),
        ]);

        return view('livewire.products.products-catalog', [
            'items' => $products,
            'categories' => $this->getCategories(),
        ]);
    }
}
