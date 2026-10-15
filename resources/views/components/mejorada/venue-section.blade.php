@php
    $cms = cms('cigno-mejorada');
@endphp

<section class="bg-beige-500 px-6 py-20 text-black-500 lg:px-10 lg:py-28" aria-labelledby="mejorada-venue-title">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16 xl:gap-24">
        <div class="flex max-w-xl flex-col">
            <img
                src="{{ asset('images/ermita/icons/Vector (16).svg') }}"
                alt=""
                width="72"
                height="72"
                class="h-auto w-14 object-contain lg:w-[72px]"
                aria-hidden="true"
            >

            <h2 id="mejorada-venue-title" class="type-h1 mt-8 text-balance">
                {{ $cms->text('venue_teaser.title', 'mejorada.story.venue_title') }}
            </h2>

            <p class="type-b2 mt-6 max-w-md">
                {{ $cms->text('venue_teaser.lead', 'mejorada.story.venue_lead') }}
            </p>

            <x-mejorada.button :href="route('cigno-mejorada.venue')" class="mt-10 w-full max-w-md">
                {{ $cms->text('venue_teaser.cta', 'mejorada.story.venue_cta') }}
            </x-mejorada.button>
        </div>

        <img
            src="{{ $cms->asset('venue_teaser.image', 'images/mejorada/home/offers-bg.png') }}"
            alt="{{ $cms->text('venue_teaser.title', 'mejorada.story.venue_title') }}"
            class="aspect-[5/4] w-full object-cover"
            loading="lazy"
        >
    </div>
</section>
