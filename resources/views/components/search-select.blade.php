@props([
    'options' => collect([]),
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'optionDescription' => null,
    'optionImage' => null,
    'searchable' => false,
    'placeholder' => 'Buscar...'
])

@php
    // Normalizamos la estructura en PHP puro antes de tocar cualquier línea de JavaScript
    $normalizedOptions = collect($options)->map(function ($option) use ($optionValue, $optionLabel, $optionDescription, $optionImage) {
        return [
            'value'       => (string) data_get($option, $optionValue),
            'label'       => (string) data_get($option, $optionLabel),
            'description' => $optionDescription ? (string) data_get($option, $optionDescription) : null,
            'image'       => $optionImage ? (string) data_get($option, $optionImage) : null,
        ];
    })->values()->toArray();
@endphp

<div class="w-full"
     wire:key="search-select-v3-{{ $attributes->wire('model')->value() }}"
     x-data="{
         open: false,
         search: '',
         value: @entangle($attributes->wire('model')),
         options: {{ json_encode($normalizedOptions) }},

         get selectedOption() {
             return this.options.find(opt => opt.value == this.value) || null;
         },
         select(val) {
             this.value = val;
             this.open = false;
             this.search = '';

             setTimeout(() => {
                 this.value = null;
             }, 50);
         }
     }"
     @click.outside="open = false"
     class="relative">

    <label class="block text-sm font-medium text-gray-900 mb-1.5">{{ $attributes->get('label', 'Agregar producto') }}</label>

    <div class="relative mt-1">
        <!-- Botón del Selector Principal -->
        <button type="button"
                @click="open = !open"
                class="relative w-full cursor-default rounded-md bg-white py-2.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">

            <div class="flex items-center">
                <!-- Icono SVG fijo por defecto -->
                <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 flex-shrink-0 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>

                <!-- Textos del Botón Principal -->
                <div class="flex flex-col ml-3">
                    <span x-text="selectedOption ? selectedOption.label : '{{ $placeholder }}'"
                          class="block truncate font-normal text-gray-900"
                          :class="!selectedOption ? 'text-gray-400' : ''"></span>
                </div>
            </div>

            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm0 14a.75.75 0 01-.55-.24l-3.25-3.5a.75.75 0 111.1-1.02l2.65 2.848 2.65-2.848a.75.75 0 111.1 1.02l-3.25 3.5A.75.75 0 0110 17z" clip-rule="evenodd" />
                </svg>
            </span>
        </button>

        <!-- Contenedor Desplegable -->
        <div x-show="open"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute z-50 mt-1 max-h-64 w-full overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm flex flex-col"
             style="display: none;">

            <!-- Buscador Condicional -->
            @if($searchable)
                <div class="p-2 sticky top-0 bg-white border-b border-gray-100 z-10">
                    <div class="relative">
                        <input type="text"
                               x-model="search"
                               placeholder="Search options..."
                               class="w-full rounded-md border-0 py-1.5 pl-8 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                               @click.stop="">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-51.67-5.167M11.75 19.25a7.5 7.5 0 1 0 0-15 7.5 7.5 0 0 0 0 15Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lista de Opciones Estructurada en Blade con Filtrado Nativo de Alpine -->
            <ul class="overflow-y-auto max-h-48 py-1" role="listbox">
                @foreach($normalizedOptions as $option)
                    {{-- CORRECCIÓN: Comparamos el término de búsqueda directamente contra el texto plano generado por Blade --}}
                    <li wire:key="option-{{ $option['value'] }}-{{ $loop->index }}"
                        @click="value != '{{ $option['value'] }}' && select('{{ $option['value'] }}')"
                        x-show="!search || '{{ strtolower($option['label']) }}'.includes(search.toLowerCase()) || '{{ strtolower($option['description'] ?? '') }}'.includes(search.toLowerCase())"
                        class="relative select-none py-2.5 pl-3 pr-9 transition-all duration-150 flex items-center justify-between"
                        :class="{
                            'text-gray-900 hover:bg-gray-50 cursor-pointer': value != '{{ $option['value'] }}',
                            'opacity-40 bg-gray-50 cursor-not-allowed pointer-events-none': value == '{{ $option['value'] }}'
                        }"
                        role="option">

                        <div class="flex items-center">
                            @if($option['image'])
                                <img src="{{ $option['image'] }}" alt="" class="h-6 w-6 flex-shrink-0 rounded-full object-cover mr-3">
                            @endif

                            <div class="flex flex-col text-left">
                                <span class="text-sm font-normal">{{ $option['label'] }}</span>
                                @if($option['description'])
                                    <span class="text-xs text-gray-500 mt-0.5">{{ $option['description'] }}</span>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
