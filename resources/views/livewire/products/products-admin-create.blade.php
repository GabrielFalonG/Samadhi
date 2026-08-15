@push('css')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

<div class="min-h-screen bg-slate-100" x-data="{ showConfirmModal: false }">
    <div class="p-5 lg:p-10">

        {{-- Breadcrumb --}}
        <nav class="mb-5 flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('admin.products') }}" wire:navigate class="transition hover:text-violet-700">
                Productos
            </a>
            <span>/</span>
            <span class="font-medium text-slate-700">Nuevo producto</span>
        </nav>

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-4xl font-bold text-slate-900">Nuevo producto</h1>
                <p class="mt-2 text-slate-500">
                    Creá un producto que podrá mostrarse dentro de la aplicación.
                </p>
            </div>
        </div>

        {{-- FORMULARIO --}}
        @include('livewire.products.products-form', [
            'isEditing' => false,
        ])
    </div>

    {{-- Modal de Confirmación --}}
    <div x-data="{ showModal: @entangle('showConfirmModal') }" x-show="showModal" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none;">

        <div @click.away="showModal = false" class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">

            {{-- Icono --}}
            <div class="flex justify-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-violet-100">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-violet-50">
                        <x-heroicon-o-check-circle class="h-8 w-8 text-violet-600" />
                    </div>
                </div>
            </div>

            {{-- Título --}}
            <h2 class="mt-6 text-center text-3xl font-semibold text-slate-900">
                Guardar producto
            </h2>

            {{-- Descripción --}}
            <p class="mt-3 text-center text-base leading-relaxed text-slate-500">
                ¿Estás seguro que deseas guardar este nuevo producto?
            </p>

            {{-- Vista previa del nombre --}}
            <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-center font-medium text-slate-700">
                    {{ $this->form->title ?: 'Sin título especificado' }}
                </p>
            </div>

            {{-- Botones del Modal --}}
            <div class="mt-8 grid grid-cols-2 gap-4">
                <button type="button" wire:click="cancelSave"
                    class="rounded-xl bg-slate-100 py-3 text-base font-semibold text-slate-700 transition hover:bg-slate-200">
                    Cancelar
                </button>

                <button type="button" wire:click="save" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-xl bg-violet-700 py-3 text-base font-semibold text-white transition hover:bg-violet-800 disabled:opacity-70">
                    <span wire:loading.remove wire:target="save">Confirmar</span>
                    <span wire:loading.flex wire:target="save" class="items-center justify-center">
                        <svg class="mr-2 h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                        </svg>

                        <span>Guardando...</span>
                    </span>
                </button>
            </div>

        </div>
    </div>
</div>
