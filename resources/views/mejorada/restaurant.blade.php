@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::MejoradaRestaurant);
@endphp

<x-layouts.app :title="$cms->text('restaurant.page_title', 'mejorada.restaurant.page_title').' — '.__('nav.mejorada')">
    <section class="-mt-(--header-height) flex min-h-[100vh] flex-col justify-center bg-black-500 px-6 pt-[calc(var(--header-height)+4rem)] pb-16 text-white lg:px-10">
        <div class="mx-auto grid w-full max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <div class="flex flex-col items-center text-center">
                <h1 class="sr-only">{{ $cms->text('restaurant.page_title', 'mejorada.restaurant.page_title') }}</h1>

                <img
                    src="{{ $cms->asset('restaurant.logo', 'images/home/Cocina Vidente.svg') }}"
                    alt="Cocina Vidente"
                    width="297"
                    class="h-auto w-[200px] sm:w-[240px] lg:w-[280px]"
                >

                <p class="type-b2 mt-8 max-w-md">
                    {{ $cms->text('restaurant.lead', 'mejorada.restaurant.lead') }}
                </p>

                <div class="mt-10 flex w-full max-w-md flex-col gap-4">
                    <x-mejorada.button
                        :href="route('cigno-mejorada.contact')"
                        variant="white-solid"
                        class="w-full"
                    >
                        {{ $cms->text('restaurant.book', 'mejorada.restaurant.book') }}
                    </x-mejorada.button>

                    <x-mejorada.button
                        :href="$cms->text('restaurant.menu_url', 'mejorada.restaurant.menu_url')"
                        variant="white"
                        class="w-full"
                    >
                        {{ $cms->text('restaurant.see_menu', 'mejorada.restaurant.see_menu') }}
                    </x-mejorada.button>
                </div>
            </div>

            <div class="relative aspect-[900/800] w-full overflow-hidden">
                <x-site-video
                    class="absolute inset-0 size-full object-cover"
                    preload="none"
                    data-managed
                    src="{{ $cms->asset('restaurant.hero_video', 'videos/Copia de 01. Reel RESTAURANTE Cigno MEJORADA 2.mp4') }}"
                    poster="{{ $cms->asset('restaurant.hero_poster', 'images/ermita/home/restaurante.png') }}"
                    :aria-label="$cms->text('restaurant.gallery_alt', 'mejorada.restaurant.gallery_alt')"
                />
            </div>
        </div>
    </section>
</x-layouts.app>
