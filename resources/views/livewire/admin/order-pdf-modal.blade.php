<!-- Modal de Visualización de PDF -->
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Fondo Oscuro / Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <!-- Contenedor del Modal -->
        <div class="relative w-full max-w-4xl rounded-2xl bg-white p-6 shadow-2xl transition-all">

            <!-- Encabezado -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-lg font-semibold text-slate-800">
                    Visualizador de Pedido #{{ $selectedOrderId }}
                </h3>
                <button
                    type="button"
                    wire:click="closeModal"
                    class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                    <x-heroicon-o-x-mark class="size-6" />
                </button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="mt-4 flex h-[70vh] w-full items-center justify-center rounded-xl border border-slate-200 bg-slate-50 overflow-hidden">

                @if($selectedPdfUrl)
                    <!-- Opción A: El PDF existe y se muestra el iframe -->
                    <iframe
                        src="{{ $selectedPdfUrl }}"
                        class="h-full w-full border-none"
                        title="Vista previa del PDF">
                    </iframe>
                @else
                    <!-- Opción B: El PDF no existe -> Mostrar botón de generación -->
                    <div class="flex flex-col items-center justify-center p-6 text-center">
                        <div class="rounded-full bg-slate-100 p-4 mb-4">
                            <x-heroicon-o-document-minus class="size-10 text-slate-400" />
                        </div>
                        <h4 class="text-base font-semibold text-slate-800">El archivo PDF no está disponible</h4>
                        <p class="mt-1 text-sm text-slate-500 max-w-xs">
                            No se encontró el documento para este pedido. Puedes generarlo ahora mismo.
                        </p>

                        <!-- Botón con estado de carga (wire:loading) -->
                        <button
                            type="button"
                            wire:click="generatePdf"
                            wire:loading.attr="disabled"
                            class="mt-5 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none disabled:opacity-50 transition">

                            <!-- Icono normal -->
                            <x-heroicon-o-document-plus wire:loading.remove wire:target="generatePdf" class="size-5" />

                            <!-- Spinner de carga al procesar -->
                            <svg wire:loading wire:target="generatePdf" class="size-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>

                            <span wire:loading.remove wire:target="generatePdf">Generar PDF</span>
                            <span wire:loading wire:target="generatePdf">Generando documento...</span>
                        </button>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
