@php
    $cms = cms('cigno-mejorada');
@endphp

<section id="offers" class="relative isolate overflow-hidden site-section">
    <img
        src="{{ $cms->asset('offers.background', 'images/mejorada/home/celebrate.jpg') }}"
        alt=""
        class="absolute inset-0 size-full object-cover object-center"
        loading="lazy"
    >

    <div class="relative z-10 mx-auto flex w-full max-w-xl flex-col items-center rounded-[14px] bg-off-white-100 px-8 py-14 text-center text-black-500 sm:px-12 sm:py-16 lg:px-16">
        <h2 class="type-h1">
            {{ $cms->text('offers.title', 'mejorada.rooms_page.home_offers_title') }}
        </h2>

        <p class="type-b2 mt-6 max-w-md">
            {{ $cms->text('offers.lead', 'mejorada.rooms_page.home_offers_lead') }}
        </p>

        <x-mejorada.button :href="route('cigno-mejorada.offers')" variant="outline" class="mt-10 w-full max-w-md">
            {{ $cms->text('offers.cta', 'mejorada.rooms_page.home_offers_cta') }}
        </x-mejorada.button>
    </div>
</section>
