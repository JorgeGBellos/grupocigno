@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
@endphp

<x-layouts.app>
    <h1 class="sr-only">{{ config('app.name') }}</h1>

    <section class="relative isolate h-[calc(100svh-var(--header-height))] overflow-hidden text-white">
        <x-site-video
            class="absolute inset-0 size-full object-cover object-center"
            preload="metadata"
            aria-hidden="true"
            data-managed
            src="{{ $cms->asset('hero.video', 'videos/01. WEB Cignos (1).mp4') }}"
            poster="{{ $cms->asset('hero.background', 'images/home/Home (1).png') }}"
        />

        <div class="relative z-10 flex h-full flex-col justify-end px-6 pb-8 lg:px-10 lg:pb-10" id="booking">
            <x-home.booking-bar />
        </div>
    </section>

    <x-home.story-section />

    <x-home.destination-section />

    <x-home.hotels-section :cms="$cms" />

    <x-home.experiences-section />
    <x-home.club-section />
    <x-home.cocina-section />
    <x-home.tiendita-press-section />
</x-layouts.app>
