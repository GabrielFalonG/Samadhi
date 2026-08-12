<div class="min-h-screen bg-[#FDFBF7] py-8 text-stone-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <!-- COMPONENTE MOBILE FILTERS (Solo visible en mobile) -->
        @include('livewire.products.products-mobile-filters')
        <!-- COMPONENTE OFF-CANVAS / DRAWER DE FILTROS -->
        @include('livewire.products.products-mobile-filters-menu')

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">

            <!-- SIDEBAR DE FILTROS DESKTOP (Oculto en mobile) -->
            <aside class="hidden space-y-8 lg:col-span-1 lg:block">
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B89B6A]">{{ __('Categorías') }}</h3>
                    <ul class="mt-3 space-y-2 text-sm text-stone-600">
                        @foreach ($allCategories as $c)
                            <li>
                                <button
                                    type="button"
                                    wire:click="$set('category', '{{ $c->slug }}')"
                                    class="@if(!is_null($categoryObj) && $c->id == $categoryObj->id) font-medium text-stone-900 @endif hover:text-[#A98B68]">
                                    {{ $c->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B89B6A]">{{ __('Precio') }}</h3>

                    <div class="mt-4 pt-3 border-t border-stone-200/80">
                        <span class="text-xs font-medium text-stone-500 capitalize tracking-wider block mb-2">
                            {{ __('Ordenar por') }}
                        </span>
                        <ul class="mt-3 space-y-2 text-sm text-stone-600">
                            @foreach ($sortOptions as $value => $label)
                                @php
                                    [$field, $direction] = explode('-', $value);
                                @endphp

                                <button
                                    type="button"
                                    wire:click="setSort('{{ $field }}', '{{ $direction }}')"
                                    class="rounded-full border px-3 py-1.5 text-xs font-medium transition-all focus:outline-none
                                        @if($sortBy === $field && $sortDirection === $direction)
                                            border-[#B89B6A] bg-[#B89B6A] text-white
                                        @else
                                            border-stone-300 bg-white text-stone-700 hover:border-[#A98B6A]
                                        @endif"
                                >
                                    {{ $label }}
                                </button>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Rango de precio Personalizado (Mínimo y Máximo) -->
                    <div class="mt-4 pt-3 border-t border-stone-200/80">
                        <span class="text-xs font-medium text-stone-500 capitalize tracking-wider block mb-2">
                            {{ __('Rango de precio') }}
                        </span>

                        <div class="flex items-center gap-2">
                            <!-- Input Mínimo -->
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-xs text-stone-400">$</span>
                                <input
                                    type="number"
                                    wire:model.live.debounce.750ms="minPrice"
                                    placeholder="{{ __('Mínimo') }}"
                                    min="0"
                                    class="w-full rounded-lg border border-stone-300 bg-white pl-6 pr-2 py-1.5 text-xs text-stone-700 placeholder-stone-400 focus:border-[#B89B6A] focus:outline-none focus:ring-1 focus:ring-[#B89B6A] transition-all">
                            </div>

                            <span class="text-stone-400 text-xs">-</span>

                            <!-- Input Máximo -->
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-xs text-stone-400">$</span>
                                <input
                                    type="number"
                                    wire:model.live.debounce.750ms="maxPrice"
                                    placeholder="{{ __('Máximo') }}"
                                    min="0"
                                    class="w-full rounded-lg border border-stone-300 bg-white pl-6 pr-2 py-1.5 text-xs text-stone-700 placeholder-stone-400 focus:border-[#B89B6A] focus:outline-none focus:ring-1 focus:ring-[#B89B6A] transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- GRID DE PRODUCTOS -->
            <main class="lg:col-span-3">

                <!-- Encabezado Desktop (Oculto en mobile para no duplicar controles) -->
                <div class="mb-6 hidden items-center justify-between gap-8 lg:flex">
                    <!-- Input de Búsqueda -->
                    <div class="relative flex-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-stone-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>

                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Buscar productos..."
                            class="w-full rounded-full border border-stone-300/80 bg-white py-1.5 pl-9 pr-8 text-xs text-stone-700 placeholder-stone-400 shadow-xs transition-all focus:border-[#B89B6A] focus:outline-none focus:ring-1 focus:ring-[#B89B6A]"
                        />

                        <!-- Botón Limpiar (se muestra solo si hay texto buscando) -->
                        <button
                            x-show="$wire.search"
                            wire:click="$set('search', '')"
                            type="button"
                            class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-stone-400 hover:text-stone-600">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Contador de Resultados -->
                    <p class="shrink-0 whitespace-nowrap text-sm text-stone-500">
                        Se encontraron <span class="font-semibold text-stone-800">{{ $items->total() }}</span> productos
                    </p>
                </div>

                <!-- Grid de Cards Samadhi -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($items as $item)
                        <div wire:key="carousel-item-wrapper-{{ $item['id'] }}">
                            @include('livewire.carousel.carousel-item', ['item' => $item])
                        </div>
                    @empty
                        <div>
                            <p>
                                No se han encontrado productos
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Paginador -->
                <div class="mt-12">
                    {{ $items->links('components.pagination') }}
                </div>

            </main>

        </div>
    </div>
</div>
