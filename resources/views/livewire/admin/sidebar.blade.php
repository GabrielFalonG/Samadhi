{{-- Sidebar Desktop --}}
<aside
    class="hidden lg:flex lg:w-72 bg-gradient-to-b from-violet-900 to-violet-950 text-white flex-col">

    {{-- Logo --}}
    <div class="px-8 py-10">

        <h1 class="text-3xl font-bold tracking-wide">
            Samadhi
        </h1>

        <p class="text-violet-300 text-sm mt-1">
            Administración
        </p>

    </div>

    {{-- Navegación --}}
    <nav class="flex-1 px-5 space-y-2">

        <a
            href="#"
            @class([
                'flex items-center gap-3 rounded-xl px-4 py-3',
                'bg-violet-700 font-medium' => request()->routeIs('admin.dashboard'),
                'transition hover:bg-violet-800' => !request()->routeIs('admin.dashboard'),
            ])>

            <x-heroicon-o-home class="size-5"/>

            Dashboard

        </a>

        <a
            href="{{ route('admin.orders') }}"
            @class([
                'flex items-center gap-3 rounded-xl px-4 py-3',
                'bg-violet-700 font-medium' => request()->routeIs('admin.orders'),
                'transition hover:bg-violet-800' => !request()->routeIs('admin.orders'),
            ])>

            <x-heroicon-o-shopping-bag class="size-5"/>

            Pedidos

        </a>

        <a
            href="{{ route('admin.carousels') }}"
            @class([
                'flex items-center gap-3 rounded-xl px-4 py-3',
                'bg-violet-700 font-medium' => request()->routeIs('admin.carousels'),
                'transition hover:bg-violet-800' => !request()->routeIs('admin.carousels'),
            ])>

            <x-heroicon-o-rectangle-stack class="size-5" />

            Carrouseles

        </a>

        <a
            href="{{ route('admin.products') }}"
            @class([
                'flex items-center gap-3 rounded-xl px-4 py-3',
                'bg-violet-700 font-medium' => request()->routeIs('admin.products'),
                'transition hover:bg-violet-800' => !request()->routeIs('admin.products'),
            ])>

            <x-heroicon-o-archive-box class="size-5" />

            Productos

        </a>

        <a
            href="#"
            @class([
                'flex items-center gap-3 rounded-xl px-4 py-3',
                'bg-violet-700 font-medium' => request()->routeIs('admin.dashboard'),
                'transition hover:bg-violet-800' => !request()->routeIs('admin.dashboard'),
            ])>

            <x-heroicon-o-chart-bar class="size-5"/>

            Reportes

        </a>

        <a
            href="#"
            @class([
                'flex items-center gap-3 rounded-xl px-4 py-3',
                'bg-violet-700 font-medium' => request()->routeIs('admin.dashboard'),
                'transition hover:bg-violet-800' => !request()->routeIs('admin.dashboard'),
            ])>

            <x-heroicon-o-cog-6-tooth class="size-5"/>

            Configuración

        </a>

    </nav>

</aside>
