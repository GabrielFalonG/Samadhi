<!-- BARRA DE FILTROS MOBILE (Solo visible en pantallas chicas < lg) -->
<div class="sticky top-0 z-20 -mx-4 -mt-8 mb-6 border-b border-stone-200/80 bg-[#FDFBF7]/95 px-4 py-3 backdrop-blur-md sm:-mx-6 sm:px-6 lg:hidden">
    <div class="flex items-center justify-between gap-2">

        <!-- Zona 1: Scroll horizontal de selects / accesos rápidos -->
        <div class="no-scrollbar flex items-center space-x-2 overflow-x-auto pr-2">

            <!-- Filter Dropdown: Categorías -->
            <div class="relative shrink-0">
                <select
                    wire:model.live.debounce.500ms="category"
                    class="appearance-none rounded-xl border border-stone-200 bg-white py-2 pl-3 pr-8 text-xs
                    font-medium text-stone-700 shadow-sm transition-colors focus:border-[#A98B68]
                    focus:outline-none focus:ring-1 focus:ring-[#A98B68]">
                    @foreach ($allCategories as $c)
                        <option value="{{ $c->slug }}" @selected(!is_null($categoryObj) && $c->id == $categoryObj->id)>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-stone-400">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

        </div>

        <!-- Separador vertical -->
        <div class="h-6 w-[1px] shrink-0 bg-stone-200"></div>

        <!-- Zona 2: Botón 'Filtros' fijo a la derecha con Drawer/Modal trigger -->
        <button
            type="button"
            x-data
            @click="$dispatch('open-mobile-filters')"
            class="flex shrink-0 items-center space-x-1.5 rounded-xl border border-[#B89B6A]/30 bg-white px-3 py-2 text-xs font-semibold text-[#B89B6A] shadow-sm transition-all hover:bg-[#B89B6A] hover:text-white">

            <!-- Icono Filtro / Ajustes -->
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
            </svg>

            <span>Filtros</span>

            <!-- Contador de filtros activos (Badge) -->
            <span class="inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-[#B89B6A] px-1 text-[10px] font-bold text-white group-hover:bg-white group-hover:text-[#B89B6A]">
                1
            </span>
        </button>

    </div>

    <div class="flex mt-3">

        <!-- Zona 1: Scroll horizontal de selects / accesos rápidos -->
        <!-- Buscador tomará todo el espacio sobrante -->
        <div class="relative flex-1">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-stone-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>

            <input
                type="text"
                wire:model.live.debounce.500ms="search"
                placeholder="Buscar productos..."
                class="w-full rounded-full border border-stone-200 bg-white py-2 pl-10 pr-8 text-xs font-medium text-stone-700 shadow-xs transition-colors placeholder-stone-400 focus:border-[#A98B68] focus:outline-none focus:ring-1 focus:ring-[#A98B68]"
            />

            @if($search)
                <button
                    wire:click="$set('search', '')"
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-stone-400 hover:text-stone-600">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            @endif
        </div>

    </div>
</div>
