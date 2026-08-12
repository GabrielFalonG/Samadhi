<div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

    <div
        class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">

        {{-- Icono --}}
        <div class="flex justify-center">

            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-red-100">

                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-50">

                    <x-heroicon-o-exclamation-triangle
                        class="h-8 w-8 text-red-600"/>

                </div>

            </div>

        </div>

        {{-- Título --}}
        <h2
            class="mt-6 text-center text-3xl font-semibold text-slate-900">

            Eliminar producto

        </h2>

        {{-- Descripción --}}
        <p
            class="mt-3 text-center text-base leading-relaxed text-slate-500">

            ¿Estás seguro que deseas eliminar este producto?

            <br>

            Esta acción no podrá deshacerse.

        </p>

        {{-- Nombre --}}
        <div
            class="mt-5 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">

            <p class="text-center font-medium text-slate-700">

                {{ $this->productToDelete?->title ?? 'N/A' }}

            </p>

        </div>

        {{-- Botones --}}
        <div class="mt-8 grid grid-cols-2 gap-4">

            <button
                wire:click="cancelDelete"
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
                wire:click="deleteProduct"
                type="button"
                class="
                    rounded-xl
                    bg-red-500
                    py-3
                    text-base
                    font-semibold
                    text-white
                    transition
                    hover:bg-red-600">

                Eliminar

            </button>

        </div>

    </div>

</div>
