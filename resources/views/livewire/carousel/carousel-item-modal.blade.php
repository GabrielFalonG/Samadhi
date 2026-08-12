<div>
    @if($open)

        {{-- Backdrop --}}
        <div wire:click="close"
             class="fixed inset-0 z-[60] bg-black/40 backdrop-blur-sm">
        </div>

        {{-- Modal --}}
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 lg:p-8">

            <div class="relative w-full max-w-5xl overflow-hidden rounded-[32px] bg-[#FAF8F5] p-4 sm:p-6 shadow-2xl">

                {{-- Botón de Cierre --}}
                <button wire:click="close"
                        class="absolute top-6 right-6 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-stone-100 text-stone-600 transition hover:bg-stone-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="grid lg:grid-cols-2 gap-6 lg:gap-10 items-center">

                    {{-- Columna Izquierda: Imagen del Producto --}}
                    <div class="relative overflow-hidden rounded-[24px] bg-[#F2EFEA] aspect-square lg:h-[540px] w-full flex items-center justify-center">
                        <img src="{{ asset($product['image_url']) }}"
                             alt="{{ $product['title'] }}"
                             class="h-full w-full object-contain">
                    </div>

                    {{-- Columna Derecha: Detalles del Producto --}}
                    <div class="flex flex-col justify-between py-2 pr-2 lg:pr-6">

                        <div>
                            {{-- Subtítulo --}}
                            <span class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B5956E]">
                                {{ $product['category'] ?? 'Spray Áurico' }}
                            </span>

                            {{-- Título --}}
                            <h2 class="mt-1 text-3xl sm:text-4xl font-normal text-stone-800">
                                {{ $product['title'] }}
                            </h2>

                            {{-- Descripción Corta --}}
                            <p class="mt-2 text-sm text-stone-600 leading-relaxed">
                                {{ $product['subtitle'] ?? $product['description'] }}
                            </p>

                            {{-- Divisor Decorativo con Flor de Loto --}}
                            <div class="relative my-6 text-center">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-stone-200/70"></div>
                                </div>
                                <div class="relative inline-block bg-[#FAF8F5] px-3 text-[#B5956E]">
                                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 3c-1.5 3-4 5.5-7 6.5 2.5 1.5 5.5 1.5 7 0 1.5 1.5 4.5 1.5 7 0-3-1-5.5-3.5-7-6.5zm0 8c-2.5 2-6 3-9 3 3 2 6.5 2.5 9 5 2.5-2.5 6-3 9-5-3 0-6.5-1-9-3z"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Descripción Larga --}}
                            <p class="text-xs text-stone-600 leading-relaxed">
                                {{ $product['long_description'] ?? 'Una mezcla sutil y amorosa de rosas y vainilla con la energía del cuarzo rosa, creada para abrir el corazón, cultivar el amor propio y atraer vínculos conscientes.' }}
                            </p>

                            {{-- Ingredientes Principales --}}
                            <div class="mt-6 pt-4 border-t border-dashed border-stone-200">
                                <span class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">
                                    Ingredientes Principales
                                </span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($product->ingredients_array as $ingredient)
                                        <span class="rounded-full bg-[#F3EFEA] px-4 py-1.5 text-xs text-stone-700">
                                            {{ $ingredient }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Bloque de Precio y Comprar --}}
                        <div class="mt-8 pt-4 border-t border-dashed border-stone-200">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-3xl font-normal text-stone-800">
                                        ${{ number_format($product['price'] ?? 15000, 0, ',', '.') }}
                                    </p>
                                </div>

                                <button wire:click="addToCart"
                                        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#A98B68] px-6 py-3.5 text-xs font-medium text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#8D7358] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#A98B68]/50">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>{{ __('Agregar al carrito') }}</span>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endif
</div>
