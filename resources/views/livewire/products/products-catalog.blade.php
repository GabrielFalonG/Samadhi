<div class="min-h-screen bg-[#FDFBF7] py-8 text-stone-800" x-data="{
    productModal: {
        open: false,
        product: null
    },

    isMobile: window.innerWidth < 1024,

    openProduct(product) {
        this.productModal.product = product;
        this.productModal.open = true;

        document.body.classList.add('overflow-hidden');
    },

    closeProduct() {
        this.productModal.open = false;
        this.productModal.product = null;

        document.body.classList.remove('overflow-hidden');
    }
}"
@keydown.escape.window="closeProduct()"
@product-modal:close.window="closeProduct()"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <!-- COMPONENTE MOBILE FILTERS (Solo visible en mobile) -->
        @include('livewire.products.products-mobile-filters')

        <!-- COMPONENTE OFF-CANVAS / DRAWER DE FILTROS -->
        @include('livewire.products.products-mobile-filters-menu')


        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">

            <!-- SIDEBAR DE FILTROS DESKTOP (Oculto en mobile) -->
            <aside class="hidden space-y-8 lg:col-span-1 lg:block">

                <div>

                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B89B6A]">
                        {{ __('Categorías') }}
                    </h3>

                    <ul class="mt-3 space-y-2 text-sm text-stone-600">

                        @foreach ($allCategories as $c)
                            <li>

                                <button type="button" wire:click="$set('category', '{{ $c->slug }}')"
                                    class="@if (!is_null($categoryObj) && $c->id == $categoryObj->id) font-medium text-stone-900 @endif hover:text-[#A98B68]">
                                    {{ $c->name }}
                                </button>

                            </li>
                        @endforeach

                    </ul>

                </div>


                <div>

                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B89B6A]">
                        {{ __('Precio') }}
                    </h3>


                    <div class="mt-4 pt-3 border-t border-stone-200/80">

                        <span class="text-xs font-medium text-stone-500 capitalize tracking-wider block mb-2">
                            {{ __('Ordenar por') }}
                        </span>

                        <ul class="mt-3 space-y-2 text-sm text-stone-600">

                            @foreach ($sortOptions as $value => $label)
                                @php
                                    [$field, $direction] = explode('-', $value);
                                @endphp

                                <button type="button"
                                    wire:click="setSort('{{ $field }}', '{{ $direction }}')"
                                    class="rounded-full border px-3 py-1.5 text-xs font-medium transition-all focus:outline-none
                                        @if ($sortBy === $field && $sortDirection === $direction) border-[#B89B6A] bg-[#B89B6A] text-white
                                        @else
                                            border-stone-300 bg-white text-stone-700 hover:border-[#A98B6A] @endif">
                                    {{ $label }}
                                </button>
                            @endforeach

                        </ul>

                    </div>


                    <!-- Rango de precio -->
                    <div class="mt-4 pt-3 border-t border-stone-200/80">

                        <span class="text-xs font-medium text-stone-500 capitalize tracking-wider block mb-2">
                            {{ __('Rango de precio') }}
                        </span>


                        <div class="flex items-center gap-2">

                            <!-- Input Mínimo -->
                            <div class="relative flex-1">

                                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-xs text-stone-400">
                                    $
                                </span>

                                <input type="number" wire:model.live.debounce.750ms="minPrice"
                                    placeholder="{{ __('Mínimo') }}" min="0"
                                    class="w-full rounded-lg border border-stone-300 bg-white pl-6 pr-2 py-1.5 text-xs text-stone-700 placeholder-stone-400 focus:border-[#B89B6A] focus:outline-none focus:ring-1 focus:ring-[#B89B6A] transition-all">

                            </div>


                            <span class="text-stone-400 text-xs">
                                -
                            </span>


                            <!-- Input Máximo -->
                            <div class="relative flex-1">

                                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 text-xs text-stone-400">
                                    $
                                </span>

                                <input type="number" wire:model.live.debounce.750ms="maxPrice"
                                    placeholder="{{ __('Máximo') }}" min="0"
                                    class="w-full rounded-lg border border-stone-300 bg-white pl-6 pr-2 py-1.5 text-xs text-stone-700 placeholder-stone-400 focus:border-[#B89B6A] focus:outline-none focus:ring-1 focus:ring-[#B89B6A] transition-all">

                            </div>

                        </div>

                    </div>

                </div>

            </aside>


            <!-- GRID DE PRODUCTOS -->
            <main class="lg:col-span-3">

                {{-- Encabezado de la categoría --}}
                <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between lg:gap-8">

                    {{-- Información de la categoría --}}
                    <div class="min-w-0 flex-1">

                        {{-- Nombre de la categoría --}}
                        <h1 class="font-serif text-4xl leading-tight text-stone-900 md:text-5xl">
                            {{ $categoryObj?->name ?? 'Todos los productos' }}
                        </h1>

                        {{-- Descripción --}}
                        @if ($categoryObj?->description)

                            <p class="mt-4 max-w-3xl text-base leading-7 text-stone-600 md:text-lg md:leading-8">
                                {{ $categoryObj->description }}
                            </p>

                        @else

                            <p class="mt-4 max-w-3xl text-base leading-7 text-stone-600 md:text-lg md:leading-8">
                                Explorá nuestra colección de productos diseñados para acompañar
                                tu bienestar y conectar con tu energía cada día.
                            </p>

                        @endif

                    </div>


                    {{-- Contador --}}
                    <p class="shrink-0 text-sm leading-6 text-stone-500 lg:pb-1">
                        Se encontraron
                        <span class="font-semibold text-stone-800">
                            {{ $items->total() }}
                        </span>
                        productos
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


    {{-- ========================================================= --}}
    {{-- MODAL ÚNICO DE PRODUCTO --}}
    {{-- ========================================================= --}}
    @include('livewire.products.product-item-modal')

    {{-- ========================================================= --}}
    {{-- MODAL ÚNICO DE PRODUCTO MOBILE --}}
    {{-- ========================================================= --}}
    @include('livewire.products.product-item-mobile-modal')

</div>
