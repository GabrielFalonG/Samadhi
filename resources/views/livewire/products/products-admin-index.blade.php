<div class="min-h-screen bg-slate-100">

    <div class="p-5 lg:p-10">

        {{-- Header --}}
        <div
            class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div>

                <h1 class="text-4xl font-bold text-slate-900">

                    Productos

                </h1>

                <p class="mt-2 text-slate-500">

                    Administración de productos disponibles en la aplicación.

                </p>

            </div>

            <a
                href="{{ route('admin.products.create') }}"
                wire:navigate
                class="inline-flex w-full items-center justify-center rounded-2xl bg-violet-700 px-6 py-3 font-medium text-white transition hover:bg-violet-800 lg:w-auto">

                Nuevo producto

            </a>

        </div>

        {{-- Resumen --}}
        <div class="mb-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">

            {{-- Total --}}
            <div
                class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">

                    Total productos

                </p>

                <h2 class="mt-2 text-3xl font-bold text-slate-900">

                    {{ $this->products->total() }}

                </h2>

            </div>

            {{-- Activos --}}
            <div
                class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">

                    Activos

                </p>

                <h2 class="mt-2 text-3xl font-bold text-green-600">

                    {{ $this->products->where('active', true)->count() }}

                </h2>

            </div>

            {{-- Inactivos --}}
            <div
                class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">

                    Inactivos

                </p>

                <h2 class="mt-2 text-3xl font-bold text-slate-600">

                    {{ $this->products->where('active', false)->count() }}

                </h2>

            </div>

            {{-- Precio promedio --}}
            <div
                class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">

                    Precio promedio

                </p>

                <h2 class="mt-2 text-3xl font-bold text-violet-700">

                    $
                    {{ number_format($this->products->avg('price'),0,',','.') }}

                </h2>

            </div>

        </div>

        {{-- Toolbar --}}
        <div
            class="mb-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <div
                class="flex flex-col gap-4 xl:flex-row xl:items-end">

                {{-- Buscar --}}
                <div class="flex-1">

                    <label
                        class="mb-2 block text-sm font-medium text-slate-600">

                        Buscar

                    </label>

                    <div class="relative">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
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
                            placeholder="Buscar por nombre..."
                            class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-12 pr-4 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">

                    </div>

                </div>

                {{-- Estado --}}
                <div class="w-full sm:w-60">

                    <label
                        class="mb-2 block text-sm font-medium text-slate-600">

                        Estado

                    </label>

                    <select
                        wire:model.live="status"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-100">

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

        {{-- Tabla --}}
        <div
            class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            {{-- Cabecera --}}
            <div
                class="border-b border-slate-200 px-6 py-5">

                <div>

                    <h2 class="text-xl font-semibold text-slate-900">

                        Productos registrados

                    </h2>

                    <p class="mt-1 text-sm text-slate-500">

                        Listado de todos los productos disponibles.

                    </p>

                </div>

            </div>

                        {{-- Desktop --}}
            <div class="hidden overflow-x-auto lg:block">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Imagen

                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Producto

                            </th>

                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Precio

                            </th>

                            <th
                                class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Estado

                            </th>

                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">

                                Acciones

                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($this->products as $product)

                            <tr
                                wire:key="product-{{ $product->id }}"
                                class="transition hover:bg-slate-50">

                                {{-- Imagen --}}
                                <td class="px-6 py-5">

                                    @if($product->image_url)

                                        <img
                                            src="{{ $product->image_url }}"
                                            alt="{{ $product->title }}"
                                            class="h-16 w-16 rounded-2xl border border-slate-200 object-contain">

                                    @else

                                        <div
                                            class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100">

                                            <x-heroicon-o-photo
                                                class="h-7 w-7 text-slate-400"/>

                                        </div>

                                    @endif

                                </td>

                                {{-- Producto --}}
                                <td class="px-6 py-5">

                                    <div>

                                        <p
                                            class="font-semibold text-slate-900">

                                            {{ $product->title }}

                                        </p>

                                        @if($product->description)

                                            <p
                                                class="mt-1 max-w-md text-sm text-slate-500">

                                                {{ Str::limit($product->description, 90) }}

                                            </p>

                                        @endif

                                    </div>

                                </td>

                                {{-- Precio --}}
                                <td
                                    class="px-6 py-5 text-right">

                                    <span
                                        class="whitespace-nowrap text-lg font-semibold text-slate-900">

                                        $

                                        {{ number_format($product->price,0,',','.') }}

                                    </span>

                                </td>

                                {{-- Estado --}}
                                <td
                                    class="px-6 py-5 text-center">

                                    @if($product->active)

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

                                {{-- Acciones --}}
                                <td class="px-6 py-5">

                                    <div
                                        class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.products.edit',$product->id) }}"
                                            wire:navigate
                                            class="inline-flex rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">

                                            Editar

                                        </a>

                                        <button
                                            wire:click="confirmDelete({{ $product->id }})"
                                            class="rounded-xl border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">

                                            Eliminar

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5">

                                    <div class="py-20 text-center">

                                        <div
                                            class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">

                                            <x-heroicon-o-cube
                                                class="h-8 w-8 text-slate-400"/>

                                        </div>

                                        <h3
                                            class="text-lg font-semibold text-slate-900">

                                            No hay productos

                                        </h3>

                                        <p
                                            class="mt-2 text-slate-500">

                                            Creá tu primer producto para comenzar.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

                    {{-- Mobile --}}
        <div class="divide-y divide-slate-200 lg:hidden">

            @forelse($this->products as $product)

                <div
                    wire:key="product-mobile-{{ $product->id }}"
                    class="p-5">

                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

                        {{-- Header --}}
                        <div class="flex items-start gap-4">

                            @if($product->image_url)

                                <img
                                    src="{{ $product->image_url }}"
                                    alt="{{ $product->title }}"
                                    class="h-20 w-20 rounded-2xl border border-slate-200 object-cover">

                            @else

                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100">

                                    <x-heroicon-o-photo
                                        class="h-8 w-8 text-slate-400"/>

                                </div>

                            @endif

                            <div class="flex-1">

                                <div
                                    class="flex items-start justify-between gap-3">

                                    <h3
                                        class="font-semibold text-slate-900">

                                        {{ $product->title }}

                                    </h3>

                                    @if($product->active)

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

                                @if($product->description)

                                    <p
                                        class="mt-2 text-sm text-slate-500">

                                        {{ Str::limit($product->description, 120) }}

                                    </p>

                                @endif

                            </div>

                        </div>

                        {{-- Información --}}
                        <div
                            class="mt-6 grid grid-cols-2 gap-4">

                            <div>

                                <p
                                    class="text-sm text-slate-400">

                                    Precio

                                </p>

                                <p
                                    class="mt-1 text-lg font-semibold text-slate-900">

                                    $

                                    {{ number_format($product->price,0,',','.') }}

                                </p>

                            </div>

                            <div>

                                <p
                                    class="text-sm text-slate-400">

                                    Estado

                                </p>

                                <p
                                    class="mt-1 font-medium text-slate-900">

                                    {{ $product->active ? 'Activo' : 'Inactivo' }}

                                </p>

                            </div>

                        </div>

                        {{-- Acciones --}}
                        <div
                            class="mt-6 flex gap-3">

                            <a
                                href="{{-- route('admin.products.edit', $product->id) --}}"
                                wire:navigate
                                class="flex-1 rounded-2xl border border-slate-300 bg-white py-3 text-center font-medium text-slate-700 transition hover:bg-slate-50">

                                Editar

                            </a>

                            <button
                                wire:click="confirmDelete({{ $product->id }})"
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

                        <x-heroicon-o-cube
                            class="h-8 w-8 text-slate-400"/>

                    </div>

                    <h3
                        class="text-lg font-semibold text-slate-900">

                        No hay productos

                    </h3>

                    <p
                        class="mt-2 text-slate-500">

                        Creá tu primer producto para comenzar.

                    </p>

                </div>

            @endforelse

        </div>

                {{-- Paginación --}}
        @if($products->hasPages())

            <div
                class="border-t border-slate-200 bg-white px-6 py-5">

                {{ $products->links() }}

            </div>

        @endif

    </div>

    {{-- Modal eliminar --}}
    @if($showDeleteModal)

        @include('livewire.products.product-confirm-delete')

    @endif

</div>
