@php
    use App\Enums\CmsPageSlug;
    $cms = cms(CmsPageSlug::MejoradaBarrio);
@endphp

<x-layouts.app :title="$cms->text('barrio.page_title', 'mejorada.story.barrio_page_title').' — '.__('nav.mejorada')">
    <section class="bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/ermita/icons/cisneentero.svg') }}"
                alt=""
                width="120"
                class="h-auto w-[96px] sm:w-[120px]"
            >

            <h1 class="type-h1 mt-10 max-w-xl text-balance">
                {{ $cms->text('barrio.page_title', 'mejorada.story.barrio_page_title') }}
            </h1>

            <p class="type-b2 mt-8 max-w-xl">
                {{ $cms->text('barrio.page_lead', 'mejorada.story.barrio_page_lead') }}
            </p>

            <x-mejorada.button
                :href="route('booking.search', ['hotel' => 'cigno-mejorada'])"
                class="mt-10 w-full max-w-lg"
            >
                {{ __('mejorada.story.book_btn') }}
            </x-mejorada.button>
        </div>

        <div class="mx-auto mt-16 grid max-w-6xl grid-cols-1 gap-8 sm:grid-cols-3 lg:mt-20 lg:gap-8">
            <img
                src="{{ asset('images/mejorada/barrio/tiles.png') }}"
                alt="{{ $cms->text('barrio.page_title', 'mejorada.story.barrio_page_title') }}"
                class="aspect-[3/4] w-full object-cover"
                loading="lazy"
            >

            <img
                src="{{ asset('images/mejorada/barrio/window.png') }}"
                alt="{{ $cms->text('barrio.page_title', 'mejorada.story.barrio_page_title') }}"
                class="aspect-[3/4] w-full object-cover"
                loading="lazy"
            >

            <img
                src="{{ asset('images/mejorada/barrio/temple.png') }}"
                alt="{{ $cms->text('barrio.page_title', 'mejorada.story.barrio_page_title') }}"
                class="aspect-[3/4] w-full object-cover"
                loading="lazy"
            >
        </div>
    </section>

    <section class="relative isolate overflow-hidden bg-blue-mejorada-300 px-6 py-16 text-white lg:px-10 lg:py-24">
        <img
            src="{{ asset('images/mejorada/barrio/banner.png') }}"
            alt=""
            class="absolute inset-0 size-full object-cover object-center opacity-40 mix-blend-multiply"
            loading="lazy"
            aria-hidden="true"
        >

        <div class="relative z-10 mx-auto flex max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/ermita/icons/cisneentero.svg') }}"
                alt=""
                width="56"
                class="h-auto w-12 brightness-0 invert lg:w-14"
                aria-hidden="true"
            >

            <h2 class="type-h1 mt-8 max-w-2xl text-balance">
                {{ $cms->text('barrio.banner_title', 'mejorada.story.barrio_banner_title') }}
            </h2>

            <p class="type-b2 mt-6 max-w-xl">
                {{ $cms->text('barrio.banner_body', 'mejorada.story.barrio_banner_body') }}
            </p>
        </div>
    </section>

    <section class="bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <div class="flex max-w-xl flex-col">
                <img
                    src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
                    alt=""
                    width="56"
                    class="h-auto w-12 lg:w-14"
                    aria-hidden="true"
                >

                <h2 class="type-h2 mt-8 text-balance">
                    {{ $cms->text('barrio.history_title', 'mejorada.story.barrio_history_title') }}
                </h2>

                <p class="type-b2 mt-6">
                    {{ $cms->text('barrio.history_body', 'mejorada.story.barrio_history_body') }}
                </p>

                <x-mejorada.button
                    :href="route('booking.search', ['hotel' => 'cigno-mejorada'])"
                    class="mt-10 w-full max-w-xs"
                >
                    {{ __('mejorada.story.book_btn') }}
                </x-mejorada.button>
            </div>

            <img
                src="{{ asset('images/mejorada/barrio/stairs-lanterns.png') }}"
                alt="{{ __('mejorada.story.image_alt') }}"
                class="aspect-[5/4] w-full object-cover"
                loading="lazy"
            >
        </div>
    </section>

    <section class="bg-off-white-300 px-6 pb-16 text-black-500 lg:px-10 lg:pb-24">
        <div class="mx-auto max-w-6xl">
            <img
                src="{{ asset('images/mejorada/barrio/history.png') }}"
                alt="{{ __('mejorada.story.image_alt') }}"
                class="aspect-[21/9] w-full object-cover"
                loading="lazy"
            >
        </div>
    </section>

    <x-mejorada.location-section />
</x-layouts.app>
