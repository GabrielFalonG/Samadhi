<div
    x-data="{
        open: false,
        activeTab: 'categories',
        // Estados de ejemplo para los filtros
        filters: {
            category: '{{ $category->slug ?? '' }}',
            price: true,
            {{-- cuotas: false,
            descuento: false,
            organico: false,
            crueltyFree: false --}}
        }
    }"
    @open-mobile-filters.window="open = true"
    x-show="open"
    x-cloak
    class="relative z-50 lg:hidden"
    aria-labelledby="slide-over-title"
    role="dialog"
    aria-modal="true">

    <!-- Backdrop / Fondo oscuro suave -->
    <div
        x-show="open"
        x-transition:enter="ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-stone-900/40 backdrop-blur-xs transition-opacity"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                <!-- Panel Principal Slide-over -->
                <div
                    x-show="open"
                    x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto w-screen max-w-md bg-[#FDFBF7]">

                    <div class="flex h-full flex-col shadow-2xl">

                        <!-- Encabezado del Modal -->
                        <div class="flex items-center justify-between border-b border-stone-200/80 bg-white px-5 py-4">
                            <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#B89B6A]">
                                Filtrar Productos
                            </h2>
                            <button
                                @click="open = false"
                                type="button"
                                class="rounded-lg p-1 text-stone-400 hover:bg-stone-100 hover:text-stone-600 focus:outline-none">
                                <span class="sr-only">Cerrar menú</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Cuerpos de Filtros (Layout 2 Columnas estilo Mercado Libre) -->
                        <div class="flex flex-1 overflow-hidden">

                            <!-- Columna Izquierda: Menú de Pestañas -->
                            <div class="w-1/3 border-r border-stone-200/70 bg-stone-100/50">
                                <nav class="flex flex-col text-xs font-medium text-stone-600">

                                    <button
                                        @click="activeTab = 'categories'"
                                        :class="activeTab === 'categories' ? 'bg-[#FDFBF7] text-[#B89B6A] font-semibold border-l-2 border-[#B89B6A]' : 'hover:bg-stone-200/40'"
                                        class="flex items-center justify-between px-3 py-3.5 text-left transition-colors">
                                        <span>Categorías</span>
                                        <svg x-show="activeTab === 'categories'" class="h-3.5 w-3.5 text-[#B89B6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button>

                                    <button
                                        @click="activeTab = 'price'"
                                        :class="activeTab === 'price' ? 'bg-[#FDFBF7] text-[#B89B6A] font-semibold border-l-2 border-[#B89B6A]' : 'hover:bg-stone-200/40'"
                                        class="flex items-center justify-between px-3 py-3.5 text-left transition-colors">
                                        <span>Precio</span>
                                        <svg x-show="activeTab === 'price'" class="h-3.5 w-3.5 text-[#B89B6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>

                                    {{-- <button
                                        @click="activeTab = 'financing'"
                                        :class="activeTab === 'financing' ? 'bg-[#FDFBF7] text-[#B89B6A] font-semibold border-l-2 border-[#B89B6A]' : 'hover:bg-stone-200/40'"
                                        class="flex items-center justify-between px-3 py-3.5 text-left transition-colors">
                                        <span>Financiación</span>
                                        <svg x-show="activeTab === 'financing'" class="h-3.5 w-3.5 text-[#B89B6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button>

                                    <button
                                        @click="activeTab = 'discounts'"
                                        :class="activeTab === 'discounts' ? 'bg-[#FDFBF7] text-[#B89B6A] font-semibold border-l-2 border-[#B89B6A]' : 'hover:bg-stone-200/40'"
                                        class="flex items-center justify-between px-3 py-3.5 text-left transition-colors">
                                        <span>Descuentos</span>
                                        <svg x-show="activeTab === 'discounts'" class="h-3.5 w-3.5 text-[#B89B6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button>

                                    <button
                                        @click="activeTab = 'properties'"
                                        :class="activeTab === 'properties' ? 'bg-[#FDFBF7] text-[#B89B6A] font-semibold border-l-2 border-[#B89B6A]' : 'hover:bg-stone-200/40'"
                                        class="flex items-center justify-between px-3 py-3.5 text-left transition-colors">
                                        <span>Propiedades</span>
                                        <svg x-show="activeTab === 'properties'" class="h-3.5 w-3.5 text-[#B89B6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button> --}}

                                </nav>
                            </div>

                            <!-- Columna Derecha: Opciones del Filtro Seleccionado -->
                            <div class="w-2/3 overflow-y-auto p-5">

                                <!-- Tab: Categorías (Selección por Chips o Links) -->
                                <div x-show="activeTab === 'categories'" class="space-y-4">
                                    <h3 class="text-xs font-semibold uppercase tracking-wider text-stone-400">Seleccionar Categoría</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($allCategories as $c)
                                            <button
                                                type="button"
                                                wire:click="$set('category', '{{ $c->slug }}')"
                                                class="rounded-full border px-3 py-1.5 text-xs font-medium transition-all
                                                    @if(!is_null($categoryObj) && $c->id == $categoryObj->id)
                                                        border-[#B89B6A] bg-[#B89B6A] text-white
                                                    @else
                                                        border-stone-300 bg-white text-stone-700 hover:border-[#A98B68]
                                                    @endif">
                                                {{ $c->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Precio -->
                                <div x-show="activeTab === 'price'" class="space-y-4">
                                    <h3 class="text-xs font-semibold uppercase tracking-wider text-stone-400">Order por</h3>
                                    <div class="flex flex-wrap gap-2">
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
                                    </div>

                                    <!-- Rango de precio Personalizado (Mínimo y Máximo) -->
                                    <div class="mt-4 pt-3 border-t border-stone-200/80">
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-stone-400">{{ __('Rango de precio') }}</h3>

                                        <div class="mt-4 flex items-center gap-2">
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

                                {{-- <!-- Tab: Financiación (Toggles) -->
                                <div x-show="activeTab === 'financing'" class="space-y-5">
                                    <h3 class="text-xs font-semibold uppercase tracking-wider text-stone-400">Opciones de pago</h3>

                                    <!-- Toggle item -->
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs font-medium text-stone-800">3 Cuotas sin interés</p>
                                            <p class="text-[10px] text-stone-500">En productos seleccionados</p>
                                        </div>
                                        <button
                                            @click="filters.cuotas = !filters.cuotas"
                                            type="button"
                                            :class="filters.cuotas ? 'bg-[#B89B6A]' : 'bg-stone-300'"
                                            class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                            <span :class="filters.cuotas ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Tab: Descuentos -->
                                <div x-show="activeTab === 'discounts'" class="space-y-3">
                                    <h3 class="text-xs font-semibold uppercase tracking-wider text-stone-400">Promociones</h3>
                                    <label class="flex items-center space-x-2.5 text-xs font-medium text-stone-700">
                                        <input type="checkbox" class="h-4 w-4 rounded border-stone-300 text-[#B89B6A] focus:ring-[#B89B6A]">
                                        <span>Desde 10% OFF</span>
                                    </label>
                                    <label class="flex items-center space-x-2.5 text-xs font-medium text-stone-700">
                                        <input type="checkbox" class="h-4 w-4 rounded border-stone-300 text-[#B89B6A] focus:ring-[#B89B6A]">
                                        <span>Desde 20% OFF</span>
                                    </label>
                                </div>

                                <!-- Tab: Propiedades -->
                                <div x-show="activeTab === 'properties'" class="space-y-5">
                                    <h3 class="text-xs font-semibold uppercase tracking-wider text-stone-400">Atributos del producto</h3>

                                    <!-- Toggle Organico -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium text-stone-800">100% Orgánico</span>
                                        <button
                                            @click="filters.organico = !filters.organico"
                                            type="button"
                                            :class="filters.organico ? 'bg-[#B89B6A]' : 'bg-stone-300'"
                                            class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                            <span :class="filters.organico ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>

                                    <!-- Toggle Cruelty Free -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium text-stone-800">Cruelty Free</span>
                                        <button
                                            @click="filters.crueltyFree = !filters.crueltyFree"
                                            type="button"
                                            :class="filters.crueltyFree ? 'bg-[#B89B6A]' : 'bg-stone-300'"
                                            class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                            <span :class="filters.crueltyFree ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                </div> --}}

                            </div>
                        </div>

                        <!-- Sticky Footer (Acciones) -->
                        <div class="flex items-center justify-between border-t border-stone-200/80 bg-white p-4 shadow-lg">
                            <button
                                wire:click="clearFilters"
                                type="button"
                                class="text-xs font-semibold text-stone-500 hover:text-stone-800 hover:underline">
                                Limpiar filtros
                            </button>

                            <button
                                @click="open = false; $wire.call('$refresh')"
                                type="button"
                                class="rounded-xl bg-[#B89B6A] px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-white shadow-sm transition-colors hover:bg-[#A98B68] focus:outline-none">
                                Ver resultados
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
