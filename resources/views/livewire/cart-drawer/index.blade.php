<div>

    @if($open)

        {{-- Backdrop --}}
        <div
            wire:click="close"
            class="fixed inset-0 z-[60] bg-black/35 backdrop-blur-[2px]">

        </div>

        {{-- Drawer --}}
        <aside
            class="fixed right-0 top-0 z-[70] flex h-screen w-full max-w-[430px] flex-col bg-white shadow-2xl">

            {{-- Header --}}

            <div class="flex items-start justify-between border-b p-6">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-7 w-7 text-green-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"/>

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-2xl font-semibold">

                            Agregado al carrito

                        </h2>

                        <p class="text-stone-500">

                            {{ count($items) }} producto(s)

                        </p>

                    </div>

                </div>

                <button
                    wire:click="close"
                    class="text-3xl text-stone-400 hover:text-stone-700">

                    ×

                </button>

            </div>

            {{-- Productos --}}
            <div class="flex-1 overflow-y-auto">

                @foreach($items as $id => $item)
                    <article
                        class="flex gap-4 border-b p-5">

                        <div
                            class="flex h-24 w-24 shrink-0 items-center justify-center rounded-2xl bg-[#F2EFEA]">

                            <img
                                src="{{ asset($item['image_url']) }}"
                                class="max-h-20 object-contain">

                        </div>

                        <div class="flex flex-1 flex-col">

                            <h3
                                class="font-medium text-lg">

                                {{ $item['title'] }}

                            </h3>

                            <p
                                class="mt-1 text-sm text-stone-500">

                                {{ $item['description'] }}

                            </p>

                            <div
                                class="mt-4 flex items-center justify-between">

                                <span
                                    class="font-semibold text-lg">

                                    ${{ number_format($item['price']) }}

                                </span>

                                <div
                                    class="flex items-center gap-3">

                                    <button
                                        wire:click="decrease({{ $item['id'] }})"
                                        class="flex h-8 w-8 items-center justify-center rounded-full border">

                                        -

                                    </button>

                                    <span>

                                        {{ $item['quantity'] }}

                                    </span>

                                    <button
                                        wire:click="increase({{ $item['id'] }})"
                                        class="flex h-8 w-8 items-center justify-center rounded-full border">

                                        +

                                    </button>

                                </div>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

            {{-- Footer --}}

            <div
                class="border-t p-6">

                <div
                    class="mb-6 flex justify-between text-xl">

                    <span>

                        Total

                    </span>

                    <strong>

                        ${{ number_format($total) }}

                    </strong>

                </div>

                <button wire:click="checkout"
                    class="w-full rounded-2xl bg-[#A98B68] py-4 text-lg font-medium text-white transition hover:bg-[#8D7358]">

                    Ver carrito de compras

                </button>

                <button
                    wire:click="close"
                    class="mt-3 w-full rounded-2xl border border-stone-300 py-4">

                    Seguir comprando

                </button>

            </div>

        </aside>

    @endif

</div>
