@php
    $cms = cms('cigno-mejorada');
@endphp

<section class="relative isolate overflow-hidden px-6 py-20 text-white lg:px-10 lg:py-28">
    <img
        src="{{ asset('images/home/About (1).png') }}"
        alt=""
        class="absolute inset-0 size-full object-cover"
    >

    <div class="relative z-10 mx-auto grid max-w-7xl grid-cols-1 items-center gap-14 lg:grid-cols-2 lg:gap-16 xl:gap-20">
        <div class="carousel-square order-2 w-full max-w-[40rem] justify-self-center overflow-hidden lg:order-1 lg:max-w-none">
            <div class="relative aspect-square overflow-hidden">
                <x-site-video
                    class="absolute inset-0 size-full object-cover"
                    preload="none"
                    data-managed
                    src="{{ asset('videos/Cocina.mp4') }}"
                    poster="{{ asset('images/cocina/725621555_982617504576688_4481192901537941310_n.jpg') }}"
                    :aria-label="$cms->text('cocina.title', 'mejorada.cocina.title')"
                />
            </div>
        </div>

        <div class="order-1 flex flex-col items-center text-center lg:order-2">
            <h2 class="sr-only">{{ $cms->text('cocina.title', 'mejorada.cocina.title') }}</h2>

            <img
                src="{{ asset('images/home/Cocina Vidente.svg') }}"
                alt="Cocina Vidente"
                width="297"
                class="h-auto w-[220px] lg:w-[297px]"
            >

            <p class="type-s2 mt-8 max-w-md text-white">
                {{ $cms->text('cocina.body', 'mejorada.cocina.body') }}
            </p>

            <div class="mt-10 flex w-full max-w-md flex-col gap-4">
                <x-mejorada.button
                    :href="route('cigno-mejorada.restaurant')"
                    variant="white-solid"
                    class="w-full"
                >
                    {{ $cms->text('cocina.book', 'mejorada.cocina.book') }}
                </x-mejorada.button>

                <x-mejorada.button
                    :href="route('cigno-mejorada.restaurant')"
                    variant="white"
                    class="w-full"
                >
                    {{ $cms->text('cocina.see_more', 'mejorada.cocina.see_more') }}
                </x-mejorada.button>
            </div>

            <img
                src="{{ asset('images/home/Isotipo.svg') }}"
                alt=""
                width="71"
                class="mt-12 h-auto w-[71px]"
                aria-hidden="true"
            >
        </div>
    </div>
</section>
