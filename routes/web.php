<?php

use App\Livewire\Components\CarouselAdmin;
use App\Livewire\Components\CarouselCreateAdmin;
use App\Livewire\Components\CarouselEditAdmin;
use App\Livewire\Components\CartPage;
use App\Livewire\Components\CheckoutPage;
use App\Livewire\Components\Dashboard;
use App\Livewire\Components\FavoritesPage;
use App\Livewire\Components\Home;
use App\Livewire\Components\OrderAdmin;
use App\Livewire\Components\OrderEdit;
use App\Livewire\Components\ProductsAdmin;
use App\Livewire\Components\Products;
use App\Livewire\Components\ProductsAdminCreate;
use App\Livewire\Components\ProductsAdminEdit;
use App\Livewire\Components\ProductsCatalog;
use Illuminate\Support\Facades\Route;

use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::get('/', Home::class)->name('home');
//Route::view('/', 'welcome');

Route::view('profile', 'profile')
->middleware(['auth'])
->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::prefix('admin')->group(function () {
        Route::get('/carousels', CarouselAdmin::class)->name('admin.carousels');
        Route::get('/carousels/create', CarouselCreateAdmin::class)->name('admin.carousels.create');
        Route::get('/carousels/edit/{id}', CarouselEditAdmin::class)->name('admin.carousels.edit');
        Route::get('/orders', OrderAdmin::class)->name('admin.orders');
        Route::get('/orders/edit/{id}', OrderEdit::class)->name('admin.orders.edit');

        Route::get('/products', ProductsAdmin::class)->name('admin.products');
        Route::get('/products/create', ProductsAdminCreate::class)->name('admin.products.create');
        Route::get('/products/edit/{id}', ProductsAdminEdit::class)->name('admin.products.edit');
    });
});

Route::get('/products', Products::class)->name('products');
Route::get('/shop', ProductsCatalog::class)->name('category');
Route::get('/favorites', FavoritesPage::class)->name('favorite');
Route::get('/cart', CartPage::class)->name('cart');
Route::get('/checkout', CheckoutPage::class)->name('checkout');
Route::get('/contact', Dashboard::class)->name('contact');


require __DIR__.'/auth.php';
