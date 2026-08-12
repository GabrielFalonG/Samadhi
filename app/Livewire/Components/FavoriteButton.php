<?php

namespace App\Livewire\Components;

use App\Services\Favorite\Contracts\FavoriteServiceInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class FavoriteButton extends Component
{
    protected FavoriteServiceInterface $favoriteService;

    public int $productId;
    public bool $isFavorite = false;

    public function mount(int $productId): void
    {
        $this->productId = $productId;
        $this->isFavorite = $this->favoriteService->isFavorite($productId);
    }

    public function boot(FavoriteServiceInterface $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function toggleFavorite(): void
    {
        $this->isFavorite = $this->favoriteService->toggleFavorite($this->productId);
        $this->dispatch('favorite-updated');
        $this->dispatch('favorite-page-updated');
    }

    #[On('favorite-updated')]
    public function syncFavoriteState(): void
    {
        $this->isFavorite = $this->favoriteService->isFavorite($this->productId);
    }

    public function render()
    {
        return view('livewire.favorite.index');
    }
}
