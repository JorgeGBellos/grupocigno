@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::ErmitaRestaurant);
@endphp

<x-layouts.app :title="$cms->text('restaurant.page_title', 'ermita.restaurant.page_title').' — '.__('nav.ermita')">
    <section class="-mt-(--header-height) site-section--x flex min-h-[100vh] flex-col justify-center bg-black-500 pt-[calc(var(--header-height)+4rem)] pb-16 text-white">
        <div class="site-shell grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <div class="flex flex-col items-center text-center">
                <h1 class="sr-only">{{ $cms->text('restaurant.page_title', 'ermita.restaurant.page_title') }}</h1>

                <img
                    src="{{ $cms->asset('restaurant.logo', 'images/home/Cocina Vidente.svg') }}"
                    alt="Cocina Vidente"
                    width="297"
                    class="h-auto w-[200px] sm:w-[240px] lg:w-[280px]"
                >

                <p class="type-b2 mt-8 max-w-md">
                    {{ $cms->text('restaurant.lead', 'ermita.restaurant.lead') }}
                </p>

                <div class="mt-10 flex w-full max-w-md flex-col gap-4">
                    <x-ermita.button
                        :href="hotel_phone_tel('ermita')"
                        variant="white-solid"
                        class="w-full"
                    >
                        {{ $cms->text('restaurant.book', 'ermita.restaurant.book') }}
                    </x-ermita.button>

                    <x-ermita.button
                        :href="restaurant_menu_url('ermita', 'food')"
                        variant="white"
                        class="w-full"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ $cms->text('restaurant.see_menu_food', 'ermita.restaurant.see_menu_food') }}
                    </x-ermita.button>

                    <x-ermita.button
                        :href="restaurant_menu_url('ermita', 'drinks')"
                        variant="white"
                        class="w-full"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ $cms->text('restaurant.see_menu_drinks', 'ermita.restaurant.see_menu_drinks') }}
                    </x-ermita.button>
                </div>
            </div>

            <div class="relative aspect-[900/800] w-full overflow-hidden">
                <img
                    src="{{ $cms->asset('restaurant.hero_poster', 'images/ermita/home/restaurante.png') }}"
                    alt="{{ $cms->text('restaurant.gallery_alt', 'ermita.restaurant.gallery_alt') }}"
                    class="absolute inset-0 size-full object-cover"
                >
            </div>
        </div>
    </section>
</x-layouts.app>
