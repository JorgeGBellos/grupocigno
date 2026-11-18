@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::ErmitaBarrio);
    $gallery = $cms->gallery('barrio.gallery', [
        'images/ermita/barrio/Rectangle 3 (22).png',
        'images/ermita/barrio/Rectangle 3 (23).png',
        'images/ermita/barrio/Rectangle 3 (24).png',
    ]);
    $pageTitle = $cms->text('barrio.page_title', 'ermita.barrio.page_title');
@endphp

<x-layouts.app :title="$pageTitle.' — '.__('nav.ermita')">
    <section class="bg-off-white-300 site-section text-black-500">
        <div class="mx-auto flex w-full max-w-3xl flex-col items-center text-center">
            <img
                src="{{ asset('images/ermita/icons/tortugaentera.svg') }}"
                alt=""
                width="280"
                class="h-auto w-[220px] sm:w-[260px]"
            >

            <h1 class="type-h1 mt-10 max-w-xl text-balance">{{ $pageTitle }}</h1>

            <p class="type-b2 mt-8 max-w-xl">{{ $cms->text('barrio.page_lead', 'ermita.location.body') }}</p>

            <x-ermita.button :href="route('cigno-ermita').'#booking'" class="mt-10 w-full max-w-lg">
                {{ $cms->text('barrio.book', 'ermita.story.book') }}
            </x-ermita.button>
        </div>

        <div class="site-shell mt-16 grid grid-cols-1 gap-8 sm:grid-cols-3 lg:mt-20 lg:gap-8">
            <img
                src="{{ asset($gallery[0] ?? 'images/ermita/barrio/Rectangle 3 (22).png') }}"
                alt="{{ $pageTitle }}"
                class="aspect-[3/4] w-full object-cover"
            >

            <div class="relative aspect-[3/4] overflow-hidden">
                <x-site-video
                    class="absolute inset-0 size-full object-cover"
                    preload="none"
                    data-managed
                    src="{{ $cms->asset('barrio.video', 'videos/ermita-barrio.mp4') }}"
                    poster="{{ asset($gallery[1] ?? 'images/ermita/barrio/Rectangle 3 (23).png') }}"
                    :aria-label="__('ermita.barrio.image_alt')"
                />
            </div>

            <img
                src="{{ asset($gallery[2] ?? 'images/ermita/barrio/Rectangle 3 (24).png') }}"
                alt="{{ __('ermita.barrio.image_alt') }}"
                class="aspect-[3/4] w-full object-cover"
            >
        </div>
    </section>

    <section class="bg-blue-ermita-300 site-section text-white">
        <div class="site-shell grid grid-cols-1 items-start gap-12 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.62fr)] lg:gap-x-20 lg:gap-y-10">
            <div>
                <img
                    src="{{ $cms->asset('barrio.story_image', 'images/ermita/barrio/Rectangle 3 (25).png') }}"
                    alt="{{ __('ermita.story.image_alt') }}"
                    class="aspect-[4/3] w-full object-cover"
                >

                <div class="type-b2 mt-6 w-full space-y-1">
                    <p>{{ $cms->text('barrio.story_lead_1', 'ermita.story.lead_1') }}</p>
                    <p>{{ $cms->text('barrio.story_lead_2', 'ermita.story.lead_2') }}</p>
                </div>
            </div>

            <div class="w-full lg:justify-self-end">
                <img
                    src="{{ $cms->asset('barrio.hero_image', 'images/ermita/barrio/Rectangle 3 (26).png') }}"
                    alt="{{ $cms->text('barrio.hero_line', 'ermita.hero.line_1') }}"
                    class="aspect-[400/515] w-full object-cover"
                >

                <p class="type-b2 mt-6 w-full">{{ $cms->text('barrio.hero_line', 'ermita.hero.line_1') }}</p>
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
                    <p>{{ $cms->text('barrio.history_1', 'ermita.barrio.history_1') }}</p>
                    <p>{{ $cms->text('barrio.history_2', 'ermita.barrio.history_2') }}</p>
                </div>

                <x-ermita.button :href="route('cigno-ermita').'#booking'" class="mt-10 w-full max-w-xs">
                    {{ $cms->text('barrio.book', 'ermita.story.book') }}
                </x-ermita.button>
            </div>

            <img
                src="{{ $cms->asset('barrio.history_image', 'images/ermita/barrio/Rectangle 3 (27).png') }}"
                alt="{{ __('ermita.story.image_alt') }}"
                class="aspect-[5/4] w-full object-cover"
            >
        </div>
    </section>

    <x-ermita.location-section />
</x-layouts.app>