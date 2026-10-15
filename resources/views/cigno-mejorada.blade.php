<x-layouts.app :title="__('nav.mejorada').' — '.config('app.name')">
    <h1 class="sr-only">{{ __('nav.mejorada') }}</h1>

    <x-mejorada.hero />
    <x-mejorada.story-section />
    <x-mejorada.barrio-section />
    <x-mejorada.rooms-section />
    <x-mejorada.amenities-section banner />
    <x-mejorada.cocina-section />
    <x-mejorada.experiences-section />
    <x-mejorada.offers-section />
    <x-mejorada.venue-section />
    <x-mejorada.daypass-section />
    <x-mejorada.guests-section />
    <x-mejorada.location-section />
</x-layouts.app>
