@props([
    'title',
    'image' => null,
    'modelId',
])

<div class="flex items-center gap-2">

    @if ($image)
        <img
            src="{{ $image }}"
            alt="{{ $title }}"
            class="h-7 w-7 rounded-full object-cover">
    @endif

    <span class="text-sm font-medium text-slate-700">
        {{ $title }}
    </span>

    <button
        type="button"
        {{ $attributes }}
        class="rounded-full p-1 text-slate-400 transition hover:bg-red-50 hover:text-red-500">

        <x-heroicon-o-x-mark class="h-4 w-4"/>
    </button>

</div>
