@php
$configs = [
    'success' => [
        'bg' => 'bg-green-50 border-green-200 dark:bg-green-950/40 dark:border-green-900',
        'title' => 'Éxito',
        'text' => 'text-green-800 dark:text-green-300',
        'sub' => 'text-green-700 dark:text-green-400',
    ],
    'error' => [
        'bg' => 'bg-red-50 border-red-200 dark:bg-red-950/40 dark:border-red-900',
        'title' => 'Error',
        'text' => 'text-red-800 dark:text-red-300',
        'sub' => 'text-red-700 dark:text-red-400',
    ],
    'info' => [
        'bg' => 'bg-blue-50 border-blue-200 dark:bg-blue-950/40 dark:border-blue-900',
        'title' => 'Información',
        'text' => 'text-blue-800 dark:text-blue-300',
        'sub' => 'text-blue-700 dark:text-blue-400',
    ],
    'warning' => [
        'bg' => 'bg-amber-50 border-amber-200 dark:bg-amber-950/40 dark:border-amber-900',
        'title' => 'Advertencia',
        'text' => 'text-amber-800 dark:text-amber-300',
        'sub' => 'text-amber-700 dark:text-amber-400',
    ]
];

// Relectura de mensajes iniciales desde la sesión
$initialToasts = [];
foreach (['success', 'error', 'info', 'warning'] as $type) {
    if (session()->has($type)) {
        $data = session($type);
        if (is_array($data) && isset($data['message'])) {
            $initialToasts[] = ['id' => uniqid(), 'type' => $type, 'title' => $data['title'], 'message' => $data['message']];
        } else {
            $initialToasts[] = ['id' => uniqid(), 'type' => $type, 'title' => null, 'message' => (string)$data];
        }
    }
}
@endphp

<div x-data="{
        toasts: {{ Js::from($initialToasts) }},
        configs: {{ Js::from($configs) }},
        addToast(type, message, title = null) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, type, message, title });
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
     }"
     @toast.window="addToast($event.detail.type || 'info', $event.detail.message, $event.detail.title)"
     class="fixed top-5 right-5 z-[100] flex flex-col gap-4 w-full max-w-md pointer-events-none">

    <template x-for="toast in toasts" :key="toast.id">
        <div x-data="{ show: true }"
             x-init="setTimeout(() => { show = false; setTimeout(() => removeToast(toast.id), 300); }, 5000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-[-10px] md:translate-x-[10px]"
             x-transition:enter-end="opacity-100 transform translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             :class="'w-full p-5 rounded-xl border shadow-lg flex items-start justify-between pointer-events-auto ' + (configs[toast.type] ? configs[toast.type].bg : configs.info.bg)">

            <div class="flex flex-col pr-6">
                <h3 class="text-base font-semibold leading-6 tracking-wide mb-1"
                    :class="configs[toast.type] ? configs[toast.type].text : configs.info.text"
                    x-text="toast.title || (configs[toast.type] ? configs[toast.type].title : configs.info.title)">
                </h3>
                <p class="text-sm font-normal leading-relaxed"
                   :class="configs[toast.type] ? configs[toast.type].sub : configs.info.sub"
                   x-text="toast.message">
                </p>
            </div>

            <button @click="show = false; setTimeout(() => removeToast(toast.id), 300);"
                    type="button"
                    class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 p-1 rounded-lg transition-colors focus:outline-none flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </template>
</div>
