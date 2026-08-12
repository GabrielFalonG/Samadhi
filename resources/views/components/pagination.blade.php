@if ($paginator->hasPages())
    <nav class="flex items-center justify-center">

        {{-- Botón Anterior --}}
        @if ($paginator->onFirstPage())
            <span
                class="inline-flex items-center space-x-1 px-3 py-1 text-stone-300 cursor-not-allowed select-none"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                <span>Anterior</span>
            </span>
        @else
            <button
                type="button"
                wire:click="previousPage"
                wire:loading.attr="disabled"
                class="inline-flex items-center space-x-1 px-3 py-1 text-stone-600 transition-colors hover:text-[#B89B6A]"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                <span>Anterior</span>
            </button>
        @endif


        {{-- Números de páginas --}}
        <div class="flex items-center space-x-1 px-2">

            @foreach ($elements as $element)

                {{-- Separador ... --}}
                @if (is_string($element))
                    <span class="px-2 py-1 text-stone-400 select-none">
                        {{ $element }}
                    </span>
                @endif


                {{-- Links de páginas --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        @if ($page == $paginator->currentPage())

                            {{-- Página activa --}}
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border-2 border-[#B89B6A] bg-white text-sm font-semibold text-[#B89B6A] shadow-sm"
                            >
                                {{ $page }}
                            </span>

                        @else

                            {{-- Página --}}
                            <button
                                type="button"
                                wire:click="gotoPage({{ $page }})"
                                wire:loading.attr="disabled"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-sm text-stone-600 transition-colors hover:bg-stone-100 hover:text-[#B89B6A]"
                            >
                                {{ $page }}
                            </button>

                        @endif

                    @endforeach
                @endif

            @endforeach

        </div>


        {{-- Botón Siguiente --}}
        @if ($paginator->hasMorePages())

            <button
                type="button"
                wire:click="nextPage"
                wire:loading.attr="disabled"
                class="inline-flex items-center space-x-1 px-3 py-1 text-stone-600 transition-colors hover:text-[#B89B6A]"
            >
                <span>Siguiente</span>

                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M9 5l7 7-7 7"
                    />
                </svg>
            </button>

        @else

            <span
                class="inline-flex items-center space-x-1 px-3 py-1 text-stone-300 cursor-not-allowed select-none"
            >
                <span>Siguiente</span>

                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M9 5l7 7-7-7"
                    />
                </svg>
            </span>

        @endif

    </nav>
@endif
