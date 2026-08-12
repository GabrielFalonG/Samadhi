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
    <body class="bg-slate-100 min-h-screen antialiased">

        <livewire:layout.navigation />

        <div class="flex min-h-[calc(100vh-4rem)]">

            <livewire:components.sidebar-admin />

            <main class="flex-1 p-6 min-w-0">
                {{ $slot }}
            </main>

            <!-- Invocación de la Alerta Global Reutilizable -->
            <x-toast-notification />

        </div>

    </body>
</html>
