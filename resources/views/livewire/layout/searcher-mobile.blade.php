{{-- Buscador Mobile --}}
<div class="pb-4 lg:hidden">

    <div class="relative">

        {{-- Icono búsqueda --}}
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-stone-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>

        {{-- Input --}}
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar productos..."
            class="w-full rounded-full
                        border border-stone-300/80
                        bg-white
                        py-2.5
                        pl-11
                        pr-10
                        text-sm
                        text-stone-700
                        placeholder-stone-400
                        shadow-sm
                        transition-all
                        focus:border-[#B89B6A]
                        focus:outline-none
                        focus:ring-1
                        focus:ring-[#B89B6A]">

        {{-- Limpiar búsqueda --}}
        @if ($search)
            <button type="button" wire:click="$set('search', '')"
                class="absolute inset-y-0 right-0
                            flex items-center
                            pr-3.5
                            text-stone-400
                            transition
                            hover:text-stone-600">

                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>

            </button>
        @endif

    </div>

</div>
