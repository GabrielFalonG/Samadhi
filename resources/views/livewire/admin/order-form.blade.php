<div class="mt-10 flex flex-col gap-4">
    <form
        wire:submit="confirmSaveData"
        class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm mb-8">

        {{-- Header / Título --}}
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">
                    Editar Pedido #{{ $form->order_number }}
                </h2>
                <p class="mt-1 text-slate-500">
                    Gestioná los detalles, el estado y el seguimiento del pedido.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span class="inline-flex items-center rounded-full bg-violet-100 px-4 py-2 text-sm font-medium text-violet-700">
                    Cliente: {{ $form->customer_name }}
                </span>
            </div>
        </div>

        {{-- Campos Principales --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Estado actual --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-600">
                    Estado actual
                </label>

                <input
                    type="text"
                    value="{{ $this->statusLabel() }}"
                    disabled
                    class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-500 disabled:bg-slate-100 disabled:text-slate-400 cursor-not-allowed">

                @error('form.status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Teléfono del cliente --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-600">
                    {{ __('Teléfono cliente') }}
                </label>
                <input
                    type="text"
                    maxlength="50"
                    wire:model.blur="form.customer_phone"
                    placeholder="+54911987601234"
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.customer_phone')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                @error('form.customer_phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Instagram del cliente --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-600">
                    {{ __('Instagram cliente') }}
                </label>
                <input
                    type="text"
                    maxlength="100"
                    wire:model.blur="form.customer_instagram"
                    placeholder=""
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.customer_instagram')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                @error('form.customer_instagram')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email del cliente --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-600">
                    {{ __('Email cliente') }}
                </label>
                <input
                    type="email"
                    maxlength="150"
                    wire:model.blur="form.customer_email"
                    placeholder=""
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.customer_email')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                @error('form.customer_email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Código / Número de Seguimiento --}}
            {{-- <div>
                <label class="mb-2 block text-sm font-medium text-slate-600">
                    Código de Seguimiento (Tracking)
                </label>
                <input
                    type="text"
                    maxlength="100"
                    wire:model.blur="form.tracking_number"
                    placeholder="Ej: AB123456789AR"
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.tracking_number')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                @error('form.tracking_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}

            {{-- Empresa de Transporte --}}
            {{-- <div>
                <label class="mb-2 block text-sm font-medium text-slate-600">
                    Empresa de Transporte (Tracking)
                </label>
                <input
                    type="text"
                    maxlength="100"
                    wire:model.blur="form.shipping_carrier"
                    placeholder="Ej: Correo Argentino, Andreani, etc."
                    class="w-full rounded-2xl border px-4 py-3 outline-none transition
                        {{ $errors->has('form.shipping_carrier')
                            ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                            : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">

                @error('form.shipping_carrier')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}

            {{-- Comentarios / Notas del cliente (Bloqueado) --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-600">
                    {{ __('Notas del cliente') }}
                </label>

                <textarea
                    rows="5"
                    disabled
                    class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-400 cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 focus:outline-none resize-none">{{ $form->customer_notes }}</textarea>

                @error('form.customer_notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Lista de Productos en la Orden --}}
            <div class="lg:col-span-2 mt-4">
                <h3 class="mb-4 text-lg font-semibold text-slate-800">
                    Productos del Pedido
                </h3>

                <div class="overflow-hidden rounded-2xl border border-slate-200">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Producto</th>
                                <th class="px-4 py-3 text-center">Cantidad</th>
                                <th class="px-4 py-3 text-right">Precio Unitario</th>
                                <th class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($this->form->items as $item)
                                <tr wire:key="order-item-{{ $item['id'] }}">
                                    <td class="px-4 py-3 font-medium text-slate-900 flex items-center gap-3">
                                        @if(!empty($item['image_url']))
                                            <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}" class="h-10 w-10 rounded-lg object-cover border border-slate-200">
                                        @endif
                                        <span>{{ $item['title'] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">{{ $item['quantity'] }}</td>
                                    <td class="px-4 py-3 text-right">${{ number_format($item['price'], 2) }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-slate-900">
                                        ${{ number_format($item['quantity'] * $item['price'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 font-semibold text-slate-900 border-t border-slate-200">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right">Total:</td>
                                <td class="px-4 py-3 text-right text-violet-700 text-base">
                                    ${{ number_format($this->form->total, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sección de Cambio de Estado Historial --}}
        <div class="mt-8 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 mb-6">
                Historial de Estados
            </h3>

            {{-- Formulario para registrar nuevo estado --}}
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 mb-8">
                <h4 class="text-sm font-semibold text-slate-700 mb-4">Actualizar estado / Agregar comentario</h4>

                {{-- <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-600">Nuevo Estado *</label>
                        <select
                            wire:model="form.h_status"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 bg-white outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition">
                                <option value="">{{ __('Todos') }}</option>
                            @foreach(App\Enums\OrderStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                            @endforeach
                        </select>
                        @error('form.h_status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-600">Comentario (Opcional)</label>
                        <input
                            type="text"
                            wire:model="form.h_new_comment"
                            placeholder="Escribe un comentario sobre este cambio..."
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 bg-white outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition"
                        />
                        @error('form.h_new_comment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div> --}}

                <div class="grid gap-4 md:grid-cols-2">
                    {{-- Select para Nuevo Estado --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-600">Nuevo Estado *</label>
                        <select
                            wire:model="form.h_status"
                            class="w-full rounded-2xl border px-4 py-3 bg-white outline-none transition
                                {{ $errors->has('form.h_status') || $errors->has('h_status')
                                    ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                                    : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}">
                            <option value="">Seleccionar estado...</option>
                            @foreach(App\Enums\OrderStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                            @endforeach
                        </select>

                        @error('form.h_status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input para Comentario --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-600">Comentario (Opcional)</label>
                        <input
                            type="text"
                            maxlength="500"
                            wire:model="form.h_new_comment"
                            placeholder="Escribe un comentario sobre este cambio..."
                            class="w-full rounded-2xl border px-4 py-3 bg-white outline-none transition
                                {{ $errors->has('form.h_new_comment') || $errors->has('h_new_comment')
                                    ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                                    : 'border-slate-300 focus:border-violet-500 focus:ring-4 focus:ring-violet-100' }}"
                        />

                        @error('form.h_new_comment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <button
                        type="button"
                        wire:click="addStatusHistory"
                        class="rounded-xl bg-violet-700 hover:bg-violet-800 px-5 py-2.5 text-sm font-medium text-white transition">
                        Registrar Estado
                    </button>
                </div>
            </div>

            {{-- Timeline / Visor del Historial --}}
            <details class="group rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden transition">
                <summary class="flex cursor-pointer items-center justify-between p-5 font-semibold text-slate-700 hover:bg-slate-100 transition list-none select-none">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-slate-500 transition group-open:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                        <span>Ver historial de estados ({{ count($this->form->history) }})</span>
                    </div>
                    <span class="text-xs text-slate-400 group-open:hidden">Haz clic para desplegar</span>
                </summary>

                <div class="p-6 bg-white border-t border-slate-200">
                    {{-- Timeline / Visor del Historial --}}
                    <div class="relative border-l-2 border-slate-200 ml-4 space-y-6">
                        @forelse($this->form->history as $entry)
                            <div class="relative pl-6">
                                <!-- Indicador en la línea de tiempo -->
                                <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-full border-2 border-white bg-violet-600 shadow-sm"></span>

                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center rounded-lg border px-2.5 py-0.5 text-xs font-semibold {{ $entry['status']->color() }}">
                                            {{ $entry['status']->label() }}
                                        </span>
                                        <span class="text-xs text-slate-400">#{{ $entry['id'] }}</span>
                                    </div>
                                    <time class="text-xs text-slate-400">{{ $entry['created_at'] }}</time>
                                </div>

                                @if(!empty($entry['comment']))
                                    <p class="mt-2 text-sm text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                        {{ $entry['comment'] }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="pl-6 text-sm text-slate-400">No hay historial registrado para este pedido.</p>
                        @endforelse
                    </div>
                </div>
            </details>
        </div>

        {{-- Switch de Confirmación / Checkbox --}}
        {{-- <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-5">
            <label class="flex items-center gap-4 cursor-pointer">
                <div class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        id="form_notify_customer"
                        wire:model="form.notify_customer"
                        class="h-5 w-5 rounded border-slate-300 text-violet-600 transition focus:ring-2 focus:ring-violet-500"
                    >
                    <label for="form_notify_customer" class="text-sm font-medium text-slate-700 select-none">
                        Notificar al cliente
                    </label>
                </div>
                <div>
                    <p class="font-semibold text-slate-900">
                        Notificar al cliente por correo
                    </p>
                    <p class="text-sm text-slate-500">
                        Se enviará un e-mail con las actualizaciones del estado de su pedido.
                    </p>
                </div>
            </label>
        </div> --}}

        {{-- Botones de Acción --}}
        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.orders') }}" wire:navigate
                class="rounded-2xl border border-slate-300 bg-white px-6 py-3 font-medium text-slate-700 hover:bg-slate-50 transition text-center">
                Cancelar
            </a>

            <button
                type="submit"
                class="rounded-2xl bg-violet-700 hover:bg-violet-800 px-6 py-3 text-white font-medium transition">
                Actualizar pedido
            </button>
        </div>

    </form>
</div>
