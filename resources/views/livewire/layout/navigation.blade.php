<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
};
?>

@php
    $isAdmin = request()->routeIs('admin.*');
@endphp

<nav
    x-data="{ open: false }"
    @class([
        'border-b border-stone-200 bg-white/90 backdrop-blur-md shadow-sm',
        // Frontend
        'fixed inset-x-0 top-0 z-50' => ! $isAdmin,
        // Admin
        'sticky top-0 z-30' => $isAdmin,
    ])>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- CONTENEDOR IZQUIERDO: Logo y Dashboard -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            </div>

            <!-- 🟢 CONTENEDOR DERECHO UNIFICADO: Une Navegación Estática + Autenticación -->
            <div class="hidden md:flex items-center h-16 space-x-6">

                <!-- Enlaces de navegación fijos -->
                {{-- <livewire:components.cart-floating-button /> --}}

                <!-- Separador vertical estilo Spotify -->
                <span class="text-gray-300 font-light select-none">|</span>

                <!-- Bloque condicional de usuario (Acoplado al mismo flex) -->
                @auth
                    <div>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile')" wire:navigate>
                                    {{ __('My Profile') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.carousels')" wire:navigate>
                                    {{ __('Admin Carrusel') }}
                                </x-dropdown-link>

                                <hr class="my-2 border-stone-200">

                                <x-dropdown-link wire:click="logout" class="cursor-pointer">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('login') }}" wire:navigate class="text-sm font-medium text-gray-500 hover:text-samadhi-gold-dark transition duration-150 ease-in-out py-2">
                            {{ __('Ingresar') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" wire:navigate class="text-sm font-medium text-gray-500 hover:text-samadhi-gold-dark transition duration-150 ease-in-out py-2">
                                {{ __('Registrarse') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger (Menú móvil) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    @auth
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Samadhi') }}
                </x-responsive-nav-link>
            </div>
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link wire:click="logout" class="cursor-pointer">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>
    @endauth
</nav>
