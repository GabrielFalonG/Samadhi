<div class="relative" x-data="{ open: false }">
    {{-- Botón Trigger del Header --}}
    <button type="button"
            @click="open = !open"
            aria-expanded="false"
            class="flex items-center gap-2 hover:text-[#A98B68] transition focus:outline-none">

        <div class="relative flex items-center justify-center">
            <svg class="h-5 w-5 {{ $count > 0 ? 'text-red-500' : 'text-stone-600' }}"
                 fill="{{ $count > 0 ? 'currentColor' : 'none' }}"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>

            @if($count > 0)
                <span class="absolute -top-1 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">
                    {{ $count }}
                </span>
            @endif
        </div>

        <span class="hidden sm:inline font-medium text-stone-700 hover:text-[#A98B68]">Favoritos</span>
    </button>

    {{-- Backdrop para mobile --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="fixed inset-0 bg-black/20 backdrop-blur-xs sm:hidden z-40"
         style="display: none;"></div>

    {{-- Dropdown Menu (Adaptativo Mobile / Desktop) --}}
    <div x-show="open"
         @click.outside="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2 sm:translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-2 sm:translate-y-1"
         style="display: none;"
         class="fixed left-4 right-4 top-16 sm:absolute sm:left-auto sm:right-0 sm:top-full sm:mt-3 w-auto sm:w-96 max-w-md rounded-2xl sm:rounded-xl bg-white p-4 shadow-2xl sm:shadow-xl ring-1 ring-black/5 z-50">

        {{-- Header del Dropdown --}}
        <div class="flex items-center justify-between border-b border-stone-100 pb-3 mb-3">
            <div class="flex items-center gap-2">
                <h3 class="font-semibold text-stone-800 text-sm">Mis Favoritos</h3>
                <span class="inline-flex items-center justify-center rounded-full bg-stone-100 px-2 py-0.5 text-xs font-semibold text-stone-600">
                    {{ $count }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                @if($count > 0)
                    <span class="hidden sm:inline text-xs text-stone-500">Guardados en tu lista</span>
                @endif
                {{-- Botón Cerrar (Solo visible en mobile) --}}
                <button type="button" @click="open = false" class="sm:hidden text-stone-400 hover:text-stone-600 p-1">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Lista de Productos (Máximo 5 elementos) --}}
        <div class="max-h-[50vh] sm:max-h-72 overflow-y-auto divide-y divide-stone-100 pr-1">
            @forelse($products->take(5) as $product)
                <div class="flex items-center justify-between py-2.5 gap-3 group">
                    <a
                        href="{{ route('favorite', ['product' => $product->slug]) }}"
                        class="flex items-center gap-3 min-w-0 flex-1">
                        <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}"
                             alt="{{ $product->title ?? $product->name }}"
                             class="h-12 w-12 rounded-lg object-cover border border-stone-100 flex-shrink-0" />

                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-stone-800 truncate group-hover:text-[#A98B68] transition">
                                {{ $product->title ?? $product->name }}
                            </p>
                            <p class="text-xs font-semibold text-stone-900 mt-0.5">
                                ${{ number_format($product->price, 2) }}
                            </p>
                        </div>
                    </a>

                    {{-- Botón Quitar --}}
                    <button type="button"
                            wire:click="removeFavorite({{ $product->id }})"
                            aria-label="Quitar de favoritos"
                            class="text-stone-400 hover:text-red-500 transition p-1.5 rounded-md hover:bg-stone-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @empty
                <div class="py-8 text-center text-stone-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-stone-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <p class="text-xs">No tienes productos en favoritos</p>
                </div>
            @endforelse
        </div>

        {{-- Footer del Dropdown --}}
        @if($count > 0)
            <div class="mt-3 border-t border-stone-100 pt-3">
                <a
                    href="{{ route('favorite') }}"
                    class="flex w-full items-center justify-center gap-2 rounded-full bg-[#A98B68] px-4 py-3 text-xs font-medium text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#8D7358] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#A98B68]/50">
                    <span>
                        {{ $count > 5 ? 'Ver los ' . $count . ' favoritos' : 'Ver todos los favoritos' }}
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4 transition-transform duration-300"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
