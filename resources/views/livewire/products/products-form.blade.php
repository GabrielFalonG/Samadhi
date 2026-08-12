<div class="grid gap-8 xl:grid-cols-3">
    {{-- Columna izquierda (2 cols) - Contenido Principal --}}
    <div class="space-y-8 xl:col-span-2">

        {{-- Información General --}}
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-xl font-semibold text-slate-900">Información general</h2>
                <p class="mt-1 text-sm text-slate-500">Datos principales del producto.</p>
            </div>

            <div class="space-y-6 p-6">
                {{-- Nombre --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Nombre</label>
                    <input type="text"
                            wire:model.blur="form.title"
                            placeholder="Ej. Bruma Calma"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
                    @error('form.title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Descripción</label>
                    <input type="text" wire:model.blur="form.description"
                            name="description" id="description" placeholder="Ej. Bruma energética de protección"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
                    @error('form.description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción larga --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Descripción larga</label>
                    <textarea rows="3"
                                wire:model.blur="form.long_description"
                                placeholder="Descripción larga..."
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100"></textarea>
                    @error('form.long_description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ingredientes --}}
                <x-multi-select
                    label="Ingredientes"
                    wire-model="form.selectedIngredients"
                    :options="$this->selectableIngredients"
                    placeholder="Buscar ingrediente..."
                    :allow-create="true"
                />

                {{-- Categoria --}}
                <x-multi-select
                    label="Categorías"
                    wire-model="form.categories"
                    :options="$selectableCategories"
                    placeholder="Buscar categoría..."
                    :fixed-values="$form->defaultCategory"
                    :allow-create="false"
                />
            </div>
        </div>

    </div>

    {{-- Sidebar Derecho (1 col) --}}
    <div class="space-y-8">

        {{-- Card de Imagen --}}
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm" x-data="{ showModal: false }">
            {{-- Header de la Card --}}
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-xl font-semibold text-slate-900">Imagen</h2>
                <p class="mt-1 text-sm text-slate-500">Imagen principal del producto.</p>
            </div>

            {{-- Cuerpo de la Card --}}
            <div class="p-6">
                {{-- Preview Box --}}
                <div class="flex h-56 w-full items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50">
                    @if($this->imagePreview)
                        <img src="{{ $this->imagePreview }}" class="h-full w-full object-contain">
                    @else
                        <div class="p-4 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-violet-100">
                                <x-heroicon-o-photo class="h-7 w-7 text-violet-600"/>
                            </div>
                            <h3 class="mt-3 text-base font-semibold text-slate-800">Sin imagen</h3>
                            <p class="mt-1 text-xs text-slate-500">JPG · PNG · WEBP</p>
                        </div>
                    @endif
                </div>

                {{-- Botones de Acción --}}
                <div class="mt-4">
                    <div class="flex gap-3">
                        @if($this->originalImage)
                            {{-- Botón Ver Actual --}}
                            <button
                                type="button"
                                x-on:click="showModal = true"
                                class="flex flex-1 items-center justify-center rounded-2xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                            >
                                <x-heroicon-o-eye class="mr-2 h-4 w-4 text-slate-500"/>
                                Ver Actual
                            </button>
                        @endif

                        {{-- Botón Cambiar / Seleccionar --}}
                        <label class="flex flex-1 cursor-pointer items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 focus-within:ring-2 focus-within:ring-violet-500 focus-within:ring-offset-2">
                            <input type="file" class="hidden" wire:model.blur="form.image" accept="image/*">
                            <x-heroicon-o-arrow-up-tray class="mr-2 h-4 w-4 text-slate-500"/>
                            {{ $this->imagePreview ? 'Cambiar' : 'Seleccionar' }}
                        </label>
                    </div>

                    @error('form.image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4 rounded-xl bg-slate-50 p-3 text-xs text-slate-500">
                    Recomendado: <strong>.png .jpg .jpeg</strong>
                </div>
            </div>

            {{-- Modal para ver la imagen actual de la DB --}}
            @if($this->originalImage)
                <div
                    x-show="showModal"
                    x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                    style="display: none;"
                >
                    {{-- Backdrop --}}
                    <div
                        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                        x-on:click="showModal = false"
                    ></div>

                    {{-- Modal Content --}}
                    <div class="relative z-10 w-full max-w-3xl overflow-hidden rounded-3xl bg-white shadow-2xl">
                        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                            <h3 class="text-base font-semibold text-slate-800">Imagen actual</h3>
                            <button
                                type="button"
                                x-on:click="showModal = false"
                                class="rounded-full p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600"
                            >
                                <x-heroicon-o-x-mark class="h-6 w-6"/>
                            </button>
                        </div>

                        <div class="p-6 bg-slate-50 flex items-center justify-center max-h-[75vh]">
                            <img
                                src="{{ $this->originalImage }}"
                                alt="Imagen guardada"
                                class="max-h-[65vh] w-auto rounded-xl object-contain shadow-sm"
                            >
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

    {{-- Precio y Estado --}}
    <div class="col-span-full rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-xl font-semibold text-slate-900">Configuración</h2>
            <p class="mt-1 text-sm text-slate-500">Precio y estado del producto.</p>
        </div>

        {{-- Grilla principal 50% / 50% en pantallas medianas en adelante --}}
        <div class="grid grid-cols-1 gap-8 p-6 md:grid-cols-2">

            {{-- Columna izquierda (50%): Precio y Estado uno debajo del otro --}}
            <div class="space-y-6">
                {{-- Precio --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Precio</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-medium text-slate-500">$</span>
                        <input type="number" min="0" step="0.01" wire:model.blur="form.price" placeholder="0.00"
                            class="w-full rounded-2xl border border-slate-300 py-3 pl-8 pr-4 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
                    </div>
                    @error('form.price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Estado</label>
                    <label class="flex cursor-pointer items-center justify-between rounded-2xl border border-slate-200 p-4 transition hover:border-violet-300">
                        <div>
                            <p class="font-medium text-slate-900">Producto activo</p>
                            <p class="mt-1 text-xs text-slate-500">Visible en la aplicación.</p>
                        </div>
                        <input type="checkbox" wire:model.blur="form.active" class="h-5 w-5 rounded border-slate-300 text-violet-600 focus:ring-violet-500">
                    </label>
                </div>
            </div>

            {{-- Columna derecha (50%): Resumen --}}
            <div class="flex flex-col justify-between rounded-2xl border border-violet-100 bg-violet-50 p-6">
                <div>
                    <h3 class="font-semibold text-violet-900">Resumen</h3>
                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nombre</span>
                            <span class="font-medium text-slate-900">{{ $this->form->title ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Descripcion</span>
                            <span class="font-medium text-slate-900">{{ $this->form->description ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Precio</span>
                            <span class="font-medium text-slate-900">${{ $this->form->price ?: '0' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Estado</span>
                            <span class="font-medium">
                                @if($this->form->active)
                                    <span class="text-green-600">Activo</span>
                                @else
                                    <span class="text-slate-600">Inactivo</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer / Acciones alineadas a la derecha --}}
        <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-6 py-4">
            <a href="{{ route('admin.products') }}"
            wire:navigate
            class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 font-medium text-slate-700 transition hover:bg-slate-50">
                Cancelar
            </a>

            <button type="button"
                    wire:click="confirmSave"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-2xl bg-violet-700 px-8 py-3 font-medium text-white transition hover:bg-violet-800 disabled:opacity-70">
                {{ $isEditing ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </div>
</div>
