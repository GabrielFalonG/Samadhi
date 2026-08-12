<div class="min-h-screen bg-slate-100">

    <div class="p-5 lg:p-10">
        {{-- Header --}}
        <div
            class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-8">

            <div>

                <h1 class="text-4xl font-bold text-slate-900">

                    Carruseles

                </h1>

                <p class="mt-2 text-slate-500">

                    Administración de carruseles e ítems que se muestran en la aplicación.

                </p>

            </div>

            <a href="{{ route('admin.carousels.create') }}"
                wire:navigate
                class="w-full lg:w-auto inline-flex items-center justify-center rounded-2xl bg-violet-700 hover:bg-violet-800 px-6 py-3 text-white font-medium transition">
                    Nuevo carrusel
            </a>

        </div>

        {{-- Resumen --}}
        <div class="mb-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">

                    Total Carruseles

                </p>

                <h2 class="mt-2 text-3xl font-bold text-slate-900">

                    {{ $this->carousels->total() }}

                </h2>

            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">

                    Activos

                </p>

                <h2 class="mt-2 text-3xl font-bold text-green-600">

                    {{ $this->carousels->where('active', true)->count() }}

                </h2>

            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">

                    Inactivos

                </p>

                <h2 class="mt-2 text-3xl font-bold text-slate-600">

                    {{ $this->carousels->where('active', false)->count() }}

                </h2>

            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">

                    Productos disponibles

                </p>

                <h2 class="mt-2 text-3xl font-bold text-violet-700">

                    {{ $this->allProducts->count() }}

                </h2>

            </div>

        </div>

        {{-- Toolbar --}}
        <div
            class="rounded-3xl
                   border
                   border-slate-200
                   bg-white
                   p-6
                   shadow-sm
                   mb-8">

            <div
                class="flex flex-col xl:flex-row gap-4 xl:items-end">

                {{-- Buscar --}}
                <div class="flex-1">

                    <label
                        class="mb-2 block text-sm font-medium text-slate-600">

                        Buscar

                    </label>

                    <div class="relative">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m21 21-4.35-4.35m1.35-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>

                        </svg>

                        <input
                            type="text"
                            wire:model.live.debounce.500ms="search"
                            placeholder="Buscar por título..."
                            class="w-full rounded-2xl
                                   border
                                   border-slate-300
                                   bg-white
                                   py-3
                                   pl-12
                                   pr-4
                                   outline-none
                                   transition
                                   focus:border-violet-500
                                   focus:ring-4
                                   focus:ring-violet-100">

                    </div>

                </div>

                {{-- Sección --}}
                <div class="w-full sm:w-60">

                    <label
                        class="mb-2 block text-sm font-medium text-slate-600">

                        Sección

                    </label>

                    <select
                        wire:model.live="section"
                        class="w-full rounded-2xl
                               border
                               border-slate-300
                               px-4
                               py-3
                               outline-none
                               focus:border-violet-500
                               focus:ring-4
                               focus:ring-violet-100">

                        <option value="">Todas</option>

                        <option value="inicio">

                            Inicio

                        </option>

                        <option value="productos">

                            Productos

                        </option>

                        <option value="servicios">

                            Servicios

                        </option>

                    </select>

                </div>

                {{-- Estado --}}
                <div class="w-full sm:w-60">

                    <label
                        class="mb-2 block text-sm font-medium text-slate-600">

                        Estado

                    </label>

                    <select
                        wire:model.live="active"
                        class="w-full rounded-2xl
                               border
                               border-slate-300
                               px-4
                               py-3
                               outline-none
                               focus:border-violet-500
                               focus:ring-4
                               focus:ring-violet-100">

                        <option value="">

                            Todos

                        </option>

                        <option value="1">

                            Activos

                        </option>

                        <option value="0">

                            Inactivos

                        </option>

                    </select>

                </div>

            </div>

        </div>

        {{-- Tabla de Carruseles --}}
        <div
            class="rounded-3xl
                border
                border-slate-200
                bg-white
                shadow-sm
                overflow-hidden">

            {{-- Cabecera --}}
            <div
                class="border-b border-slate-200 px-6 py-5">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-xl font-semibold text-slate-900">

                            Carruseles registrados

                        </h2>

                        <p class="mt-1 text-sm text-slate-500">

                            Listado de todos los carruseles disponibles.

                        </p>

                    </div>

                </div>

            </div>

            {{-- Desktop --}}
            <div class="hidden lg:block overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Posición

                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Carrusel

                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Sección

                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Productos

                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Estado

                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Acciones

                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($this->carousels as $row)

                            <tr
                                wire:key="carousel-{{ $row->id }}"
                                class="hover:bg-slate-50 transition">

                                <td class="px-6 py-5">

                                    <span
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-violet-100 font-semibold text-violet-700">

                                        {{ $row->position }}

                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <div>

                                        <p class="font-semibold text-slate-900">

                                            {{ $row->title }}

                                        </p>

                                        @if($row->subtitle)

                                            <p class="mt-1 text-sm text-slate-500">

                                                {{ $row->subtitle }}

                                            </p>

                                        @endif

                                    </div>

                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700 capitalize">

                                        {{ $row->section }}

                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span
                                        class="text-lg font-semibold text-slate-800">

                                        {{ $row->products->count() }}

                                    </span>

                                    <span class="text-slate-400">

                                        /5

                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    @if($row->active)

                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">

                                            Activo

                                        </span>

                                    @else

                                        <span
                                            class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-600">

                                            Inactivo

                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.carousels.edit', $row->id) }}"
                                            class="inline-flex rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                                        >
                                            Editar
                                        </a>

                                        <button
                                            wire:click="confirmDelete({{ $row->id }})"
                                            class="rounded-xl border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">

                                            Eliminar

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6">

                                    <div class="py-20 text-center">

                                        <div
                                            class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">

                                            📦

                                        </div>

                                        <h3 class="text-lg font-semibold text-slate-900">

                                            No hay carruseles

                                        </h3>

                                        <p class="mt-2 text-slate-500">

                                            Creá tu primer carrusel utilizando el formulario superior.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Mobile --}}
        <div class="lg:hidden divide-y divide-slate-200">

            @forelse($this->carousels as $row)

                <div
                    wire:key="carousel-mobile-{{ $row->id }}"
                    class="p-5">

                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

                        {{-- Header --}}
                        <div class="flex items-start justify-between">

                            <div>

                                <div class="flex items-center gap-3">

                                    <span
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-violet-100 font-semibold text-violet-700">

                                        {{ $row->position }}

                                    </span>

                                    <div>

                                        <h3
                                            class="font-semibold text-slate-900">

                                            {{ $row->title }}

                                        </h3>

                                        @if($row->subtitle)

                                            <p
                                                class="text-sm text-slate-500">

                                                {{ $row->subtitle }}

                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>

                            @if($row->active)

                                <span
                                    class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">

                                    Activo

                                </span>

                            @else

                                <span
                                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">

                                    Inactivo

                                </span>

                            @endif

                        </div>

                        {{-- Información --}}
                        <div
                            class="mt-6 grid grid-cols-2 gap-4 text-sm">

                            <div>

                                <p class="text-slate-400">

                                    Sección

                                </p>

                                <p
                                    class="mt-1 font-medium capitalize text-slate-900">

                                    {{ $row->section }}

                                </p>

                            </div>

                            <div>

                                <p class="text-slate-400">

                                    Ítems

                                </p>

                                <p
                                    class="mt-1 font-medium text-slate-900">

                                    {{ $row->products->count() }}/5

                                </p>

                            </div>

                        </div>

                        {{-- Acciones --}}
                        <div
                            class="mt-6 flex gap-3">

                            <button
                                wire:click="edit({{ $row->id }})"
                                class="flex-1 rounded-2xl border border-slate-300 bg-white py-3 font-medium text-slate-700 transition hover:bg-slate-50">

                                Editar

                            </button>

                            <button
                                wire:click="remove({{ $row->id }})"
                                wire:confirm="¿Eliminar el carrusel y todos sus ítems?"
                                class="flex-1 rounded-2xl border border-red-200 bg-white py-3 font-medium text-red-600 transition hover:bg-red-50">

                                Eliminar

                            </button>

                        </div>

                    </div>

                </div>

            @empty

                <div class="p-10 text-center">

                    <div
                        class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">

                        📦

                    </div>

                    <h3
                        class="text-lg font-semibold text-slate-900">

                        No hay carruseles

                    </h3>

                    <p
                        class="mt-2 text-slate-500">

                        Creá tu primer carrusel para comenzar.

                    </p>

                </div>

            @endforelse

        </div>
    </div>

    @if($showDeleteModal)
        @include('livewire.carousel.carousel-confirm-delete')
    @endif

</div>
