<section class="bg-[#F8F6F2] min-h-screen">
    <div class="mx-auto max-w-7xl px-5 py-10 lg:px-8 lg:py-14">
        {{-- Breadcrumb --}}
        <nav class="mb-4 text-sm text-stone-500">
            <a href="{{ route('products') }}" wire:navigate class="transition hover:text-stone-800">
                Productos
            </a>
            <span class="mx-2">/</span>
            <a href="{{ route('cart') }}" wire:navigate class="transition hover:text-stone-800">
                Carrito
            </a>
            <span class="mx-2">/</span>
            <span class="text-stone-700">Confirmación</span>
        </nav>

        {{-- Encabezado --}}
        <div class="max-w-3xl">
            <span class="text-[12px] uppercase tracking-[0.35em] text-[#A98B68]">
                ✦ Confirmación de compra
            </span>
            <h1 class="mt-3 font-serif text-4xl text-stone-900 lg:text-6xl">
                Confirmá tu pedido
            </h1>
            <p class="mt-5 max-w-2xl text-lg leading-8 text-stone-500">
                Solo necesitamos algunos datos para poder comunicarnos con vos,
                confirmar el stock disponible y coordinar la entrega de tu pedido.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 p-5 border border-red-200">
                <div class="flex items-center gap-2 text-red-800 font-medium mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.65 18h16.7a1 1 0 00.86-1.5l-7.5-13a1 1 0 00-1.72 0z"/>
                    </svg>
                    <span>Por favor corregí los siguientes errores:</span>
                </div>

                <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Contenido --}}
        <div wire:key="checkout-form-container">
            {{-- FORMULARIO --}}
            <form wire:submit.prevent="confirmOrder" class="mt-12 grid gap-10 lg:grid-cols-[1fr_380px]">
                <div class="rounded-[32px] bg-white shadow-[0_15px_45px_rgba(0,0,0,.05)] overflow-hidden">
                    <div class="border-b border-stone-100 px-6 py-6 lg:px-10">
                        <span class="text-[11px] uppercase tracking-[0.35em] text-[#A98B68]">
                            ✦ Tus datos
                        </span>
                        <h2 class="mt-3 font-serif text-3xl text-stone-900">
                            Datos de contacto
                        </h2>
                        <p class="mt-2 text-stone-500 leading-7">
                            Completá la información para que pueda comunicarme con vos y coordinar el pedido.
                        </p>
                    </div>

                    <div class="space-y-8 p-6 lg:p-10">
                        {{-- Nombre --}}
                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-stone-700">
                                Nombre completo
                            </label>
                            <input
                                id="name"
                                type="text"
                                wire:model.blur="form.customer_name"
                                placeholder="Ej. Mara Lezcano"
                                @class([
                                    'w-full rounded-2xl bg-white px-5 py-4 text-stone-800 placeholder:text-stone-400 transition-all',
                                    'border border-stone-200 focus:border-[#A98B68] focus:ring-[#A98B68]' => !$errors->has('form.customer_name'),
                                    'border border-red-300 focus:border-red-400 focus:ring-red-300' => $errors->has('form.customer_name'),
                                ])>

                            @error('form.customer_name')
                                <p class="mt-2 flex items-center gap-2 text-sm text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.65 18h16.7a1 1 0 00.86-1.5l-7.5-13a1 1 0 00-1.72 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Whatsapp --}}
                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-stone-700">
                                Número de teléfono
                            </label>
                            <input
                                id="phone"
                                type="text"
                                wire:model.blur="form.customer_phone"
                                placeholder="Ej. +54 9 353 5555555"
                                @class([
                                    'w-full rounded-2xl bg-white px-5 py-4 text-stone-800 placeholder:text-stone-400 transition-all',
                                    'border border-stone-200 focus:border-[#A98B68] focus:ring-[#A98B68]' => !$errors->has('form.customer_phone'),
                                    'border border-red-300 focus:border-red-400 focus:ring-red-300' => $errors->has('form.customer_phone'),
                                ])>

                            @error('form.customer_phone')
                                <p class="mt-2 flex items-center gap-2 text-sm text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.65 18h16.7a1 1 0 00.86-1.5l-7.5-13a1 1 0 00-1.72 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Instagram --}}
                        <div>
                            <label for="instagram" class="mb-2 block text-sm font-medium text-stone-700">
                                Instagram <span class="text-stone-400">(opcional)</span>
                            </label>
                            <input
                                id="instagram"
                                type="text"
                                wire:model.blur="form.customer_instagram"
                                placeholder="@samadhi"
                                @class([
                                    'w-full rounded-2xl bg-white px-5 py-4 text-stone-800 placeholder:text-stone-400 transition-all',
                                    'border border-stone-200 focus:border-[#A98B68] focus:ring-[#A98B68]' => !$errors->has('form.customer_instagram'),
                                    'border border-red-300 focus:border-red-400 focus:ring-red-300' => $errors->has('form.customer_instagram'),
                                ])>

                            @error('form.customer_instagram')
                                <p class="mt-2 flex items-center gap-2 text-sm text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.65 18h16.7a1 1 0 00.86-1.5l-7.5-13a1 1 0 00-1.72 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-stone-700">
                                Email <span class="text-stone-400">(opcional)</span>
                            </label>
                            <input
                                id="email"
                                type="email"
                                wire:model.blur="form.customer_email"
                                placeholder="tu@email.com"
                                @class([
                                    'w-full rounded-2xl bg-white px-5 py-4 text-stone-800 placeholder:text-stone-400 transition-all',
                                    'border border-stone-200 focus:border-[#A98B68] focus:ring-[#A98B68]' => !$errors->has('form.customer_email'),
                                    'border border-red-300 focus:border-red-400 focus:ring-red-300' => $errors->has('form.customer_email'),
                                ])>

                            @error('form.customer_email')
                                <p class="mt-2 flex items-center gap-2 text-sm text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.65 18h16.7a1 1 0 00.86-1.5l-7.5-13a1 1 0 00-1.72 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Observaciones --}}
                        <div>
                            <label for="notes" class="mb-2 block text-sm font-medium text-stone-700">
                                Observaciones <span class="text-stone-400">(opcional)</span>
                            </label>
                            <textarea
                                id="notes"
                                rows="5"
                                wire:model.blur="form.customer_notes"
                                placeholder="¿Querés agregar algún comentario sobre tu pedido?"
                                @class([
                                    'w-full rounded-2xl bg-white px-5 py-4 text-stone-800 placeholder:text-stone-400 transition-all',
                                    'border border-stone-200 focus:border-[#A98B68] focus:ring-[#A98B68]' => !$errors->has('form.customer_notes'),
                                    'border border-red-300 focus:border-red-400 focus:ring-red-300' => $errors->has('form.customer_notes'),
                                ])></textarea>

                            @error('form.customer_notes')
                                <p class="mt-2 flex items-center gap-2 text-sm text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.65 18h16.7a1 1 0 00.86-1.5l-7.5-13a1 1 0 00-1.72 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Consentimiento --}}
                        <div>
                            <label @class([
                                'flex items-start gap-4 rounded-2xl p-5 transition-all cursor-pointer',
                                'bg-[#F8F6F2] border border-transparent' => !$errors->has('form.accept_terms'),
                                'bg-[#FDF5F3] border border-[#E8C5BE]' => $errors->has('form.accept_terms'),
                            ])>
                                <input
                                    type="checkbox"
                                    wire:model.blur="form.accept_terms"
                                    class="mt-1 h-5 w-5 shrink-0 rounded border-stone-300 text-[#A98B68] focus:ring-[#A98B68]">

                                <span class="text-sm leading-7 text-stone-600">
                                    Acepto ser contactado por WhatsApp, Instagram o Email
                                    para confirmar el stock, coordinar el envío y finalizar
                                    la compra.
                                </span>
                            </label>

                            @error('form.accept_terms')
                                <div class="mt-3 flex items-center gap-2 text-sm text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.65 18h16.7a1 1 0 00.86-1.5l-7.5-13a1 1 0 00-1.72 0z"/>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- RESUMEN --}}
                <aside class="self-start lg:sticky lg:top-24 space-y-6">
                    {{-- Resumen del pedido --}}
                    <div class="overflow-hidden rounded-[32px] bg-white shadow-[0_15px_45px_rgba(0,0,0,.05)]">
                        <div class="border-b border-stone-100 px-7 py-7">
                            <span class="text-[11px] uppercase tracking-[0.35em] text-[#A98B68]">
                                ✦ Resumen
                            </span>
                            <h2 class="mt-3 font-serif text-4xl text-stone-900">
                                Tu pedido
                            </h2>
                        </div>

                        {{-- Productos --}}
                        <div class="divide-y divide-stone-100">
                            @foreach($this->form->items as $index => $item)
                                <div wire:key="cart-item-{{ $item['id'] ?? $index }}" class="flex items-center gap-4 px-7 py-5">
                                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#F5F2EC]">
                                        <img src="{{ asset($item['image_url']) }}" alt="{{ $item['title'] }}" class="max-h-12 object-contain">
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h4 class="truncate font-medium text-stone-900">
                                            {{ $item['title'] }}
                                        </h4>
                                        <p class="mt-1 text-sm text-stone-500">
                                            x {{ $item['quantity'] }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="font-medium text-[#A98B68]">
                                            ${{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Totales --}}
                        <div class="border-t border-stone-100 px-7 py-7">
                            <div class="flex justify-between text-stone-600">
                                <span>Subtotal</span>
                                <span>${{ number_format($this->subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="mt-4 flex justify-between text-stone-600">
                                <span>Envío</span>
                                <span class="font-medium text-green-600">A coordinar</span>
                            </div>

                            <div class="my-6 border-t border-dashed border-stone-200"></div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm uppercase tracking-[0.25em] text-stone-400">
                                    Total estimado
                                </span>
                                <span class="font-serif text-4xl text-[#A98B68]">
                                    ${{ number_format($this->subtotal, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Acciones --}}
                            <div class="mt-10 flex flex-col gap-4">
                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center justify-center rounded-full bg-[#A98B68] px-10 py-4 font-medium text-white transition-all duration-300 hover:-translate-y-1 hover:bg-[#8D7358] hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="confirmOrder">Finalizar</span>
                                    <span wire:loading wire:target="confirmOrder">Procesando...</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Información --}}
                    <div class="rounded-[32px] bg-white p-7 shadow-[0_15px_45px_rgba(0,0,0,.05)]">
                        <div class="flex gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700 font-bold">
                                ✓
                            </div>
                            <div>
                                <h3 class="font-medium text-stone-900">
                                    ¿Qué sucede después?
                                </h3>
                                <p class="mt-2 leading-7 text-stone-500 text-sm">
                                    Una vez enviado el pedido me comunicaré con vos para
                                    confirmar el stock disponible, responder cualquier duda
                                    y coordinar el método de pago y el envío.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </form>
        </div>
    </div>
</section>
