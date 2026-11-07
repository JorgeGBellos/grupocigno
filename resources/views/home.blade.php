@php
    use App\Enums\CmsPageSlug;

    $cms = cms(CmsPageSlug::Home);
@endphp

<x-layouts.app>
    <h1 class="sr-only">{{ config('app.name') }}</h1>

    <x-site-hero
        :video="$cms->asset('hero.video', 'videos/01. WEB Cignos (1).mp4')"
        :poster="$cms->asset('hero.background', 'images/home/Home (1).png')"
    />

    <x-home.story-section />

    <x-home.destination-section />

    <x-home.hotels-section :cms="$cms" />

    <x-home.experiences-section />
    <x-home.cocina-section />
    <x-home.tiendita-press-section />
</x-layouts.app>
