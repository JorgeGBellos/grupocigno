<x-layouts.app :title="__('ermita.barrio.page_title').' — '.__('nav.ermita')">
    <section class="bg-off-white-300 px-6 py-16 text-black-500 lg:px-10 lg:py-24">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/ermita/icons/tortugaentera.svg') }}"
                alt=""
                width="280"
                class="h-auto w-[220px] sm:w-[260px]"
            >

            <h1 class="type-h1 mt-10 max-w-xl text-balance">{{ __('ermita.barrio.page_title') }}</h1>

            <p class="type-b2 mt-8 max-w-xl">{{ __('ermita.location.body') }}</p>

            <x-ermita.button :href="route('cigno-ermita').'#booking'" class="mt-10 w-full max-w-lg">
                {{ __('ermita.story.book') }}
            </x-ermita.button>
        </div>

        <div class="mx-auto mt-16 grid max-w-6xl grid-cols-1 gap-8 sm:grid-cols-3 lg:mt-20 lg:gap-8">
            <img
                src="{{ asset('images/ermita/barrio/Rectangle 3 (22).png') }}"
                alt="{{ __('ermita.barrio.page_title') }}"
                class="aspect-[3/4] w-full object-cover"
            >

            <div class="relative aspect-[3/4] overflow-hidden">
                <x-site-video
                    class="absolute inset-0 size-full object-cover"
                    preload="none"
                    data-managed
                    src="{{ asset('videos/Copia de Reel 01. Semana Santa en Ermita.mp4') }}"
                    poster="{{ asset('images/ermita/barrio/Rectangle 3 (23).png') }}"
                    :aria-label="__('ermita.barrio.image_alt')"
                />
            </div>

            <img
                src="{{ asset('images/ermita/barrio/Rectangle 3 (24).png') }}"
                alt="{{ __('ermita.barrio.image_alt') }}"
                class="aspect-[3/4] w-full object-cover"
            >
        </div>
    </section>

    <section class="bg-blue-ermita-300 px-6 py-16 text-white lg:px-10 lg:py-24">
        <div class="mx-auto grid max-w-6xl grid-cols-1 items-start gap-12 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.62fr)] lg:gap-x-20 lg:gap-y-10">
            <div>
                <img
                    src="{{ asset('images/ermita/barrio/Rectangle 3 (25).png') }}"
                    alt="{{ __('ermita.story.image_alt') }}"
                    class="aspect-[4/3] w-full object-cover"
                >

                <div class="type-b2 mt-6 max-w-xl space-y-1">
                    <p>{{ __('ermita.story.lead_1') }}</p>
                    <p>{{ __('ermita.story.lead_2') }}</p>
                </div>
            </div>

            <div class="lg:max-w-sm lg:justify-self-end">
                <img
                    src="{{ asset('images/ermita/barrio/Rectangle 3 (26).png') }}"
                    alt="{{ __('ermita.hero.line_1') }} {{ __('ermita.hero.line_2') }}"
                    class="aspect-[5/4] w-full object-cover"
                >

                <p class="type-b2 mt-6">{{ __('ermita.hero.line_1') }} {{ __('ermita.hero.line_2') }}</p>
            </div>
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
                >

                <div class="type-b2 mt-8 space-y-6">
                    <p>{{ __('ermita.barrio.history_1') }}</p>
                    <p>{{ __('ermita.barrio.history_2') }}</p>
                </div>

                <x-ermita.button :href="route('cigno-ermita').'#booking'" class="mt-10 w-full max-w-xs">
                    {{ __('ermita.story.book') }}
                </x-ermita.button>
            </div>

            <img
                src="{{ asset('images/ermita/barrio/Rectangle 3 (27).png') }}"
                alt="{{ __('ermita.story.image_alt') }}"
                class="aspect-[5/4] w-full object-cover"
            >
        </div>
    </section>

    <x-ermita.location-section />
</x-layouts.app>
