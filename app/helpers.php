<?php

if (! function_exists('flashMessage')) {
    function flashMessage(string $level, string $message, ?string $title = null): void
    {
        // 1. Guardamos en la sesión tradicional (para redirects)
        session()->flash($level, [
            'title' => $title,
            'message' => $message,
        ]);

        // 2. Si es una petición de Livewire, disparamos el evento al navegador
        if (request()->hasHeader('X-Livewire') && class_exists(\Livewire\Livewire::class)) {
            // Obtenemos el componente Livewire actual en ejecución
            $currentComponent = \Livewire\Livewire::current();

            if ($currentComponent) {
                // Despachamos el evento directamente desde la instancia del componente activo
                $currentComponent->dispatch('toast',
                    type: $level,
                    message: $message,
                    title: $title
                );
            }
        }
    }
}

if (! function_exists('flashMessageSuccess')) {
    function flashMessageSuccess(string $message, ?string $title = null): void
    {
        flashMessage('success', $message, $title);
    }
}

if (! function_exists('flashMessageError')) {
    function flashMessageError(string $message, ?string $title = null): void
    {
        flashMessage('error', $message, $title);
    }
}

if (! function_exists('flashMessageInfo')) {
    function flashMessageInfo(string $message, ?string $title = null): void
    {
        flashMessage('info', $message, $title);
    }
}

if (! function_exists('flashMessageWarning')) {
    function flashMessageWarning(string $message, ?string $title = null): void
    {
        flashMessage('warning', $message, $title);
    }
}
