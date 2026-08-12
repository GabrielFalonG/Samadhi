<div class="min-h-screen bg-slate-100">

    <div class="p-5 lg:p-10">
        {{-- Header --}}
        <div
            class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-8">

            <div>

                <h1 class="text-4xl font-bold text-slate-900">

                    Carruseles

                </h1>

                <p class="mt-2 text-slate-500">

                    Administración de carruseles e ítems que se muestran en la aplicación.

                </p>

            </div>

        </div>

        {{-- FROMULARIO --}}
        @include('livewire.carousel.carousel-form', ['isEditing' => true])
    </div>

    {{-- Modal confirmacion --}}
    @if($showConfirmModal)

        @include('livewire.carousel.carousel-confirm-edit')

    @endif

</div>
