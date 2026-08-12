<div class="group relative flex h-full flex-col justify-between overflow-hidden rounded-[2rem] bg-[#FCFBF7] p-4 shadow-sm border border-stone-200/50 transition duration-300 hover:shadow-md">
    <div>
        <!-- Contenedor de Imagen -->
        <div class="relative mb-5 aspect-[4/3] w-full overflow-hidden rounded-[1.5rem] bg-white flex items-center justify-center p-2">
            {{-- Badge de Descuento --}}
            @if(!empty($item['discount_percentage']))
                <span class="absolute top-3 left-3 z-10 rounded-lg bg-[#8C6D46] px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm">
                    {{ $item['discount_percentage'] }}% OFF
                </span>
            @endif

            {{-- Botón Favorito / Wishlist --}}
            <livewire:components.favorite-button
                :product-id="$item['id']"
                wire:key="fav-button-{{ $item['id'] }}"
            />

            {{-- Imagen con object-contain para mostrar el producto completo --}}
            <img src="{{ $item['image_url'] ?? asset('images/placeholder.jpg') }}"
                 alt="{{ $item['name'] ?? $item['title'] }}"
                 class="h-full w-full object-contain object-center transition duration-500 group-hover:scale-105" />
        </div>

        <!-- Categoría / Subtítulo -->
        <p class="mb-1.5 text-[11px] font-medium uppercase tracking-[0.2em] text-[#B89B6A]">
            {{ $item['category'] ?? 'AROMATERAPIA' }}
        </p>

        <!-- Título con la tipografía de la app -->
        <h3 class="text-xl font-bold text-stone-800 leading-snug">
            {{ $item['name'] ?? $item['title'] }}
        </h3>

        <!-- Descripción corta -->
        <p class="mt-1.5 text-xs text-stone-500 line-clamp-2 leading-relaxed">
            {{ $item['description'] ?? '' }}
        </p>

        <!-- Bloque de Precios con la tipografía de la app -->
        <div class="mt-4 flex items-center gap-2 flex-wrap">
            @if(!empty($item['original_price']))
                <span class="text-sm text-stone-400 line-through">
                    ${{ number_format($item['original_price'], 0, ',', '.') }}
                </span>
            @endif

            <span class="text-2xl font-bold text-stone-900">
                ${{ number_format($item['price'] ?? 12600, 0, ',', '.') }}
            </span>

            @if(!empty($item['discount_percentage']))
                <span class="rounded-md bg-[#F4EFE6] px-2 py-0.5 text-[11px] font-medium text-[#8C6D46]">
                    {{ $item['discount_percentage'] }}% OFF
                </span>
            @endif
        </div>
    </div>

    <!-- Botón Ver Producto -->
    <div class="mt-6 pt-2">
        <button type="button"
                @click="$dispatch('open-product', { slug: '{{ $item['slug'] }}', carousel: {{ $carousel['id'] ?? 'null' }} })"
                class="flex w-full items-center justify-center gap-2 rounded-full bg-[#A98B68] py-3.5 px-4 text-xs font-medium text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#8D7358] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#A98B68]/50">
            <span>Ver producto</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </div>
</div>
