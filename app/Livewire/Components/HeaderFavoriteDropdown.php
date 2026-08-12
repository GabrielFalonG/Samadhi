<?php

namespace App\Livewire\Components;

use App\Models\Product;
use App\Services\Favorite\Contracts\FavoriteServiceInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class HeaderFavoriteDropdown extends Component
{
    protected FavoriteServiceInterface $favoriteService;

    public array $favoriteIds = [];

    public function mount(): void
    {
        $this->loadFavorites();
    }

    public function boot(FavoriteServiceInterface $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    #[On('favorite-updated')]
    public function loadFavorites(): void
    {
        $products = $this->favoriteService->getFavoriteProducts();
        $this->favoriteIds = $products->pluck('id')->toArray();
    }

    public function removeFavorite(int $productId): void
    {
        $this->favoriteService->toggleFavorite($productId);
        $this->loadFavorites();
        $this->dispatch('favorite-updated');
        $this->dispatch('favorite-page-updated');
    }

    public function render()
    {
        // Consultamos la BD usando los IDs obtenidos del servicio de Redis
        $products = Product::whereIn('id', $this->favoriteIds)->get();

        return view('livewire.favorite.header-favorite-dropdown', [
            'products' => $products,
            'count'    => count($this->favoriteIds),
        ]);
    }
}
