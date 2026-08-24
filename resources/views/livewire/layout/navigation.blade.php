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

<nav x-data="{ open: false }" @class([
    // Estilos para Admin: mismo fondo morado que la barra lateral y sin bordes
    'bg-[#4c1d95] shadow-sm' => $isAdmin,

    // Estilos para Frontend: fondo claro translúcido con borde inferior
    'border-b border-stone-200 bg-white/90 backdrop-blur-md shadow-sm fixed inset-x-0 top-0 z-50' => !$isAdmin,

    // Posicionamiento para Admin
    'sticky top-0 z-30' => $isAdmin,
])>

    {{-- Primary Navigation Menu --}}
    <div class="bg-[#4c1d95] text-white shadow-sm">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">

                {{-- CONTENEDOR IZQUIERDO: Logo --}}
                <div class="flex">
                    <div class="flex shrink-0 items-center">
                        <a href="{{ route('home') }}" wire:navigate
                            class="rounded-xl outline-none focus:ring-2 focus:ring-purple-400">
                            <x-application-logo
                                class="block h-9 w-auto fill-current text-white transition-colors hover:text-purple-200" />
                        </a>
                    </div>
                </div>

                {{-- CONTENEDOR DERECHO: Navegación + Autenticación --}}
                <div class="hidden h-16 items-center space-x-6 md:flex">

                    {{-- Separador --}}
                    <span class="select-none font-light text-purple-700/60">
                        |
                    </span>

                    {{-- Usuario --}}
                    @auth
                        <div>
                            <x-dropdown align="right" width="48">

                                {{-- Trigger --}}
                                <x-slot name="trigger">
                                    <button
                                        class="group inline-flex items-center rounded-2xl border border-transparent bg-purple-900/40 px-4 py-2 text-sm font-medium text-white transition hover:bg-purple-800/60 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400">

                                        <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                            x-on:profile-updated.window="name = $event.detail.name"></div>

                                        <div class="ms-2">
                                            <svg class="h-4 w-4 fill-current text-purple-300 transition-colors group-hover:text-white"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a2 2 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>

                                    </button>
                                </x-slot>

                                {{-- Dropdown Content --}}
                                <x-slot name="content">
                                    <div class="rounded-2xl border border-slate-200 bg-white p-1 shadow-md">
                                        <x-dropdown-link :href="route('profile')" wire:navigate
                                            class="rounded-xl px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-purple-50 hover:text-purple-700">
                                            {{ __('My Profile') }}
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('admin.carousels')" wire:navigate
                                            class="rounded-xl px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-purple-50 hover:text-purple-700">
                                            {{ __('Admin Carrusel') }}
                                        </x-dropdown-link>

                                        <hr class="my-1 border-slate-100">

                                        <x-dropdown-link wire:click="logout"
                                            class="cursor-pointer rounded-xl px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-purple-50 hover:text-purple-700">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </div>
                                </x-slot>

                            </x-dropdown>
                        </div>
                    @endauth

                </div>

            </div>
        </div>
    </div>
</nav>
