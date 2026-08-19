<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

    <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">

        {{-- Icono --}}
        <div class="flex justify-center">

            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-red-100">

                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-50">

                    <x-heroicon-o-information-circle class="h-8 w-8 text-blue-600" />

                </div>

            </div>

        </div>

        {{-- Título --}}
        <h2 class="mt-6 text-center text-3xl font-semibold text-slate-900">

            Crear Carousel

        </h2>

        {{-- Descripción --}}
        <p class="mt-3 text-center text-base leading-relaxed text-slate-500">

            ¿Estás seguro que deseas crear este carousel?

        </p>

        {{-- Nombre --}}
        <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">

            <p class="text-center font-medium text-slate-700">

                {{ $this->form?->title ?? 'N/A' }}

            </p>

        </div>

        {{-- Botones --}}
        <div class="mt-8 grid grid-cols-2 gap-4">

            <button wire:click="$set('showConfirmModal', false)" type="button"
                class="
                    rounded-xl
                    bg-slate-100
                    py-3
                    text-base
                    font-semibold
                    text-slate-700
                    transition
                    hover:bg-slate-200">

                Cancelar

            </button>

            <button wire:click="save" wire:loading.attr="disabled" wire:target="save" type="button"
                class="inline-flex items-center justify-center rounded-2xl bg-violet-600 px-6 py-3.5 text-base font-semibold text-white transition hover:bg-violet-700 disabled:opacity-50">
                {{-- Estado normal --}}
                <span wire:loading.remove wire:target="save">
                    Crear
                </span>

                {{-- Estado procesando --}}
                <span wire:loading.flex wire:target="save" class="items-center justify-center">
                    <svg class="mr-2 h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                    </svg>

                    <span>Procesando...</span>
                </span>
            </button>

        </div>

    </div>

</div>
