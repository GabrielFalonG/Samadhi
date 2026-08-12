<section class="relative overflow-hidden bg-[#F8F7F4]">

    <!-- Fondos decorativos -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-32 -right-32 h-72 w-72 rounded-full bg-amber-100/30 blur-3xl md:h-96 md:w-96"></div>
        <div class="absolute bottom-0 left-0 h-56 w-56 rounded-full bg-stone-200/30 blur-3xl md:h-72 md:w-72"></div>
    </div>

    {{--
      CAMBIOS AQUÍ:
      1. Se reemplaza 'min-h-screen' por 'min-h-[calc(100vh-130px)]' (se ajusta al espacio restante bajo el header).
      2. Se remueve 'pt-28' y se reemplaza por 'py-8 lg:py-12' para centrar verticalmente sin desfasar.
    --}}
    <div class="relative mx-auto flex min-h-[calc(100vh-130px)] max-w-7xl items-center px-5 py-8 sm:px-6 lg:px-12 lg:py-12">

        <div class="grid w-full items-center gap-8 lg:grid-cols-2 lg:gap-16">

            <!-- ============================= -->
            <!-- Imagen -->
            <!-- ============================= -->
            <div class="relative order-1 lg:order-2 flex justify-center">
                <div class="absolute -inset-6 hidden rounded-[40px] bg-white/40 blur-2xl lg:block"></div>
                <div class="relative">
                    <img
                        src="{{ asset('images/hero.png') }}"
                        alt="Samadhi"
                        class="h-[300px] w-full object-contain transition duration-700 hover:scale-105 sm:h-[380px] md:h-[460px] lg:h-[540px]">
                </div>
            </div>

            <!-- ============================= -->
            <!-- Texto -->
            <!-- ============================= -->
            <div class="order-2 text-center lg:order-1 lg:text-left">
                <h1 class="font-serif text-4xl font-light leading-tight text-stone-800 sm:text-5xl lg:text-6xl xl:text-7xl">
                    Encontrá el equilibrio entre
                    <span class="italic text-[#A98B68]">cuerpo,</span>
                    <span class="italic text-[#A98B68]">mente</span>
                    y energía.
                </h1>

                <p class="mx-auto mt-6 max-w-xl text-base leading-8 text-stone-600 sm:text-lg lg:mx-0 lg:mt-8">
                    Productos artesanales creados con intención y sesiones de
                    Reiki, Tarot Evolutivo y Limpiezas Energéticas para
                    acompañarte en tu camino de transformación.
                </p>

                <!-- Botones -->
                <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-center lg:justify-start">
                    <a
                        href="{{ route('products') }}"
                        class="inline-flex items-center justify-center rounded-full bg-[#A98B68] px-8 py-4 font-medium text-white transition-all duration-300 hover:-translate-y-1 hover:bg-[#8D7358] hover:shadow-xl">
                        Ver Productos
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
