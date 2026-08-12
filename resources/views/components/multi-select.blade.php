@props([
    'options' => [],
    'wireModel',
    'label' => null,
    'placeholder' => 'Buscar...',
    'valueKey' => 'id',
    'labelKey' => 'name',
    'fixedValues' => [],
    'allowCreate' => false,
])

@php
    $optionsData = collect($options)
        ->map(function ($option) use ($valueKey, $labelKey) {
            if (is_array($option)) {
                return [
                    'id' => $option[$valueKey],
                    'label' => $option[$labelKey],
                ];
            }

            return [
                'id' => $option->{$valueKey},
                'label' => $option->{$labelKey},
            ];
        })
        ->values();
@endphp

<div
    x-data="{
        open: false,
        search: '',

        selected: $wire.entangle('{{ $wireModel }}').live,

        options: @js($optionsData),

        fixedValues: @js($fixedValues),

        allowCreate: @js($allowCreate),

        init() {
            // Nos aseguramos de que los valores fijos estén seleccionados.
            this.fixedValues.forEach(id => {
                if (!this.isSelected(id)) {
                    this.selected.push(id);
                }
            });
        },

        get filteredOptions() {
            const search = this.search.toLowerCase().trim();

            if (!search) {
                return this.options;
            }

            return this.options.filter(option =>
                String(option.label)
                    .toLowerCase()
                    .includes(search)
            );
        },

        isSelected(id) {
            return this.selected.some(
                value => String(value) === String(id)
            );
        },

        isFixed(id) {
            return this.fixedValues.some(
                value => String(value) === String(id)
            );
        },

        toggle(id) {
            if (this.isFixed(id)) {
                return;
            }

            if (this.isSelected(id)) {
                this.selected = this.selected.filter(
                    value => String(value) !== String(id)
                );
            } else {
                this.selected.push(id);
            }
        },

        remove(id) {
            if (this.isFixed(id)) {
                return;
            }

            this.selected = this.selected.filter(
                value => String(value) !== String(id)
            );
        },

        getLabel(id) {
            const option = this.options.find(
                option => String(option.id) === String(id)
            );

            // Si existe en las opciones, usamos su label.
            if (option) {
                return option.label;
            }

            // Si es un valor creado manualmente,
            // el propio ID funciona como label.
            return String(id);
        },

        addCustomOption() {
            const value = this.search.trim();

            if (!value) {
                return;
            }

            // Si ya está seleccionado, no hacemos nada.
            if (this.isSelected(value)) {
                this.search = '';
                this.open = false;
                return;
            }

            // Si ya existe una opción con ese nombre,
            // seleccionamos la existente en lugar de crear otra.
            const existingOption = this.options.find(
                option =>
                    String(option.label)
                        .trim()
                        .toLowerCase() === value.toLowerCase()
            );

            if (existingOption) {
                if (!this.isSelected(existingOption.id)) {
                    this.selected.push(existingOption.id);
                }
            } else {
                // Nuevo valor creado manualmente.
                this.selected.push(value);
            }

            this.search = '';
            this.open = false;
        }
    }"

    @click.outside="open = false"

    class="relative w-full"
>

    {{-- Label --}}
    @if ($label)
        <label class="mb-2 block text-sm font-medium text-slate-700">
            {{ $label }}
        </label>
    @endif


    {{-- Selector --}}
    <div
        @click="open = true"

        class="min-h-[50px] w-full cursor-text rounded-2xl border border-slate-300 bg-white px-4 py-2.5 outline-none transition"

        :class="open
            ? 'border-violet-500 ring-4 ring-violet-100'
            : ''"
    >

        <div class="flex flex-wrap items-center gap-2">

            {{-- Pills seleccionados --}}
            <template
                x-for="id in selected"
                :key="String(id)"
            >

                <span
                    class="inline-flex items-center gap-1.5 rounded-lg bg-violet-50 px-2.5 py-1 text-sm font-medium text-violet-700"
                >

                    {{-- Nombre --}}
                    <span x-text="getLabel(id)"></span>


                    {{-- Botón eliminar --}}
                    <template x-if="!isFixed(id)">

                        <button
                            type="button"

                            @click.stop="remove(id)"

                            class="rounded-full p-0.5 text-violet-400 transition hover:bg-violet-100 hover:text-violet-700"
                        >

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>

                        </button>

                    </template>

                </span>

            </template>

            {{-- Input de búsqueda --}}
            <input
                type="text"

                x-model="search"

                @focus="open = true"

                @keydown.escape="open = false"

                @keydown.enter.prevent="addCustomOption()"

                placeholder="{{ $placeholder }}"
                
                class="min-w-[120px] flex-1 border-0 bg-transparent px-0 py-1 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0"
            >

            {{-- Flecha --}}
            <button
                type="button"

                @click.stop="open = !open"

                class="text-slate-400 transition hover:text-slate-600"
            >

                <svg
                    class="h-5 w-5 transition-transform"

                    :class="{ 'rotate-180': open }"

                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>

            </button>

        </div>

    </div>


    {{-- Dropdown --}}
    <div
        x-show="open"

        x-transition

        style="display: none;"

        class="absolute z-50 mt-2 max-h-64 w-full overflow-y-auto rounded-2xl border border-slate-200 bg-white py-2 shadow-lg"
    >

        {{-- Crear nuevo valor --}}
        <template x-if="allowCreate && search.trim() !== '' && filteredOptions.length === 0">

            <button
                type="button"

                @click="addCustomOption()"

                class="flex w-full items-center gap-3 px-4 py-3 text-left text-slate-700 transition hover:bg-violet-50 hover:text-violet-600"
            >

                <span
                    class="flex h-7 w-7 items-center justify-center rounded-full bg-violet-100 text-violet-600"
                >
                    +
                </span>

                <span>
                    Agregar
                    <strong x-text="`&quot;${search.trim()}&quot;`"></strong>
                </span>

            </button>

        </template>


        {{-- Sin resultados --}}
        <template x-if="filteredOptions.length === 0 && (!allowCreate || search.trim() === '')">

            <div class="px-4 py-4 text-slate-400">
                No se encontraron resultados.
            </div>

        </template>


        {{-- Opciones --}}
        <template
            x-for="option in filteredOptions"
            :key="String(option.id)"
        >

            <button
                type="button"

                @click="toggle(option.id)"

                class="flex w-full items-center justify-between px-4 py-2.5 text-left text-sm transition"

                :class="[
                    isSelected(option.id)
                        ? 'bg-violet-50 font-medium text-violet-700'
                        : 'text-slate-600 hover:bg-violet-50',

                    isFixed(option.id)
                        ? 'cursor-default'
                        : 'cursor-pointer'
                ]"
            >

                {{-- Nombre --}}
                <span x-text="option.label"></span>


                <div class="flex items-center gap-2">

                    {{-- Indicador de valor fijo --}}
                    <span
                        x-show="isFixed(option.id)"

                        class="text-xs font-normal text-slate-400"
                    >
                        Obligatoria
                    </span>


                    {{-- Check --}}
                    <svg
                        x-show="isSelected(option.id)"

                        class="h-5 w-5 text-violet-600"

                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

            </button>

        </template>

    </div>


    {{-- Error de validación --}}
    @error($wireModel)

        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>

    @enderror

</div>
