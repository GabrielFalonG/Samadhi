<?php

namespace App\Livewire\Components;

use App\Models\Product;
use App\Services\Favorite\Contracts\FavoriteServiceInterface;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class HeaderFavoriteDropdown extends Component
{
    protected FavoriteServiceInterface $favoriteService;

    public ?Collection $products = null;
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
        $this->products = $this->favoriteService->getFavoriteProducts();
        $this->favoriteIds = $this->products->pluck('id')->toArray();
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
        return view('livewire.favorite.header-favorite-dropdown', [
            'products' => $this->products,
            'count'    => count($this->favoriteIds),
        ]);
    }
}
