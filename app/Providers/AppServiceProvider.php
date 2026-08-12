<?php

namespace App\Providers;

use App\Repositories\Cache\RedisCartStorage;
use App\Repositories\Cache\RedisFavoriteStorage;
use App\Repositories\Cache\SessionCartStorage;
use App\Repositories\Contracts\CarouseRepositoryInterface;
use App\Repositories\Contracts\CartStorageInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\FavoriteStorageInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\SqlDB\CarouselRepository;
use App\Repositories\SqlDB\CategoryRepository;
use App\Repositories\SqlDB\OrderRepository;
use App\Repositories\SqlDB\ProductRepository;
use App\Services\Carousel\Contracts\CarouselServiceInterface;
use App\Services\Carousel\CarouselService;
use App\Services\CartStorage\CartService;
use App\Services\CartStorage\Contracts\CartServiceInterface;
use App\Services\Category\CategoryService;
use App\Services\Category\Contracts\CategoryServiceInterface;
use App\Services\Favorite\Contracts\FavoriteServiceInterface;
use App\Services\Favorite\FavoriteService;
use App\Services\Orders\Contracts\OrderServiceInterface;
use App\Services\Orders\OrderService;
use App\Services\Products\Contracts\ProductServiceInterface;
use App\Services\Products\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            FavoriteServiceInterface::class,
            FavoriteService::class
        );

        $this->app->bind(
            FavoriteStorageInterface::class,
            RedisFavoriteStorage::class
        );

        $this->app->bind(
            CartServiceInterface::class,
            CartService::class
        );

        // $this->app->bind(
        //     CartStorageInterface::class,
        //     SessionCartStorage::class
        // );

        $this->app->bind(
            CartStorageInterface::class,
            RedisCartStorage::class
        );

        $this->app->bind(
            CategoryServiceInterface::class,
            CategoryService::class
        );

        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            ProductServiceInterface::class,
            ProductService::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            CarouselServiceInterface::class,
            CarouselService::class
        );

        $this->app->bind(
            CarouseRepositoryInterface::class,
            CarouselRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            OrderServiceInterface::class,
            OrderService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
