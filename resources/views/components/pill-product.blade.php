@props([
    'title',
    'image',
    'productId',
])

<div
    class="inline-flex items-center gap-3 rounded-full border border-violet-200 bg-white px-3 py-2 shadow-sm transition hover:border-violet-400">

    <img
        src="{{ $image }}"
        class="h-7 w-7 rounded-full object-cover">

    <span
        class="text-sm font-medium text-slate-700">

        {{ $title }}

    </span>

    <button
        type="button"
        {{ $attributes }}
        class="rounded-full p-1 text-slate-400 transition hover:bg-red-50 hover:text-red-500">

        <x-heroicon-o-x-mark class="h-4 w-4"/>

    </button>

</div>
