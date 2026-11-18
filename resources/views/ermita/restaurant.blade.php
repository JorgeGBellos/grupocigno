@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::ErmitaRestaurant);
    $restaurantGallery = $cms->gallery('restaurant.gallery', __('ermita.restaurant.gallery'));
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

    <section class="bg-off-white-300 site-section text-black-500">
        <div class="site-shell mx-auto flex max-w-3xl flex-col items-center text-center">
            <img
                src="{{ $cms->asset('restaurant.signature.icon', 'images/home/Cocina Vidente.svg') }}"
                alt=""
                width="120"
                class="h-auto w-[100px] sm:w-[120px]"
            >

            <h2 class="type-h2 mt-8 text-balance">
                {{ $cms->text('restaurant.signature.title', 'ermita.restaurant.signature.title') }}
            </h2>

            <div class="type-b2 mt-12 grid w-full grid-cols-1 gap-12 text-left lg:grid-cols-2 lg:gap-16">
                <article>
                    <h3 class="type-s2">
                        {{ $cms->text('restaurant.signature.breakfast.title', 'ermita.restaurant.signature.breakfast.title') }}
                    </h3>
                    <p class="type-label mt-3">
                        {{ $cms->text('restaurant.signature.breakfast.hours', 'ermita.restaurant.signature.breakfast.hours') }}
                    </p>
                    <p class="type-b2 mt-4 text-pretty">
                        {{ $cms->text('restaurant.signature.breakfast.body', 'ermita.restaurant.signature.breakfast.body') }}
                    </p>
                </article>

                <article>
                    <h3 class="type-s2">
                        {{ $cms->text('restaurant.signature.dinner.title', 'ermita.restaurant.signature.dinner.title') }}
                    </h3>
                    <p class="type-b2 mt-4 text-pretty">
                        {{ $cms->text('restaurant.signature.dinner.body', 'ermita.restaurant.signature.dinner.body') }}
                    </p>
                </article>
            </div>

            <p class="type-b3 mt-12 max-w-2xl text-pretty">
                {{ $cms->text('restaurant.signature.note', 'ermita.restaurant.signature.note') }}
            </p>
        </div>
    </section>

    <section class="bg-beige-100 site-section text-black-500">
        <div class="site-shell grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <div class="flex max-w-xl flex-col max-lg:order-2">
                <img
                    src="{{ $cms->asset('restaurant.signature.icon', 'images/home/Cocina Vidente.svg') }}"
                    alt=""
                    width="56"
                    class="h-auto w-12 lg:w-14"
                >

                <h2 class="type-h2 mt-8 text-balance">
                    {{ $cms->text('restaurant.chef.title', 'ermita.restaurant.chef.title') }}
                </h2>

                <div class="type-b2 mt-8 space-y-6">
                    <p>{{ $cms->text('restaurant.chef.body_1', 'ermita.restaurant.chef.body_1') }}</p>
                    <p>{{ $cms->text('restaurant.chef.body_2', 'ermita.restaurant.chef.body_2') }}</p>
                </div>
            </div>

            <img
                src="{{ $cms->asset('restaurant.chef.image', 'images/home/ermita.png') }}"
                alt="{{ __('ermita.restaurant.chef.image_alt') }}"
                class="aspect-[4/5] w-full object-cover max-lg:order-1"
            >
        </div>
    </section>

    @if (count($restaurantGallery) > 0)
        <section class="bg-off-white-300 site-section text-black-500">
            <div class="site-shell">
                <x-home.peek-carousel
                    class="w-full"
                    :images="$restaurantGallery"
                    :alt="$cms->text('restaurant.gallery_alt', 'ermita.restaurant.gallery_alt')"
                    bar-class="bg-blue-ermita-300"
                />
            </div>
        </section>
    @endif
</x-layouts.app>
