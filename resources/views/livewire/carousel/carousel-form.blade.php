{{-- Aquí continúa el formulario --}}
<div class="mt-10 flex flex-col gap-4">
    <form wire:submit="confirmSaveData"
        class="rounded-3xl
            border
            border-slate-200
            bg-white
            p-8
            shadow-sm
            mb-8">

        {{-- Título --}}
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>

                <h2 class="text-2xl font-bold text-slate-900">

                    {{ $isEditing ? 'Editar carrusel' : 'Crear nuevo carrusel' }}

                </h2>

                <p class="mt-1 text-slate-500">

                    Configurá la información general del carrusel.

                </p>

            </div>

            <div>

                <span
                    class="inline-flex items-center rounded-full bg-violet-100 px-4 py-2 text-sm font-medium text-violet-700">

                    {{ count($this->form->products) }}/5 Productos

                </span>

            </div>

        </div>

        {{-- Campos --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Título --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-slate-600">

                    Título principal *

                </label>

                <input type="text" maxlength="120" wire:model.blur="form.title"
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.title')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                @error('form.title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- Subtítulo --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-slate-600">

                    Título pequeño

                </label>

                <input type="text" maxlength="120" wire:model.blur="form.subtitle"
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.subtitle')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                @error('form.subtitle')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- Descripción --}}
            <div class="lg:col-span-2">

                <label class="mb-2 block text-sm font-medium text-slate-600">

                    Descripción

                </label>

                <textarea rows="4" maxlength="300" wire:model.blur="form.description"
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.description')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}"></textarea>

                @error('form.description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- Sección --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-slate-600">

                    Sección

                </label>

                <select wire:model.blur="form.section"
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.section')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                    @foreach ($form->sections() as $section)
                        <option value="{{ $section['value'] }}">
                            {{ $section['label'] }}
                        </option>
                    @endforeach

                </select>

                @error('form.section')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- Posición --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-slate-600">

                    Posición

                </label>

                <input type="number" min="1" wire:model.blur="form.position"
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.position')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                @error('form.position')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- Productos --}}
            <div class="flex gap-3">
                <div class="flex-1">
                    <x-multi-select label="Agregar producto" wire-model="form.products"
                        :options="$this->form->getSelectableProducts($allProducts->toArray())"
                        placeholder="Buscar producto..." :fixed-values="null" :allow-create="false" image-key="image" />
                </div>
            </div>
        </div>

        {{-- Estado --}}
        <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-5">

            <label class="flex items-center gap-4 cursor-pointer">

                <div class="flex items-center gap-3">
                    <input type="checkbox" id="form_active" wire:model="form.active"
                        class="h-5 w-5 rounded border-slate-300 text-violet-600 transition focus:ring-2
                            {{ $errors->has('form.active') ? 'border-red-500 focus:ring-red-500' : 'focus:ring-violet-500' }}">
                    <label for="form_active" class="text-sm font-medium text-slate-700 select-none">
                        Carrusel activo
                    </label>
                </div>

                @error('form.active')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div>

                    <p class="font-semibold text-slate-900">

                        Carrusel activo

                    </p>

                    <p class="text-sm text-slate-500">

                        Si está activo será visible en la aplicación.

                    </p>

                </div>

            </label>

        </div>

        {{-- Botones --}}
        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.carousels') }}" wire:navigate
                class="rounded-2xl
                        border
                        border-slate-300
                        bg-white
                        px-6
                        py-3
                        font-medium
                        hover:bg-slate-50
                        transition">

                {{ 'Cancelar' }}

            </a>

            <button type="submit" wire:loading.attr="disabled" wire:target="confirmSaveData"
                class="inline-flex items-center justify-center rounded-2xl bg-violet-700 px-6 py-3 font-medium text-white transition hover:bg-violet-800 disabled:opacity-70">
                {{-- Estado normal --}}
                <span wire:loading.remove wire:target="confirmSaveData">
                    {{ $isEditing ? 'Actualizar carrusel' : 'Crear carrusel' }}
                </span>

                {{-- Estado procesando --}}
                <span wire:loading.flex wire:target="confirmSaveData" class="items-center justify-center">
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

    </form>
</div>
