@php
    $cms = cms('cigno-mejorada');
@endphp

<section class="relative isolate h-[100vh] overflow-hidden bg-beige-100 text-black-500">
    <img
        src="{{ $cms->asset('location.map', 'images/ermita/home/locations.png') }}"
        alt=""
        class="absolute inset-0 size-full object-cover object-left"
    >

    <div class="relative flex h-full items-end justify-end">
        <div class="flex w-full max-w-2xl flex-col px-6 pb-12 sm:px-10 lg:px-12 lg:pb-16">
            <h2 class="type-h2 text-balance">{{ $cms->text('location.title', 'mejorada.location.title') }}</h2>
            <p class="type-b2 mt-6">{{ $cms->text('location.body', 'mejorada.location.body') }}</p>

            <x-mejorada.button
                :href="$cms->text('location.map_url', 'mejorada.location.map_url')"
                variant="outline"
                target="_blank"
                rel="noopener noreferrer"
                class="mt-10 w-full max-w-md"
            >
                {{ $cms->text('location.cta', 'mejorada.location.cta') }}
            </x-mejorada.button>
        </div>
    </div>
</section>
