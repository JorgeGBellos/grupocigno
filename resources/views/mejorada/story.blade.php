@php
    use App\Enums\CmsPageSlug;
    $cms = cms(CmsPageSlug::MejoradaBarrio);
@endphp

<x-layouts.app :title="$cms->text('barrio.page_title', 'mejorada.story.barrio_page_title').' — '.__('nav.mejorada')">
    <section class="bg-off-white-300 site-section text-black-500">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/ermita/icons/cisneentero.svg') }}"
                alt=""
                width="280"
                class="h-auto w-[220px] sm:w-[260px]"
            >

            <h1 class="type-h1 mt-10 max-w-xl text-balance">
                {{ $cms->text('barrio.page_title', 'mejorada.story.barrio_page_title') }}
            </h1>

            <p class="type-b2 mt-8 max-w-xl">
                {{ $cms->text('barrio.page_lead', 'mejorada.location.body') }}
            </p>

            <x-mejorada.button :href="route('cigno-mejorada').'#booking'" class="mt-10 w-full max-w-lg">
                {{ __('mejorada.story.book_btn') }}
            </x-mejorada.button>
        </div>

        <div class="site-shell mt-16 grid grid-cols-1 gap-8 sm:grid-cols-3 lg:mt-20 lg:gap-8">
            <img
                src="{{ asset('images/mejorada/barrio/tiles.png') }}"
                alt="{{ $cms->text('barrio.page_title', 'mejorada.story.barrio_page_title') }}"
                class="aspect-[3/4] w-full object-cover"
            >

            <img
                src="{{ asset('images/mejorada/barrio/window.png') }}"
                alt="{{ __('mejorada.story.image_alt') }}"
                class="aspect-[3/4] w-full object-cover"
            >

            <img
                src="{{ asset('images/mejorada/barrio/temple.png') }}"
                alt="{{ __('mejorada.story.image_alt') }}"
                class="aspect-[3/4] w-full object-cover"
            >
        </div>
    </section>

    <section class="bg-blue-mejorada-300 site-section text-white">
        <div class="site-shell grid grid-cols-1 items-start gap-12 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.62fr)] lg:gap-x-20 lg:gap-y-10">
            <div>
                <img
                    src="{{ asset('images/mejorada/barrio/banner.png') }}"
                    alt="{{ $cms->text('barrio.banner_body', 'mejorada.story.barrio_banner_body') }}"
                    class="aspect-[4/3] w-full object-cover"
                >

                <p class="type-b2 mt-6 w-full">
                    {{ $cms->text('barrio.banner_body', 'mejorada.story.barrio_banner_body') }}
                </p>
            </div>

            <div class="w-full lg:justify-self-end">
                <img
                    src="{{ asset('images/mejorada/barrio/stairs-lanterns.png') }}"
                    alt="{{ $cms->text('barrio.banner_title', 'mejorada.story.barrio_banner_title') }}"
                    class="aspect-[400/515] w-full object-cover"
                >

                <p class="type-b2 mt-6 w-full">
                    {{ $cms->text('barrio.banner_title', 'mejorada.story.barrio_banner_title') }}
                </p>
            </div>
        </div>
    </section>

    <section class="bg-off-white-300 site-section text-black-500">
        <div class="site-shell grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
            <div class="flex max-w-xl flex-col">
                <img
                    src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
                    alt=""
                    width="56"
                    class="h-auto w-12 lg:w-14"
                >

                <div class="type-b2 mt-8 space-y-6">
                    <p>{{ $cms->text('barrio.history_title', 'mejorada.story.barrio_history_title') }}</p>
                    <p>{{ $cms->text('barrio.history_body', 'mejorada.story.barrio_history_body') }}</p>
                </div>

                <x-mejorada.button :href="route('cigno-mejorada').'#booking'" class="mt-10 w-full max-w-xs">
                    {{ __('mejorada.story.book_btn') }}
                </x-mejorada.button>
            </div>

            <img
                src="{{ asset('images/mejorada/barrio/history.png') }}"
                alt="{{ __('mejorada.story.image_alt') }}"
                class="aspect-[5/4] w-full object-cover"
            >
        </div>
    </section>

    <x-mejorada.location-section />
</x-layouts.app>
