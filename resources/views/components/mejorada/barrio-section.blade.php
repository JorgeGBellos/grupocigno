@php
    $cms = cms('cigno-mejorada');
@endphp

<section class="bg-beige-500 px-6 py-20 text-black-500 lg:px-10 lg:py-28" aria-labelledby="mejorada-barrio-title">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
        <img
            src="{{ $cms->asset('barrio.image', 'images/mejorada/barrio-window.jpg') }}"
            alt="{{ $cms->text('barrio.title', 'mejorada.barrio.title') }}"
            class="aspect-square w-full object-cover"
            loading="lazy"
        >

        <div class="flex max-w-xl flex-col">
            <img
                src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
                alt=""
                width="64"
                height="64"
                class="h-auto w-14 object-contain lg:w-16"
                aria-hidden="true"
            >

            <h2 id="mejorada-barrio-title" class="type-h1 mt-8">
                {{ $cms->text('barrio.title', 'mejorada.story.barrio_title') }}
            </h2>

            <div class="type-b2 mt-6 space-y-4">
                <p>{{ $cms->text('barrio.lead', 'mejorada.story.barrio_lead') }}</p>
            </div>

            <x-mejorada.button :href="route('cigno-mejorada.rooms')" class="mt-10 w-full max-w-md">
                {{ $cms->text('barrio.cta', 'mejorada.story.barrio_cta') }}
            </x-mejorada.button>
        </div>
    </div>
</section>
