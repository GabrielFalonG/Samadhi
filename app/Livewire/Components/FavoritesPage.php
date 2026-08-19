<?php

namespace App\Livewire\Components;

use App\Concerns\InteractsWithCart;
use App\Models\Category;
use App\Services\Favorite\Contracts\FavoriteServiceInterface;
use App\Services\Category\Contracts\CategoryServiceInterface;
use Exception;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class FavoritesPage extends Component
{
    use InteractsWithCart;

    protected FavoriteServiceInterface $favoriteService;
    protected CategoryServiceInterface $categoryService;

    #[Url(except: '')]
    public ?string $product = '';
    public ?Category $defaultCategory = null;

    public function mount()
    {
        $this->defaultCategory = $this->categoryService->getCategoryId(Category::DEFAULT_ID);
    }

    public function boot(
        FavoriteServiceInterface $favoriteService,
        categoryServiceInterface $categoryService
    ): void
    {
        $this->favoriteService = $favoriteService;
        $this->categoryService = $categoryService;
    }

    public function removeFavorite(int $productId): void
    {
        $this->favoriteService->toggleFavorite($productId);
        $this->dispatch('favorite-updated');
    }

    #[On('favorite-page-updated')]
    public function refreshFavorites(): void
    {
        try {
            if ($this->product) {
                $favorites = $this->favoriteService->getFavoriteProducts();
                $stillExists = $favorites->contains('slug', $this->product);

                if (!$stillExists) {
                    $this->product = '';
                }
            }
        } catch (Exception $e) {
            report($e);
        }
    }

    public function render()
    {
        $products = $this->favoriteService->getFavoriteProducts();

        if ($this->product) {
            $products = $products->where('slug', $this->product);
        }

        return view('livewire.favorite.favorite-page', [
            'products' => $products,
        ]);
    }
}
