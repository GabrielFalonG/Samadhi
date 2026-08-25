<div class="bg-stone-50 min-h-screen py-10 sm:py-14"
    x-data="{
        productModal: {
            open: false,
            product: null
        },

        isMobile: window.innerWidth < 1024,
        isPreview: false,

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

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">

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
    @include('livewire.products.product-item-modal')

    {{-- ========================================================= --}}
    {{-- MODAL ÚNICO DE PRODUCTO MOBILE --}}
    {{-- ========================================================= --}}
    @include('livewire.products.product-item-mobile-modal')

</div>
