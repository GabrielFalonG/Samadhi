<div
    id="productos"
    class="mx-auto max-w-7xl px-6 bg-[#F8F7F4] pt-4">

    <!-- Encabezado institucional -->
    <section class="relative overflow-hidden pb-8 pt-8 lg:px-16">

        <div class="relative mx-auto max-w-4xl text-center">

            {{-- H1 --}}
            <h1 class="mt-6 font-serif text-4xl leading-tight text-stone-900 md:text-5xl">
                Bienestar que se siente.
                <br>
                Energía que permanece.
            </h1>

            {{-- Bajada --}}
            <p class="mx-auto mt-8 max-w-3xl text-lg leading-8 text-stone-600">
                Cada creación de <strong class="font-medium text-stone-800">Samadhi</strong>
                nace de un proceso artesanal, ingredientes cuidadosamente seleccionados
                y una intención consciente.
                Productos diseñados para acompañar tus rituales cotidianos con equilibrio,
                armonía y belleza.
            </p>

            {{-- Beneficios --}}
            <div class="mt-12 grid gap-6 md:grid-cols-3">

                <div class="rounded-2xl bg-white/80 p-6 shadow-sm ring-1 ring-stone-200 backdrop-blur">
                    <div class="mb-4 text-2xl">🌿</div>

                    <h3 class="font-serif text-2xl text-stone-900">
                        Artesanal
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-stone-600">
                        Elaboramos cada producto con dedicación,
                        cuidando cada detalle del proceso.
                    </p>
                </div>

                <div class="rounded-2xl bg-white/80 p-6 shadow-sm ring-1 ring-stone-200 backdrop-blur">
                    <div class="mb-4 text-2xl">✨</div>

                    <h3 class="font-serif text-2xl text-stone-900">
                        Intención
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-stone-600">
                        Aromas, minerales y elementos elegidos para acompañar
                        momentos de conexión y bienestar.
                    </p>
                </div>

                <div class="rounded-2xl bg-white/80 p-6 shadow-sm ring-1 ring-stone-200 backdrop-blur">
                    <div class="mb-4 text-2xl">🤍</div>

                    <h3 class="font-serif text-2xl text-stone-900">
                        Bienestar
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-stone-600">
                        Diseñados para convertir los pequeños momentos
                        cotidianos en rituales conscientes.
                    </p>
                </div>

            </div>

        </div>


        <div class="mt-16 flex flex-col items-center">

            <span class="mb-4 text-xs uppercase tracking-[0.35em] text-stone-500">
                Descubrí nuestras colecciones
            </span>

            <a
                href="#colecciones"
                class="group flex h-16 w-16 items-center justify-center rounded-full border border-stone-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#C6A77A] hover:shadow-lg"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6 text-[#A67C52] transition-transform duration-300 group-hover:translate-y-1"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 8.25L12 15.75 4.5 8.25"
                    />
                </svg>

            </a>

        </div>

    </section>

    <!-- Separación -->
    <div class="my-12 border-t border-stone-200"></div>

    <section id="colecciones">

        <livewire:components.carousel-section
            wire:key="carousel-component-{{ time() }}"
        />

    </section>
</div>



