<?php
use App\Livewire\Actions\Logout;
use App\Services\Category\CategoryService;
use Livewire\Volt\Component;

new class extends Component /** * Log the current user out of the application. */ {

    public string $search = '';
    public bool $showSearch = false;

    public function mount(): void
    {
        $this->showSearch = request()->routeIs('category');
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function with(CategoryService $categoryService): array
    {
        return [
            'categories' => $categoryService->getActiveCategories(),
        ];
    }

    public function updatedSearch(string $value): void
    {
        $this->dispatch('search-products', search: $value);
    }
};

?>

<header class="sticky top-0 z-50 w-full bg-[#FAF8F5] text-stone-700 border-b border-stone-200/60 font-sans shadow-sm">


    {{-- Top Navigation Bar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between gap-6 py-4 lg:py-5">

            {{-- Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="flex shrink-0 items-center">
                <x-application-logo />
            </a>

            {{-- Buscador se oculta en modo mobile --}}
            <div
                @class([
                    'hidden' => !$showSearch,
                    'flex-1 justify-center lg:flex lg:-translate-x-20' => $showSearch,
                ])>
                @include('livewire.layout.searcher')
            </div>


            {{-- Acciones --}}
            <div class="flex shrink-0 items-center gap-5 text-xs text-stone-600">

                {{-- Favoritos --}}
                <livewire:components.header-favorite-dropdown />


                {{-- Carrito --}}
                <livewire:components.cart-floating-button />


                {{-- Usuario --}}
                @auth

                    <div>
                        <x-dropdown align="right" width="48">

                            <x-slot name="trigger">

                                <button
                                    class="flex items-center gap-2
                                        transition
                                        hover:text-[#A98B68]
                                        focus:outline-none">

                                    {{-- User Icon --}}
                                    <svg class="h-5 w-5 text-stone-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.8">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                                    </svg>

                                    {{-- Nombre --}}
                                    <span class="hidden whitespace-nowrap sm:inline" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                        x-on:profile-updated.window="name = $event.detail.name">
                                    </span>

                                    {{-- Caret --}}
                                    <svg class="h-4 w-4 text-stone-500 transition-transform duration-200" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">

                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />

                                    </svg>

                                </button>

                            </x-slot>


                            <x-slot name="content">

                                <x-dropdown-link :href="route('profile')" wire:navigate class="hover:text-[#A98B68]">
                                    {{ __('My Profile') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.carousels')" wire:navigate class="hover:text-[#A98B68]">
                                    {{ __('Admin Carrusel') }}
                                </x-dropdown-link>

                                <hr class="my-2 border-stone-200">

                                <x-dropdown-link wire:click="logout" class="cursor-pointer hover:text-[#A98B68]">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>

                            </x-slot>

                        </x-dropdown>
                    </div>
                @else
                    {{-- Usuario no autenticado --}}
                    <div class="flex items-center gap-5">

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" wire:navigate
                                class="flex items-center gap-2
                                    transition
                                    hover:text-[#A98B68]">

                                <svg class="h-5 w-5 text-stone-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.8">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />

                                </svg>

                                <span class="hidden sm:inline">
                                    {{ __('Registrarse') }}
                                </span>

                            </a>
                        @endif


                        <a href="{{ route('login') }}" wire:navigate
                            class="flex items-center gap-2
                                transition
                                hover:text-[#A98B68]">

                            <svg class="h-5 w-5 text-stone-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                            </svg>

                            <span class="hidden sm:inline">
                                Mi cuenta
                            </span>

                        </a>

                    </div>

                @endauth

            </div>

        </div>

        {{-- Buscador se oculta en modo desktop --}}
        <div
            @class([
                'hidden' => !$showSearch,
                'lg:hidden' => $showSearch,
            ])>
            @include('livewire.layout.searcher-mobile')
        </div>

    </div>

    {{-- Bottom Navigation Links --}}
    @unless (request()->routeIs('category'))
        <div class="border-t border-stone-200/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-8 py-3 text-xs font-medium text-stone-600 overflow-x-auto no-scrollbar">

                    @foreach ($categories as $category)
                        <a href="{{ route('category', ['category' => $category->slug]) }}" wire:navigate
                            class="hover:text-[#A98B68] transition shrink-0">
                            {{ $category->name }}
                        </a>
                    @endforeach

                </nav>
            </div>
        </div>
    @endunless
</header>
