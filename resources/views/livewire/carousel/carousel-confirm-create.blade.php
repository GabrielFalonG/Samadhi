<div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

    <div
        class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">

        {{-- Icono --}}
        <div class="flex justify-center">

            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-red-100">

                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-50">

                    <x-heroicon-o-information-circle
                        class="h-8 w-8 text-blue-600" />

                </div>

            </div>

        </div>

        {{-- Título --}}
        <h2
            class="mt-6 text-center text-3xl font-semibold text-slate-900">

            Crear Carousel

        </h2>

        {{-- Descripción --}}
        <p
            class="mt-3 text-center text-base leading-relaxed text-slate-500">

            ¿Estás seguro que deseas crear este carousel?

        </p>

        {{-- Nombre --}}
        <div
            class="mt-5 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">

            <p class="text-center font-medium text-slate-700">

                {{ $this->form?->title ?? 'N/A' }}

            </p>

        </div>

        {{-- Botones --}}
        <div class="mt-8 grid grid-cols-2 gap-4">

            <button
                wire:click="$set('showConfirmModal', false)"
                type="button"
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

            <button
                wire:click="save"
                wire:loading.attr="disabled"
                type="button"
                class="inline-flex items-center justify-center rounded-2xl bg-violet-600 px-6 py-3.5 text-base font-semibold text-white transition hover:bg-violet-700 disabled:opacity-50">

                <span wire:loading.remove>Crear</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>

        </div>

    </div>

</div>
