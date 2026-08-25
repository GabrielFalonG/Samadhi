{{-- ========================================================= --}}
{{-- MODAL MOBILE / PREVIEW --}}
{{-- ========================================================= --}}

<template x-teleport="body">

    <div x-show="productModal.open && isMobile" x-cloak role="dialog" aria-modal="true"
        class="fixed inset-0 z-[100] flex items-center justify-center overflow-hidden"
        :class="isPreview ? 'bg-black/60 p-4' : 'h-[100dvh] w-screen'">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" x-show="productModal.open"
            x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="closeProduct()"></div>

        {{-- Container del Modal --}}
        <div @click.stop x-show="productModal.open" x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="relative flex flex-col overflow-hidden bg-[#FDFBF7] shadow-2xl transition-all duration-300"
            :class="isPreview ? 'h-[90vh] max-h-[680px] w-[340px] rounded-2xl border border-stone-300/50' : 'h-[100dvh] w-full'">

            {{-- ================================================= --}}
            {{-- HEADER / BOTÓN CERRAR --}}
            {{-- ================================================= --}}

            <div class="absolute inset-x-0 top-0 z-30 flex items-center justify-end px-4 py-3">
                <button type="button" @click="closeProduct()"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-stone-600 shadow-sm backdrop-blur-sm transition active:scale-95"
                    aria-label="Cerrar">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>


            {{-- ================================================= --}}
            {{-- CONTENIDO FIJO (SIN SCROLL PRINCIPAL EN PREVIEW) --}}
            {{-- ================================================= --}}

            <div class="min-h-0 flex-1 pb-24" :class="isPreview ? 'overflow-hidden' : 'overflow-y-auto'">

                {{-- Imagen --}}
                <div class="w-full bg-[#F3EFEA]">
                    <div class="aspect-[4/3] w-full">
                        <img :src="productModal.product?.image_url"
                            :alt="productModal.product?.name ?? productModal.product?.title ?? ''"
                            class="h-full w-full object-contain object-center">
                    </div>
                </div>


                {{-- Información --}}
                <div :class="isPreview ? 'pb-4 pt-4 px-4' : 'pb-2 pt-2 px-6'">

                    {{-- Categoría --}}
                    <span class="block text-[10px] font-semibold uppercase tracking-[0.28em] text-[#B5956E]"
                        x-text="productModal.product?.category ?? 'Producto Samadhi'"></span>


                    {{-- Título --}}
                    <h1 class="font-serif leading-tight text-stone-900"
                        :class="isPreview ? 'mt-1 text-3xl' : 'mt-2 text-4xl'"
                        x-text="productModal.product?.name ?? productModal.product?.title ?? ''"></h1>


                    {{-- Descripción corta --}}
                    <p x-show="productModal.product?.description" x-text="productModal.product?.description"
                        class="text-stone-500"
                        :class="isPreview ? 'mt-1.5 text-xs leading-5' : 'mt-3 text-base leading-7'"></p>


                    {{-- Separador --}}
                    <div x-show="productModal.product?.long_description || productModal.product?.ingredients"
                        class="relative flex items-center justify-center" :class="isPreview ? 'my-3' : 'my-7'">

                        <div class="absolute inset-x-0 border-t border-stone-200"></div>

                        <div class="relative bg-[#FDFBF7] px-3 text-[#B5956E]">
                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 3c-1.5 3-4 5.5-7 6.5 2.5 1.5 5.5 1.5 7 0 1.5 1.5 4.5 1.5 7 0-3-1-5.5-3.5-7-6.5zm0 8c-2.5 2-6 3-9 3 3 2 6.5 2.5 9 5 2.5-2.5 6.5-3-9-5 3 0 6.5-1 9-3z" />
                            </svg>
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- DESCRIPCIÓN + INGREDIENTES (ÚNICO BLOQUE CON SCROLL) --}}
                    {{-- ================================================= --}}
                    <div class="overflow-y-auto pr-1" :class="isPreview ? 'max-h-[180px]' : 'max-h-[290px]'">

                        {{-- Descripción larga --}}
                        <div
                            x-show="productModal.product?.long_description && productModal.product?.long_description.trim() !== ''"
                            class="prose prose-stone max-w-none text-stone-700"
                            :class="isPreview ? 'prose-xs text-xs leading-relaxed' : 'prose-sm leading-normal'"
                            x-html="productModal.product?.long_description || ''"
                        ></div>

                        {{-- Ingredientes --}}
                        <div
                            x-show="productModal.product?.ingredients && productModal.product?.ingredients.trim() !== ''"
                            class="mt-6 pt-4 border-t border-dashed border-stone-200"
                            :class="[
                                isPreview ? 'mt-3 pt-2' : 'mt-7 pt-5',
                                (!productModal.product?.long_description || productModal.product?.long_description.trim() === '') ? '!border-t-0 !pt-0 !mt-0' : ''
                            ]"
                        >
                            <span class="mb-2 block text-[9px] font-semibold uppercase tracking-[0.2em] text-stone-400">
                                Ingredientes principales
                            </span>

                            <div class="flex flex-wrap gap-1.5">
                                <template
                                    x-for="(ingredient, index) in (productModal.product?.ingredients || '')
                                        .split(',')
                                        .map(i => i.trim())
                                        .filter(Boolean)"
                                    :key="index"
                                >
                                    <span
                                        x-text="ingredient"
                                        class="rounded-full bg-[#F3EFEA] text-stone-700"
                                        :class="isPreview ? 'px-2 py-0.5 text-[10px]' : 'px-4 py-2 text-xs'"
                                    ></span>
                                </template>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- CTA FIJO --}}
            {{-- ================================================= --}}

            <div class="absolute inset-x-0 bottom-0 z-40 border-t border-stone-200/80 bg-[#FDFBF7]/95 backdrop-blur-md"
                :class="isPreview ? 'px-4 py-3' : 'px-5 py-4'">

                <div class="flex items-center gap-3">

                    {{-- Precio --}}
                    <div class="flex w-1/2 flex-col items-center justify-center">

                        <span class="block text-[9px] uppercase tracking-[0.15em] text-stone-400">
                            Precio
                        </span>

                        <span class="block font-medium text-stone-900" :class="isPreview ? 'text-lg' : 'text-2xl'"
                            x-text="'$' + new Intl.NumberFormat('es-AR', {
                            maximumFractionDigits: 0
                        }).format(productModal.product?.price ?? 0)"></span>

                    </div>


                    {{-- Agregar al carrito --}}
                    <button type="button" @click="$wire.addToCart(productModal.product.id)"
                        wire:loading.attr="disabled" wire:target="addToCart" :disabled="isPreview"
                        class="flex w-1/2 items-center justify-center gap-2 rounded-full bg-[#A98B68] text-white shadow-sm transition-all duration-200 hover:bg-[#8D7358] active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-70"
                        :class="isPreview ? 'min-h-[40px] px-3 text-[11px]' : 'min-h-[52px] px-4 text-xs'">

                        {{-- Estado normal --}}
                        <span wire:loading.remove wire:target="addToCart"
                            class="flex items-center justify-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>

                            <span>Agregar al carrito</span>
                        </span>


                        {{-- Spinner --}}
                        <span wire:loading.flex wire:target="addToCart"
                            class="items-center justify-center gap-2 whitespace-nowrap">
                            <svg class="h-4 w-4 shrink-0 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="3"></circle>

                                <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z">
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
