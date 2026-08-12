<section class="min-h-screen bg-[#F8F7F4]">

    {{-- Fondos decorativos --}}

    <div class="absolute inset-0 overflow-hidden pointer-events-none">

        <div
            class="absolute -top-48 right-0 h-96 w-96 rounded-full bg-[#EFE7DA]/40 blur-3xl">
        </div>

        <div
            class="absolute bottom-0 left-0 h-72 w-72 rounded-full bg-stone-200/40 blur-3xl">
        </div>

    </div>

    <div class="relative mx-auto max-w-7xl px-5 py-10 lg:px-8 lg:py-16">
        {{-- Breadcrumb --}}
        <nav
            class="mb-4 flex items-center gap-2 text-sm text-stone-500">
            <a
                href="{{ route('home') }}"
                class="hover:text-[#A98B68]">
                Inicio
            </a>
            <span>/</span>
            <span
                class="text-stone-700">
                Carrito
            </span>
        </nav>

        {{-- Titulo --}}

        <div class="mb-10">
            <h1
                class="font-serif text-4xl text-stone-900 lg:text-5xl">
                Tu carrito
            </h1>
            <p
                class="mt-3 text-stone-500">
                Revisá tus productos antes de finalizar la compra.
            </p>
        </div>

        {{-- Layout Desktop --}}

        <div
            class="grid gap-10 lg:grid-cols-[1fr_360px]">
            {{-- ================================================= --}}
            {{-- PRODUCTOS --}}
            {{-- ================================================= --}}
            <div class="flex flex-col overflow-hidden">
                {{-- Card productos --}}
                <div
                    class="overflow-hidden rounded-[30px] bg-white shadow-[0_12px_35px_rgba(0,0,0,.05)]">
                    @foreach($items as $item)
                        <article
                            class="flex flex-col gap-5 border-b border-stone-100 p-6 sm:flex-row">
                            {{-- Imagen --}}
                            <div
                                class="flex h-36 w-full shrink-0 items-center justify-center rounded-3xl bg-[#F5F2EC] sm:h-36 sm:w-36">
                                <img
                                    src="{{ asset($item['image_url']) }}"
                                    alt="{{ $item['title'] }}"
                                    class="max-h-28 object-contain transition duration-300 hover:scale-105">
                            </div>
                            {{-- Información --}}
                            <div
                                class="flex flex-1 flex-col">
                                <span
                                    class="text-[11px] uppercase tracking-[0.35em] text-[#A98B68]">
                                    ✦ Línea Samadhi
                                </span>
                                <h2
                                    class="mt-2 font-serif text-3xl text-stone-900">
                                    {{ $item['title'] }}
                                </h2>

                                <p
                                    class="mt-2 text-stone-500">
                                    {{ $item['description'] }}
                                </p>
                                <p
                                    class="mt-3 text-sm text-[#A98B68]">
                                    Romero • Menta • Cornalina
                                </p>
                                {{-- Controles inferiores --}}
                                <div
                                    class="mt-6 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                                    {{-- Cantidad --}}
                                    <div
                                        class="flex items-center gap-4">
                                        <div
                                            class="flex items-center rounded-full border border-stone-200 bg-stone-50">
                                            <button
                                                wire:click="decrease({{ $item['id'] }})"
                                                class="flex h-10 w-10 items-center justify-center rounded-full transition hover:bg-stone-200">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 12H4"/>
                                                </svg>
                                            </button>
                                            <span
                                                class="w-10 text-center font-medium text-stone-700">
                                                {{ $item['quantity'] }}
                                            </span>
                                            <button
                                                wire:click="increase({{ $item['id'] }})"
                                                class="flex h-10 w-10 items-center justify-center rounded-full transition hover:bg-stone-200">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <button
                                            wire:click="remove({{ $item['id'] }})"
                                            class="text-sm text-red-500 transition hover:text-red-700">
                                            Eliminar
                                        </button>
                                    </div>

                                    {{-- Precio --}}

                                    <div
                                        class="text-left lg:text-right">
                                        <p
                                            class="text-sm uppercase tracking-[0.25em] text-stone-400">
                                            Precio
                                        </p>
                                        <p
                                            class="mt-1 font-serif text-3xl text-[#A98B68]">
                                            ${{ number_format($item['price']) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                {{-- Banner informativo --}}
                <div
                    class="mt-8 rounded-[30px] bg-white p-6 shadow-[0_12px_35px_rgba(0,0,0,.05)]">
                    <div
                        class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-7 w-7 text-green-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h3
                                class="font-medium text-lg text-stone-800">
                                Envío a todo el país
                            </h3>
                            <p
                                class="mt-1 text-stone-500">
                                Tus productos serán preparados artesanalmente,
                                cuidadosamente embalados y despachados con seguimiento.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================= --}}
            {{-- RESUMEN --}}
            {{-- ================================================= --}}
            <aside
                class="self-start lg:sticky lg:top-28">
                <div
                    class="overflow-hidden rounded-[30px] bg-white shadow-[0_12px_35px_rgba(0,0,0,.05)]">
                    {{-- Header --}}
                    <div
                        class="border-b border-stone-100 p-7">
                        <span
                            class="text-[11px] uppercase tracking-[0.35em] text-[#A98B68]">
                            ✦ Resumen
                        </span>
                        <h2
                            class="mt-3 font-serif text-3xl text-stone-900">
                            Tu compra
                        </h2>
                    </div>
                    {{-- Totales --}}
                    <div
                        class="space-y-5 p-7">
                        <div
                            class="flex items-center justify-between text-stone-600">
                            <span>
                                Subtotal
                            </span>
                            <span>
                                ${{ number_format($this->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                        <div
                            class="flex items-center justify-between text-stone-600">
                            <span>
                                Envío
                            </span>
                            <span
                                class="font-medium text-green-600">
                                Gratis
                            </span>
                        </div>
                        <div
                            class="flex items-center justify-between text-stone-600">
                            <span>
                                Productos
                            </span>
                            <span>
                                {{ count($items) }}
                            </span>
                        </div>
                        <div
                            class="border-t border-dashed border-stone-200 pt-5">
                            <div
                                class="flex items-end justify-between">
                                <div>
                                    <p
                                        class="text-sm uppercase tracking-[0.25em] text-stone-400">
                                        Total
                                    </p>
                                    <h3
                                        class="mt-2 font-serif text-5xl text-[#A98B68]">
                                        ${{ number_format($this->total, 0, ',', '.') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Beneficios --}}

                    <div
                        class="border-t border-stone-100 bg-[#FAF9F7] p-7">
                        <ul
                            class="space-y-4 text-sm text-stone-600">
                            <li
                                class="flex items-center gap-3">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                                    ✓
                                </div>
                                Productos preparados artesanalmente
                            </li>

                            <li
                                class="flex items-center gap-3">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100">
                                    ✦
                                </div>
                                Cristales naturales en cada preparación
                            </li>

                            <li
                                class="flex items-center gap-3">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
                                    🚚
                                </div>
                                Envíos a todo el país
                            </li>
                        </ul>
                    </div>
                    {{-- Botones --}}
                    <div
                        class="space-y-3 p-7">
                        <button wire:click="checkoutPage"
                            class="w-full rounded-full bg-[#A98B68] py-4 text-lg font-medium text-white transition-all duration-300 hover:-translate-y-1 hover:bg-[#8D7358] hover:shadow-xl">
                            Continuar
                        </button>
                        <a
                            href="{{ route('products') }}"
                            wire:navigate
                            class="flex w-full items-center justify-center rounded-full border border-stone-300 py-4 text-stone-700 transition hover:border-[#A98B68] hover:text-[#A98B68]">
                            Seguir comprando
                        </a>
                    </div>
                </div>
            </aside>
        </div>
                {{-- Información adicional --}}
        <div
            class="mt-10 grid gap-6 md:grid-cols-3">
            <div
                class="rounded-[30px] bg-white p-6 shadow-[0_12px_35px_rgba(0,0,0,.05)]">
                <div
                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#F5F2EC]">
                    🌿
                </div>
                <h3
                    class="font-medium text-stone-800">
                    Ingredientes naturales
                </h3>

                <p
                    class="mt-2 text-sm leading-7 text-stone-500">
                    Esencias, cristales y materias primas cuidadosamente
                    seleccionadas para acompañar cada intención.
                </p>
            </div>

            <div
                class="rounded-[30px] bg-white p-6 shadow-[0_12px_35px_rgba(0,0,0,.05)]">
                <div
                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#F5F2EC]">
                    ✨
                </div>
                <h3
                    class="font-medium text-stone-800">
                    Preparación artesanal
                </h3>
                <p
                    class="mt-2 text-sm leading-7 text-stone-500">
                    Cada producto es preparado individualmente,
                    energizado e intencionado antes de ser enviado.
                </p>
            </div>
            <div
                class="rounded-[30px] bg-white p-6 shadow-[0_12px_35px_rgba(0,0,0,.05)]">
                <div
                    class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#F5F2EC]">
                    🤍
                </div>

                <h3
                    class="font-medium text-stone-800">
                    Compra segura
                </h3>

                <p
                    class="mt-2 text-sm leading-7 text-stone-500">
                    Muy pronto podrás finalizar tu compra utilizando
                    Mercado Pago y diferentes medios de pago.
                </p>
            </div>
        </div>
    </div>
</section>
