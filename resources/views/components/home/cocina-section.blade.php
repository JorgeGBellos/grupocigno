@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
    $cocinaPoster = $cms->asset('cocina.poster', 'images/cocina/gallery-meat.png');
@endphp

<section class="site-section relative isolate overflow-hidden text-white">
    <img
        src="{{ $cms->asset('cocina.background', 'images/home/About (1).png') }}"
        alt=""
        class="absolute inset-0 size-full object-cover"
    >

    <div class="site-shell relative z-10 grid grid-cols-1 items-center gap-[var(--site-gap)] lg:grid-cols-2 lg:gap-[clamp(2.5rem,5vw,5rem)]">
        <div class="carousel-square order-2 w-full max-w-[40rem] justify-self-center overflow-hidden lg:order-1 lg:max-w-none">
            <div class="relative aspect-square overflow-hidden">
                <img
                    src="{{ $cocinaPoster }}"
                    alt="{{ __('home.cocina.image_alt') }}"
                    class="absolute inset-0 size-full object-cover"
                >
            </div>
        </div>

        <div class="order-1 flex flex-col items-center text-center lg:order-2">
            <h2 class="sr-only">Cocina Vidente</h2>

            <img
                src="{{ $cms->asset('cocina.logo', 'images/home/Cocina Vidente.svg') }}"
                alt="Cocina Vidente"
                width="297"
                class="h-auto w-[220px] lg:w-[297px]"
            >

            <p class="type-b3 mt-8 max-w-md text-white">
                {{ $cms->text('cocina.body', 'home.cocina.body') }}
            </p>

            <div class="mt-10 flex w-full max-w-md flex-col gap-4">
                <x-home.outline-button
                    :href="hotel_phone_tel('ermita')"
                    variant="white-solid"
                    class="w-full"
                >
                    {{ $cms->text('cocina.book_ermita', 'home.cocina.book_ermita') }}
                </x-home.outline-button>
                <x-home.outline-button
                    :href="hotel_phone_tel('mejorada')"
                    variant="white-solid"
                    class="w-full"
                >
                    {{ $cms->text('cocina.book_mejorada', 'home.cocina.book_mejorada') }}
                </x-home.outline-button>
                <x-home.outline-button
                    :href="route('cocina-vidente')"
                    variant="white"
                    class="w-full"
                >
                    {{ $cms->text('cocina.see_more', 'home.cocina.see_more') }}
                </x-home.outline-button>
            </div>
        </div>
    </div>
</section>
