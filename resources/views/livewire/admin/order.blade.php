<div class="min-h-screen bg-slate-100">

    <div class="flex">

        {{-- Contenido --}}
        <main class="flex-1">

            {{-- Header Mobile --}}
            <header
                class="lg:hidden bg-white shadow-sm px-5 py-4 flex justify-between items-center">

                <h2 class="font-bold text-xl">

                    Pedidos

                </h2>

                <button>

                    <x-heroicon-o-bars-3 class="size-7"/>

                </button>

            </header>

            {{-- Contenido --}}
            <div class="p-5 lg:p-10">

                {{-- Header Desktop --}}
                <div
                    class="hidden lg:flex justify-between items-center mb-8">

                    <div>

                        <h1 class="text-4xl font-bold text-slate-900">

                            Pedidos

                        </h1>

                        <p class="text-slate-500 mt-1">

                            Gestión de pedidos realizados desde la web.

                        </p>

                    </div>

                    <button
                        class="rounded-xl bg-violet-700 hover:bg-violet-800 text-white px-6 py-3 font-medium transition">

                        Nuevo pedido

                    </button>

                </div>

                {{-- Aquí comenzaremos la pantalla --}}
                <div
                    class="rounded-3xl bg-white shadow-sm border border-slate-200 p-6">

                    {{-- Toolbar --}}
                    <div class="mb-8">

                        <div
                            class="flex flex-col xl:flex-row xl:items-end gap-4">

                            {{-- Buscador --}}
                            <div class="flex-1">

                                <label
                                    class="mb-2 block text-sm font-medium text-slate-600">

                                    Buscar pedido

                                </label>

                                <div class="relative">

                                    <x-heroicon-o-magnifying-glass
                                        class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-slate-400"/>

                                    <input
                                        type="text"
                                        wire:model.live.debounce.500ms="search"
                                        placeholder="Número, cliente, teléfono..."
                                        class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-12 pr-4
                                            transition
                                            focus:border-violet-500
                                            focus:ring-4
                                            focus:ring-violet-100
                                            outline-none">

                                </div>

                            </div>

                            {{-- Estado --}}
                            <div class="w-full sm:w-60">

                                <label
                                    class="mb-2 block text-sm font-medium text-slate-600">

                                    Estado

                                </label>

                                <select wire:model.live.debounce.500ms="status"
                                    class="w-full rounded-2xl border border-slate-300 py-3 px-4
                                        focus:border-violet-500
                                        focus:ring-4
                                        focus:ring-violet-100
                                        outline-none">

                                        <option value="">Todos</option>

                                    @foreach(App\Enums\OrderStatus::cases() as $status)
                                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                    @endforeach
                                </select>

                            </div>

                            {{-- Fecha --}}
                            <div class="w-full sm:w-60">

                                <label
                                    class="mb-2 block text-sm font-medium text-slate-600">

                                    Fecha

                                </label>

                                <input
                                    wire:model.live.debounce.500ms="date"
                                    type="date"
                                    class="w-full rounded-2xl border border-slate-300 py-3 px-4
                                        focus:border-violet-500
                                        focus:ring-4
                                        focus:ring-violet-100
                                        outline-none">

                            </div>

                            {{-- Botón --}}
                            <div class="w-full sm:w-auto">

                                <button wire:click="getOrders"
                                    class="w-full rounded-2xl bg-violet-700 hover:bg-violet-800
                                        px-8 py-3
                                        text-white
                                        font-medium
                                        transition">

                                    Filtrar

                                </button>

                            </div>

                        </div>

                    </div>

                    <div
                        class="mb-6 flex flex-col lg:flex-row justify-between gap-4">

                        <div>

                            <h2
                                class="text-xl font-semibold text-slate-800">

                                Listado de pedidos

                            </h2>

                            <p
                                class="text-slate-500 mt-1">

                                Se encontraron
                                <span class="font-semibold">
                                    152
                                </span>
                                pedidos.

                            </p>

                        </div>

                        <button
                            class="rounded-xl border border-slate-300 bg-white px-5 py-3
                                hover:bg-slate-50
                                transition">

                            Exportar

                        </button>

                    </div>

                    <div
                        class="hidden lg:block overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="overflow-x-auto">

                            <table class="min-w-full">

                                {{-- Header --}}
                                <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Pedido
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Cliente
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Fecha
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Total
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Estado
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Acciones
                                    </th>

                                </tr>

                                </thead>

                                {{-- Body --}}
                                <tbody class="divide-y divide-slate-100">

                                    @foreach($this->orders as $order)

                                        <tr
                                            class="transition hover:bg-slate-50">

                                            {{-- Pedido --}}
                                            <td class="px-6 py-5">

                                                <div class="font-semibold text-slate-900">

                                                    {{ $order['order_number'] }}

                                                </div>

                                                <div class="mt-1 text-sm text-slate-500">

                                                    {{ rand(1,5) }} productos

                                                </div>

                                            </td>

                                            {{-- Cliente --}}
                                            <td class="px-6 py-5">

                                                <div class="font-medium text-slate-800">

                                                    {{ $order['customer_name'] }}

                                                </div>

                                                <div class="mt-1 text-sm text-slate-500">

                                                    {{ $order['customer_phone'] }}

                                                </div>

                                            </td>

                                            {{-- Fecha --}}
                                            <td class="px-6 py-5">

                                                <div class="text-slate-800">

                                                    {{ $order['created_at_formatted'] }}

                                                </div>

                                                <div class="mt-1 text-sm text-slate-500">

                                                    {{ $order['created_time_formatted'] }}

                                                </div>

                                            </td>

                                            {{-- Total --}}
                                            <td class="px-6 py-5 text-right">

                                                <span class="text-lg font-bold text-slate-900">

                                                    {{ $order['total'] }}

                                                </span>

                                            </td>

                                            {{-- Estado --}}
                                            <td class="px-6 py-5 text-center">
                                                <span class="inline-flex rounded-full px-4 py-1 text-sm font-medium {{ $order->status->color() }}">
                                                    {{ $order->status->label() }}
                                                </span>
                                            </td>

                                            {{-- Acciones --}}
                                            <td class="px-6 py-5">

                                                <div
                                                    class="flex justify-end gap-2">

                                                    <button
                                                        type="button"
                                                        wire:click="viewPdf({{ $order['id'] }})"
                                                        class="rounded-xl border border-slate-200 p-2 hover:bg-slate-100 transition">
                                                        <x-heroicon-o-eye class="size-5" />
                                                    </button>

                                                    {{-- EDITAR --}}
                                                    <a
                                                        href="{{ route('admin.orders.edit', $order['id']) }}"
                                                        class="rounded-xl border border-slate-200 p-2 hover:bg-slate-100 transition">
                                                        <x-heroicon-o-pencil-square class="size-5"/>
                                                    </a>

                                                    <button
                                                        class="rounded-xl border border-slate-200 p-2 hover:bg-slate-100 transition">

                                                        <x-heroicon-o-ellipsis-horizontal class="size-5"/>

                                                    </button>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                    {{-- Mobile --}}
                    <div class="space-y-4 lg:hidden">

                        @foreach($this->orders as $order)

                            <div
                                class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

                                <div class="flex items-start justify-between">

                                    <div>

                                        <p class="font-bold text-slate-900">

                                            {{ $order['order_number'] }}

                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">

                                            {{ $order['created_at'] }}

                                        </p>

                                    </div>

                                    <button
                                        class="rounded-xl p-2 hover:bg-slate-100">

                                        <x-heroicon-o-ellipsis-horizontal
                                            class="size-5"/>

                                    </button>

                                </div>

                                <div class="mt-5 space-y-3">

                                    <div
                                        class="flex justify-between">

                                        <span class="text-slate-500">

                                            Cliente

                                        </span>

                                        <span class="font-medium">

                                            {{ $order['customer_name'] }}

                                        </span>

                                    </div>

                                    <div
                                        class="flex justify-between">

                                        <span class="text-slate-500">

                                            Productos

                                        </span>

                                        <span>

                                            3

                                        </span>

                                    </div>

                                    <div
                                        class="flex justify-between">

                                        <span class="text-slate-500">

                                            Total

                                        </span>

                                        <span class="font-bold text-lg">

                                            {{ $order['total'] }}

                                        </span>

                                    </div>

                                </div>

                                <div
                                    class="mt-5 flex items-center justify-between">

                                    <span
                                        class="rounded-full bg-yellow-100 px-4 py-1 text-sm font-medium text-yellow-700">

                                        Pendiente

                                    </span>

                                    <button
                                        class="rounded-xl bg-violet-700 px-4 py-2 text-sm text-white hover:bg-violet-800">

                                        Ver pedido

                                    </button>

                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- Paginador --}}
                    @if ($this->orders->hasPages() || $this->orders->total() > 0)
                        <div class="mt-8 flex flex-col items-center justify-between gap-4 md:flex-row">
                            <!-- Información del rango de resultados -->
                            <p class="text-sm text-slate-500">
                                Mostrando
                                <strong>{{ $this->orders->firstItem() ?? 0 }}</strong>
                                a
                                <strong>{{ $this->orders->lastItem() ?? 0 }}</strong>
                                de
                                <strong>{{ $this->orders->total() }}</strong>
                                pedidos
                            </p>

                            <!-- Botones de navegación -->
                            <div class="flex items-center gap-2">
                                {{-- Botón Anterior --}}
                                @if ($this->orders->onFirstPage())
                                    <button
                                        disabled
                                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-300 cursor-not-allowed">
                                        ←
                                    </button>
                                @else
                                    <button
                                        wire:click="previousPage"
                                        wire:loading.attr="disabled"
                                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 hover:bg-slate-100 transition">
                                        ←
                                    </button>
                                @endif

                                {{-- Números de Página --}}
                                @foreach ($this->orders->getUrlRange(1, $this->orders->lastPage()) as $page => $url)
                                    @if ($page == $this->orders->currentPage())
                                        <button
                                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-700 font-medium text-white shadow-sm">
                                            {{ $page }}
                                        </button>
                                    @else
                                        <button
                                            wire:click="gotoPage({{ $page }})"
                                            wire:loading.attr="disabled"
                                            class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach

                                {{-- Botón Siguiente --}}
                                @if ($this->orders->hasMorePages())
                                    <button
                                        wire:click="nextPage"
                                        wire:loading.attr="disabled"
                                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 hover:bg-slate-100 transition">
                                        →
                                    </button>
                                @else
                                    <button
                                        disabled
                                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-300 cursor-not-allowed">
                                        →
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Statistics --}}
                    <div
                        class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">

                        {{-- Hoy --}}
                        <div
                            class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">

                            <p class="text-slate-500 text-sm">

                                Pedidos hoy

                            </p>

                            <h3
                                class="mt-2 text-4xl font-bold text-slate-900">

                                12

                            </h3>

                            <p
                                class="mt-2 text-green-600 text-sm">

                                +18%

                            </p>

                        </div>

                        {{-- Pendientes --}}
                        <div
                            class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">

                            <p class="text-slate-500 text-sm">

                                Pendientes

                            </p>

                            <h3
                                class="mt-2 text-4xl font-bold text-yellow-600">

                                8

                            </h3>

                            <p
                                class="mt-2 text-slate-500 text-sm">

                                Esperando confirmación

                            </p>

                        </div>

                        {{-- En preparación --}}
                        <div
                            class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">

                            <p class="text-slate-500 text-sm">

                                Preparando

                            </p>

                            <h3
                                class="mt-2 text-4xl font-bold text-blue-600">

                                5

                            </h3>

                            <p
                                class="mt-2 text-slate-500 text-sm">

                                En producción

                            </p>

                        </div>

                        {{-- Facturación --}}
                        <div
                            class="rounded-3xl bg-gradient-to-br from-violet-700 to-violet-900 text-white p-6 shadow-lg">

                            <p class="text-violet-200 text-sm">

                                Facturación del mes

                            </p>

                            <h3
                                class="mt-2 text-4xl font-bold">

                                $1.245.000

                            </h3>

                            <p
                                class="mt-2 text-violet-100 text-sm">

                                +12% respecto al mes anterior

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

    <!-- Modal de Visualización de PDF -->
    @if($showPdfModal)
        @include('livewire.admin.order-pdf-modal')
    @endif

</div>
