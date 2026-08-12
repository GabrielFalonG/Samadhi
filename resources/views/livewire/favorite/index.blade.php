<button type="button"
        wire:click="toggleFavorite"
        wire:loading.attr="disabled"
        aria-label="{{ $isFavorite ? 'Quitar de favoritos' : 'Agregar a favoritos' }}"
        class="absolute top-3 right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 shadow-sm backdrop-blur-sm transition hover:bg-white {{ $isFavorite ? 'text-red-500' : 'text-stone-700 hover:text-red-500' }}">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-5 w-5 transition-transform active:scale-125"
         fill="{{ $isFavorite ? 'currentColor' : 'none' }}"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
</button>
