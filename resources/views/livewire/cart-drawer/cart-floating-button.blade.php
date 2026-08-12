<div>

    @if($count > 0)

        <button type="button"
                wire:click="openCart"
                class="flex items-center gap-2 hover:text-[#A98B68] transition focus:outline-none">
            <div class="relative">
                <svg class="h-5 w-5 text-stone-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-[#A98B68] text-[10px] font-bold text-white">
                    {{ $count }}
                </span>
            </div>
            <span class="hidden sm:inline">{{ __('Carrito') }}</span>
        </button>

    @endif

</div>
