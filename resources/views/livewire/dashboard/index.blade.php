<div class="min-h-screen bg-slate-100">

    <div class="p-5 lg:p-10">
        {{-- Header --}}
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-8">

            <div>

                <h1 class="text-4xl font-bold text-slate-900">

                    Dashboard

                </h1>

                <p class="mt-2 text-slate-500">

                    Bienvenido {{ \Illuminate\Support\Str::ucfirst(auth()->user()->name) }}

                </p>

            </div>

        </div>

        {{-- Resumen --}}

        {{-- ================================================= --}}
        {{-- MÉTRICAS --}}
        {{-- ================================================= --}}

        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Pedidos --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Pedidos
                </p>

                <div class="mt-4 flex items-end justify-between">

                    <span class="text-3xl font-semibold text-slate-900">
                        12
                    </span>

                    <span class="text-sm font-medium text-green-600">
                        +3 hoy
                    </span>

                </div>

            </div>


            {{-- Productos --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Productos
                </p>

                <div class="mt-4 flex items-end justify-between">

                    <span class="text-3xl font-semibold text-slate-900">
                        59
                    </span>

                    <span class="text-sm font-medium text-[#6B32D5]">
                        Activos
                    </span>

                </div>

            </div>


            {{-- Categorías --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Categorías
                </p>

                <div class="mt-4 flex items-end justify-between">

                    <span class="text-3xl font-semibold text-slate-900">
                        8
                    </span>

                    <span class="text-sm text-slate-400">
                        Activas
                    </span>

                </div>

            </div>


            {{-- Carruseles --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Carruseles
                </p>

                <div class="mt-4 flex items-end justify-between">

                    <span class="text-3xl font-semibold text-slate-900">
                        7
                    </span>

                    <span class="text-sm font-medium text-[#6B32D5]">
                        Activos
                    </span>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- CUERPO --}}
        {{-- ================================================= --}}

        <div class="mt-6 grid gap-6 xl:grid-cols-3">

            {{-- Actividad --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-lg font-semibold text-slate-900">
                        Actividad reciente
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Últimos pedidos realizados.
                    </p>

                </div>

                <div class="divide-y divide-slate-100">

                    @foreach ([['id' => '#1024', 'name' => 'Pedido recibido', 'amount' => '$15.000'], ['id' => '#1023', 'name' => 'Pedido recibido', 'amount' => '$8.500'], ['id' => '#1022', 'name' => 'Pedido recibido', 'amount' => '$12.000']] as $order)
                        <div class="flex items-center justify-between px-6 py-5">

                            <div>
                                <p class="text-sm font-medium text-slate-800">
                                    {{ $order['name'] }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $order['id'] }}
                                </p>
                            </div>

                            <span class="text-sm font-semibold text-slate-800">
                                {{ $order['amount'] }}
                            </span>

                        </div>
                    @endforeach

                </div>

            </section>


            {{-- Accesos rápidos --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-lg font-semibold text-slate-900">
                        Accesos rápidos
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Administrá tu tienda.
                    </p>

                </div>

                <div class="space-y-2 p-4">

                    <a href="{{ route('admin.carousels') }}" wire:navigate
                        class="flex items-center justify-between rounded-xl p-4 transition hover:bg-violet-50">
                        <div>
                            <p class="text-sm font-medium text-slate-800">
                                Carruseles
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Gestionar carruseles
                            </p>
                        </div>

                        <svg class="h-5 w-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>


                    <a href="#"
                        class="flex items-center justify-between rounded-xl p-4 transition hover:bg-violet-50">
                        <div>
                            <p class="text-sm font-medium text-slate-800">
                                Productos
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Gestionar productos
                            </p>
                        </div>

                        <svg class="h-5 w-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>


                    <a href="#"
                        class="flex items-center justify-between rounded-xl p-4 transition hover:bg-violet-50">
                        <div>
                            <p class="text-sm font-medium text-slate-800">
                                Pedidos
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Ver pedidos
                            </p>
                        </div>

                        <svg class="h-5 w-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                </div>

            </section>

        </div>
    </div>

</div>
