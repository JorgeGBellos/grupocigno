<x-layouts.app :title="__('nav.ermita').' — '.config('app.name')">
    <h1 class="sr-only">{{ __('nav.ermita') }}</h1>

    <x-ermita.hero />
    <x-ermita.story-section />
    <x-ermita.barrio-section />
    <x-ermita.rooms-section />
    <x-ermita.amenities-section banner />
    <x-ermita.cocina-section />
    <x-ermita.experiences-section />
    <x-ermita.offers-section />
    <x-ermita.daypass-section />
    <x-ermita.celebrate-section />
    <x-ermita.guests-section />
    <x-ermita.location-section />
</x-layouts.app>
