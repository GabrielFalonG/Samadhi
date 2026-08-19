<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <!-- Eliminamos 'dark:bg-gray-900' y dejamos un fondo gris muy claro ('bg-gray-100') -->
        <div class="min-h-screen bg-gray-100">

            {{-- <livewire:layout.navigation /> --}}

            <livewire:layout.header />


            <!-- Page Content -->
            <main>
                {{-- <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"> --}}
                    {{ $slot }}
                {{-- </div> --}}
            </main>

            <livewire:components.cart-drawer />

            <livewire:components.footer />

        </div>
    </body>

</html>
