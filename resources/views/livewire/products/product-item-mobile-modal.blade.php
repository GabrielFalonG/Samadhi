{{-- ========================================================= --}}
{{-- MODAL MOBILE --}}
{{-- ========================================================= --}}

<template x-teleport="body">

    <div x-show="productModal.open && isMobile" x-cloak class="fixed inset-0 z-[100] h-[100dvh] w-screen" role="dialog"
        aria-modal="true">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" x-show="productModal.open"
            x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="closeProduct()"></div>

        {{-- Modal --}}
        <div @click.stop x-show="productModal.open" x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="relative flex h-[100dvh] w-full flex-col overflow-hidden bg-[#FDFBF7] shadow-2xl">

            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="closeProduct()"></div>

            {{-- Modal --}}
            <div @click.stop class="relative flex h-[100dvh] w-full flex-col overflow-hidden bg-[#FDFBF7]">

                {{-- ================================================= --}}
                {{-- HEADER --}}
                {{-- ================================================= --}}

                <div class="absolute inset-x-0 top-0 z-30 flex items-center justify-end px-5 py-4">
                    <button type="button" @click="closeProduct()"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-stone-600 shadow-sm backdrop-blur-sm transition active:scale-95"
                        aria-label="Cerrar">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                        </svg>
                    </button>
                </div>


                {{-- ================================================= --}}
                {{-- CONTENIDO SCROLLABLE --}}
                {{-- ================================================= --}}

                <div class="min-h-0 flex-1 overflow-y-auto pb-32">

                    {{-- Imagen --}}
                    <div class="w-full bg-[#F3EFEA]">
                        <div class="aspect-[4/3] w-full">
                            <img :src="productModal.product?.image_url"
                                :alt="productModal.product?.name ?? productModal.product?.title ?? ''"
                                class="h-full w-full object-cover object-center">
                        </div>
                    </div>


                    {{-- Información --}}
                    <div class="px-6 pb-8 pt-7">

                        {{-- Categoría --}}
                        <span class="block text-[10px] font-semibold uppercase tracking-[0.28em] text-[#B5956E]"
                            x-text="productModal.product?.category ?? 'Producto Samadhi'"></span>


                        {{-- Título --}}
                        <h1 class="mt-2 font-serif text-4xl leading-tight text-stone-900"
                            x-text="productModal.product?.name ?? productModal.product?.title ?? ''"></h1>


                        {{-- Descripción corta --}}
                        <p x-show="productModal.product?.description" x-text="productModal.product?.description"
                            class="mt-3 text-base leading-7 text-stone-500"></p>


                        {{-- Separador --}}
                        <div class="relative my-7 flex items-center justify-center">

                            <div class="absolute inset-x-0 border-t border-stone-200"></div>

                            <div class="relative bg-[#FDFBF7] px-4 text-[#B5956E]">
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 3c-1.5 3-4 5.5-7 6.5 2.5 1.5 5.5 1.5 7 0 1.5 1.5 4.5 1.5 7 0-3-1-5.5-3.5-7-6.5zm0 8c-2.5 2-6 3-9 3 3 2 6.5 2.5 9 5 2.5-2.5 6.5-3-9-5 3 0 6.5-1 9-3z" />
                                </svg>
                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- DESCRIPCIÓN + INGREDIENTES --}}
                        {{-- ================================================= --}}

                        <div class="max-h-[300px] overflow-y-auto pr-2">

                            {{-- Descripción --}}
                            <div x-show="productModal.product?.long_description">
                                <p class="text-[15px] leading-7 text-stone-600"
                                    x-text="productModal.product?.long_description ?? ''"></p>
                            </div>


                            {{-- Ingredientes --}}
                            <div x-show="productModal.product?.ingredients"
                                class="mt-7 border-t border-dashed border-stone-200 pt-5">

                                <span
                                    class="mb-3 block text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">
                                    Ingredientes principales
                                </span>

                                <div class="flex flex-wrap gap-2">

                                    <template
                                        x-for="ingredient in (productModal.product?.ingredients ?? '')
                                        .split(',')
                                        .map(i => i.trim())
                                        .filter(Boolean)"
                                        :key="ingredient">
                                        <span x-text="ingredient"
                                            class="rounded-full bg-[#F3EFEA] px-4 py-2 text-xs text-stone-700"></span>
                                    </template>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- CTA FIJO --}}
                {{-- ================================================= --}}

                <div
                    class="absolute inset-x-0 bottom-0 z-40 border-t border-stone-200/80 bg-[#FDFBF7]/95 px-5 py-4 backdrop-blur-md">

                    <div class="flex items-center gap-4">

                        {{-- Precio --}}
                        <div class="flex w-1/2 flex-col items-center justify-center">

                            <span class="block text-[10px] uppercase tracking-[0.15em] text-stone-400">
                                Precio
                            </span>

                            <span class="block text-2xl font-medium text-stone-900"
                                x-text="'$' + new Intl.NumberFormat('es-AR', {
                                maximumFractionDigits: 0
                            }).format(productModal.product?.price ?? 0)"></span>

                        </div>


                        {{-- Agregar al carrito --}}
                        <button type="button" @click="$wire.addToCart(productModal.product.id)"
                            wire:loading.attr="disabled" wire:target="addToCart"
                            class="flex min-h-[52px] w-1/2 items-center justify-center gap-2 rounded-full bg-[#A98B68] px-4 text-xs font-medium text-white shadow-sm transition-all duration-200 hover:bg-[#8D7358] active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-70">

                            {{-- Estado normal --}}
                            <span wire:loading.remove wire:target="addToCart"
                                class="flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>

                                <span>Agregar al carrito</span>
                            </span>


                            {{-- Spinner --}}
                            <span wire:loading wire:target="addToCart" class="flex items-center justify-center gap-2">
                                <svg class="h-5 w-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="3"></circle>

                                    <path class="opacity-90" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z">
                                    </path>
                                </svg>

                                <span>Agregando...</span>
                            </span>

                        </button>

                    </div>

                </div>

            </div>

        </div>

</template>
