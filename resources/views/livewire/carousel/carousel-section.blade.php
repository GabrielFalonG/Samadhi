<div class="space-y-20 py-8" x-data="{
    productModal: {
        open: false,
        product: null
    },

    isMobile: window.innerWidth < 1024,

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

    @foreach ($carousels as $carousel)
        <section wire:key="carousel-{{ $carousel['id'] }}" class="page-section relative" x-data="{
            index: 0,
            visible: 5,
            total: 0,
            interval: null,
            touchStartX: 0,

            init() {
                this.refreshCarousel();
                window.addEventListener('resize', () => this.updateVisible());
                this.$nextTick(() => { this.refreshCarousel(); });
            },

            refreshCarousel() {
                this.total = this.$refs.track ?
                    this.$refs.track.children.length :
                    0;

                this.updateVisible();
                this.startAutoScroll();
            },

            updateVisible() {
                if (window.innerWidth < 640) {
                    this.visible = 1;
                } else if (window.innerWidth < 1024) {
                    this.visible = 2;
                } else if (window.innerWidth < 1280) {
                    this.visible = 3;
                } else if (window.innerWidth < 1536) {
                    this.visible = 4;
                } else {
                    this.visible = 5;
                }

                this.move();
            },

            move() {
                if (!this.$refs.track) return;

                const card = this.$refs.track.children[0];

                if (!card) return;

                const style = getComputedStyle(this.$refs.track);
                const gap = parseFloat(style.columnGap || style.gap || 0);
                const width = card.offsetWidth + gap;

                if (width > gap) {
                    this.$refs.track.style.transform =
                        `translateX(-${this.index * width}px)`;
                }
            },

            scroll(direction, resetTimer = true) {
                if (resetTimer) {
                    this.stopAutoScroll();
                }

                const max = Math.max(
                    0,
                    this.total - this.visible
                );

                this.index += direction;

                if (this.index < 0) {
                    this.index = max;
                }

                if (this.index > max) {
                    this.index = 0;
                }

                this.move();

                if (resetTimer) {
                    this.startAutoScroll();
                }
            },

            startAutoScroll() {
                this.stopAutoScroll();

                this.interval = setInterval(() => {
                    this.scroll(1, false);
                }, 5000);
            },

            stopAutoScroll() {
                if (this.interval) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            },

            touchStart(event) {
                this.touchStartX =
                    event.changedTouches[0].clientX;
            },

            touchEnd(event) {
                const end =
                    event.changedTouches[0].clientX;

                const diff =
                    this.touchStartX - end;

                if (Math.abs(diff) < 50) return;

                diff > 0 ?
                    this.scroll(1) :
                    this.scroll(-1);
            }
        }"
            @touchstart="touchStart($event)" @touchend="touchEnd($event)" @mouseenter="stopAutoScroll()"
            @mouseleave="startAutoScroll()">

            {{-- ================================================= --}}
            {{-- Encabezado --}}
            {{-- ================================================= --}}

            @if (!empty($carousel['title']))
                <div class="mx-auto max-w-4xl text-center">

                    @if (!empty($carousel['subtitle']))
                        <h2 class="font-serif text-5xl text-stone-800">
                            {{ $carousel['title'] }}
                        </h2>
                    @endif

                    <div class="mt-6">
                        <span class="text-sm uppercase tracking-[0.35em] text-[#A98B68]">
                            {{ $carousel['subtitle'] }}
                        </span>
                    </div>

                    @if (!empty($carousel['description']))
                        <p class="mx-auto mt-2 max-w-3xl text-lg leading-9 text-stone-600">
                            {{ $carousel['description'] }}
                        </p>
                    @endif

                </div>
            @endif


            {{-- ================================================= --}}
            {{-- Cuerpo del Carrusel --}}
            {{-- ================================================= --}}

            <div class="relative flex items-center w-full">

                {{-- Botón Anterior --}}
                <button type="button" x-show="total > visible" x-cloak @click="scroll(-1)"
                    class="absolute -left-5 z-20 hidden lg:flex h-11 w-11 items-center justify-center rounded-full bg-white text-stone-700 shadow-md transition hover:bg-stone-50 hover:shadow-lg"
                    aria-label="Anterior">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>


                {{-- ================================================= --}}
                {{-- Track / Contenedor de Items --}}
                {{-- ================================================= --}}

                <div class="relative overflow-hidden w-full px-1 py-2">

                    <div x-ref="track" class="mt-6 flex gap-4 transition-transform duration-500 ease-out">

                        @foreach ($carousel['products'] as $item)
                            <article wire:key="item-{{ $item['id'] }}"
                                class="shrink-0 w-full sm:w-[calc((100%-1rem)/2)] lg:w-[calc((100%-2rem)/3)] xl:w-[calc((100%-3rem)/4)] 2xl:w-[calc((100%-4rem)/5)]">

                                @if (!empty($item['linkUrl']))
                                    <a href="{{ $item['linkUrl'] }}" class="block h-full">
                                        @include('livewire.carousel.carousel-item', [
                                            'item' => $item,
                                            'carousel' => $carousel,
                                        ])
                                    </a>
                                @else
                                    @include('livewire.carousel.carousel-item', [
                                        'item' => $item,
                                        'carousel' => $carousel,
                                    ])
                                @endif

                            </article>
                        @endforeach

                    </div>

                </div>


                {{-- Botón Siguiente --}}
                <button type="button" x-show="total > visible" x-cloak @click="scroll(1)"
                    class="absolute -right-5 z-20 hidden lg:flex h-11 w-11 items-center justify-center rounded-full bg-white text-stone-700 shadow-md transition hover:bg-stone-50 hover:shadow-lg"
                    aria-label="Siguiente">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

            </div>

        </section>
    @endforeach


    {{-- ========================================================= --}}
    {{-- MODAL ÚNICO DE PRODUCTO --}}
    {{-- ========================================================= --}}
    @include('livewire.products.product-item-modal')

    {{-- ========================================================= --}}
    {{-- MODAL ÚNICO DE PRODUCTO MOBILE --}}
    {{-- ========================================================= --}}
    @include('livewire.products.product-item-mobile-modal')

