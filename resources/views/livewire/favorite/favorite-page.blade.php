<div class="bg-stone-50 min-h-screen py-10 sm:py-14" x-data="{
    productModal: {
        open: false,
        product: null
    },

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
}" @keydown.escape.window="closeProduct()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Encabezado de la página --}}
        <div class="border-b border-stone-200 pb-6 mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">

            <div>
                <h1 class="mt-6 font-serif text-4xl leading-tight text-stone-900 md:text-5xl">
                    Mis Favoritos
                </h1>
            </div>

            @if ($products->count() > 0)
                <span
                    class="text-xs font-semibold text-stone-600 bg-stone-200/60 px-3 py-1 rounded-full self-start sm:self-auto">
                    {{ $products->count() }}
                    {{ $products->count() === 1 ? 'producto' : 'productos' }}
                </span>
            @endif

        </div>


        {{-- Grilla de Productos --}}
        @if ($products->count() > 0)

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach ($products as $product)
                    <div wire:key="fav-grid-item-{{ $product->id }}">

                        @include('livewire.carousel.carousel-item', ['item' => $product])

                    </div>
                @endforeach

            </div>
        @else
            {{-- Estado Vacío --}}
            <div class="max-w-md mx-auto text-center py-16 px-4">

                <div
                    class="mx-auto h-20 w-20 rounded-full bg-stone-100 flex items-center justify-center text-stone-400 mb-5">

                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>

                </div>

                <h2 class="text-xl font-serif font-bold text-stone-800">
                    Tu lista está vacía
                </h2>

                <p class="text-stone-500 text-xs sm:text-sm mt-2 leading-relaxed">
                    Parece que todavía no has guardado ningún producto en tus favoritos.
                    Explorá la tienda y guardá lo que más te guste.
                </p>

                <div class="mt-6">

                    <a href="{{ route('category', ['category' => $defaultCategory->slug]) }}"
                        class="inline-flex items-center gap-2 rounded-full bg-[#A98B68] px-6 py-3 text-xs font-medium text-white shadow-sm transition-all duration-300 hover:bg-[#8D7358] hover:shadow-md focus:outline-none">
                        <span>
                            Descubrir productos
                        </span>

                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                </div>

            </div>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- MODAL ÚNICO DE PRODUCTO --}}
    {{-- ========================================================= --}}

    <div x-show="productModal.open" x-cloak class="fixed inset-0 z-[60]">

        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="closeProduct()"></div>


        {{-- Contenedor --}}
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 lg:p-8">

            <div x-show="productModal.open" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" @click.stop
                class="relative w-full max-w-5xl overflow-hidden rounded-[32px] bg-[#FAF8F5] p-4 shadow-2xl sm:p-6">

                {{-- Botón cerrar --}}
                <button type="button" @click="closeProduct()"
                    class="absolute top-6 right-6 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-stone-100 text-stone-600 transition hover:bg-stone-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>


                <div class="grid lg:grid-cols-2 gap-6 lg:gap-10 items-center">

                    {{-- Imagen --}}
                    <div
                        class="relative overflow-hidden rounded-[24px] bg-[#F2EFEA] aspect-square lg:h-[540px] w-full flex items-center justify-center">

                        <img :src="productModal.product?.image_url"
                            :alt="productModal.product?.name ?? productModal.product?.title"
                            class="h-full w-full object-contain">

                    </div>


                    {{-- Información --}}
                    <div class="flex flex-col justify-between py-2 pr-2 lg:pr-6">

                        <div>

                            {{-- Categoría --}}
                            <span class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#B5956E]"
                                x-text="productModal.product?.category ?? 'Spray Áurico'"></span>


                            {{-- Título --}}
                            <h2 class="mt-1 text-3xl sm:text-4xl font-normal text-stone-800"
                                x-text="productModal.product?.name ?? productModal.product?.title"></h2>


                            {{-- Descripción --}}
                            <p class="mt-2 text-sm text-stone-600 leading-relaxed"
                                x-text="productModal.product?.subtitle ?? productModal.product?.description"></p>


                            {{-- Separador --}}
                            <div class="relative my-6 text-center">

                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-stone-200/70"></div>
                                </div>

                                <div class="relative inline-block bg-[#FAF8F5] px-3 text-[#B5956E]">

                                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M12 3c-1.5 3-4 5.5-7 6.5 2.5 1.5 5.5 1.5 7 0 1.5 1.5 4.5 1.5 7 0-3-1-5.5-3.5-7-6.5zm0 8c-2.5 2-6 3-9 3 3 2 6.5 2.5 9 5 2.5-2.5 6-3 9-5-3 0-6.5-1-9-3z" />
                                    </svg>

                                </div>

                            </div>


                            {{-- Descripción larga --}}
                            <p class="text-xs text-stone-600 leading-relaxed"
                                x-text="productModal.product?.long_description ?? ''"></p>


                            {{-- Ingredientes --}}
                            <div x-show="productModal.product?.ingredients"
                                class="mt-6 pt-4 border-t border-dashed border-stone-200">

                                <span
                                    class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">
                                    Ingredientes Principales
                                </span>

                                <div class="flex flex-wrap gap-2">

                                    <template
                                        x-for="ingredient in (productModal.product?.ingredients ?? '').split(',').map(i => i.trim()).filter(Boolean)"
                                        :key="ingredient">

                                        <span x-text="ingredient"
                                            class="rounded-full bg-[#F3EFEA] px-4 py-1.5 text-xs text-stone-700"></span>

                                    </template>

                                </div>

                            </div>

                        </div>


                        {{-- Precio --}}
                        <div class="mt-8 pt-4 border-t border-dashed border-stone-200">

                            <div class="flex items-center justify-between gap-4">

                                <p class="text-3xl font-normal text-stone-800"
                                    x-text="
                                        new Intl.NumberFormat(
                                            'es-AR',
                                            {
                                                maximumFractionDigits: 0
                                            }
                                        ).format(
                                            productModal.product?.price ?? 0
                                        )
                                    ">
                                </p>


                                {{-- Agregar al carrito --}}
                                <button type="button" @click="$wire.addToCart(productModal.product.id)"
                                    class="inline-flex items-center justify-center gap-2 rounded-full bg-[#A98B68] px-6 py-3.5 text-xs font-medium text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#8D7358] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#A98B68]/50">

                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>

                                    <span>
                                        Agregar al carrito
                                    </span>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
